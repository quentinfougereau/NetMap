<?php
require("../utils/DatabaseManager.php");

class Event {

    private $dbConnection;

    public function __construct() {

    }

    public function init() {
        $this->dbConnection = DatabaseManager::getDatabaseConnection();

    }

    public function getEvents() {
        $query = "SELECT Event.libelle, Event.dateEvent, Place.libelle AS place, Address.rue, Address.CP, Address.ville, Location.longitude, Location.latitude 
                FROM Event, Place, Address, Location
                WHERE Place.idLocation = Location.idLocation 
                AND Place.addressPlace = Address.idAddress 
                AND Event.idPlace = Place.idPlace";
        $result = mysqli_query($this->dbConnection, $query);
        return $result;
    }

    public function addEvent($event) {
        $event_name = NULL;
        if (isset($event["event_name"])) {
            $event_name = $event["event_name"];
        }
        $event_date = NULL;
        if (isset($event["event_date"])) {
            $event_date = $event["event_date"];
        }
        $place_name = NULL;
        if (isset($event["place_name"])) {
            $place_name = $event["place_name"];
        }
        $street = NULL;
        if (isset($event["street"])) {
            $street = $event["street"];
        }
        $postcode = NULL;
        if (isset($event["postcode"])) {
            $postcode = $event["postcode"];
        }
        $city = NULL;
        if (isset($event["city"])) {
            $city = $event["city"];
        }
        $longitude = NULL;
        if (isset($event["longitude"])) {
            $longitude = $event["longitude"];
        }
        $latitude = NULL;
        if (isset($event["latitude"])) {
            $latitude = $event["latitude"];
        }

        $location_id = null;
        $query = "INSERT INTO Location (longitude, latitude) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'dd',$longitude, $latitude);
        mysqli_stmt_execute($stmt);
        $location_id = mysqli_insert_id($this->dbConnection);
        mysqli_stmt_close($stmt);

        $query = "INSERT INTO Address (ville, rue, CP) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'ssi',$city, $street, $postcode);
        mysqli_stmt_execute($stmt);
        $address_id = mysqli_insert_id($this->dbConnection);
        mysqli_stmt_close($stmt);

        $query = "INSERT INTO Place (libelle, idLocation, addressPlace) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'sii',$place_name, $location_id, $address_id);
        mysqli_stmt_execute($stmt);
        $place_id = mysqli_insert_id($this->dbConnection);
        mysqli_stmt_close($stmt);

        $query = "INSERT INTO Event (libelle, dateEvent, idPlace) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'ssi',$event_name, $event_date, $place_id);
        mysqli_stmt_execute($stmt);
        $place_id = mysqli_insert_id($this->dbConnection);
        mysqli_stmt_close($stmt);

    }

}