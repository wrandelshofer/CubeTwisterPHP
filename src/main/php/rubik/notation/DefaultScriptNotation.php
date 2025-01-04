<?php
/*
 * @(#)DefaultScriptNotation.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/Symbol.php';
require_once __DIR__ . '/Syntax.php';
require_once __DIR__ . '/../cube/Cube.php';
require_once __DIR__ . '/../io/Writer.php';
require_once __DIR__ . '/AbstractScriptNotation.php';

/**
 * Default ScriptNotation.
 */
class DefaultScriptNotation extends AbstractScriptNotation {

     public function __construct(int $layerCount) {
        $this->setLayerCount($layerCount);
     }
}
