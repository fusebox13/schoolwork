<?php

class Slot {
    private $team;
   
    /**
     * Set the Team
     * @param Team $team
     */
    public function setTeam(Team $team) {
        
        $this->team = $team;
    }
    
    /**
     * Returns true if a team is slotted
     * False if a team is not slotted
     * @return boolean
     */
    public function hasTeam() {
        return ($this->team)?true:false;
    }
    
    /**
     * Get the Team
     * @return Team
     */
    public function getTeam() {
        return $this->team;
    }
    
}

