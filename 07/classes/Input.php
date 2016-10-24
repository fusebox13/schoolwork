<?php

class Input {
    
    public function __construct() {
        
    }
    
    /**
     * Generate the HTML to input a file
     */
    public static function File() {
        echo "<form method='post' action='index.php' enctype='multipart/form-data'>";
        echo "<input type='file' name='myfile'>";
        echo "<input type='submit' value='upload'>";
        echo "</form>";
    }
}
