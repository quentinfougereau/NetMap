<?php

include '../controllers/c_event.php';

if (isset($_GET["new_event"])) {
    include "../views/v_newEventForm.php";
}

if (isset($_POST["add_event"])) {
    $c_event = new C_Event();
    $c_event->addEvent($_POST);
}

if (isset($_GET["fetch_all_events"])) {
    $c_event = new C_Event();
    var_dump($c_event->getEvents());
}