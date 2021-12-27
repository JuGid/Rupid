<?php

namespace Rubid;

use LogicException;
use Rupid\Memory;

class Rubid {

    private const AVAILABLE_CHAR_REGEX = '/[a-zA-Z0-9;\*\=\(\)\.\!\-]/';

    private array $code_array;

    private int $curr_index;

    private Memory $memory;

    public function __construct(string $code, ?Memory $memory = null)
    {
        $this->code_array = str_split($code, 1);
        $this->curr_index = 0;

        if($memory === null) {
            $this->memory = new Memory();
            $this->memory->push(0);
        } else {
            $this->memory = $memory;
        }
    }

    public function increment(int $numberOfIncrementation = 1) : void {
        $this->curr_index += $numberOfIncrementation;
    }

    public function readCurrent() {
        return $this->readNext(0);
    }

    public function readNext(int $offsetFromCurrent = 1) : bool|string {
        if(!isset($this->code_array[$this->curr_index+$offsetFromCurrent])) {
            return false;
        }

        return $this->code_array[$this->curr_index+$offsetFromCurrent];
    }

    public function getNext() : bool|string {
        if(!isset($this->code_array[$this->curr_index])) {
            return false;
        }

        $character = $this->code_array[$this->curr_index];
        $this->increment();

        return $character;
    }

    private function validate() : int|bool {
        $error_position = -1;

        foreach($this->code_array as $position => $char) {
            if (!preg_match(self::AVAILABLE_CHAR_REGEX, $char)) {
                $error_position = $position;
            }
        }

        return !($error_position > -1);
    }

    public function result() {
        if(($position = $this->validate()) !== true) {
            throw new LogicException('A character is not valid at position '. $position);
        }

        while(($current = $this->getNext()) !== false) {
            if(preg_match('/[a-z]/', $current)) {
                $this->functionnal($current);
            } elseif(preg_match('/[A-Z]/', $current)) {
                $this->method($current);
            } elseif(preg_match('/[0-9]/', $current)) {
                $this->number($current);
            } elseif(preg_match('/[;\.\(\!\-\*]/', $current)) {
                $this->operator($current);
            }
            else {
                throw new LogicException('Invalid character ' . $current . ' at position ' . $this->curr_index);
            } 
        }
    }

    private function functionnal(string $char) : void {
        switch($char) {
            case 'd':
                if($this->readCurrent() === '*' && is_numeric($this->readNext(1))) {
                    $this->increment(1);
                    $this->memory->decrease(intval($this->getNext()));
                } else {
                    $this->memory->decrease();
                }
                break;
            case 'u':
                if($this->readCurrent() === '*' && is_numeric($this->readNext(1))) {
                    $this->increment(1);
                    $this->memory->increase(intval($this->getNext()));
                } else {
                    $this->memory->increase();
                }
                break;
        }
    }

    private function method(string $char) : void {
        switch($char) {
            case 'A':
                $this->memory->addition();
                break;
            case 'C':
                echo $this->memory->ascii();
                break;
            case 'D':
                $this->memory->division();
                break;
            case 'M':
                $this->memory->multiplication();
                break;
            case 'N':
                echo "\n";
                break;
            case 'P':
                echo $this->memory;
                break;
            case 'S':
                $this->memory->substraction();
                break;
            case 'U':
                while(!is_numeric($input = readline("User input >> ")));
                $this->memory->push(intval($input));
            case 'W':
                echo " ";
                break;
        }
    }

    private function number(string $char) : void {
        
    }

    private function operator(string $char) : void {
        switch($char) {
            case ';':
                $this->memory->push(0);
                break;
            case '.':
                $this->memory->reset();
                break;
            case '(':
                $counter = $this->memory->top();
                $code = '';
                while(($char = $this->getNext()) != ')') {
                    $code.=$char;
                }

                $this->memory->push(0);

                for($i=0; $i< intval($counter); $i++) {
                    $rupid = new self($code, $this->memory);
                    $rupid->result();
                    $this->memory = $rupid->getMemory();
                }
                break;
            case '*':
                $times = $this->getNext();
                if(is_numeric($times)) {
                    $this->memory->multiply(intval($times));
                }
                break;
            case '-':
                $this->memory->pop();
                break;
            case '!':
                $this->memory->printStack();
                break;
        }
    }

    public function getMemory() : Memory {
        return $this->memory;
    }
}