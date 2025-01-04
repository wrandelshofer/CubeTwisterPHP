<?php

require_once __DIR__ . '/KeywordNode.php';

/**
 * A greedy tokenizer.
 * <p>
 * By default, this tokenizer parses the entire input sequence as a single word.
 * You can activate skipping of whitespaces by adding whitespace tokens using {@link #addSkip}.
 * You can activate tokenization of positive integer numbers, by invoking {@link #addNumbers}.
 * You can activate tokenization of keywords, by adding keyword tokens using {@link #addKeyword}.
 * You can activate tokenization of comments, by adding comment tokens using {@link #addComment}.
 * <p>
 * Note that keyword parsing is greedy.
 * <p>
 * The tokenizer supports backtracking. That is, it can be
 * set to the state of another tokenizer. See method {@link #setTo}.
 */
class Tokenizer {
    public  static int $TT_WORD = -2;
    public  static int $TT_EOF = -1;

    // the following token types can be activated on demand
    public final static int $TT_KEYWORD = -4;
    public final static int $TT_NUMBER = -5;

    // the following token types are used internally
    final static int $TT_DIGIT = -11;
    final static int $TT_SKIP = -13;


    private string $input = "";
    private int $pos = 0;
    private bool $pushedBack = false;
    private int $ttype = -1; //=$TT_EOF;
    private int $tstart = 0;
    private int $tend = 0;
    private ?string $sval = null;

    private ?int $nval = null;

    private KeywordNode $keywordTree;
    /**
     * Map<int,ttype> maps ord(char) to ttype or to null
     */
    private array $lookup =  array();


    public function __construct() {
        $this->keywordTree = new KeywordNode();
    }

    /**
     * Adds a comment token.
     * <p>
     * To add a single line comment, use:
     * <pre>
     *     addComment("//","\n");
     * </pre>
     * <p>
     * To add a multi line comment, use:
     * <pre>
     *     addComment("/*", "* /");
     * </pre>
     */
    public function addComment( string $start,  string $end) {
        KeywordNode::addStartEndSequence($this->keywordTree, $start, $end);
    }

    /**
     * Adds a digit character.
     * @param ch a string containing a single character
     */
    private function addDigit(string $ch) {
        $this->lookup[ord($ch[0])]= Tokenizer::$TT_DIGIT;
    }

    /**
     * Adds a keyword.
     *
     * @param keyword the keyword token
     */
    public function addKeyword( string $keyword) {
        KeywordNode::addCharacterSequence($this->keywordTree, $keyword);
    }


    /**
     * Defines the tokens needed for parsing non-negative integers.
     */
    public function addNumbers() {
        $this->addDigit('0');
        $this->addDigit('1');
        $this->addDigit('2');
        $this->addDigit('3');
        $this->addDigit('4');
        $this->addDigit('5');
        $this->addDigit('6');
        $this->addDigit('7');
        $this->addDigit('8');
        $this->addDigit('9');
    }

    /**
     * Adds a character that the tokenizer should skip.
     * @param ch a string that contains a single character
     */
    private function addSkip(string $ch) {
        $this->lookup[ord($ch[0])] = Tokenizer::$TT_SKIP;
    }

    /**
     * Returns the end position of the current token.
     * @return int the end position
     */
    public function getEndPosition() {
        return $this->tend;
    }

    /**
     * Returns the current token numeric value.
     *
     * @return int value or null
     */
    public function getNumericValue() {
        return $this->nval;
    }

    /**
     * Returns the start position of the current token.
     * @return int the start position
     */
    public function getStartPosition() {
        return $this->tstart;
    }

    /**
     * Returns the current token string value.
     *
     * @return string value or null
     */
    public function getStringValue() {
        return $this->sval;
    }

    /**
     * Returns the current token type.
     *
     * @return int the token type
     */
    public function getTokenType() {
        return $this->ttype;
    }

    /**
     * Returns the specified mapped value or the default value
     * if no mapping exists.
     */
    private function getOrDefault( array $map, $key, $defaultValue) {
        return array_key_exists($key,$map) ? $map[$key] : $defaultValue;
    }

