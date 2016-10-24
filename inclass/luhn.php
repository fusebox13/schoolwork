<?php

/*
 * This functions tells us whether a given number conforms to the luhn checksum
 */

/**
 * Luhn number check
 * @param int $number
 * @return boolean
 */
function isLuhn($number) {
    $number = abs(intval($number));
    
    if ($number < 10)
        return false;
    
    // 1 Split into parts
    //http://php.net/manual/en/function.str-split.php
    $digits = str_split($number);
    
    //2 reverse the array;
    $digits = array_reverse($digits);
    
    $n = count($digits);
    
    //3 Double ever other digit
    for ($i = 1; $i < $n; $i+=2) {
        $digits[$i]*=2;
    }
    //4 Fixing numbers over 9
    
    for ($i =1; $i < $n ; $i++) {
        $d = $digits[$i];
        
        if ($d > 9) {
            $digits[$i] = $d-9;
        }
            
    }
    
    //5 Sum of digits
    $sum = array_sum($digits);
    
    if ($sum % 10 == 0)
        return true;
    
    return false;
    
}

