<?php

/**
 * Static class that reads in a file, and parses data
 */
class DataParser {
    /**
     * Checks to see if the passed file is parsable, must be MIME-Type Text.  Any
     * subtype of Text is accepted eg. Text/CSV, Text/Plain etc..  If the data is
     * parsable, attempt to extract accounting data from the passed file.
     * @param String $filename
     * @return \AccountingData
     * @return null if parseData failed
     */
    public static function parseData($filename){
            
        if(File::isParsable($filename, 'text')) {
            $rawfile = file_get_contents($filename);
            if (preg_match_all(RegexPattern::_MASTERKEY, $rawfile, $master)) {
                return new AccountingData($master[2], $master[1], $master[3]);
            }
            else {
                return null;
            }
        }
        return null;
     
    }
     
    
}
