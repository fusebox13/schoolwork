<?php
include 'db_connect.php';

$id = $_GET['id'];

// Query for details
$sql = "SELECT * FROM chickens WHERE id=?";

$query = $pdo->prepare($sql);
$query->execute(array($id));

if ($query->rowCount() == 1) {

    //$row = $query->fetch(PDO::FETCH_OBJ);
    $row = $query->fetchObject();
    $hatchedTS = strtotime($row->hatched);
    $hatcheddate = date('n/j/Y', $hatchedTS);
    echo "Name is $row->name<br/>";
    echo "Breed is $row->breed<br/>";
    echo "Type is $row->type<br/>";
    echo "Price is $row->price<br/>";
    echo "Eggs laid is $row->eggs<br/>";
    echo "Hatched on $hatcheddate <br/>";
} else {
    echo "Error: Chicken not found.";
}
