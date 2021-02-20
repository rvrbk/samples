<?php

namespace Test;

class Unit 
{
    static public function assert($assertion, $output) 
    {
        if($assertion == $output) {
            return ':) Expected \'' . $assertion . '\' and got it!' . "\n";
        }

        return ':( Expected \'' . $assertion . '\' but got ' . $output . '.' . "\n";
    }
}

?>