<?php
require_once("../utils/DatabaseManager.php");

class Event {

    private $dbConnection;

    public function __construct() {

    }

    public function init() {
        $this->dbConnection = DatabaseManager::getDatabaseConnection();

    }

    public function getEvents() {
        $query = "SELECT Event.idEvent, Event.libelle, Event.dateEvent, Place.libelle AS place, Address.rue AS street, Address.CP AS postcode, Address.ville AS city, Location.longitude, Location.latitude,
                Event.dateEvent, Event.startTime, Event.endTime 
                FROM Event, Place, Address, Location
                WHERE Place.idLocation = Location.idLocation 
                AND Place.addressPlace = Address.idAddress 
                AND Event.idPlace = Place.idPlace";
        $result = mysqli_query($this->dbConnection, $query);
        return $result;
    }

    public function getEventsForMap() {
        $query = "SELECT Event.idEvent, Event.libelle, Event.dateEvent, Place.libelle AS place, Address.rue AS street, Address.CP AS postcode, Address.ville AS city, Location.longitude, Location.latitude,
                Event.dateEvent, Event.startTime, Event.endTime 
                FROM Event, Place, Address, Location
                WHERE Place.idLocation = Location.idLocation 
                AND Place.addressPlace = Address.idAddress 
                AND Event.idPlace = Place.idPlace
                AND Event.idPlace = Place.idPlace AND Event.dateEvent > NOW()";
        $result = mysqli_query($this->dbConnection, $query);
        return $result;
    }

    public function getEventsNotJoined($user_login) {
        $query = "SELECT DISTINCT Event.idEvent, Event.libelle, Event.dateEvent, Place.libelle AS place, Address.rue AS street, Address.CP AS postcode, Address.ville AS city, Location.longitude, Location.latitude 
                FROM Event, Place, Address, Location
                WHERE Place.idLocation = Location.idLocation 
                AND Place.addressPlace = Address.idAddress 
                AND Event.idPlace = Place.idPlace
                AND Event.idEvent NOT IN (SELECT idEvent FROM Participer WHERE Participer.login = ?)";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 's',$user_login);
        mysqli_stmt_execute($stmt);
        $events =  mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $events;
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
        $event_start_time = NULL;
        if (isset($event["event_start_time"])) {
            $event_start_time = $event["event_start_time"];
        }
        $event_end_time = NULL;
        if (isset($event["event_end_time"])) {
            $event_end_time = $event["event_end_time"];
        }
        $place_id = NULL;
        if (isset($event["place"])) {
            $place_id = $event["place"];
        }

        $query = "INSERT INTO Event (libelle, dateEvent, startTime, endTime, idPlace) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'ssssi',$event_name, $event_date, $event_start_time, $event_end_time, $place_id);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $res;
    }

    public function joinEvent($event_id, $user_login) {
        $query = "INSERT INTO Participer (login, idEvent) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'si',$user_login, $event_id);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $res;
    }

    public function getUserEvents($user_login) {
        $query = "SELECT Event.idEvent, Event.libelle, Event.dateEvent, Place.libelle AS place, Address.rue AS street, Address.CP AS postcode, Address.ville AS city
                FROM Event, Place, Address, Participer
                WHERE Event.idPlace = Place.idPlace
                AND Place.addressPlace = Address.idAddress
                AND Event.idEvent = Participer.idEvent
                AND Participer.login = ?";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 's',$user_login);
        mysqli_stmt_execute($stmt);
        $events =  mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $events;
    }

    public function getEvent($event_id) {
        $query = "SELECT Event.idEvent, Event.libelle, Event.dateEvent, Place.libelle AS place, Address.rue AS street, Address.CP AS postcode, Address.ville AS city,
                Event.dateEvent AS date, Event.startTime AS start, Event.endTime AS end
                FROM Event, Place, Address
                WHERE Event.idPlace = Place.idPlace
                AND Place.addressPlace = Address.idAddress
                AND Event.idEvent = ?";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'i',$event_id);
        mysqli_stmt_execute($stmt);
        $result =  mysqli_stmt_get_result($stmt);
        $event = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $event;
    }

    public function getCities() {
        $query = "SELECT DISTINCT ville FROM Address ORDER BY ville ASC";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_execute($stmt);
        $cities =  mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $cities;
    }

    public function userHasJoined($user_login, $event_id) {
        $query = "SELECT * FROM Participer WHERE login = ? AND idEvent = ?";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'si',$user_login,$event_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $hasJoined = false;
        if ($result->num_rows == 1) {
            $hasJoined = true;
        }
        mysqli_stmt_close($stmt);
        return $hasJoined;
    }


}