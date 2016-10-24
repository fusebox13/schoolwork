<?php
include 'utils/Utility.functions.php';
include 'classes/SQL.class.php';
include 'classes/Control.class.php';

/**
 * Dev Note:  The create methods contain HTML while the show methods do not.  
 * Create, creates individual elements while show the determines the order the 
 * the elements are positioned.
 */
class View {
    
    private $error;
    private $sql;
    private $control;
    private $header;
    
    /**
     * Constructor
     * SQL is the Model object, Control is the Control object
     */
    public function __construct() {
        $this->sql = new SQL();
        $this->control = new Control('post');
        $this->error = ''; 
    }
    
    /**
     * Shows the control, then filters input incoming from the control to show
     * either an error or the results.
     */
    public function showView() {
        $this->control->showControls();
        $action = filter_input(INPUT_POST, 'action');
        $zip = filter_input(INPUT_POST, 'zip');
        switch ($action) {
            case 'search':
                $this->showLocation($zip);
                $this->showResults($zip);
                break;
            default:
                break;
        }
        echo $this->error;
    }
    
    /**
     * Shows the location div if there is a valid zip code
     * @param type $zipcode
     */
    private function showLocation($zipcode) {
        if(validZipCode($zipcode)) {
            $this->createLocation($zipcode);
        }
        else {
            $this->error = "Error: Invalid zipcode.<br/>";
        }
    }
    
    /**
     * Creates the HTML for the location element
     * @param type $zipcode
     */
    private function createLocation($zipcode) {
        $this->header = $this->sql->getLocation($zipcode);
        echo "<div class='location'>";
        if ($this->header) {
            echo "<h1>Instructors near ".$this->header->location_name." ".$this->header->state." ".$this->header->zipcode."</h1>";
        } else  {
            $this->error = "Error: Location not found.<br/>";
        }
        echo "</div>";
    }
    
    /**
     * Shows the results div if there is a valid zipcode
     * @param type $zipcode
     */
    private function showResults($zipcode) {
        if (validZipCode($zipcode)) {
            $this->createResults();
        } else {
            $this->error = 'Invaid zip code';
        }
    }
    
    /**
     * Creates the HTML for the results element
     */
    private function createResults() {
        $results = $this->sql->getResults($this->header->latitude, $this->header->longitude, 25);
        echo "<div class='results'>";
        if ($results->rowCount() > 0) {
            echo '<div>'.$results->rowCount().' instructors</div>';
            while ($row = $results->fetchObject()) {
                $this->createRow($row);
            }
        } else {
            $this->error = 'None';
        }
        echo "</div>";
    }
    
    /**
     * Creates the HTML for a row in the result set
     * Used by createResults()
     * @param type $row
     */
    private function createRow($row) {
        $distance = $row->distance > 0 ? number_format($row->distance,2) : $row->distance;
        echo "<div class='row'>";
        echo "<div class='row-header'>";
        echo "<div class='row-header-person'>$row->person_name</div>";
        echo "<div class='row-header-distance'>$distance miles</div>";
        echo "</div>";
        echo "<div class='row-location'>$row->location_name $row->state, $row->zipcode</div>";
        echo "<div class='row-subject'>$row->subject_label ($row->provider_number)</div>";
        echo "</div></br>";
        
    }
}

