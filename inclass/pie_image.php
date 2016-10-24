<?php

include 'img_library.php';

//create image
$img = new Img(400,400);

//draw borders
$img->setColorRGB(200, 150, 20);
$img->setLineWidth(3);
$img->drawFilledRect(0, 0, 400, 400);

$img->setColorRGB(255, 255, 200);
$img->drawFilledRect(10, 10, 380, 380);

$img->setColorRGB(0, 0, 0);

//draw a circle
$radius = 180;
$img->moveTo(200, 380);
for($i = 0; $i < 360; $i++) {
    
    $r = $i * 0.0174532925;
    $x = 200 + sin($r) * $radius;
    $y = 200 + cos($r) * $radius;
    //$img->setPixel($x, $y, 0,0,0);
    $img->lineTo($x, $y);
}
//drawing pie-shaped wedges
/*$array = array(
    'mary' => 44,
    'fred' => 20,
    'john' => 11,
    'nancy' => 39,
    
);*/

if(isset($_GET['input'])) {
    $input = $_GET['input'];
    $array = json_decode($input, true);
} else {
    $array = array();
}

$total = 0;
foreach($array as $k => $v) {
    $total+=$v;
}

$percent_array = array();
foreach($array as $k => $v) {
    $percent_array[$k] = $v / $total;
}

$sum_angles = 0;
foreach($percent_array as $k => $v) {
    $img->moveTo(200, 200);
    //calculate the wedge
    $angle = 360 * $v + $sum_angles;
    $r = $angle * 0.0174532925;
    $x = 200 + sin($r) * $radius;
    $y = 200 + cos($r) * $radius;
    $sum_angles = $angle;
    
    $img->lineTo($x, $y);
}
$img->output();
