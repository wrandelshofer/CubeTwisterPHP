<?php
/*
 * @(#)CMCube.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */

require_once __DIR__ . '/AxisEnum.php';
require_once __DIR__ . '/../notation/Symbol.php';

/**
 * Holds Token Data.
 */
class CMToken {
    public Symbol $symbol;
    public AxisEnum $axis;
    public int $angle;
    /** List<Integer> */
    public array $layers = array();
    /** List<String> */
    public array $tokens = array();
}