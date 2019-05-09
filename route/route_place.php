<?php

include '../controllers/c_place.php';

header('Access-Control-Allow-Origin: *');

$c_place = new C_Place();

if (isset($_POST["action"]) && $_POST["action"] == "addPlaces") {
    echo $c_place->addPlaces($_POST);
}