<?php

$host = "localhost";
$user = "root";
$password = "root";
$db = "NetMap";

$dbConnection =  mysqli_connect($host, $user, $password, $db);
mysqli_query($dbConnection,"Set names UTF8");

$now = date('Y-m-d');
$query = "SELECT Event.idEvent, Event.dateEvent, Place.idPlace, Address.idAddress, Location.idLocation
        FROM Event, Place, Address, Location
        WHERE Event.idPlace = Place.idPlace
        AND Place.addressPlace = Address.idAddress
        AND Place.idLocation = Location.idLocation
        AND Event.dateEvent < '" . $now . "'";
$events = mysqli_query($dbConnection, $query);

while ($event = mysqli_fetch_assoc($events)) {
    $query_del_event = "DELETE FROM Event WHERE idEvent = " . $event["idEvent"];
    mysqli_query($dbConnection, $query_del_event);

    $query_del_place = "DELETE FROM Place WHERE idPlace = " . $event["idPlace"];
    mysqli_query($dbConnection, $query_del_place);

    $query_del_location = "DELETE FROM Location WHERE idLocation = " . $event["idLocation"];
    mysqli_query($dbConnection, $query_del_location);

    $query_del_address = "DELETE FROM Address WHERE idAddress = " . $event["idAddress"];
    mysqli_query($dbConnection, $query_del_address);
}
