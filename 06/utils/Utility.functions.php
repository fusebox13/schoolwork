<?php

/**
 * Compares a zipcode to the regex pattern for U.S. Zipcodes
 * http://stackoverflow.com/questions/160550/zip-code-us-postal-code-validation
 * @param type $zipcode
 * @return int
 */
function validZipCode($zipcode) {
    
    $zip_regex = '/(^\d{5}$)|(^\d{5}-\d{4}$)/';
    return preg_match($zip_regex, $zipcode);
}

