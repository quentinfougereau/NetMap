<?php

include_once("../models/Event.php");

class C_Event {

    public $event;

    public function __construct()
    {
        session_start();
        $this->event = new Event();
        $this->event->init();
    }

    public function addEvent($event) {
        $event = $this->getCoordinates($event);
        $this->event->addEvent($event);
    }

    public function getCoordinates($event) {
        $address = $event["street"] . "," . $event["postcode"] . "," . $event["city"] . ",France";
        $nominatim_query = "http://nominatim.openstreetmap.org/search?format=json&q=".urlencode($address);
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
            $event["idNode"] = $result_array[0]["osm_id"];
            $event["longitude"] = $result_array[0]["lon"];
            $event["latitude"] = $result_array[0]["lat"];
        }
        return $event;
    }

    /*
     * Parcours tous les events et récupère le nom de l'event et sa localisation (longitude / latitude)
     */
    public function getEventsForMap() {
        $events = $this->event->getEvents();
        $events_coordinates = array();
        while ($row = mysqli_fetch_assoc($events)) {
            $coordinates = array("name" => $row["libelle"],"longitude" => $row["longitude"], "latitude" => $row["latitude"],
                            "place" => $row["place"], "street" => $row["street"], "postcode" => $row["postcode"], "city" => $row["city"]);
            array_push($events_coordinates, $coordinates);
        }
        return $events_coordinates;
    }

    public function getEvents() {
        return $this->event->getEvents();
    }

    public function joinEvent($event_id) {
        $this->event->joinEvent($event_id, $_SESSION["login_user"]);
    }

    public function getUserEvents() {
        return $this->event->getUserEvents($_SESSION["login_user"]);
    }

    public function getEventsNotJoined() {
        return $this->event->getEventsNotJoined($_SESSION["login_user"]);
    }


}