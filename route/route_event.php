<?php

include '../controllers/c_event.php';

$c_event = new C_Event();

if (isset($_GET["new_event"])) {
    include "../views/v_newEventForm.php";
}

if (isset($_POST["add_event"])) {
    $c_event->addEvent($_POST);
}

if (isset($_GET["fetch_all_eventsForMap"])) {
    var_dump($c_event->getEventsForMap());
}

if (isset($_GET["fetch_all_events"])) {
    $events = $c_event->getEvents();
    include "../views/v_listEvents.php";
}

if (isset($_GET["join_event"])) {
    echo "Evenement n° " . $_GET["id_event"];
    $c_event->joinEvent($_GET["id_event"]);
}

if (isset($_GET["list_user_events"])) {
    $events = $c_event->getUserEvents();
    var_dump($events);
}

