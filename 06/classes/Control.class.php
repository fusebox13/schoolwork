<?php

class Control {
    
    public $method;
  
    /**
     * Constructor
     * @param type $method
     */
    public function __construct($method) {
        $this->method = $method;
      
    }
    /**
     * Show calls all create methods but this app has only one 
     */
    public function showControls() {
        $this->createZipEntry();
    }
    
    /**
     * Creates a standalone form inside a div that can be created anywhere
     */
    private function createZipEntry() {
        echo "<div class='zipform'>";
        echo "<form method='$this->method' action='index.php'>";
        echo "<input type='hidden' name='action' value='search'>";
        echo "<input class='zipinput' type='text' name='zip' placeholder='zipcode'/><br/>";
        echo "<input class='zipinput' type='submit' value='Submit'/>";
        echo "</form>";
        echo "</div>";
    }
    
}

?>
