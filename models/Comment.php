<?php
require_once("../utils/DatabaseManager.php");

class Comment {

    private $dbConnection;

    private $content;
    private $status;
    private $datetime;
    private $userLogin;
    private $idEvent;

    public function __construct() {

    }

    public function init() {
        $this->dbConnection = DatabaseManager::getDatabaseConnection();

    }

    /*
     * Insertion d'un commentaire en BDD
     */
    public function add($comment) {
        $content = $comment->getContent();
        $status = $comment->getStatus();
        $datetime = $comment->getDatetime();
        $userLogin = $comment->getUserLogin();
        $idEvent = $comment->getIdEvent();

        $query = "INSERT INTO Comment (content, status, datetime, userLogin, idEvent) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'ssssi',$content,$status, $datetime, $userLogin, $idEvent);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $res;
    }

    public function getAllOfEvent($idEvent) {
        $query = "SELECT Comment.content, Comment.datetime, Comment.userLogin  
                FROM Comment
                WHERE status = 'approved' 
                AND idEvent = ?";
        $stmt = mysqli_prepare($this->dbConnection, $query);
        mysqli_stmt_bind_param($stmt, 'i',$idEvent);
        mysqli_stmt_execute($stmt);
        $comments =  mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $comments;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param mixed $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return mixed
     */
    public function getUserLogin()
    {
        return $this->userLogin;
    }

    /**
     * @param mixed $userLogin
     */
    public function setUserLogin($userLogin)
    {
        $this->userLogin = $userLogin;
    }

    /**
     * @return mixed
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * @param mixed $idEvent
     */
    public function setIdEvent($idEvent)
    {
        $this->idEvent = $idEvent;
    }




}