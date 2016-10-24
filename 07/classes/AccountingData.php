<?php

class AccountingData {
    private $accounts;
    private $phones;
    private $sales;
    private $totals;
    private $charCount;
    
    private $heuristicData;
    private $shift;
    
    /**
     * AccountingData is a data structure that stores parsed accounting data 
     * USE DataParser to create AccountingData objects
     * @param Array $accounts
     * @param Array $phones
     * @param Array $sales
     * @param int $radius
     * @throws Exception
     */
    public function __construct($accounts, $phones, $sales, $radius = 4) {
    
        if(is_array($accounts) && is_array($phones) && is_array($sales)) {
            $this->accounts = array_filter($accounts);
            $this->phones = array_filter($phones);
            $this->sales = array_filter($sales);
            $this->totals = array("acounts" => count($accounts),
                                  "phones" => count($phones),
                                  "sales" => count($sales));
            
            
            if (!$this->hasParity()) {   
                $this->heuristicData = $this->doHeuristics($this->getFragmentedData(), $radius);
            }
            
        } else {
            throw new Exception("Failed to construct AccountingData - all parameters must be arrays");
        }
    }
    
    /**
     * Looks at the size of the arrays for both sets of data to find the smaller
     * array.  Both data sets should be related and the smaller array needs to be
     * matched with the extra data. 
     * @return Multi-dimensional Array
     */
    private function getFragmentedData() {
        if (count(array_unique($this->accounts)) < count(array_unique($this->phones))) {
            return array('accounts' =>  $this->accounts, 'phone numbers' => $this->phones);
        }
        else {
            return array('phone numbers' => $this->phones, 'accounts' => $this->accounts);
        }
    }
    
    /**
     * Looks at the smaller data set and determines the distance of each data point
     * to the data in the larger data set.  This works because of how the REGEX filters
     * the subpatterns.  Given a radius, we can determine how close data points are to
     * each other.
     * @param type $fragmentedData
     * @return Multi-dimensional Array
     */
    private function doHeuristics($fragmentedData, $radius) {
        $heuristicData = array();
        $this->shift = 0;
        $keys = array_keys($fragmentedData);
        foreach ($fragmentedData[$keys[0]] as $index => $value) {
            $heuristicData[]=array($keys[0] => $fragmentedData[$keys[0]][$index],
                $keys[1] => $this->findNearestMatches($fragmentedData[$keys[1]], $index, $radius));
        }
        
        //Computes the data shift -1: to the left, 1: to the right, 0: indeterminate
        if ($this->shift != 0) {
            $this->shift = ($this->shift > 0) ? 1 : -1;
        }
        
        return $heuristicData;
      
    }
    
    /**
     * Helps the doHeuristics() method find the distance, but also does a quick
     * statistical analysis to determine the data shift('left' if the data points
     * from the larger set are more often located to the left of the data points 
     * from the smaller set and visa versa.
     * @param type $fragmentedData
     * @param type $index
     * @param type $radius
     * @return type
     */
    private function findNearestMatches($fragmentedData, $index, $radius) {
        $nearestMatches = array();
        foreach($fragmentedData as $key => $value) {
            $distance = $key - $index;
            
            if (abs($distance) == 1) {
                $this->shift+=$distance;
            }
            if (abs($distance) < $radius) {
                $nearestMatches[]=array("value" => $value, "distance" => $distance);
            }
        }
        
        return $nearestMatches;
    }
    
    
    /**
     * If the totals array only has one unique value, the totals are all the same
     * and the data is in parity.
     * @return boolean
     */
    public function hasParity() {
        return (count($this->accounts) == count($this->phones));
    }
    
    /**
     * Gets parsed account numbers 
     * @return Array
     */
    public function getAccounts() {
        return $this->accounts;
    }
    
    
    public function getHeuristicData() {
        return $this->heuristicData;
    }
    /**
     * Gets parsed phone numbers
     * @return Array
     */
    public function getPhones() {
        return $this->phones;
    }
    /**
     * Gets parsed sales
     * @return Array
     */
    public function getSales() {
        return $this->sales;
    }
    /**
     * Gets the sum of all the sales
     * @return type
     */
    public function getSalesTotal() {
        return array_sum($this->sales);
    }
    
    /**
     * When heuristic analysis is performed, the shift is calculated.  This number
     * will be either 0, 1 or -1.  If the shift is 1, the corresponding data point
     * will likely be to the right.  If the shift is -1 the data point will be to the left.
     * And if the shift is 0, the corrsponding datapoint cannot be determined.
     * @return int
     */
    public function getShift() {
        return $this->shift;
  
    }
    
}
