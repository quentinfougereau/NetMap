<?php
header('Access-Control-Allow-Origin: https://netmap.servebeer.com');

include '../controllers/c_place.php';


$c_place = new C_Place();

if (isset($_GET["action"]) && $_GET["action"] == "addPlaces") {
    echo $c_place->queryOverPass($_POST);
}

/*
 * Fetch all places that are in the city $_POST["city"]
 * And return a list of places
 */
if (isset($_GET["action"]) && $_GET["action"] == "getPlacesFromCity") {
    if (isset($_POST["city"])) {
        $places = $c_place->getPlacesFromCity($_POST["city"]);
        $rows = array();
        while ($row = mysqli_fetch_assoc($places)) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    }
}

