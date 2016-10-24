<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Performer
 *
 * @author Dan
 */
namespace circus\performer;
abstract class Performer {
    protected $profit;
    protected $risk;
    protected $terror;
    
    public function __construct($profit = 0, $risk = 0, $terror = 0) {
        $this->profit = $profit;
        $this->risk = $risk;
        $this->terror = $terror;
        
    }
    
    public function __get($name) {
        switch($name){
            case 'profit':
                return $this->profit;
            case 'risk':
                return $this->risk;
            case 'terror':
                return $this->terror;
            default:
                return null;
        }
    }
    
    public function __set($name, $value) {
        switch($name) {
            case 'profit':
                $this->profit = $value;
                break;
            case 'risk':
                $this->risk = $value;
                break;
            case 'terror':
                $this->terror = $value;
                break;
            default:
                return false;
        }
    }
    
    public function setProfit($value) {
        $this->profit = $value;
    }
    public function setRisk($value) {
        $this->risk = $value;
    }
    public function setTerror($value) {
        $this->terror = $value;
    }
    
    
    public function __toString() {
        $reflect = new \ReflectionClass($this);
        return $reflect->getShortName();
    }
}
