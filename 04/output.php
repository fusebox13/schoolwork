<?php
//include 'db_connect.php';

/*
 *  Builds the SQL string
 */
//http://php.net/manual/en/function.define.php
//_CLEANSQL is a constant used to check the built SQL string to determine the proper
//clause needed to do compound searches
define("_CLEANSQL", "SELECT * FROM matches");
$sql = "SELECT * FROM matches";
$params = array();
$result = '';
$start = '';
$end = '';
$playerName = '';

if (!empty($_POST['start']) && !empty($_POST['end'])) {
    $start = $_POST['start'];
    $end = $_POST['end'];
    $sql.=" WHERE matchDate BETWEEN ? AND ?";
    $params[] = str_replace('-', '', $start);
    $params[] = str_replace('-', '', $end);
}
if (!empty($_POST['playerName'])) {
    $playerName = $_POST['playerName'];
    //I thought that this was kind of clever...
    $sql.=($sql != _CLEANSQL)?" AND ":" WHERE "; 
    $sql.="(player1 LIKE ? OR player2 LIKE ?)";
    $params[] = $playerName;
    $params[] = $playerName;
}

if(!empty($_POST['result'])) {
    $result = $_POST['result'];
    $sql.=($sql != _CLEANSQL)?" AND ":" WHERE "; 
    
    switch($result) {
        case 'p1wins':
            $sql.="result=1";
            break;
        case 'p2wins':
            $sql.="result=2";
            break;
        case 'draw':
            $sql.="result='D'";
            break;
        default:
            //$sql.="KILL THE BATMAN";
            //This causes an error, but does not kill the Batman.
    }
}

$sql.=" ORDER BY matchDate DESC LIMIT 250";

/*
 *  Execute SQL
 */
$queryObj = $pdo->prepare($sql);
if ($params) {
    $queryObj->execute($params);
} else {
    $queryObj->execute();
}

//If there are results, return them else let the user know there are no results.
if ($queryObj->rowCount() > 0) {
    echo "<table border='1' border-collapse='collapse'>";
    echo "<tr>";
    echo "<td>Date</td>";
    echo "<td>Player 1</td>";
    echo "<td>Player 2</td>";
    echo "<td>Result</td>";
    echo "<td>ECO</td>";
    echo "<td>Details</td>";
    echo "</tr>";
    while ($row = $queryObj->fetchObject()) {
        $dateTS = strtotime($row->matchDate);
        $date = date('n/j/Y', $dateTS);
        echo "<tr>";
        echo "<td>$date</td>";
        echo "<td>$row->player1</td>";
        echo "<td>$row->player2</td>";
        echo "<td>$row->result</td>";
        echo "<td>$row->eco</td>";
        //This inputbox is part of the index.php form
        echo "<td align='center'>";
        echo "<form method='POST' action='index.php'>";
        echo "<input type='image' src='images/details.png' width='24' height='24' name='submit'>";
        echo "<input type='hidden' name='id' value='$row->id'>";
        echo "<input type='hidden' name='start' value='$start'>";
        echo "<input type='hidden' name='end' value='$end'>";
        echo "<input type='hidden' name='result' value='$result'>";
        echo "<input type='hidden' name='playerName' value='$playerName'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "<table>";
    $numResults = $queryObj->rowCount();
    echo "$numResults entries";
   
} else {
    echo "No results.";
}