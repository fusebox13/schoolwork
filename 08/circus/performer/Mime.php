<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mime
 *
 * @author Dan
 */
namespace circus\performer;
class Mime extends Performer {
    
    public function __construct($profit = 0, $risk = 0, $terror = 0.5) {
        Performer::__construct($profit, $risk, $terror);
    }
}
