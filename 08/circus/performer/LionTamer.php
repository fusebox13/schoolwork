<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LionTamer
 *
 * @author Dan
 */
namespace circus\performer;
class LionTamer extends Performer {
    
    public function __construct($profit = 2, $risk = 3, $terror = 2) {
        Performer::__construct($profit, $risk, $terror);
    }
}
