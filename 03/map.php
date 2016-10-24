<?php
include 'img_library.php';

$img = new Img();
$img->loadImage('us_map.jpg');

//If JSON is passed as null, load only the image and output it.
if(isset($_GET['input'])) {
    $input = $_GET['input'];
    $array = json_decode($input, true);
    $patharray = $array['path'];
    
    $count = count($patharray);
    //  Set first x,y coordinates
    $x = $patharray['0']['x'];
    $y = $patharray['0']['y'];
    //  Draw
    $img->setLineWidth(3);
    $img->setColorRGB(0, 0, 0);
    $img->moveTo($x, $y);
    for ($i = 1; $i < $count; $i++) {
        $x = $patharray[$i]['x'];
        $y = $patharray[$i]['y'];
        $img->lineTo($x, $y);   
    }
}
$img->output();

?>

