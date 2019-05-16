<?php

include_once("../models/Place.php");

class C_Place {

    public $place;

    public function __construct()
    {
        session_start();
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

    public function addPlaces($nodes) {

        foreach ($nodes as $node) {

            $idNode = NULL;
            if (isset($node["id"])) {
                $idNode = $node["id"];
            }
            $latitude = NULL;
            if (isset($node["lat"])) {
                $latitude = $node["lat"];
            }
            $longitude = NULL;
            if (isset($node["lon"])) {
                $longitude = $node["lon"];
            }

            $id_location = $this->place->addLocation($node);
            $address = $this->getAddressFromIdNode($idNode);
            $id_address = $this->place->addAddress($address);
            $this->place->addPlace($node["tags"], $id_location, $id_address);

        }

    }

    public function queryOverPass($post) {
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
            $this->addPlaces($result_array["elements"]);
        }

        echo json_encode($result_array["elements"]);
    }

    public function getAddressFromIdNode($idNode) {
        $nominatim_query = "https://nominatim.openstreetmap.org/lookup?format=json&osm_ids=N" . urlencode($idNode);
        //Context to fake user agents (fake browser)
        $context = stream_context_create(
            array (
                "http" => array(
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                )
            )
        );
        $result = file_get_contents($nominatim_query, false, $context);
        $result_array = json_decode($result, true);
        if (count($result_array) > 0) {
            $address = array();
            $address["street"] = "";
            if (isset($result_array[0]["address"]["house_number"])) {
                $address["street"] = $result_array[0]["address"]["house_number"] . " ";
            }
            if (isset($result_array[0]["address"]["road"])) {
                $address["street"] .= $result_array[0]["address"]["road"];
            } else if (isset($result_array[0]["address"]["pedestrian"])) {
                $address["street"] .= $result_array[0]["address"]["pedestrian"];
            }
            if (isset($result_array[0]["address"]["city"])) {
                $address["city"] = $result_array[0]["address"]["city"];
            }
            if (isset($result_array[0]["address"]["postcode"])) {
                $address["postcode"] = $result_array[0]["address"]["postcode"];
            }
        }
        return $address;
    }

    public function getPlacesFromCity($city) {
        return $this->place->getPlacesFromCity($city);
    }

}