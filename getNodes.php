<?php
header('Access-Control-Allow-Origin: *');

$type = "";
$latitude = 43.3000859;
$longitude = 5.3844536;

$radius = 2000;
$limit = 100;

if (isset($_POST["latitude"])) {
    $latitude = $_POST["latitude"];
}

if (isset($_POST["latitude"])) {
    $longitude = $_POST["longitude"];
}

$query = '[out:json][timeout:25];';
$query .= "(";

foreach ($_POST["interests"] as $interest) {
    switch ($interest) {
        case "restaurant":
            $type = '"amenity"="restaurant"';
            $query .= 'node[' . $type . '](around:' . $radius . ',' . $latitude . ',' . $longitude.');';
            break;

        case "museum":
            $type = '"tourism"="museum"';
            $query .= 'node[' . $type . '](around:' . $radius . ',' . $latitude . ',' . $longitude.');';
            break;
    }
}

$query .= ")";
$query .= ';out;';

$result = file_get_contents("http://overpass-api.de/api/interpreter?data=".urlencode($query));

$result_array = json_decode($result, true);

echo json_encode($result_array["elements"]);
