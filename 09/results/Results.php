<?php

namespace results;
class Results {
    
    /**
     * Updates the results in the session.  A better way would be to store
     * a results model in the session and update the model, but I didn't have 
     * time to get that all implemented.
     * @param type $debug
     */
    public static function updateResults($debug = false){
        
        if (isset($_REQUEST['answer'])) {
            $answerBias = $_REQUEST['answer'];
            $_SESSION['IE']+=filter_input(INPUT_POST, 'IE') * $answerBias;
            $_SESSION['SN']+=filter_input(INPUT_POST, 'SN') * $answerBias;
            $_SESSION['FT']+=filter_input(INPUT_POST, 'FT') * $answerBias;
            $_SESSION['JP']+=filter_input(INPUT_POST, 'JP') * $answerBias;
            $_SESSION['questionCount']++;
            
            
            if ($debug) {
            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";
            }
        }
    }
    
    
}
