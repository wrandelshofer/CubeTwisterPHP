<?php

require_once __DIR__ . '/../../../../main/php/rubik/xml/CubeMarkupReader.php';

function testCubeMarkupReader() {
    echo "testing CubeMarkupReader\n";
    $success = true;

    $reader = new CubeMarkupReader();
    $file = __DIR__ .'/template.xml';
    $cubeMarkup = $reader->readFile($file);
    foreach ($reader->getErrors() as $error) {
        echo "  error: ".$error."\n";
    }
    $success &= count($reader->getErrors()) == 0;

    return $success;
}