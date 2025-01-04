<?php

require_once __DIR__ . '/../../../../main/php/rubik/tokenizer/Tokenizer.php';

// ----- Utility functions ------


/** Utility function for testing a Tokenizer instance. */
function doTokenizer(Tokenizer $instance, string $input, string $expected) {
  $success = true;
  $success &= doNextToken($instance, $input, $expected);
  $success &= doPushBack($instance, $input, $expected);
  return $success;
}

/**
 * Tokenizes the input. Calls nextToken() for each token.
 *
 * @param instance the tokenizer
 * @param input    the input
 * @param expected the expected output
 */
function doNextToken(Tokenizer $instance, string $input, string $expected) {
    $instance->setInput($input);
    $actual = '';
    while ($instance->nextToken() != Tokenizer::$TT_EOF) {
        $actual = appendToken($instance, $actual);
    }
    if ($expected != $actual) {
        echo "TokenizerTest.doNextToken() failed\n";
        echo "  input   =$input\n";
        echo "  expected=$expected\n";
        echo "  actual  =$actual\n";
        return false;
    }

    /*
    echo "TokenizerTest.doNextToken() passed\n";
    echo "  input   =$input\n";
    echo "  expected=$expected\n";
    echo "  actual  =$actual\n";
    */
    return true;
}

    /**
     * Tokenizes the input. Calls nextToken(),pushBack(),nextToken() for each token.
     *
     * @param instance the tokenizer
     * @param input    the input
     * @param expected the expected output
     */
function doPushBack(Tokenizer $instance, string $input, string $expected) {
    $instance->setInput($input);
    $actual = '';
    while ($instance->nextToken() != Tokenizer::$TT_EOF) {
        $instance->pushBack();
        $instance->nextToken();
        $actual = appendToken($instance, $actual);
    }
    if ($expected != $actual) {
        echo "TokenizerTest.doPushBack() failed";
        echo "  input=$input";
        echo "  expected=$expected";
        echo "  actual=$actual";
        return false;
    }
    return true;
}

/**
 * Appends a string description of the current token in the tokenizer to
 * the given buffer.
 *
 * @param instance the tokenizer
 * @param buf      the buffer
 */
function appendToken(Tokenizer $instance,string $buf) {
    if (strlen($buf)>0) {
        $buf = $buf.", ";
    }
    $buf = $buf.$instance->getStartPosition();
    $buf = $buf."..";
    $buf = $buf.$instance->getEndPosition();
    $buf = $buf.':';
    switch ($instance->getTokenType()) {
        case Tokenizer::$TT_NUMBER:
            $buf = $buf."NUM";
            $buf = $buf.':';
            $buf = $buf.$instance->getNumericValue();
            break;
        case Tokenizer::$TT_KEYWORD:
            $buf = $buf."KEY";
            $buf = $buf.':';
            $buf = $buf.$instance->getStringValue();
            break;
        case Tokenizer::$TT_WORD:
            $buf = $buf."WORD";
            $buf = $buf.':';
            $buf = $buf.$instance->getStringValue();
            break;
        default:
            $buf = $buf."Unexpected token type: " . $instance->getTokenType();
    }
    return $buf;
}

// ----- Unit tests ------


function shouldParseEntireString() {
   $tt = new Tokenizer();
   return doTokenizer($tt, "lorem ipsum", "0..11:WORD:lorem ipsum");
}

function shouldSkipWhitespace() {
    $tt = new Tokenizer();
    $tt->skipWhitespace();
    return doTokenizer($tt, "lorem ipsum", "0..5:WORD:lorem, 6..11:WORD:ipsum");
}

function shouldSkipWhitespaceAndParseNumbers() {
    $tt = new Tokenizer();
    $tt->skipWhitespace();
    $tt->addNumbers();
    $success = true;
    $success &= doTokenizer($tt, "1 2", "0..1:NUM:1, 2..3:NUM:2");
    $success &= doTokenizer($tt, "1lorem 2ipsum", "0..1:NUM:1, 1..6:WORD:lorem, 7..8:NUM:2, 8..13:WORD:ipsum");
    $success &= doTokenizer($tt, "lorem1 ipsum2", "0..5:WORD:lorem, 5..6:NUM:1, 7..12:WORD:ipsum, 12..13:NUM:2");
    $success &= doTokenizer($tt, "16 21", "0..2:NUM:16, 3..5:NUM:21");
    $success &= doTokenizer($tt, "-16", "0..1:WORD:-, 1..3:NUM:16");
    return $success;
}

