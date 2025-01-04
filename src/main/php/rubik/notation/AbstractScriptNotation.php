<?php
/*
 * @(#)AbstractScriptNotation.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/Symbol.php';
require_once __DIR__ . '/Syntax.php';
require_once __DIR__ . '/../cube/Cube.php';
require_once __DIR__ . '/../io/Writer.php';
require_once __DIR__ . '/ScriptNotation.php';

/**
 * AbstractScriptNotation.
 */
abstract class AbstractScriptNotation implements ScriptNotation {
    private array/*HashMap<Symbol, List<string>>*/ $symbolToTokensMap = array();
    private array/*HashMap<string, List<Symbol>>*/ $tokenToSymbolsMap = array();
    private array/*HashMap<Move, List<string>>*/ $moveToTokensMap = array();
    private array/*HashMap<string, Move>*/ $tokenToMoveMap = array();
    private array/*HashMap<Symbol, Syntax>*/ $symbolToSyntaxMap = array();
    private array/*Map<string, string>*/ $macros = array();
    private int $layerCount;
    private string $name;

    public function /*?string*/ getMacro(string $identifier) {
        if(array_key_exists($identifier,$this->macros)){
           return $this->macros[$identifier];
        } else {
           return null;
        }
    }

    public function /*?Symbol*/ getSymbolInCompositeSymbol(string $token, Symbol $compositeSymbol) {
        foreach ($this->getSymbols(token) as $s) {
            if (Symbol::isSubSymbol($compositeSymbol, $s)) {
                return $s;
            }
        }
        return null;
    }

    public function putMacro(string $identifier, string $code) {
        $this->macros[$identifier]= $code;
        if(array_key_exists($identifier,$this->tokenToSymbolsMap)){
           $a = $this->tokenToSymbolsMap[$identifier];
        } else {
           $a = array();
        }
        array_push($a, Symbol::MACRO);
        $this->tokenToSymbolsMap[$identifier]=$a;
    }

    public function removeToken(Symbol $symbol, string $token) {
        if(array_key_exists($symbol,$this->symbolToTokensMap)){
            $a = $this->symbolToTokensMap[$symbol];
            if (($key = array_search($token, $a)) !== false) {
                unset($a[$key]);
                $this->symbolToTokensMap[$symbol]=$a;
            }
        }
        if(array_key_exists($token,$this->tokenToSymbolsMap)){
            $a = $this->tokenToSymbolsMap[$token];
            if (($key = array_search($symbol, $a)) !== false) {
                unset($a[$key]);
                $this->tokenToSymbolsMap[$token]=$a;
            }
        }
    }

    public function setLayerCount(int $value) {
        $this->layerCount = $value;
    }

    
    public function/*int*/ getLayerCount() {
        return $this->layerCount;
    }

   
    public function/*string*/ getEquivalentMacro(Cube $cube, array/*Map<string, MacroNode>*/ $localMacros) {
        // FIXME implement me
        return null;
    }

    
    
    public function /*Map<string, string>*/ getAllMacros() {
        return $this->macros;
    }

    
    public function writeToken(Writer $w, Symbol $symbol) {
        if(array_key_exists($symbol,$this->symbolToTokensMap)){
            $tokens = $this->symbolToTokensMap[$symbol];
            if (count($tokens)>0) {
                $w->write($tokens[0]);
            }
        }
    }

    
    public function writeMoveToken( Writer $w, int $axis, int $layerMask, int $angle) {
        $move = new Move(layerCount, axis, layerMask, angle);
        if(array_key_exists($move,$this->moveToTokensMap)){
            $tokens = $this->moveToTokensMap[$move];
            if (count($tokens)>0) {
               $w->write($tokens[0]);
            }
        }
    }

    
    public function/*boolean*/ isSupported(Symbol $s) {
        return array_key_exists($s, $this->symbolToSyntaxMap)
                || array_key_exists($s,$this->symbolToTokensMap);
    }

    
    public function/*boolean*/ isMoveSupported(Move $key) {
        return array_key_exists($key, $this->moveToTokensMap);
    }
    
    public function/*Syntax*/ getSyntax( Symbol $s) {
        $compositeSymbol = $s->getCompositeSymbol();
        if(array_key_exists($compositeSymbol,$this->symbolToTokensMap)){
            return $this->symbolToSyntaxMap[$compositeSymbol];
        } else{
            return null;
        }
    }
    
    public function/*?string*/ getToken(Symbol $symbol) {
        if(array_key_exists($symbol,$this->symbolToTokensMap)){
            $a = $this->symbolToSyntaxMap[$symbol];
            return count($a) > 0 ? $a[0] : null;
        } else{
            return null;
        }
    }

    public function/*List<string>*/ getAllTokens(Symbol $symbol) {
        if(array_key_exists($symbol,$this->symbolToTokensMap)){
            $a = $this->symbolToSyntaxMap[$symbol];
            return $a;
        } else{
            return array();
        }
    }
    
    public function/*string*/ getMoveToken(Move $s) {
        if(array_key_exists($s,$this->moveToTokensMap)){
            $a = $this->moveToTokensMap[$s];
            return count($a) > 0 ? $a[0] : null;
        } else{
            return null;
        }
    }

    
    
    public function/*List<string>*/ getAllMoveTokens(Move $s) {
        if(array_key_exists($s,$this->moveToTokensMap)){
            return $this->moveToTokensMap[$s];
        } else{
            return array();
        }
    }

    
    public function/*Move*/ getMoveFromToken(string $moveToken) {
        if(array_key_exists($moveToken,$this->tokenToMoveMap)){
            return $this->tokenToMoveMap[$moveToken];
        } else{
            return null;
        }
    }

    
    
    public function/*Collection<string>*/ getTokens() {
        return array_keys($this->tokenToSymbolsMap);
    }

    
    public function/*Set<Move>*/ getAllMoveSymbols() {
        return array_keys($this->moveToTokensMap);
    }

    
    public function/*List<Symbol>*/ getSymbols(string $token) {
        if(array_key_exists($token,$this->tokenToSymbolsMap)){
            return $this->tokenToSymbolsMap[$token];
        } else{
            return array();
        }
    }


    protected function addToken(Symbol $symbol, string $token) {
        if(array_key_exists($symbol,$this->symbolToTokensMap)){
           $a = $this->symbolToTokensMap[$symbol];
        } else {
           $a = array();
        }
        array_push($a, $token);
        $this->symbolToTokensMap[$symbol]=$a;

        if(array_key_exists($token,$this->tokenToSymbolsMap)){
           $a = $this->tokenToSymbolsMap[$token];
        } else {
           $a = array();
        }
        array_push($a, $symbol);
        $this->tokenToSymbolsMap[$token]=$a;
    }

    protected function addMove(Move $move, string $token) {
        if(array_key_exists($move,$this->moveToTokensMap)){
           $a = $this->moveToTokensMap[$move];
        } else {
           $a = array();
        }
        array_push($a, $token);
        $this->moveToTokensMap[$move]=$a;

        if(array_key_exists($token,$this->tokenToMoveMap)){
           $a = $this->tokenToMoveMap[$token];
        } else {
           $a = array();
        }
        array_push($a, $move);
        $this->tokenToMoveMap[$token]=$a;
    }

    protected function putSyntax(Symbol $symbol, Syntax $syntax) {
        $this->symbolToSyntaxMap[$symbol]=$syntax;
    }

    public function/*string*/ getName() {
        return $this->name;
    }

    protected function setName(string $name) {
        $this->name = $name;
    }
}
