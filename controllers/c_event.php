<?php

include_once("../models/Event.php");

class C_Event {

    public $event;

    public function __construct()
    {
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
            array(
                "http" => array(
                    "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
                )
            )
        );
        $result = file_get_contents($nominatim_query, false, $context);
        $result_array = json_decode($result, true);
        $event["longitude"] = $result_array[0]["lon"];
        $event["latitude"] = $result_array[0]["lat"];
        return $event;
    }

    /*
     * Parcours tous les events et récupère le nom de l'event et sa localisation (longitude / latitude)
     */
    public function getEvents() {
        $events = $this->event->getEvents();
        $events_coordinates = array();
        while ($row = mysqli_fetch_assoc($events)) {
            $coordinates = array("name" => $row["libelle"],"longitude" => $row["longitude"], "latitude" => $row["latitude"]);
            array_push($events_coordinates, $coordinates);
        }
        return $events_coordinates;
    }


}