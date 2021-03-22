<?php

/**
 * @author Rik Verbeek
 * @since 2021-03-21
 * 
 * The assignment was to show the numbers 1 to 100 and show different texts depending on the multiple.
 */
class Number 
{
    // Check if input is multiple of check
    static public function isMultiple(int $number, int $check) : bool 
    {
        return $number % $check === 0;
    }
}

for($number = 1; $number < 101; $number++) {
    $ismultipleof3 = Number::isMultiple($number, 3);
    $ismultipleof5 = Number::isMultiple($number, 5);

    if($ismultipleof3 && $ismultipleof5) {
        echo 'FizzBuzz';
    }
    else if($ismultipleof3) {
        echo 'Fizz';
    }
    else if($ismultipleof5) {
        echo 'Buzz';
    }
    else {
        echo $number;
    }

    echo "\n";
}