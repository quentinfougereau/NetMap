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

    public function addPlaces($place, $last_location_id) {
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

            $query = "INSERT INTO Place (libelle, rating, description, website, idLocation) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($this->dbConnection, $query);
            mysqli_stmt_bind_param($stmt, 'sissi', $name, $rating, $description, $website, $last_location_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
    }

    public function addLocations($nodes) {
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

            $query = "INSERT INTO Location (idNode, longitude, latitude) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($this->dbConnection, $query);
            mysqli_stmt_bind_param($stmt, 'sdd', $idNode, $longitude, $latitude);
            mysqli_stmt_execute($stmt);
            $last_location_id = mysqli_insert_id($this->dbConnection);
            mysqli_stmt_close($stmt);
            if ($last_location_id) {
                $this->addPlaces($node["tags"], $last_location_id);
            }
        }
    }

}