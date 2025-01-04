<?php
/*
 * @(#)CMDocument.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/CMCube.php';
require_once __DIR__ . '/CMNotation.php';

/**
 * Holds CubeMarkup Data.
 */
class CMDocument {
    public array $cubes = array();
    public array $notations = array();
    public array $scripts = array();
    public array $texts = array();
    public CMCube $defaultCube;
    public CMNotation $defaultNotation;
}