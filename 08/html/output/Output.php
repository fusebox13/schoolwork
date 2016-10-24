<?php

/*
 * HTML object that outputs computations.
 */

/**
 * Description of Output
 *
 * @author Dan
 */
namespace html\output;
class Output {
    
    /**
     * Recieves from POST the number of circus performers calculates the insurance
     * index and rate and outputs the calculation     */
    public function circusInsuranceQuery() {
        
        
        if ($_POST) {
            $employees = new \circus\Employees();
            $insurer = new \insurer\Insurer();
            
            $numClowns = abs(intval(filter_input(INPUT_POST, 'Clown')));
            $numHumanCannonballs = abs(intval(filter_input(INPUT_POST, 'HumanCannonball')));
            $numJugglers = abs(intval(filter_input(INPUT_POST, 'Juggler')));
            $numLionTamers = abs(intval(filter_input(INPUT_POST, 'LionTamer')));
            $numMimes = abs(intval(filter_input(INPUT_POST, 'Mime')));
            $numTrapezeArtists = abs(intval(filter_input(INPUT_POST, 'TrapezeArtist')));


            $employees->addEmployees(new \circus\performer\Clown(), $numClowns);
            $employees->addEmployees(new \circus\performer\HumanCannonball(), $numHumanCannonballs);
            $employees->addEmployees(new \circus\performer\Juggler(), $numJugglers);
            $employees->addEmployees(new \circus\performer\LionTamer(), $numLionTamers);
            $employees->addEmployees(new \circus\performer\Mime(), $numMimes);
            $employees->addEmployees(new \circus\performer\TrapezeArtist(), $numTrapezeArtists);
            try {
                $insurer->insure($employees);
                echo 'Index: '.number_format($employees->index,2).'</br>';
                echo 'Rate: $'.number_format($employees->rate,2).'</br>';
            } catch (\Exception $e) {
                echo "Error: ".$e->getMessage();
            }
            //$employees->getBreakdown();
            
        }
        
    }
}
