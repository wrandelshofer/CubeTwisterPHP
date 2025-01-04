<?php
/*
 * @(#)CubeMarkupReader.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/../util/Stack.php';
require_once __DIR__ . '/../doc/CubeKindEnum.php';
require_once __DIR__ . '/../doc/ScriptTypeEnum.php';
require_once __DIR__ . '/../doc/CMDocument.php';
require_once __DIR__ . '/../doc/CMCube.php';
require_once __DIR__ . '/../doc/CMPart.php';
require_once __DIR__ . '/../doc/CMColor.php';
require_once __DIR__ . '/../doc/CMNotation.php';
require_once __DIR__ . '/../doc/CMScript.php';
require_once __DIR__ . '/../doc/CMMacro.php';
require_once __DIR__ . '/../doc/CMText.php';
require_once __DIR__ . '/../notation/Symbol.php';
require_once __DIR__ . '/../notation/Syntax.php';

/**
 * Reader for CubeMarkup XML files.
 */
class CubeMarkupReader {
    private ?CMDocument $cubeMarkup;
    private string $characterData;
    private array $errors = array();
    /** Stack<object> of objects. */
    private Stack $stack;
    private array $idToObjMap = array();

    public function __construct() {
        $this->clear();
    }

    function startCube(XMLParser $parser, string $name, array $attrs) {
        $cube = new CMCube();
        $this->stack->push($cube);
        array_push($this->cubeMarkup->cubes, $cube);

        foreach($attrs as $key => $value) {
            $illegal = false;
            switch($key){
                case "TWISTDURATION" :
                    $cube->twistDuration = floatval($value);
                    break;
                case "KIND" :
                    $kind = CubeKindEnum::tryFrom($value);
                    if($kind!=null){
                        $cube->kind=$kind;
                    }
                    $illegal = $kind == null;
                    break;
                case "EXPLODE" :
                    $cube->explode = floatval($value);
                    break;
                case "ALPHA" :
                    $cube->alpha = floatval($value);
                    break;
                case "SCALE" :
                    $cube->scale = floatval($value);
                    break;
                case "ID" :
                    $cube->id = $value;
                    $this->idToObjMap[$value] = $cube;
                    break;
                case "BETA" :
                    $cube->beta = floatval($value);
                    break;
                case "DEFAULT" :
                    $illegal = $value!="true"&&$value!="false";
                    if (boolval($value)) {
                        $this->cubeMarkup->defaultCube = $cube;
                    }
                    break;
                case "BACKGROUNDCOLOR" :
                    $cube->backgroundColor = $value;
                    break;
                default:
                    $illegal = true;
                    break;
            }
            if($illegal){
               array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
            }
        }
    }
    function startColor(XMLParser $parser, string $name, array $attrs) {
        $top = $this->stack->top();
        if (!($top instanceof CMCube)) {
            array_push($this->errors, "illegal element <$name> in line ".xml_get_current_line_number($parser));
            return;
        }
        $color = new CMColor();
        array_push($top->colors, $color);
        foreach($attrs as $key => $value) {
            $illegal = false;
            switch($key){
                case "ID" :
                    $color->id = $value;
                    $this->idToObjMap[$value] = $color;
                    break;
                case "ARGB" :
                    $color->argb = $value;
                    break;
                default:
                    $illegal = true;
                    break;
            }
            if($illegal){
               array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
            }
        }
    }
    function startPart(XMLParser $parser, string $name, array $attrs) {
        $top = $this->stack->top();
        if (!($top instanceof CMCube)) {
            array_push($this->errors, "illegal element <$name> in line ".xml_get_current_line_number($parser));
            return;
        }
        $part = new CMPart();
        array_push($top->parts, $part);
        foreach($attrs as $key => $value) {
            $illegal = false;
            switch($key){
                case "INDEX" :
                    $part->index = intval($value);
                    break;
                case "VISIBLE" :
                    $illegal = $value!="true"&&$value!="false";
                    $part->visible = boolval($value);
                    break;
                case "FILLCOLORREF" :
                    $illegal = !array_key_exists($value, $this->idToObjMap)
                                || !($this->idToObjMap[$value] instanceof CMColor);
                    if(!$illegal){
                        $part->fillColor = $this->idToObjMap[$value];
                    }
                    break;
                case "OUTLINECOLORREF" :
                    $illegal = !array_key_exists($value, $this->idToObjMap)
                                || !($this->idToObjMap[$value] instanceof CMColor);
                    if(!$illegal){
                        $part->outlineColor = $this->idToObjMap[$value];
                    }
                    break;
                default:
                    $illegal = true;
                    break;
            }
            if($illegal){
               array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
            }
        }
    }
    function startSticker(XMLParser $parser, string $name, array $attrs) {
        $top = $this->stack->top();
        if (!($top instanceof CMCube)) {
            array_push($this->errors, "illegal element <$name> in line ".xml_get_current_line_number($parser));
            return;
        }
        $sticker = new CMSticker();
        array_push($top->stickers, $sticker);
        foreach($attrs as $key => $value) {
            $illegal = false;
            switch($key){
                case "INDEX" :
                    $sticker->index = intval($value);
                    break;
                case "VISIBLE" :
                    $illegal = $value!="true"&&$value!="false";
                    $sticker->visible = boolval($value);
                    break;
                case "FILLCOLORREF" :
                    $illegal = !array_key_exists($value, $this->idToObjMap)
                                || !($this->idToObjMap[$value] instanceof CMColor);
                    if(!$illegal){
                        $sticker->fillColor = $this->idToObjMap[$value];
                    }
                    break;
                default:
                    $illegal = true;
                    break;
            }
            if($illegal){
               array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
            }
        }
    }
    function startStickersImage(XMLParser $parser, string $name, array $attrs) {
        $top = $this->stack->top();
        if (!($top instanceof CMCube)) {
            array_push($this->errors, "illegal element <$name> in line ".xml_get_current_line_number($parser));
            return;
        }
        $stickersImage = new CMStickersImage();
        $top->stickersImage = $stickersImage;
        foreach($attrs as $key => $value) {
            $illegal = false;
            switch($key){
                case "VISIBLE" :
                    $illegal = $value!="true"&&$value!="false";
                    $stickersImage->visible = boolval($value);
                    break;
                default:
                    $illegal = true;
                    break;
            }
            if($illegal){
               array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
            }
        }
        return $stickersImage;
    }
    function startStatement(XMLParser $parser, string $name, array $attrs) {
        $top = $this->stack->top();
        if (!($top instanceof CMNotation)) {
            array_push($this->errors, "illegal element <$name> in line ".xml_get_current_line_number($parser));
            return;
        }
        $statement = new CMStatement();
        array_push($top->statements, $statement);
        foreach($attrs as $key => $value) {
            $illegal = false;
            switch($key){
                case "ENABLED" :
                    $illegal = $value!="true"&&$value!="false";
                    $statement->enabled = boolval($value);
                    break;
                case "SYMBOL" :
                    $symbol = Symbol::tryFrom($value);
                    if($symbol!=null){
                        $statement->symbol=$symbol;
                    }
                    $illegal = $symbol == null;
                    break;
                case "SYNTAX" :
                    $syntax = Syntax::tryFrom($value);
                    if($syntax!=null){
                        $statement->syntax=$syntax;
                    }
                    $illegal = $syntax == null;
                    break;
                default:
                    $illegal = true;
                    break;
            }
            if($illegal){
               array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
            }
        }
        return $statement;
    }
    function startToken(XMLParser $parser, string $name, array $attrs) {
        $top = $this->stack->top();
        if (!($top instanceof CMStatement)) {
            array_push($this->errors, "illegal element <$name> in line ".xml_get_current_line_number($parser));
            return;
        }
        $token = new CMToken();
        array_push($top->tokens, $token);
        foreach($attrs as $key => $value) {
            $illegal = false;
            switch($key){
                case "ANGLE" :
                    $token->angle = intval($value);
                    break;
                case "AXIS" :
                    $axis = AxisEnum::tryFrom($value);
                    if($axis!=null){
                        $token->axis=$axis;
                    }
                    $illegal = $axis == null;
                    break;
                case "SYMBOL" :
                    $symbol = Symbol::tryFrom($value);
                    if($symbol!=null){
                        $token->symbol=$symbol;
                    }
                    $illegal = $symbol == null;
                    break;
                case "LAYERLIST" :
                    $items = preg_split('/\s*,\s*/', $value);
                    foreach ($items as $item) {
                        $layer = intval($item);
                        $illegal |= $layer < 1 ;
                        array_push($token->layers, $layer);
                    }
                    break;
                default:
                    $illegal = true;
                    break;
            }
            if($illegal){
               array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
            }
        }
        return $token;
    }
    function startMacro(XMLParser $parser, string $name, array $attrs) {
        $top = $this->stack->top();
        if (!($top instanceof CMNotation)
          && !($top instanceof CMScript)) {
            array_push($this->errors, "illegal element <$name> in line ".xml_get_current_line_number($parser));
            return;
        }
        $macro = new CMMacro();
        array_push($top->macros, $macro);
        foreach($attrs as $key => $value) {
           $illegal = false;
           switch($key){
                case "IDENTIFIER" :
                    $macro->identifier = $value;
                    break;
               default:
                   $illegal = true;
                   break;
           }
           if($illegal){
              array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
           }
        }
        return $macro;
    }

