<?php
/*
 * @(#)Syntax.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */

 /**
 * Typesafe enum of Syntaxes for the Parser.
 */
enum Syntax:string {
    /**
     * A primary expression: A single literal or name that stands for itself
     * or can be used as a building block of other expressions.
     */
   case PRIMARY ="primary";

    /**
     * Unary prefix expression. The operator consists
     * of a single token that is placed before the operand,
     * or of a prefix sequence.
     * <pre>
     * Prefix ::= Operator, Operand ;
     * PrefixSequence ::= Begin, Sequence, End, Operand ;
     * </pre>
     */
    case PREFIX="prefix";
    /**
     * Unary suffix expression.  The operator consists
     * of a single token that is placed after the operand.
     * or of a suffix sequence.
     * <pre>
     * Suffix ::= Operand, Operator;
     * SuffixSequence ::= Operand, Begin, Sequence, End ;
     * </pre>
     */
    case SUFFIX="suffix";
    /**
     * Unary circumfix expression: The operator consists
     * of two tokens (begin, end) that are placed
     * around the operand.
     * <pre>
     * Unary Circumfix ::= Begin , Operand1 , End ;
     * </pre>
     */
    case CIRCUMFIX="circumfix";
    /**
     * Binary Pre-Circumfix expression:  The operator consists
     * of three tokens (begin, delimiter, end) that are placed
     * around operand 2 and operand 1.
     * <pre>
     * Binary Precircumfix ::= Begin , Operand2 , Delimiter , Operand1 , End ;
     * </pre>
     */
    case PRECIRCUMFIX="precircumfix";
    /**
     * Binary Post-Circumfix expression:  The operator consists
     * of three tokens (begin, delimiter, end) that are placed
     * around the operands 1 and 2.
     * <pre>
     * Binary Postcircumfix ::= Begin , Operand1 , Delimiter , Operand2 , End ;
     * </pre>
     */
    case POSTCIRCUMFIX="postcircumfix";
    /**
     * Binary Pre-Infix expression: The operator consists of a single token
     * that is placed between operand 2 and 1.
     * <pre>
     * Preinfix ::= Operand2 , Operator, Operand1;
     * </pre>
     */
    case PREINFIX="preinfix";
    /**
     * Binary Post-Infix expression: The operator consists of a single token
     * that is placed between operand 1 and 2.
     * <pre>
     * Postinfix ::= Operand1 , Operator, Operand2;
     * </pre>
     */
    case POSTINFIX="postinfix";
}