<?php

namespace questions;
class Questions {
    private $questions = array();
    
   
    
    private function __construct(){
        
    }
    
    public static function generateQuestions() {
        global $pdo;
        $questions = new Questions();
        $sql = 'SELECT * FROM a9_questions';
        $results = $pdo->query($sql);
        
        if ($results->rowCount() > 0) {
            while ($row = $results->fetchObject()) {
                $questions->addQuestion(new Question($row->id, $row->question, $row->answer_a, $row->answer_b, $row->IE, $row->SN, $row->FT, $row->JP));
                
            }
        }
        \shuffle($questions->questions);
        return $questions;
       
    }
    
    private function addQuestion(Question $question) {
        $this->questions[] = $question;
    }
    
    public function getQuestions() {
        return $this->questions;
    }

    
}

