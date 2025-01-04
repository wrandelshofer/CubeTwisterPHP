<?php
/*
 * @(#)CMCube.php
 * Copyright © 2025 Werner Randelshofer, Switzerland. MIT License.
 */

/**
 * References:
 * - StackOverflow: https://stackoverflow.com/questions/20210324/php-stack-implementation
 */
class Stack {

    protected array $stack;

    public function __construct() {
        $this->clear();
    }

    public function push($item) {
        // prepend item to the start of the array
        array_unshift($this->stack, $item);
    }

    public function pop() {
        if ($this->isEmpty()) {
            // trap for stack underflow
            throw new RunTimeException('Stack is empty!');
        } else {
            // pop item from the start of the array
            return array_shift($this->stack);
        }
    }

    public function clear() {
        $this->stack = array();
    }

    public function top() {
        return current($this->stack);
    }

    public function isEmpty() {
        return empty($this->stack);
    }

}