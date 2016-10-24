<?php
include 'states.php';
session_start();
?>

<form method='post' action="index.php">
<table>
    <tr>
        <?php
        
        $counter = 0;
        $checked = '';
        //  Generates columns holding 10 state checkboxes
        foreach($states as $abb => $name) {
            
            //  Reads session array to precheck previous selected states.
            if(isset($_SESSION['checkedstates'])) {
                if(in_array($abb, $_SESSION['checkedstates'])) {
                    $checked = 'checked';
                }
                else {
                    $checked = '';
                }
            }
                //  If the current state is the starting state, the checkbox gets a hidden flag making it unselectable
                $hidden = (isset($_SESSION['startingstate']) && $_SESSION['startingstate'] == $abb)?'hidden':''; 
                $checkboxhtml = "<input type='checkbox' name='checkedstates[]' value='$abb' $checked $hidden>$name</input>";
                //  Very first checkbox needs an opening column tag.
                if($counter == 0) {
                    echo "<td valign='top'>$checkboxhtml<br/>";
                }
                //  Close the column tags after the first ten entries, every ten entries.
                elseif($counter != 0 && $counter % 10 == 0 ){
                    echo"</td><td valign='top'>$checkboxhtml<br/>";

                }
                //  Close the column tag after the last checkbox
                elseif($counter == count($states)){
                    echo "$checkboxhtml</td>";
                }
                //  If there are no special boundry conditions, add the next checkbox.
                else {
                    echo "$checkboxhtml <br/>";
                }
                $counter++;
    
        }
        
       
        ?>
       
    </tr>
</table>
<input type="submit" value="Submit"/>
</form>

