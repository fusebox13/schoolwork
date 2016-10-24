<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Output
 *
 * @author Dan
 */
class Output {
    public function __construct() {
        
    }
    
    /**
     * Generate the HTML to output the parsed contents of the inputted file.
     */
    public static function parsedFile() {
        // Needed to properly display checkmarks
        header("content-type: text/html; charset=UTF-8");
        $file = File::getUpload();
        $message = '';
        
        if (File::isParsable($file['destination'], 'text')) {
            $data = DataParser::parseData($file['destination']);
            
            if ($data) {
                $tables = new Table($data);
                setlocale(LC_MONETARY, 'en_US.utf8');
                // Parent
                echo "<div>";
                // File Info
                echo "<div style='clear:both'>";
                echo $file['name'].' ('.$file['size'].') characters';
                echo "</div>";
                // Sales
                echo "<div style='clear:both'>";
                echo "Sales total: ".money_format('$%!n',$data->getSalesTotal());
                echo "</div>";
                // Accounts & Phone Nummbers
                if ($data->hasParity()) {
                    $tables->showTable('parity');
                } else {
                    echo "<h3 style='color:red'>Data is fragmented</h3>";
                    echo "✓ - best match";
                    $tables->showTable('heuristic');
                }
                echo "</div>";
           
            } else {
                $message .= "Failed to parse file.  ";
            }
        } else {
            if (!empty($file)) {
                $message.= "Unable to parse ".$file['type']." files.  ";
            } else {
                $message .= "Please upload a text file.  ";
            }
        }
        
        echo $message;

    }
}