    /**
     * Parses the next token.
     *
     * @return int the ttype
     */
    public function nextToken() {
        while (true) {
            if ($this->pushedBack) {
                $this->pushedBack = false;
                return $this->ttype;
            }

            $start = $this->pos;
            $ch = $this->read();

            // try to skip characters
            while ($ch != Tokenizer::$TT_EOF && $this->getOrDefault($this->lookup, $ch, Tokenizer::$TT_WORD) == Tokenizer::$TT_SKIP) {
                $ch = $this->read();
                $start += 1;
            }

            // try to tokenize a keyword or a comment
            $node = $this->keywordTree;
            $foundNode = null;
            $end = $start;
            while ($ch != Tokenizer::$TT_EOF && $node != null && $node->getChild($ch) != null) {
                $node = $node->getChild($ch);
                if ($node != null && $node->getStartSeq() != null) {
                    $foundNode = $node;
                    $end = $this->pos;
                }
                $ch = $this->read();
            }
            if ($foundNode != null) {
                $commentEnd = $foundNode->getEndSeq();
                if ($commentEnd != null) {
                    $this->seekTo($commentEnd);
                    continue;
                }

                $this->setPosition($end);
                $this->ttype = Tokenizer::$TT_KEYWORD;
                $this->tstart = $start;
                $this->tend = $end;
                $this->sval = $foundNode->getStartSeq();
                return $this->ttype;
            }
            $this->setPosition($start);
            $ch = $this->read();

            // try to tokenize a number
            if ($ch != Tokenizer::$TT_EOF && $this->getOrDefault($this->lookup, $ch, Tokenizer::$TT_WORD) == Tokenizer::$TT_DIGIT) {
                while ($ch != Tokenizer::$TT_EOF && $this->getOrDefault($this->lookup, $ch, Tokenizer::$TT_WORD) == Tokenizer::$TT_DIGIT) {
                    $ch = $this->read();
                }
                if ($ch != Tokenizer::$TT_EOF) {
                    $this->unread();
                }
                $this->ttype = Tokenizer::$TT_NUMBER;
                $this->tstart = $start;
                $this->tend = $this->pos;
                $this->sval = substr($this->input, $start, $this->pos - $start);
                $this->nval = intval($this->sval);
                return $this->ttype;
            }

            // try to tokenize a word
            if ($ch != Tokenizer::$TT_EOF && $this->getOrDefault($this->lookup, $ch, Tokenizer::$TT_WORD) == Tokenizer::$TT_WORD) {
                while ($ch != Tokenizer::$TT_EOF && $this->getOrDefault($this->lookup, $ch, Tokenizer::$TT_WORD) == Tokenizer::$TT_WORD) {
                    $ch = $this->read();
                }
                if ($ch != Tokenizer::$TT_EOF) {
                    $this->unread();
                }
                $this->ttype = Tokenizer::$TT_WORD;
                $this->tstart = $start;
                $this->tend = $this->pos;
                $this->sval = substr($this->input, $start, $this->pos - $start);
                return $this->ttype;
            }

            $this->ttype = $ch; // special character
            $this->sval = $ch == Tokenizer::$TT_EOF ? "<EOF>" : chr($ch);
            return $this->ttype;
        }
    }

    /**
     * Causes the next call to the {@code nextToken} method of this
     * tokenizer to return the current value.
     */
    public function pushBack() {
        $this->pushedBack = true;
    }

    /**
     * Reads the next character from input.
     *
     * @return the next character or null in case of EOF
     */
    private function read() {
        if ($this->pos < strlen($this->input)) {
            $ch = $this->input[$this->pos];
            $this->pos = $this->pos + 1;
            return ord($ch);
        } else {
            $this->pos = strlen($this->input);
            return Tokenizer::$TT_EOF;
        }
    }

    private function seekTo(string $str) {
        $i = strpos($this->input, $str, $this->pos);
        $this->pos = ($i == false) ? strlen($this->input) : $i + strlen($str);
    }

    /**
     * Sets the input for the tokenizer.
     *
     * @param input the input string;
     */
    public function setInput( string $input) {
        $this->input = $input;
        $this->pos = 0;
        $this->pushedBack = false;
        $this->ttype = Tokenizer::$TT_EOF;
        $this->tstart = 0;
        $this->tend = 0;
        $this->sval = null;
    }

    /**
     * Sets the input position.
     */
    private function setPosition(int $newValue) {
        $this->pos = $newValue;
    }

    /**
     * Sets this tokenizer to the state of that tokenizer
     * <p>
     * This should only be used for backtracking.
     * <p>
     * Note that both tokenizer share the same tokenizer
     * settings (e.g. added keywords, added comments, ...)
     * after this call.
     *
     * @param that another tokenizer
     */
    public function setTo( Tokenizer $that) {
        $this->input = $that->input;
        $this->pos = $that->pos;
        $this->pushedBack = $that->pushedBack;
        $this->lookup = $that->lookup;
        $this->ttype = $that->ttype;
        $this->tstart = $that->tstart;
        $this->tend = $that->tend;
        $this->sval = $that->sval;
        $this->nval = $that->nval;
        $this->keywordTree = $that->keywordTree;
    }

    /**
     * Adds whitespace characters to the list of characters that the tokenizer
     * is supposed to skip.
     */
    public function skipWhitespace() {
        $this->addSkip(' ');
        $this->addSkip("\f");// FORM FEED
        $this->addSkip("\n");// LINE FEED
        $this->addSkip("\r");// CARRIAGE RETURN
        $this->addSkip("\t");// CHARACTER TABULATION
        $this->addSkip("\u{000b}");// LINE TABULATION
        $this->addSkip("\u{00a0}");// NO-BREAK SPACE

        // Note: The code below does not work, because we extract a single
        //       byte from the string using $string[index] when reading.
        //$this->addSkip("\u{2028}");// LINE SEPARATOR
        //$this->addSkip("\u{2029}");// PARAGRAPH SEPARATOR
    }

    /**
     * Unreads the last character from input.
     */
    private function unread() {
        if ($this->pos > 0) {
            $this->pos = $this->pos - 1;
        }
    }
}