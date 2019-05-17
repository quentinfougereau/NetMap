<?php
    header('Access-Control-Allow-Origin: *');
    
    $type = "";
    $latitude;
    $longitude;
    
    $radius;
    $limit = 100;
    
    if (isset($_POST["userPosition"]["latitude"])) {
        $latitude = $_POST["userPosition"]["latitude"];
    }
    
    if (isset($_POST["userPosition"]["latitude"])) {
        $longitude = $_POST["userPosition"]["longitude"];
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
                $query .= 'node[' . $type . '](around:' . $radius . ',' . $latitude . ',' . $longitude.');';
                break;
                
            case "museum":
                $type = '"tourism"="museum"';
                $query .= 'node[' . $type . '](around:' . $radius . ',' . $latitude . ',' . $longitude.');';
                break;
            case "bench":
                $type = '"amenity"="bench"';
                $query .= 'node[' . $type . '](around:' . $radius . ',' . $latitude . ',' . $longitude.');';
                break;
        }
    }
    
    $query .= ")";
    $query .= ';out;';
    
    $result = file_get_contents("http://overpass-api.de/api/interpreter?data=".urlencode($query));
    
    $result_array = json_decode($result, true);
    
    echo json_encode($result_array["elements"]);
