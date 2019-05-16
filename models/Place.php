<?php
require("../utils/DatabaseManager.php");

class Place {

    private $dbConnection;

    public function __construct() {

    }

    public function init() {
        $this->dbConnection = DatabaseManager::getDatabaseConnection();

    }

    public function getPlace($id) {
        $query = "Select Place.idPlace, Place.libelle, rating, description, website, coordx, coordy, rue, CP, ville, CategPlace.libelle AS category, Interest.libelle AS interest 
                FROM Place, Location, Address, Interest, CategPlace 
                WHERE Place.idLocation = Location.idLocation 
                AND Place.addressPlace = Address.idAddress 
                AND Place.idCategPlace = CategPlace.idCategPlace 
                AND Place.idInterest = Interest.idInterest
                AND Place.idPlace = ".$id.";";
        $result = mysqli_query($this->dbConnection, $query);
        return mysqli_fetch_assoc($result);
    }

    public function getPlaces() {
        $query = "Select Place.idPlace, Place.libelle, rating, coordx, coordy, rue, CP, ville, CategPlace.libelle AS category, Interest.libelle AS interest 
                FROM Place, Location, Address, Interest, CategPlace 
                WHERE Place.idLocation = Location.idLocation 
                AND Place.addressPlace = Address.idAddress 
                AND Place.idCategPlace = CategPlace.idCategPlace 
                AND Place.idInterest = Interest.idInterest;";
        $result = mysqli_query($this->dbConnection, $query);
        return $result;
    }

    public function addPlace($place, $location_id, $address_id) {
            $name = NULL;
            if (isset($place["name"])) {
                $name = $place["name"];
            }
            $rating = NULL;
            if (isset($place["rating"])) {
                $rating = $place["rating"];
            }
            $description = NULL;
            if (isset($place["description"])) {
                $description = $place["description"];
            }
            $website = NULL;
            if (isset($place["website"])) {
                $website = $place["website"];
            }

            $query = "INSERT INTO Place (libelle, rating, description, website, idLocation, addressPlace) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($this->dbConnection, $query);
            mysqli_stmt_bind_param($stmt, 'sissii', $name, $rating, $description, $website, $location_id, $address_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
    }

    public function addLocation($node) {
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

        $query = "INSERT INTO Location (idNode, longitude, latitude) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'sdd', $idNode, $longitude, $latitude);
        mysqli_stmt_execute($stmt);
        $last_location_id = mysqli_insert_id($this->dbConnection);
        mysqli_stmt_close($stmt);
        return $last_location_id;
    }

    public function addAddress($address) {
        $query = "INSERT INTO Address (rue, ville, CP) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'ssd', $address["street"], $address["city"], $address['postcode']);
        mysqli_stmt_execute($stmt);
        $last_address_id = mysqli_insert_id($this->dbConnection);
        mysqli_stmt_close($stmt);
        return $last_address_id;
    }

    public function getPlacesFromCity($city) {
        $query = "SELECT Place.idPlace AS id, Place.libelle AS place, Address.rue AS street, Address.CP AS postcode
                  FROM Place, Address
                  WHERE Place.addressPlace = Address.idAddress
                  AND Address.ville = ?
                  ORDER BY Place.libelle ASC";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 's', $city);
        mysqli_stmt_execute($stmt);
        $places =  mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $places;
    }

}