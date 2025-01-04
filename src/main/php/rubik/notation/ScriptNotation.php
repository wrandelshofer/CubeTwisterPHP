<?php
/*
 * @(#)ScriptNotation.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */
require_once __DIR__ . '/Symbol.php';
require_once __DIR__ . '/Syntax.php';
require_once __DIR__ . '/../cube/Cube.php';
require_once __DIR__ . '/../io/Writer.php';

/**
 * Defines the syntax and tokens of a Rubik's Cube script.
 */
interface ScriptNotation {
    /**
     * Returns the number of layers supported by this notation.
     * @return int number of layers
     */
    public function getLayerCount();

    /**
     * Returns a macro which performs the same transformation as the cube
     * parameter. Returns null if no macro is available.
     *
     * @param cube        A transformed cube.
     * @param localMacros A Map<string, MacroNode> with local macros.
     * @return string equivalent macro or null
     */
    public function getEquivalentMacro(Cube $cube, array $localMacros);

    /**
     * Returns the macros defined by this notation.
     *
     * @return macros.
     */
   public function getAllMacros();

    public function getMacro(string $identifier);/* {
        return $this->getAllMacros()[$identifier];
    }*/

    public function getName();

    /**
     * Writes a token for the specified symbol to the writer.
     *
     * @throws IOException If the symbol is not supported by the notation,
     *                     and if no alternative symbols could be found.
     */
    function writeToken(Writer $w, Symbol $symbol);

    /**
     * Writes a token for the specified transformation to the print writer.
     */
    function writeMoveToken(Writer $w, int $axis, int $layerMask, int $angle);

    /**
     * Returns true, if this notation supports the specified symbol.
     */
    function isSupported(Symbol $s);

    /**
     * Returns true, if this notation supports the specified move.
     */
    function isMoveSupported(Move $key);

    /**
     * Returns the syntax for the specified symbol.
     */
    function getSyntax(Symbol $s);

    /**
     * Returns a token for the specified symbol.
     * If the symbol has more than one token, the first token is returned.
     * <p>
     * Returns null, if symbol is not supported.
     */
    function getToken(Symbol $s);

    /**
     * Returns all token for the specified symbol.
     * <p>
     * Returns the token regardless whether the symbol is supported or not.
     * Returns an empty list if the token is not defined.
     */
    function getAllTokens(Symbol $key);

    /**
     * Returns a token for the specified move.
     * If the move has more than one token, the first token is returned.
     * <p>
     * Returns null, if move is not supported.
     */
    function getMoveToken(Move $s);

    /**
     * Returns all tokens for the specified move.
     * <p>
     * Returns an empty list if the move is not supported.
     */
    function getAllMoveTokens(Move $s);

    /**
     * Returns all move symbols.
     */
    function getAllMoveSymbols();

    /**
     * Returns the move from the given move token.
     *
     * @return a move
     */
    function getMoveFromToken(string $moveToken);

    /**
     * Gets all tokens defined for this notation.
     *
     * @return the tokens.
     */
    function getTokens();

    /**
     * Given a (potentially ambiguous) token returns all symbols for
     * that token.
     *
     * @param token a token
     * @return the symbols for the token
     */
    function getSymbols(string $token);

    /**
     * Given a (potentially ambiguous) token and a composite symbol
     * that parser is currently parsing, returns the symbol for
     * that token.
     *
     * @param token           a token
     * @param compositeSymbol the composite symbol being parsed
     * @return the symbol for the token in this composite symbol
     */
    function getSymbolInCompositeSymbol(string $token, Symbol $compositeSymbol);/* {
        for (Symbol s : getSymbols(token)) {
            if (compositeSymbol.isSubSymbol(s)) {
                return s;
            }
        }
        return null;
    }*/
}
