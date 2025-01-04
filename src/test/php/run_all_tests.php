<?php

require_once __DIR__ . '/rubik/tokenizer/KeywordNodeTest.php';
require_once __DIR__ . '/rubik/tokenizer/TokenizerTest.php';
require_once __DIR__ . '/rubik/cube/CubeTest.php';
require_once __DIR__ . '/rubik/notation/ScriptNotationTest.php';
require_once __DIR__ . '/rubik/xml/CubeMarkupReaderTest.php';

$success = true;
$success &= testKeywordNode();
$success &= testTokenizer();
$success &= testCube();
$success &= testScriptNotation();
$success &= testCubeMarkupReader();

if ($success){
   echo "all tests passed\n";
} else {
   echo "some tests failed\n";
}