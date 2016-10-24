<?php

/*
 * Employees is a collection of Performers that can or cannot be insured.
 */

/**
 * Description of Circus
 *
 * @author Dan
 */
namespace circus;
class Employees implements \IteratorAggregate, \insurer\Insurable {
    
    private $employees = array();
    private $totalEmployees;
    private $index;
    private $rate;
    
    /**
     * Adds a new performer type to the collection as well as the total amount
     * of performers of that type.  Throws an exception if something other than
     * a performer is added to the collection.
     * @param type $performer
     * @param type $total
     * @throws Exception
     */
    public function addEmployees($performer, $total) {
        
        if (is_subclass_of($performer, 'circus\performer\Performer')) {
            $this->employees[]=array('type'=>$performer, 'total' => $total);
            $this->totalEmployees+=$total;
        } else {
            throw new Exception('Invalid argument - Please pass a circus/performer/Performer child class.');
        }
    }
    
    /**
     * Returns the total amount of employees in the collection.
     * @return int
     */
    public function getTotalEmployees() {
        return $this->totalEmployees;
    }
    
    /**
     * Gets the collection of employees.
     * @return Multi-dimensional Array
     */
    public function getEmployees() {
        return $this->employees;
    }
    
    /**
     * @Overriden method used to iterate through the Employees object.
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new \ArrayIterator($this->employees);

    }
    
    /**
     * Getters
     * @param String $name
     * @return Multi
     */
    public function __get($name) {
        switch($name) {
            case 'employees':
                return $this->employees;
            case 'totalEmployees':
                return $this->totalEmployees;
            case 'index':
                return $this->index;
            case 'rate':
                return $this->rate;
            default:
                return null;
        }
    }
    
    /**
     * Prints the contents of the collection.
     */
    public function getBreakdown() {
        echo "<pre>";
        \print_r($this->employees);
        echo "</pre>";
        
        
    }
    
    /**
     * Actuarial objects can modify the employees collection to add an index.
     * This returns the index calculated by the actuarial object.
     * @return int
     */
    public function getIndex(){
        return $this->index;
    }
    
    
    // Dev Note:  This object relationship could be better designed.
    
    /**
     * Actuarial objects can modify the employees collect to add a rate.
     * This returns the rate calculated by the actuarial object.
     * @return int
     */
    public function getRate(){
        return $this->rate;
    }
    
    /**
     * Iterates through the entire collection of employees and sums the profit.
     * @return int
     */
    public function getTotalProfit() {
        $profit = 0;
        foreach ($this as $employee) {
            $profit += $employee['type']->profit * $employee['total'];
        }
        return $profit;
    }
    
    /**
     * Iterates through the entire collection of employees and sums the risk.
     * @return int
     */
    public function getTotalRisk() {
        $risk = 0;
        foreach ($this as $employee) {
            $risk += $employee['type']->risk * $employee['total'];
        }
        return $risk;
        
    }
    
    /**
     * Iterates through the entire collection of employees and sums the terror.
     * @return int
     */
    public function getTotalTerror() {
        $terror = 0;
        foreach ($this as $employee) {
            $terror += $employee['type']->terror * $employee['total'];
        }
        return $terror;
    }
    
    /**
     * Overwrites the employees array if another array is passed.
     * @param Array $value
     */
    public function setEmployees($value) {
        if (is_array($value)) {
            $this->employees = $value;
        }
    }
    
    /**
     * Used by actuarial objects to set the index of the employees
     * @param int $value
     */
    public function setIndex($value) {
        $this->index = $value;
    }
    /**
     * Used by the actuarial objects to set the rate for the collection of
     * employees.
     * @param int $value
     */
    public function setRate($value) {
        $this->rate = $value;
    }

}
