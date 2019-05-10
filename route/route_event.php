<?php

include '../controllers/c_event.php';
include '../controllers/c_comment.php';

$c_event = new C_Event();
$c_comment = new C_Comment();

/* Si l'utilisateur n'est pas connecté, il reste sur le page d'accueil */
/*
if (!isset($_SESSION["login_user"])) {
    include "../views/v_accueilvisiteur.php";
    return;
}
*/

if (isset($_GET["new_event"])) {
    include "../views/v_newEventForm.php";
}

if (isset($_POST["add_event"])) {
    $c_event->addEvent($_POST);
    echo "événement ajouté !";
}

if (isset($_GET["fetch_all_eventsForMap"])) {
    echo json_encode($c_event->getEventsForMap());
}

if (isset($_GET["fetch_events_not_joined"])) {
    $events = $c_event->getEventsNotJoined();
    include "../views/v_listEventsNotJoined.php";
}

if (isset($_GET["join_event"])) {
    echo "Evenement n° " . $_GET["id_event"];
    $c_event->joinEvent($_GET["id_event"]);
}

if (isset($_GET["list_user_events"])) {
    $events = $c_event->getUserEvents();
    include "../views/v_listUserEvents.php";
}

if (isset($_GET["get_event"]) && isset($_GET["id_event"])) {
    $idEvent = $_GET["id_event"];
    $event = $c_event->getEvent($idEvent);
    $comments = $c_comment->getAllCommentsOfEvent($idEvent);
    include "../views/v_event.php";
}
