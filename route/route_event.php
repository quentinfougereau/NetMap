<?php

include '../controllers/c_event.php';
include '../controllers/c_comment.php';

$c_event = new C_Event();
$c_comment = new C_Comment();

/* Si l'utilisateur n'est pas connecté, il reste sur le page d'accueil */
if (!isset($_SESSION["login_user"])) {
    include "../views/v_accueilvisiteur.php";
    return;
}

if (isset($_GET["new_event"])) {
    $cities = $c_event->getCities();
    include "../views/v_newEventForm.php";
}

if (isset($_GET["action"]) && $_GET["action"] == "add_event") {
    $response = $c_event->addEvent($_POST);
    if ($response["success"]) {
        header('Location: ../views/v_accueil.php');
    }
}

if (isset($_GET["fetch_all_eventsForMap"])) {
    echo json_encode($c_event->getEventsForMap());
}

if (isset($_GET["fetch_events_not_joined"])) {
    $events = $c_event->getEventsNotJoined();
    include "../views/v_listEventsNotJoined.php";
}

if (isset($_GET["join_event"])) {
    $response = $c_event->joinEvent($_GET["id_event"]);
    if ($response["success"]) {
        header('Location: ../route/route_event.php?get_event=1&id_event=' . $_GET["id_event"]);
    } else {
        header('Location: ../route/route_event.php?fetch_events_not_joined=1');
    }
}

if (isset($_GET["list_user_events"])) {
    $events = $c_event->getUserEvents();
    include "../views/v_listUserEvents.php";
}

if (isset($_GET["get_event"]) && isset($_GET["id_event"])) {
    $idEvent = $_GET["id_event"];
    $hasJoined = $c_event->userHasJoined($idEvent);
    $event = $c_event->getEvent($idEvent);
    $comments = $c_comment->getAllCommentsOfEvent($idEvent);
    include "../views/v_event.php";
}
