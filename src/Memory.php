<?php

namespace Rupid;

use RuntimeException;

class Memory {
    protected array $stack;
    protected int $limit;

    public function __construct($limit = 64, $initial = []) {
        $this->stack = $initial;
        $this->limit = $limit;
    }

    public function push($item) {
        if (count($this->stack) < $this->limit) {
            array_unshift($this->stack, $item);
        } else {
            throw new RuntimeException('Memory is full');
        }
    }

    public function pop() {
        if ($this->isEmpty()) {
            throw new RunTimeException('Memory is empty');
        } else {
            return array_shift($this->stack);
        }
    }

    public function top() {
        return current($this->stack);
    }

    public function isEmpty() {
        return empty($this->stack);
    }

    public function addition() {
        if (count($this->stack) < 2) {
            throw new RunTimeException('Not enought element in stack for this addition');
        } 
        
        $a = $this->pop();
        $b = $this->pop();

        $this->push($a + $b);
    }

    public function substraction() {
        if (count($this->stack) < 2) {
            throw new RunTimeException('Not enought element in stack for this substraction');
        } 
        
        $a = $this->pop();
        $b = $this->pop();

        $this->push($a - $b);
    }

    public function multiplication() {
        if (count($this->stack) < 2) {
            throw new RunTimeException('Not enought element in stack for this multiplication');
        } 
        
        $a = $this->pop();
        $b = $this->pop();

        $this->push($a * $b);
    }

    public function division() {
        if (count($this->stack) < 2) {
            throw new RunTimeException('Not enought element in stack for this division');
        } 
        
        $a = $this->pop();
        $b = $this->pop();

        $this->push($a / $b);
    }

    public function decrease(int $time = 1) {
        $current_number = $this->pop();
        $current_number -= $time;
        $this->push($current_number);
    }

    public function increase(int $time = 1) {
        $current_number = $this->pop();
        $current_number += $time;
        $this->push($current_number);
    }

    public function multiply(int $time) {
        $current_number = $this->pop();
        $current_number *= $time;
        $this->push($current_number);
    }

    public function ascii() {
        return chr($this->top());
    }

    public function reset() {
        $this->stack = [];
        $this->push(0);
    }

    public function printStack() {
        echo "\nMemory limit : ", $this->limit, "\n";
        echo "Current stack container used : ", count($this->stack),"\n";
        foreach($this->stack as $element ) {
            echo $element, "\n";
        }
    }

    public function __toString()
    {
        return $this->top();
    }
}