    function startNotation(XMLParser $parser, string $name, array $attrs) {
        $notation = new CMNotation();
        array_push($this->cubeMarkup->notations, $notation);
        foreach($attrs as $key => $value) {
            $illegal = false;
            switch($key){
                case "LAYERCOUNT" :
                    $notation->layerCount = intval($value);
                    break;
                case "DEFAULT" :
                    $illegal = $value!="true"&&$value!="false";
                    if (boolval($value)) {
                        $this->cubeMarkup->defaultNotation = $notation;
                    }
                    break;
                case "ID" :
                    $notation->id = $value;
                    $this->idToObjMap[$value] = $notation;
                    break;
                default:
                    $illegal = true;
                    break;
            }
            if($illegal){
               array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
            }
        }
        return $notation;
    }

    function startScript(XMLParser $parser, string $name, array $attrs) {
        $script = new CMScript();
        array_push($this->cubeMarkup->scripts, $script);
        foreach($attrs as $key => $value) {
            $illegal = false;
            switch($key){
                case "SCRIPTTYPE" :
                    $type = ScriptTypeEnum::tryFrom($value);
                    if($type!=null){
                        $script->type=$type;
                    }
                    $illegal = $type == null;
                    break;
                case "ID" :
                    $script->id = $value;
                    $this->idToObjMap[$value] = $script;
                    break;
                case "NOTATIONREF" :
                    if (array_key_exists($value, $this->idToObjMap)
                        && $this->idToObjMap[$value] instanceof CMNotation) {
                       $script->notation = $this->idToObjMap[$value];
                    } else {
                        $illegal = true;
                    }
                    break;
                case "CUBEREF" :
                    if (array_key_exists($value, $this->idToObjMap)
                        && $this->idToObjMap[$value] instanceof CMCube) {
                       $script->cube = $this->idToObjMap[$value];
                    } else {
                        $illegal = true;
                    }
                    break;
                default:
                    $illegal = true;
                    break;
            }
            if($illegal){
               array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
            }
        }
        return $script;
    }

