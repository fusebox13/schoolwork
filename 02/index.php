<?php
include 'col_data.php';

//Display is used to display the output or errors.
$display = '';

/*Input Checks:
 *  Each field is individually checked for two reasons:  
 *      1.  To give the user a detailed error.  
 *      2.  To retain any valid input even if the others input are invalid.
 *      3.  Empty() is used because I need to check for existence and emptiness.
 *  
 * http://php.net/manual/en/function.empty.php
 */
if (empty($_POST['locationA'])) {
    $display .= "Please select location A.<br/>";
}
else {
    $col_index_a = $_POST['locationA'];
}

if (empty($_POST['locationB'])) {
    $display .= "Please select location B.<br/>";
}
else {
    $col_index_b = $_POST['locationB'];
}

//Check for an empty wages field first.  If that fails the second condition will
//not be evaluated which tests for characters and negative numbers.
if(empty($_POST['wages']) || $_POST['wages'] <=0) {
    $display .= "Please enter a wage.<br/>";
}

if($display == '')
{
    /*Computations:
    /*  Removes commas and converts the value to float for the sake of the computations
    /*  http://php.net/manual/en/function.str-replace.php
    /*  http://php.net/manual/en/function.floatval.php
     */
    $wages_a = floatval(str_replace(',', '', $_POST['wages']));
    $col_a = $COL_array[$col_index_a];
    $col_b = $COL_array[$col_index_b];
    $wages_b = ($wages_a / $col_a ) * $col_b;
    
    
    /*Text formatting
     *  Using the lazy substring method since there will always be 4 characters to trim
     *  http://php.net/substr
     */
    $locationA = substr($col_index_a, 4);
    $locationB = substr($col_index_b, 4);
    $wages_a = number_format($wages_a, 2);
    $wages_b = number_format($wages_b, 2);
    $display =  "Making <b>$$wages_a</b> in $locationA is the same as making <b>$$wages_b</b> in $locationB";
    
}
?>

<form action='index.php' method='post'>
<table border='1'>
    <th colspan='2'>Cost of Living Calculator</th>
    <tr>
        <td colspan='2'>This application compares the relative cost of living between two locations.</td>
    </tr>
    <tr>
        <td>Location A:</td>
        <td>
            <select name='locationA'>                
                <option value=''>Please select a location</option>;
                <?php
                foreach($COL_array as $key => $value) {
                    $selected = ($key == $col_index_a)?'selected="selected"':'';
                    echo "<option value='$key' $selected>$key</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Wages in Location A:</td>
        <td>
            $<input type='text' name='wages' value='<?=(isset($wages_a))?$wages_a:''?>'/>
        </td>
    </tr>
    <tr>
        <td>Location B:</td>
        <td>
            <select name='locationB'>
                <option value=''>Please select a location</option>;
                <?php
                foreach($COL_array as $key => $value) {
                    $selected = ($key == $col_index_b)?'selected="selected"':'';
                    echo "<option value='$key' $selected>$key</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><input type='submit' value='Calculate Wages'/></td>
    </tr>
</table>
</form>
<hr>
<?php
//If Post has data, then there is either an error or a valid display.
if($_POST) {
    echo $display;
}
?>
