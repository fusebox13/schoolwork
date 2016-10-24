<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Juggler
 *
 * @author Dan
 */
namespace circus\performer;
class Juggler extends Performer{
    
    public function __construct($profit = 1, $risk = 0, $terror = 1) {
        Performer::__construct($profit, $risk, $terror);
    }
    //put your code here
}