    function startText(XMLParser $parser, string $name, array $attrs) {
        $text = new CMText();
        array_push($this->cubeMarkup->texts, $text);
        foreach($attrs as $key => $value) {
            $illegal = false;
            switch($key){
                case "TWISTDURATION" :
                    $illegal = !is_float($value);
                    $cube->twistDuration = floatval($value);
                    break;
                case "KIND" :
                    break;
                case "EXPLODE" :
                    $illegal = !is_float($value);
                    $cube->explode = floatval($value);
                    break;
                case "ALPHA" :
                    $illegal = !is_float($value);
                    $cube->alpha = floatval($value);
                    break;
                case "SCALE" :
                    $illegal = !is_float($value);
                    $cube->scale = floatval($value);
                    break;
                case "ID" :
                    $text->id = $value;
                    $this->idToObjMap[$value] = $text;
                    break;
                case "BETA" :
                    $illegal = !is_float($value);
                    $cube->beta = floatval($value);
                    break;
                case "DEFAULT" :
                    $illegal = !is_bool($value);
                    if (is_bool($value) && $value) {
                        $this->cubeMarkup->defaultCube = $cube;
                    }
                    break;
                case "BACKGROUNDCOLOR" :
                    break;
                default:
                    $illegal = true;
                    break;
            }
            if($illegal){
               array_push($this->errors, "illegal attribute <$name ".$key."=\"".$value."\"> in line ".xml_get_current_line_number($parser));
            }
        }
        return $text;
    }

