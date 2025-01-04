<?php

require_once __DIR__ . '/../../../../main/php/rubik/tokenizer/KeywordNode.php';

function testKeywordNode() {
    echo "testing KeywordNode\n";
    $success = false;

    $root = new KeywordNode();
    KeywordNode::addStartEndSequence($root,"ba","pi");

    foreach ($root->getChildren() as $charcode1 => $child1) {
      $char1 = chr($charcode1);

        foreach ($child1->getChildren() as $charcode2 => $child2) {
          $char2 = chr($charcode2);
          if($child2->getStartSeq() != "ba" or $child2->getEndSeq() != "pi") {
              $success = false;
              echo "KeywordNodeTest startSeq must be 'ba': " . $child2->getStartSeq() . "\n";
              echo "KeywordNodeTest endSeq must be 'pi': " . $child2->getEndSeq() . "\n";
              echo "KeywordNodeTest char2=$char2 child=$child2\n";
          } else {
            $success = true;
          }
        }
    }

    return $success;
}