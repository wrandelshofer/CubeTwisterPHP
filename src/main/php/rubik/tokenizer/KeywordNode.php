<?php
/*
 * @(#)KeywordNode.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */

/**
 * A node of keyword tree.
 * <p>
 * A node contains two fields: {@code startSeq} and {@code endSeq}.
 * <p>
 * Example tree structure, for the character sequences "ab", and "abcd".
 * <pre>
 * ''.KeywordNode{startseq=null}
 * ''.'a'.KeywordNode{startseq=null}
 * ''.'a'.'b'.KeywordNode{startseq="ab"}
 * ''.'a'.'b'.'c'.KeywordNode{startseq=null}
 * ''.'a'.'b'.'c'.'d'.KeywordNode{startseq="abcd"}
 * </pre>
 * If the field {@code endseq} is non-null, then the node represents
 * a character sequence that starts with {@code startseq} and ends at the
 * first occurrence of {@code endseq}. This is equivalent to the regular
 * expression {@code startseq.*?endseq }. This is useful for parsing
 * comments. Below is an example for a line comment of the form
 * {@code // foo \n}.
 * <pre>
 * ''.KeywordNode{startseq=null}
 * ''.'/'.KeywordNode{startseq=null}
 * ''.'/'.'/'.KeywordNode{startseq="//",endseq="\n"}
 * </pre>
 */
class KeywordNode {
    /**
     * The character sequence that starts the keyword.
     * This value is non-null if the node represents a keyword.
     * The value is null if the node is an intermediate node in the tree.
     */
    
    private ?string $startSeq = null;
    /**
     * The character sequence that ends the keyword.
     * This value is non-null if the node represents a character sequence
     * that starts with the {@code startseq} sequence and ends at the first
     * occurrence of the {@code endseq} sequence.
     */
    
    private ?string $endSeq = null;

    /**
     * The children map. The key of the map is the ordinal of the  character that leads
     * from this tree node down to the next.
     *
     * Map<Integer,KeywordNode>.
     */
    private array $children = array();

    public function __construct() {
    }


    /**
     * @return KeywordNode
     */
    public function getChild(int $ch) {
        return array_key_exists($ch, $this->children) ? $this->children[$ch] : null;
    }

   function putChild(int $ch,  KeywordNode $child) {
        $this->children[$ch] = $child;
    }

   function setStartSeq( string $value) {
        $this->startSeq = $value;
    }

    
    /**
     * @return string
     */
    public function getStartSeq() {
        return $this->startSeq;
    }

    public function setEndSeq( string $value) {
        $this->endSeq = $value;
    }

    
    /**
     * @return string
     */
    public function getEndSeq() {
        return $this->endSeq;
    }


    /**
     * Adds a startseq.
     *
     * @param root    the root of the startseq tree
     * @param startseq the new startseq
     * @return the KeywordNode that contains the last character of the startseq
     */
    public static function addCharacterSequence( KeywordNode $root,  string $startseq) {
        $node = $root;
        for ($i = 0; $i < strlen($startseq); $i++) {
            $ch = ord($startseq[$i]);
            $child = $node->getChild($ch);
            if ($child == null) {
                $child = new KeywordNode();
                $node->putChild($ch, $child);
            }
            $node = $child;
        }
        $node->setStartSeq($startseq);
        return $node;
    }

    /**
     * Adds a character sequence which is defined by a start character sequence
     * and an end character sequence.
     *
     * @param root     the root of the startseq tree
     * @param startseq the start sequence
     * @param endseq   the end sequence
     * @return the KeywordNode that contains the last character of the startseq
     */
    public static function addStartEndSequence( KeywordNode $root,  string $startseq,  string $endseq) {
        $charSeqNode = KeywordNode::addCharacterSequence($root, $startseq);
        $charSeqNode->endSeq = $endseq;
        return $charSeqNode;
    }

    /**
     * @return array
     */
    public function getChildren() {
        return $this->children;
    }

    public function __toString() {
        $childCount = count($this->children);
        return "KeywordNode{ $this->startSeq, $this->endSeq, $childCount }";
    }
}