    function endName(XMLParser $parser, string $name) {
        $top = $this->stack->top();
        if ($top instanceof CMCube) {
            $top->name = $this->characterData;
        } else if ($top instanceof CMNotation) {
            $top->name = $this->characterData;
        } else if ($top instanceof CMScript) {
            $top->name = $this->characterData;
        } else {
            array_push($this->errors, "illegal </$name> element in line ".xml_get_current_line_number($parser));
        }
    }

    function endSource(XMLParser $parser, string $name) {
        $top = $this->stack->top();
        if ($top instanceof CMMacro) {
            $top->source = $this->characterData;
        } else if ($top instanceof CMScript) {
            $top->source = $this->characterData;
        } else {
            array_push($this->errors, "illegal </$name> element in line ".xml_get_current_line_number($parser));
        }
    }

    function endToken(XMLParser $parser, string $name) {
        $top = $this->stack->top();
        if ($top instanceof CMToken) {
            $top->tokens = preg_split('/\s+/',$this->characterData);
        } else {
            array_push($this->errors, "illegal </$name> element in line ".xml_get_current_line_number($parser));
        }
    }

    function endStickersImage(XMLParser $parser, string $name) {
        $top = $this->stack->top();
        if ($top instanceof CMStickersImage) {
            $top->imageBase64 = $this->characterData;
        } else {
            array_push($this->errors, "illegal </$name> element in line ".xml_get_current_line_number($parser));
        }
    }

    function endTitle(XMLParser $parser, string $name) {
        $top = $this->stack->top();
        if ($top instanceof CMText) {
            $top->title = $this->characterData;
        } else {
            array_push($this->errors, "illegal <$name> element in line ".xml_get_current_line_number($parser));
        }
    }

    function endBody(XMLParser $parser, string $name) {
        $top = $this->stack->top();
        if ($top instanceof CMText) {
            $top->body = $this->characterData;
        } else {
            array_push($this->errors, "illegal <$name> element in line ".xml_get_current_line_number($parser));
        }
    }

    function endAuthor(XMLParser $parser, string $name) {
        $top = $this->stack->top();
        if ($top instanceof CMCube) {
            $top->author = $this->characterData;
        } else if ($top instanceof CMNotation) {
            $top->author = $this->characterData;
        } else if ($top instanceof CMScript) {
            $top->author = $this->characterData;
        } else if ($top instanceof CMText) {
            $top->author = $this->characterData;
        } else {
            array_push($this->errors, "illegal <$name> element in line ".xml_get_current_line_number($parser));
        }
    }

    function endDate(XMLParser $parser, string $name) {
        $top = $this->stack->top();
        if ($top instanceof CMCube) {
            $top->date = $this->characterData;
        } else if ($top instanceof CMNotation) {
            $top->date = $this->characterData;
        } else if ($top instanceof CMScript) {
            $top->date = $this->characterData;
        } else if ($top instanceof CMText) {
            $top->date = $this->characterData;
        } else {
            array_push($this->errors, "illegal <$name> element in line ".xml_get_current_line_number($parser));
        }
    }

    function endDescription(XMLParser $parser, string $name) {
        $top = $this->stack->top();
        if ($top instanceof CMCube) {
            $top->description = $this->characterData;
        } else if ($top instanceof CMNotation) {
            $top->description = $this->characterData;
        } else if ($top instanceof CMScript) {
            $top->description = $this->characterData;
        } else {
            array_push($this->errors, "illegal name element in line ".xml_get_current_line_number($parser));
        }
    }

