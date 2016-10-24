<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Table
 *
 * @author Dan
 */
class Table {
    
    private $data;
    /**
     * Creates a table from an array of data.  A header can also be passed
     * to the constructor, or can be set by the setHeader method.
     * @param AccountingData $data
     * @throws Exception
     */
    public function __construct($data){
        if ($data instanceof AccountingData && $data != null) {
            $this->data = $data;   
        }
        else {
            throw new Exception("Failed to created Table - invalid parameter.");
        }
    }
    
    
    /**
     * Shows a table based on the header
     * @param string $header
     * @throws Exception
     */
    public function showTable($header) {
        
        switch ($header) {
            case 'parity':
                $this->createParityTable();
                break;
            case 'accounts':
                $this->createTable($this->data->getAccounts(), $header);  
                break;
            case 'phone numbers':
                $this->createTable($this->data->getPhones(), $header);
                break;
            case 'heuristic':
                $this->createHeuristicTable($this->data->getHeuristicData());
                break;
            default:
                throw new Exception('Invalid header!');
        }   
        
    }
    
    /**
     * Generates the HTML to print a table
     * @param Array $data
     * @param String $header
     */
    private function createTable($data, $header) {
        $total = count($data);
        echo "<table border='1' style='float:left'>";
      
        echo "<th>".ucwords($header) ."($total results)</th>";
       
        foreach($data as $row) {
            echo"<tr><td>$row</tr></td>";
        }
        echo "</table>";
    }
    
    
    /**
     * Creates a combo table
     */
    public function createParityTable() {
        $this->showTable('phone numbers');
        $this->showTable('accounts');
    }
    
    /**
     * Generates the HTML for a Heuristic table which allows the user to see
     * what data is missing, and what data is likely a match.
     * @param Multi-Dimensional Array $heuristicData
     */
    public function createHeuristicTable($heuristicData) {
            
            $keys = array_keys($heuristicData[0]);
            echo "<table border='1'>";
            echo '<th>'.ucwords($keys[0]).'</th>';
            echo '<th>'.ucwords($keys[1]).'</th>';
            foreach($heuristicData as $datapoint) {
                echo "<tr>";
                echo '<td>'.$datapoint[$keys[0]].'</td>';
                echo '<td><select>';
                echo "<option>Possible Matches</option>";
                foreach ($datapoint[$keys[1]] as $matches){
                    
                    $selected = $matches['distance'] == $this->data->getShift()?'selected':'';
                    $bestMatch = $selected?' ✓':' ('.$matches['distance'].')';
                    
                    echo "<option $selected>".$matches['value'].''.$bestMatch.'</option>';
                }
                echo '</select></td>';
                echo "</tr>";
            }
            echo "</table>";
    }
    
    
    
}
