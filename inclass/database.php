<?php

//  Connect to DB
include 'db_connect.php';

//  Query the chickens
//  Build the SQL string based on the filters for the assignment.
$sql="SELECT * FROM chickens";
$params = array();
$searchStr = '';
if (isset($_POST['search']) && $_POST['search'] !='') {
  $sql.=" WHERE name LIKE ?";
  $params[] = '%'.$_POST['search'].'%';
  $searchStr = $_POST['search'];
}
$query = $pdo->prepare($sql);

$rows = $query->rowCount();
?>
<form method ="post">
    <input type='text' name='search' value='<?=$searchStr?>'/>
    <input type='submit' value='Search'/>
</form>
<?php
//  Display chicken tables.

//Fetches a row, then prints the row.

echo "<table border ='1'>";
echo "<tr>";
echo "<td>name</td>";
echo "<td>breed</td>";
echo "<td>type</td>";
echo "<td>price</td>";
echo "</tr>";
while ($row = $query->fetch(PDO::FETCH_OBJ)) {
    echo "<tr>";
    echo "<td><a href='chickendetails.php?id=$row->id'>".$row->name."</a></td>";
    echo "<td>$row->breed</td>";
    echo "<td>".ucfirst($row->type)."</td>";
    echo "<td>$".number_format($row->price, 2)."</td>";
    echo "</tr>";
    
}
echo "<table>";