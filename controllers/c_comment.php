<?php

include_once("../models/Comment.php");

class C_Comment {

    public $m_comment;

    public function __construct()
    {
        if (!isset($_SESSION["login_user"])) {
            session_start();
        }
        $this->m_comment = new Comment();
        $this->m_comment->init();
    }

    public function addComment($data) {
        $userLogin = null;
        if (isset($_SESSION["login_user"]) && $_SESSION["login_user"]) {
            $userLogin = $_SESSION["login_user"];
        }
        $content = null;
        if (isset($data["content"]) && $data["content"]) {
            $content = $data["content"];
        }
        $idEvent = null;
        if (isset($data["id_event"]) && $data["id_event"] != "") {
            $idEvent = $data["id_event"];
        }
        $datetime = date("Y-m-d H:i:s");

        $comment = new Comment();
        $comment->setContent($content);
        $comment->setStatus("pending");
        $comment->setDatetime($datetime);
        $comment->setUserLogin($userLogin);
        $comment->setIdEvent($idEvent);

        $res = $this->m_comment->add($comment);
        if ($res) {
            $response["success"] = 1;
            $response["message"] = "Commentaire enregistré, en attente de validation...";
            $response["id_event"] = $comment->getIdEvent();
        } else {
            $response["success"] = 0;
            $response["message"] = "Problème lors de l'enregistrement du commentaire";
        }
        return $response;
    }

    public function getAllCommentsOfEvent($event_id) {
        return $this->m_comment->getAllOfEvent($event_id);
    }

}

