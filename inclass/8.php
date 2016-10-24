<?php
$pattern = "/\Wk[a-zA-Z]*\W/";
$test_string = "I like ducks, puppies, kittens, and owls and also more kittens";

echo $test_string.'<br/>';
echo $pattern.'<br/>';

echo preg_match($pattern, $test_string);
?>
<?php/*
echo "Welcome to class session 8";

echo "<h3>exec example</h3>";

$str = 'factor 99';

$result = exec($str);

print_r($result);

echo "<h3>Loading a text file from disk...</h3><br/>";

$str = file_get_contents('sampledata.txt');
echo $str;


//uploading a file!  OH YEA!

?>

<form method='post' action='8.php' enctype='multipart/form-data'>
    <input type='file' name='myfile'>
    <input type='submit' value='upload'>
</form> 
<?php
/*
    if(isset($_FILES['myfile'])) {
        //echo "<pre>";
        //print_r($_FILES);
        //echo "</pre>";
        $original_name=$_FILES['myfile']['name'];
        $tmp_path = $_FILES['myfile']['tmp_name'];
        $type = $_FILES['myfile']['type'];
        
        if ($type == "image/jpeg") {
            $dst = 'uploads/'.$original_name;
            move_uploaded_file($tmp_path, $dst);
            echo "$original_name was uploaded.";
        } else {
            //No right type!
            echo "Sorry file must be a jpeg!";
        }
        
    }
*/

?>