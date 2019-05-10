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
        $res = $c_event->addComment($_POST);
        if ($res) {
            echo "Commentaire enregistré, en attente de validation...";
        } else {
            echo "Problème lors de l'enregistrement du commentaire";
        }
        break;

    default:
        echo "defaut";
        break;

}