<?php

namespace Rubid;

class Repl {

    public function run() {
        $memory = null;

        while(($code = readline("\n>> ")) !== 'exit') {
            $rubid = new Rubid($code, $memory);
            $rubid->result();
            $memory = $rubid->getMemory();
        }

        echo "Exiting. See Ya !\n";
    }
}