    function startElement(XMLParser $parser, string $name, array $attrs) {
        $this->characterData = '';
        $obj = null;
        switch($name){
            case "AUTHOR":
                break;
            case "BODY":
                break;
            case "COLOR":
                $this->startColor($parser, $name, $attrs);
                break;
            case "CUBEMARKUP":
                break;
            case "CUBE":
                $obj = $this->startCube($parser, $name, $attrs);
                break;
            case "DATE":
                break;
            case "DESCRIPTION":
                break;
            case "MACRO":
                $obj = $this->startMacro($parser, $name, $attrs);
                break;
            case "NAME":
                break;
            case "NOTATION":
                $obj = $this->startNotation($parser, $name, $attrs);
                break;
            case "PART":
                $this->startPart($parser, $name, $attrs);
                break;
            case "SCRIPT":
                $obj = $this->startScript($parser, $name, $attrs);
                break;
            case "SOURCE":
                break;
            case "STATEMENT":
                $obj = $this->startStatement($parser, $name, $attrs);
                break;
            case "STICKER":
                $this->startSticker($parser, $name, $attrs);
                break;
            case "STICKERSIMAGE":
                $obj = $this->startStickersImage($parser, $name, $attrs);
                break;
            case "TITLE":
                break;
            case "TEXT":
                $obj = $this->startText($parser, $name, $attrs);
                break;
            case "TOKEN":
                $obj = $this->startToken($parser, $name, $attrs);
                break;
            default:
                echo "$name\n";
                array_push($this->errors, "illegal element <".$name."> in line ".xml_get_current_line_number($parser));
                break;
        }
        if ($obj != null){
            $this->stack->push($obj);
        }
    }

    function endElement(XMLParser $parser, string $name) {
        switch($name){
            case "AUTHOR":
                $this->endAuthor($parser, $name);
                break;
            case "BODY":
                $this->endBody($parser, $name);
                break;
            case "COLOR":
            case "CUBEMARKUP":
                break;
            case "CUBE":
                $this->stack->pop();
                break;
            case "DATE":
                $this->endDate($parser, $name);
                break;
            case "DESCRIPTION":
                $this->endDescription($parser, $name);
                break;
            case "MACRO":
                $this->stack->pop();
                break;
            case "NAME":
                $this->endName($parser, $name);
                break;
            case "NOTATION":
                $this->stack->pop();
                break;
            case "PART":
                break;
            case "SCRIPT":
                $this->stack->pop();
                break;
            case "SOURCE":
                $this->endSource($parser, $name);
                break;
            case "STATEMENT":
                $this->stack->pop();
                break;
            case "STICKER":
                break;
            case "STICKERSIMAGE":
                $this->endStickersImage($parser, $name);
                $this->stack->pop();
                break;
            case "TITLE":
                $this->endTitle($parser, $name);
                break;
            case "TEXT":
                $this->stack->pop();
                break;
            case "TOKEN":
                $this->endToken($parser, $name);
                $this->stack->pop();
                break;
            default:
                echo "$name\n";
                array_push($this->errors, "illegal element </".$name."> in line ".xml_get_current_line_number($parser));
                break;
        }
    }

    function handleCharacterData(XMLParser $parser, string $data) {
        $this->characterData .= $data;
    }

    function clear() {
        $this->stack = new Stack();
        $this->cubeMarkup = new CMDocument();
        $this->errors = array();
        $this->idToObjMap = array();
    }


    public function /*CMDocument*/ readFile($file) {
        $this->clear();

        $xml_parser = xml_parser_create();
        xml_set_element_handler($xml_parser, array($this, "startElement"), array($this, "endElement"));
        xml_set_character_data_handler($xml_parser, array($this, "handleCharacterData"));
        if (!($fp = fopen($file, "r"))) {
            die("could not open XML input");
        }

        while ($data = fread($fp, 4096)) {
            if (!xml_parse($xml_parser, $data, feof($fp))) {
                die(sprintf("XML error: %s at line %d",
                            xml_error_string(xml_get_error_code($xml_parser)),
                            xml_get_current_line_number($xml_parser)));
            }
        }
        xml_parser_free($xml_parser);

        return $this->cubeMarkup;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return count($this->errors)==0;
    }

}


