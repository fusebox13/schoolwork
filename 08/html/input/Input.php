<?php

/*
 * HTML class that contains forms.
 */

/**
 * Description of Input
 *
 * @author Dan
 */
namespace html\input;
class Input {
    
    /**
     * Generates an HTML form for the insurance calculator.
     */
    public static function circusEmployees() {
        echo "<div class='input-calculator-parent'>";
        echo "<div class='input-calculator-header'>";
        echo "Insurance Calculator";
        echo "</div>";
        echo "<div class='input-calculator-form'>";
        echo "<form method='post' action='index.php'>";
        echo "<input type='text' name='LionTamer' placeholder='# of Lion Tamers'><br/>";
        echo "<input type='text' name='Clown' placeholder='# of Clowns'><br/>";
        echo "<input type='text' name='Juggler' placeholder='# of Jugglers'><br/>";
        echo "<input type='text' name='TrapezeArtist' placeholder='# of Trapeze Artists'><br/>";
        echo "<input type='text' name='HumanCannonball' placeholder='# of Human Cannonballs'><br/>";
        echo "<input type='text' name='Mime' placeholder='# of Mimes'><br/>";
        echo "<input type='submit' value='Submit'><br/>";
        echo "</form>";
        echo "</div>";
        echo "</div><br/>";
        }
}
