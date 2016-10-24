<?php


/*
echo "<pre>";
print_r($array);
echo "</pre><br/><br/>";
*/
try {
    $url = 'http://api.openweathermap.org/data/2.5/weather?q=London,uk';
    //The @ symbol ignores the warning for that line of code
    @$result = file_get_contents($url);
    $result = 'kittens';
    if (!$result) {
        throw new Exception("Service not available");
    }
    @$array = json_decode($result, true);
    if(!is_array($array)) {
        throw new Exception("Invalid data format");
    }
    $city = $array['name'];
    $temp = ($array['main']['temp'] - 273.15) * (9/5) + 32;
    echo "The current temperature in $city  is $temp";
    
} catch (Exception $e) {
    echo "Sorry service is not available.";
}
