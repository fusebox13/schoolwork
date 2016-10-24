<?php

include 'states.php';
session_start();
$error = '';

//  Dumps POST data for the starting state into the session. 
if(!empty($_POST['startingstate'])) {
    $_SESSION['startingstate'] = $_POST['startingstate'];
}

/*  Dumps POST data for the checked states into the session, if there is no post 
 *  data the referrer is checked and if empty post data comes back from the 
 *  choose_states.php it's assumed that the user intends to remove all the states 
 *  so the checked states are cleared from the session which allows the state 
 *  selection link to return to the default view.
*/
if(isset($_POST['checkedstates'])) {
    $_SESSION['checkedstates'] =$_POST['checkedstates'];
    
}
//  http://stackoverflow.com/questions/6795128/php-how-to-find-the-location-where-a-user-came-from
else if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == 'http://russet.wccnet.edu/~dwilli11/CPS276/03/choose_states.php') {
    $_SESSION['checkedstates'] = null;
}

/*  Removes the checked states from the session by searching for the key to 
 *  unset the value.  If the last value from the session is removed, the session
 *  array that holds the checked states gets set to null to satisfy isset() logic
*/
if(isset($_GET['action']) && $_GET['action'] == 'remove') {
    //  http://php.net/manual/en/function.array-search.php
    $key = array_search($_GET['state'], $_SESSION['checkedstates']);
    unset($_SESSION['checkedstates'][$key]);
    if (empty($_SESSION['checkedstates'])) {
        $_SESSION['checkedstates'] = null;
    }
}


//  If there is a starting state and checked states, attempt to make an API call
if(isset($_SESSION['checkedstates']) && isset($_SESSION['startingstate']))
{
    //  Builds a URL string to be sent to the API based on the stored session data
    $url = 'http://96.126.107.46/api.php?apikey=dwilli11&states='.$_SESSION['startingstate'].',';
    foreach($_SESSION['checkedstates'] as $checkedstates) {
        $url.=$checkedstates.',';
    }
    /*  Remove the last comma since a comma is always being appended.  Could probably
     *  be solved with better logic, but this was a quick and easy work around.
     */
    //  http://php.net/RTRIM
    $url = rtrim($url,',');
    @$json = file_get_contents($url);
    //Checks if there was an issue opening the Stream and appends the error string.
    if ($json == false) {
        $error.="Service unavailable.";
    }
    
    /*  Attempt to decode the JSON, if it fails it will return null, set the error
     *  to the error that was returned by JSON, and set the $JSON string to null so it
     *  won't be processed by the map.php file.
     */
    $path = json_decode($json, true);
    if ($path == null) {
        $error.=$json;
        $json = null;
    }
}
?>
<form method='post'>
    <table border ='1'>
        <tr>
            <td valign='top'>
                <h1>Trip Planner</h1>
                <table border='1'>
                    <tr>
                        <td colspan='2'>This application calculates the shortest route through various states.</td>
                    </tr>
                    <tr>
                        <td width='40'>Home States</td>
                        <td >
                            <!-- Quick and dirty Javascript to submit the form when an option is selected making it easy to save the post data -->
                            <!-- http://stackoverflow.com/questions/7231157/how-to-submit-form-on-change-of-dropdown-list -->
                            <select name='startingstate' onchange='this.form.submit()'>
                                <option value='' <?=isset($_SESSION['startingstate'])?'hidden':''?>>Select a State</option>
                                <?php
                                    /*  Populate the select box, set the select option to whatever is stored in the session
                                     *  And hide all states that are checked so you cannot double select states.
                                     */
                                    foreach($states as $stateabb => $statename) {
                                        $selected = ($stateabb == $_SESSION['startingstate'])?'selected':'';
                                        //  http://php.net/manual/en/function.in-array.php
                                        $hidden = (isset($_SESSION['checkedstates']) && in_array($stateabb, $_SESSION['checkedstates']))?'hidden':'';
                                            
                                        echo "<option value='$stateabb' $selected $hidden>$statename</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Other States</td>
                        <td>
                            <?php
                            //  Lists the checked states as well as a link to remove them.  
                            if(isset($_SESSION['checkedstates'])) {
                                foreach($_SESSION['checkedstates'] as $checkedstates){
                                    echo "$states[$checkedstates]";
                                    echo " [<a href='index.php?action=remove&state=$checkedstates'>x</a>]<br/>";
                                }
                                echo "<a href='choose_states.php'>Add/Remove States</a>";
                            }
                            else {
                                echo "<a href='choose_states.php'>Select Other States</a>";
                            }
                            ?>
                        </td>
                    </tr>
                    <!-- If the JSON decoder was able to build the path array, switch the hidden flag to display the output table-->
                    <tr <?=isset($path)?'':'hidden'?>>
                        <td colspan="2">
                            <table border='1' width='100%'>
                                <tr>
                                    <th colspan ='2'>Best Route</th>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <th>Miles</th>
                                    
                            
                                </tr>
                                
                                
                                <?php
                                    //  Display output from decoded JSON.  Path will either be NULL or a valid decoded array
                                    if(isset($path)) {
                                        for($i = 0; $i < count($path['path']); $i++) {
                                            echo '<tr><td>'.$states[$path['path'][$i]['state']].'</td><td>'.$path['path'][$i]['distance'].'</td></tr>';
                                        }
                                    }
                                ?>
                                <tr>
                                    <td colspan ='2'>
                                        Total Distance: <?= $path['distance']?>
                                        
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
            <td>
                <!-- JSON is validated above.  Either legit JSON or NULL will be passed to the map -->
                <img src ='map.php?input=<?=$json?>'/>
            </td>

        </tr>
    </table>
</form>
<!-- killsession.php destroys the session and redirects back to the index -->
<a href='killsession.php'>Reset</a></br>
<font color='red'><?=$error?></font> 