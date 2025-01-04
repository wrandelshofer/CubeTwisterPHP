<?php
/*
 * @(#)CMCube.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/ScriptTypeEnum.php';
require_once __DIR__ . '/CMNotation.php';
require_once __DIR__ . '/CMCube.php';

/**
 * Holds Script Data.
 */
class CMScript {
    public string $name;
    public string $description;
    public string $author;
    public string $date;
    public string $id;
    public string $source;
    public ScriptTypeEnum $type;
    public ?CMNotation $notation;
    public ?CMCube $cube;
}