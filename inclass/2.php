<?php
echo "Sessions 02";
echo "<br>";
/*
$var = "Dan";
$n = 1;
echo "There are $n {$var}s in this room";


$var = "kittens and puppies are cute!!!</br>";
echo $var;
$str = ucwords($var);
echo $str;


$n = 5439.9278;
$dollar_amount = number_format($n, 2);
echo $dollar_amount;


$var = "kittens";
echo md5($var);
 

//ARRAYS

$arr = array(23.99, 12.00, 59.98, 1000);

array_push($arr, 99);
//or
$arr[]=99;
$arr[1] = 25.99;
$arr[7] = 70;
$arr[]= 41;
$arr[]= 42;
$arr[]= 43;


$arr1 = array(1, 2, 3, 5, 6);
$n = count($arr1);
for ($i = 0; $i < $n; $i++) {
    echo $arr1[$i].' ';
}

foreach ($arr1 as $v) {
    echo $v.' ';
}

foreach ($arr1 as $index => $v) {
    echo $v.' ';
}

$arr2 = array('cat' => 4, 'dog' => 5, 'chicken' => 7);

echo "at my pet store, i have ";

foreach ($arr2 as $key => $value) {
    echo $value.' '.$key.'<br/>';
}

print_r($arr1);
$value = array_pop($arr2);

print_r($arr2);
 * 
 

$arr1 = array(55, 66, 77, 88, 99);
foreach($arr1 as $value) {
    $value2 = array_shift($arr1);
    echo $value.' ';
}

print_r($arr1);
 * 
$arr1 = array(55, 66, 77, 88, 99);
$result = array_splice($arr1, 2, 1, array(4,5,6) );
print_r($arr1);


$now = time();

echo "Today is ".date("M j, Y", $now).'<br/>';
echo "Today is ".date("y-m-d H:i:s", $now).'<br/>';
*/

?>

<table border = '1'>
    <tr>
        <th>Col1</th>
        <th>Col2</th>
        <th>Col3</th>
        
    </tr>
    <tr>
        <td>A</td>
        <td>B</td>
        <td>C</td>
    </tr>
    <tr>
        <td>D</td>
        <td>E</td>
        <td>F</td>
    </tr>
</table>



<form action='2.php' method="post">
    <input type ='text' name='myname' value="<?=$post['myname']?>"/>
    <input type='submit' value='Click Me'/>    
</form>
<?php
   $name = $_POST['myname'];
   echo $name;

