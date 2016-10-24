<?php

namespace questions;
class Question {
    private $id;
    private $question;
    private $answer_a;
    private $answer_b;
    private $IE;
    private $SN;
    private $FT;
    private $JP;
    
    public function __construct($id, $question, $answer_a, $answer_b, $IE, $SN, $FT, $JP ){
        $this->id = $id;
        $this->question = $question;
        $this->answer_a= $answer_a;
        $this->answer_b= $answer_b;
        $this->IE = $IE;
        $this->SN = $SN;
        $this->FT = $FT;
        $this->JP = $JP;
        
    }
    
    public function __get($name) {
        switch ($name) {
            case 'id': return $this->id;
            case 'question': return $this->question;
            case 'answer_a': return $this->answer_a;
            case 'answer_b': return $this->answer_b;
            case 'IE': return $this->IE;
            case 'SN': return $this->SN;
            case 'FT': return $this->FT;
            case 'JP': return $this->JP;
            default: return null;
        }
    }
    
}
