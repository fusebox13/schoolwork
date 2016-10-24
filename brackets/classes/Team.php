<?php

class Team {
    private $name;
    private $ranking;
    
    /**
     * Constructor
     * @param type $rank
     * @param type $name
     */
    public function __construct($rank, $name) {
        $this->name = $name;
        $this->ranking = $rank;
    }
    
    /**
     * Get the Team Name
     * @return String
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Get the Team Ranking
     * @return Integer
     */
    public function getRanking() {
        return $this->ranking;
    }
    
}
