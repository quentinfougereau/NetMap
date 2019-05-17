<?php
header('Access-Control-Allow-Origin: *');

$type = "";
$lat;
$lon;

$radius;
$limit = 100;

if (isset($_POST["userPosition"]["lon"])) {
    $lat = $_POST["userPosition"]["lat"];
}

if (isset($_POST["userPosition"]["lat"])) {
    $lon = $_POST["userPosition"]["lon"];
}

if (isset($_POST["radius"])) {
    $radius = $_POST["radius"];
}



$query = '[out:json][timeout:25];';
$query .= "(";

foreach ($_POST["data"] as $interest) {
    switch ($interest) {
        case "restaurant":
            $type = '"amenity"="restaurant"';
            $query .= 'node[' . $type . '](around:' . $radius . ',' . $lat . ',' . $lon.');';
            break;

        case "museum":
            $type = '"tourism"="museum"';
            $query .= 'node[' . $type . '](around:' . $radius . ',' . $lat . ',' . $lon.');';
            break;
    }
}

$query .= ")";
$query .= ';out;';

$result = file_get_contents("http://overpass-api.de/api/interpreter?data=".urlencode($query));

$result_array = json_decode($result, true);

echo json_encode($result_array["elements"]);