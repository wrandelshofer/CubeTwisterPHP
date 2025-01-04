<?php
/*
 * @(#)CMCube.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/../notation/SimpleScriptNotation.php';
require_once __DIR__ . '/CMStatement.php';
require_once __DIR__ . '/CMMacro.php';
require_once __DIR__ . '/CMToken.php';
/**
 * Holds Notation Data.
 */
class CMNotation {
    public string $name;
    public string $description;
    public string $author;
    public string $date;
    public string $id;
    public int $layerCount;
    /* List<CMMacro> of macros. */
    public array $macros = array();
    /* List<CMStatement> of statements. */
    public array $statements = array();
    /* List<CMToken> of tokens. */
    public array $tokens = array();

    public function __construct() {
    }
}