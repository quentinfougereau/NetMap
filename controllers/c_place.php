<?php

include_once("../models/Place.php");

class C_Place {

    public $place;

    public function __construct()
    {
        $this->place = new Place();
        $this->place->init();
    }

    public function getPlace($id)
    {
        $data = $this->place->getPlace($id);
    }

    public function getPlaces() {
        $data = $this->place->getPlaces();
    }

    public function addPlaces($post) {
        $interests = $post["data"];
        $type = "";
        $latitude = 43.3000859;
        $longitude = 5.3844536;

        $radius;
        $limit = 100;

        if (isset($post["userPosition"]["latitude"])) {
            $latitude = $post["userPosition"]["latitude"];
        }

        if (isset($post["userPosition"]["latitude"])) {
            $longitude = $post["userPosition"]["longitude"];
        }

        if (isset($post["radius"])) {
            $radius = $post["radius"];
        }

        $query = '[out:json][timeout:25];';
        $query .= "(";

        foreach ($interests as $interest) {
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

        //Ajoute les nouveaux Locations & Places dans la BDD
        if (isset($result_array["elements"])) {
            $this->place->addLocations($result_array["elements"]);
        }

        echo json_encode($result_array["elements"]);

    }

}