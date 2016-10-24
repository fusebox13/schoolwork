<?php
session_start(); // Tells Php that we are going to be using sessions
include 'luhn.php';
$number = '';

//If it's set, the session will use the current session, otherwise
//it will create a new array.
if(!isset($_SESSION['oldnumbers'])) {
    //Set oldnumbers into an empty array
    $_SESSION['oldnumbers'] = array();
}

if (isset($_POST['mynumber'])) {
    $number = $_POST['mynumber'];
    
    if (!in_array($number, $_SESSION['oldnumbers'])) {
        //Putting a [] at the end of the arary appends the number;
        $_SESSION['oldnumbers'][] = $number;
    }
    
    
}







?>

<form action ="luhnform.php" method ="post" >
    Please enter a number:</br>
    <input type="text" name="mynumber" value="<?=$number?>"/>
    <input type="submit" value="Go!"/>
</form>

<?php

if ($number) {
    $result = isLuhn($number);
    if($result) {
        
        echo $number.' is a Luhn number.';
        
    } else {
        echo $number.' is not a Luhn number.';
    }
}

//echo "<br/><br/>Number history: ";
//echo implode(',', $_SESSION['oldnumbers']);
?>
<hr/>
<form action ="luhnform.php" method ="post" >
    Recent numbers:</br>
    <select name='mynumber'>
        <?php
            foreach($_SESSION['oldnumbers'] as $n) {
                $selected = ($n==$number)?'selected="selected"':'';
                echo "<option value= '$n' $selected>$n</option>";
            }
        ?>
    </select>
    <input type="submit" value="Go!"/>
</form>
 
<a href='luhnform_clear.php'>Clear history</a>