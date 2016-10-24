<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HumanCannonball
 *
 * @author Dan
 */
namespace circus\performer;
class HumanCannonball extends Performer {
    
    public function __construct($profit = 2, $risk = 5, $terror = 3) {
        Performer::__construct($profit, $risk, $terror);
    }
}
