<?php

/**
 * Description of Display
 * Outputs all of the HTML
 * @author Williams
 */

namespace display;
class Display {
    
    /**
     * Displays the questions
     */
    public static function questions(){
        $questionCount = $_SESSION['questionCount'];
        $submitValue = ($questionCount == count($_SESSION['questions'])-1)?'Score Test':'Next';
        if ($questionCount < count($_SESSION['questions'])) {
            $question = $_SESSION['questions'][$questionCount];
            echo "<form method='GET' action='/~dwilli11/CPS276/09/index.php'>";
            echo "<input type='hidden' name='action' value='answer'>";
            Display::questionDiv($question, $questionCount+1);
            echo "<input type='submit' value='$submitValue'>";
            echo "<input type='hidden' name='IE' value='$question->IE'>";
            echo "<input type='hidden' name='SN' value='$question->SN'>";
            echo "<input type='hidden' name='FT' value='$question->FT'>";
            echo "<input type='hidden' name='JP' value='$question->JP'>";
            echo "</form>";
        } else {
            \display\Display::showResults();
        }
    }
    
    /**
     * Generates a Question div when passed a Question object
     * @param \questions\Question $question
     * @param type $questionCount
     */
    private static function questionDiv(\questions\Question $question, $questionCount) {
        $answerOrder = rand(0,1);
        
        echo "<div class='question-parent'>";
        echo "<div class='question'>".($questionCount).'. '."$question->question</div>";
        echo "<div class='answers'>";
        if ($answerOrder == 0) {
        echo "<div class='answer'><input type='radio' name='answer' value='1'>".ucfirst($question->answer_a)."</div>";
        echo "<div class='answer'><input type='radio' name='answer' value='-1'>".ucfirst($question->answer_b)."</div>";
        }
        else {
        echo "<div class='answer'><input type='radio' name='answer' value='-1'>".ucfirst($question->answer_b)."</div>";
        echo "<div class='answer'><input type='radio' name='answer' value='1'>".ucfirst($question->answer_a)."</div>";
        }
        echo "</div>";
        echo "</div>";
    }
    
    /**
     * HTML Form for a new test
     */
    public static function newTest() {
        echo "<form method='get' action='index.php'>";
        echo "<input type='hidden' name='action' value='start'>";
        echo "<input type='text' name='name' placeholder='name'>";
        echo "<input type='submit' value='submit'>";
        echo "</form>";
    }
    
    /**
     * Results output
     */
    public static function showResults() {
        $result = '';
        $IE = $_SESSION['IE'];
        $SN = $_SESSION['SN'];
        $FT = $_SESSION['FT'];
        $JP = $_SESSION['JP'];
        $result.= $IE < 0?'I':'E';
        $result.= $SN < 0?'S':'N';
        $result.= $FT < 0?'F':'T';
        $result.= $JP < 0?'J':'P';
        echo "Based on your answers to these questions, your score is as follows: ";
        echo "<a href='http://en.wikipedia.org/wiki/$result'>$result</a><br/>";
    }
}