function shouldSkipWhitespaceAndParseNumbersAndParseKeywords() {
    $tt = new Tokenizer();
    $tt->skipWhitespace();
    $tt->addNumbers();
    $tt->addKeyword("tom");
    $tt->addKeyword("tomato");
    $tt->addKeyword("two2");
    $tt->addKeyword("3three");
    $success = true;
    $success &= doTokenizer($tt, "tom", "0..3:KEY:tom");
    $success &= doTokenizer($tt, "toma", "0..3:KEY:tom, 3..4:WORD:a");
    $success &= doTokenizer($tt, "tomato", "0..6:KEY:tomato");
    $success &= doTokenizer($tt, "tomatoto", "0..6:KEY:tomato, 6..8:WORD:to");
    $success &= doTokenizer($tt, "tomatotom", "0..6:KEY:tomato, 6..9:KEY:tom");
    $success &= doTokenizer($tt, "to14matotom", "0..2:WORD:to, 2..4:NUM:14, 4..11:WORD:matotom");
    $success &= doTokenizer($tt, "tomato tom", "0..6:KEY:tomato, 7..10:KEY:tom");
    $success &= doTokenizer($tt, "tom ato tom", "0..3:KEY:tom, 4..7:WORD:ato, 8..11:KEY:tom");
    $success &= doTokenizer($tt, "two2 3three", "0..4:KEY:two2, 5..11:KEY:3three");
    $success &= doTokenizer($tt, "two24 63three", "0..4:KEY:two2, 4..5:NUM:4, 6..8:NUM:63, 8..13:WORD:three");
    $success &= doTokenizer($tt, "two24 6 3three", "0..4:KEY:two2, 4..5:NUM:4, 6..7:NUM:6, 8..14:KEY:3three");
    $success &= doTokenizer($tt, "two24 63thre", "0..4:KEY:two2, 4..5:NUM:4, 6..8:NUM:63, 8..12:WORD:thre");
    return $success;
}

function shouldSkipWhitespaceAndParseNumbersAndParseKeywordsAndParseComments() {
    $tt = new Tokenizer();
    $tt->skipWhitespace();
    $tt->addNumbers();
    $tt->addKeyword("tom");
    $tt->addKeyword("tomato");
    $tt->addKeyword("two2");
    $tt->addKeyword("3three");
    $tt->addComment("/*", "*/");
    $tt->addComment("//", "\n");
    $success = true;
    $success &= doTokenizer($tt, "lorem/* comment */ipsum", "0..7:WORD:lorem/*, 8..15:WORD:comment, 16..23:WORD:*/ipsum");
    $success &= doTokenizer($tt, "lorem// comment\nipsum", "0..7:WORD:lorem//, 8..15:WORD:comment, 16..21:WORD:ipsum");
    $success &= doTokenizer($tt, "lorem /* comment */ipsum", "0..5:WORD:lorem, 19..24:WORD:ipsum");
    $success &= doTokenizer($tt, "lorem // comment\nipsum", "0..5:WORD:lorem, 17..22:WORD:ipsum");
    $success &= doTokenizer($tt, "tom/* comment */tom", "0..3:KEY:tom, 16..19:KEY:tom");
    $success &= doTokenizer($tt, "tom// comment\ntom", "0..3:KEY:tom, 14..17:KEY:tom");
    return $success;
}

function testTokenizer() {
    echo "testing Tokenizer\n";
    $success = true;
    $success &= shouldParseEntireString();
    $success &= shouldSkipWhitespace();
    $success &= shouldSkipWhitespaceAndParseNumbers();
    $success &= shouldSkipWhitespaceAndParseNumbersAndParseKeywords();
    $success &= shouldSkipWhitespaceAndParseNumbersAndParseKeywordsAndParseComments();
    return $success;
}