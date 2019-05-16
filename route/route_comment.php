<?php

include '../controllers/c_comment.php';

$c_event = new C_Comment();

/* Si l'utilisateur n'est pas connecté, il reste sur la page d'accueil */
if (!isset($_SESSION["login_user"])) {
    include "../views/v_accueilvisiteur.php";
    return;
}

switch ($_GET["action"]) {

    case "addComment":
        $response = $c_event->addComment($_POST);
        if ($response["success"]) {
            header('Location: ../route/route_event.php?get_event=1&id_event=' . $response["id_event"]);
        }
        break;

    default:
        break;

}