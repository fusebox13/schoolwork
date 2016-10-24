<?php

/*
 * Insurers do acturial calculations on insurable objects.
 */

/**
 * Description of Insurer
 *
 * @author Dan
 */
namespace insurer;

class Insurer implements Actuarial {
    
    private $totalEmployees;
    private $totalRisk;
    private $totalTerror;
    private $totalProfit;
    private $underwriterStatement;
    
    
    
    public function __construct() {
    }
    
    /**
     * Determines if an insurable object can be insured.
     * @param \insurer\Insurable $insurable
     * @throws \Exception
     */
    public function insure(Insurable $insurable) {
        if($insurable->getTotalEmployees() > 0)
        {
            $this->addRiskFactor($insurable);
            if($this->isInsurable($insurable)) {
                $this->setRate($insurable);
            }
            else {
                echo "Do not insure.<br/>";
                echo $this->underwriterStatement;
            }
        } else {
            throw new \Exception("Please enter at least one employee.");
        }
        
    }
    
    /**
     * Modifies the collection of insurable objects by added a rate and an index
     * to their data structure.
     * @param \insurer\Insurable $insurable
     * @param boolean $debug
     */
    private function addRiskFactor(Insurable $insurable, $debug = false) {
        $total = $insurable->totalEmployees;
        $employees = $insurable->employees;
        
        for ($i = 0; $i < count($employees); $i++) {
            if (floatval($employees[$i]['total'] / $total) > 0.50) {
                $employees[$i]['type']->risk *= $employees[$i]['type']->risk;
                $employees[$i]['type']->profit *= 2;
                $employees[$i]['riskfactor'] = 'high';
            } else if (floatval($employees[$i]['total'] / $total) > 0.20) {
                $employees[$i]['type']->risk*=2;
                $employees[$i]['type']->profit*=1.5;
                $employees[$i]['riskfactor'] = 'moderate';
            } else {
                $employees[$i]['riskfactor'] = 'low';
            }
        }
        $insurable->setEmployees($employees);
        
        if ($debug) {
            echo "<pre>";
            print_r($employees);
            echo "</pre>";
        }
        
    }
    
    /**
     * Checks the insurable object against this insurer's specific rules to 
     * determine if the insure method can continue to compute the rate and the index.
     * @param \insurer\Insurable $insurable
     * @return boolean
     */
    public function isInsurable(Insurable $insurable) {
        $this->getTotals($insurable);
        
        if ($this->totalProfit/$this->totalEmployees < 1) {
            $this->underwriterStatement = 'Not profitable.<br/>';
            return false;
        }
        
        if($this->totalRisk > $this->totalTerror) {
            $this->underwriterStatement = 'To much risk.<br/>';
            return false;
        }
        
        return true;
        
    }
    
    /**
     * Dumps the totals from the collection of insurable objects into the 
     * acturial object in order to do further calculations.
     * @param \insurer\Insurable $insurable
     * @param boolean $debug
     */
    private function getTotals(Insurable $insurable, $debug = true) {
        $this->totalEmployees = $insurable->getTotalEmployees();
        $this->totalProfit = $insurable->getTotalProfit();
        $this->totalRisk = $insurable->getTotalRisk();
        $this->totalTerror = $insurable->getTotalTerror();
        
        if($debug) {
            echo 'Total Employees: '.$this->totalEmployees.'<br/>';
            echo 'Total Profit: '.$this->totalProfit.'<br/>';
            echo 'Total Risk: '. $this->totalRisk.'<br/>';
            echo 'Total Terror: '.$this->totalTerror.'<br/>';
        }
    }
    
    /**
     * Updates the insurable object to add an index to the data structure.
     * @param \insurer\Insurable $insurable
     */
    private function setIndex(Insurable $insurable) {
        $insurable->setIndex(100-(($this->totalTerror - $this->totalRisk) / ($this->totalProfit * 2) * 100));
    }
    /**
     * Updates the insurable object to add a rate to the data structure.
     * @param \insurer\Insurable $insurable
     */
    private function setRate(Insurable $insurable) {
        $this->setIndex($insurable);
        $insurable->setRate(0.37 * $insurable->index * $insurable->totalEmployees);
    }
    

}
