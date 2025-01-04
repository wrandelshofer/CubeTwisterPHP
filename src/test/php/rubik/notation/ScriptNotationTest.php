<?php

require_once __DIR__ . '/../../../../main/php/rubik/notation/ScriptNotation.php';
require_once __DIR__ . '/../../../../main/php/rubik/notation/DefaultScriptNotation.php';

// ----- unit tests ----

function defaultNotationFor2xCubeShouldMatchTemplate() {
    echo "testing defaultNotationFor2xCubeShouldMatchTemplate\n";
    $success = true;
    $notation = new DefaultScriptNotation(2);
    return $success;
}

function shouldCreateDefaultNotationFor3xCube() {
    echo "testing shouldCreateDefaultNotationFor3xCube\n";
    $success = true;
    return $success;
}

function shouldCreateDefaultNotationFor4xCube() {
    echo "testing shouldCreateDefaultNotationFor4xCube\n";
    $success = true;
    return $success;
}

function shouldCreateDefaultNotationFor5xCube() {
    echo "testing shouldCreateDefaultNotationFor5xCube\n";
    $success = true;
    return $success;
}

function shouldCreateDefaultNotationFor6xCube() {
    echo "testing shouldCreateDefaultNotationFor6xCube\n";
    $success = true;
    return $success;
}

function shouldCreateDefaultNotationFor7xCube() {
    echo "testing shouldCreateDefaultNotationFor7xCube\n";
    $success = true;
    return $success;
}

function testScriptNotation() {
    echo "testing ScriptNotation\n";
    $success = true;

    $success &= defaultNotationFor2xCubeShouldMatchTemplate();
    $success &= shouldCreateDefaultNotationFor3xCube();
    $success &= shouldCreateDefaultNotationFor4xCube();
    $success &= shouldCreateDefaultNotationFor5xCube();
    $success &= shouldCreateDefaultNotationFor6xCube();
    $success &= shouldCreateDefaultNotationFor7xCube();

    return $success;
}