<?php
/*
 * @(#)CubeKindEnum.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */

 /**
 * Typesafe enum of ScriptType.
 */
enum ScriptTypeEnum:string {
    case GENERATOR = "generator";
     case SOLVER="solver";
}