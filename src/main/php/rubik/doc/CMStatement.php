<?php
/*
 * @(#)CMCube.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/CMToken.php';
require_once __DIR__ . '/../notation/Syntax.php';
require_once __DIR__ . '/../notation/Symbol.php';

/**
 * Holds Statement Data.
 */
class CMStatement {
    public int $index;
    /** List<CMToken> */
    public array $tokens = array();
    public Syntax $syntax;
    public Symbol $symbol;
    public bool $enabled;
}