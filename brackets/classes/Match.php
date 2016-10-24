<?php

class Match {
   
    private $slot0;
    private $slot1;
    private $winner;
    private $status=0; // 0=not run, 1=run
    
    public function __construct() {
        $this->slot0 = new Slot();
        $this->slot1 = new Slot();
    }
    
    /**
     * Get Slot by Index Number
     * @param Integer $i
     * @return Slot
     * @throws Exception
     */
    public function getSlot($i) {
        if ($i == 0) {
            return $this->slot0;
        }
        else if ($i == 1) {
            return $this->slot1;
        } else {
            throw new Exception("getSlot out of range: ".$i);
        }
    }
    
    /**
     * Play the Match
     * @return null or Winning Team
     */
    public function play() {
        if($this->status == 1) return null;
        
        if(!$this->slot0->hasTeam() || !$this->slot1->hasTeam()) {
            return null;
        }
        
        $rank0 = $this->slot0->getTeam()->getRanking();
        $rank1 = $this->slot1->getTeam()->getRanking();
        
        $result = $this->_generate($rank0, $rank1);
        
        if($result == 0) {
            $this->winner = $this->slot0->getTeam();
        } else {
            $this->winner = $this->slot1->getTeam();
        }
        $this->status = 1;
        return $this->winner;
    }
    
    /**
     * Get the Winner
     * @return Team
     */
    public function getWinner() {
        return $this->winner;
    }
    
    
    /**
     * Selects a winner
     * @param Integer $rankA
     * @param Integer $rankB
     * @return Integer
     */
    private function _generate($rankA, $rankB) {
        $n1 = round(1/$rankA * 100);
        $n2 = round(1/$rankB * 100);
        $t = $n1 + $n2;
        
        $r = rand(0, $t);
        
        if ($r < $n1) {
            return 0;
        } else {
            return 1;
        }
        
    }
}
