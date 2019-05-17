<?php header('Access-Control-Allow-Origin: *');
$type = '"amenity"="restaurant"';
$lat;
$lon;


if (isset($_POST["lat"])) {
    $lat = $_POST["lat"];
}

if (isset($_POST["lon"])) {
    $lon = $_POST["lon"];
}


$radius = 1000;
$limit = 25;

$query = '[out:json][timeout:25];';
$query .= '(node[' . $type . '](around:' . $radius . ',' . $lat . ',' . $lon.');';
$query .= ');out ' . $limit . ';';
$result = file_get_contents("http://overpass-api.de/api/interpreter?data=".urlencode($query));

$result_array = json_decode($result, true);

echo json_encode($result_array["elements"]);
?>
