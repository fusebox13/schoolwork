<?php
//Get ID if the details image button is pressed
$id = $_POST['id'];

//Build SQL string
$sql = "SELECT * FROM matches WHERE id=?";

//Execute SQL
$query = $pdo->prepare($sql);
$query->execute(array($id));

//If there is a row, display the details
if ($query->rowCount() == 1) {
    $row = $query->fetchObject();
    //Build a winner string that is based of the result, but resolves to an actual name.
    switch ($row->result) {
        case 1:
            $winner = "<b>Round $row->round Winner:</b> $row->player1";
            break;
        case 2:
            $winner = "<b>Round $row->round Winner:</b> $row->player2";
            break;
        case 'D':
            $winner = "<b>Round $row->round:</b> Draw";
            break;
    }
    //Formatting for matchDate
    $matchDateTS = strtotime($row->matchDate);
    $matchDate = date('n/j/Y', $matchDateTS);
    echo "<br/><br/>";
    echo "<table border='none'>";
    echo "<tr><td style='font-size:x-large'>$row->player1 vs $row->player2</td></tr>";
    echo "<tr><td><i><b>@</b> $row->event, $row->site</i> (<b>$matchDate</b>)</td></tr>";
    echo "<tr><td>$winner</td></tr>";
    echo "<tr><td><b>Opener:</b> $row->opening (ECO: $row->eco)</td></tr>";
    echo "<tr><td>$row->moves</td></tr>";
    
    echo "</table>";

} else {
    //Error if no record is found.
    echo 'Could not find this record.';
}

