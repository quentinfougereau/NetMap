<?php
class DatabaseManager
{
    private $host;
    private $user;
    private $password;
    private $db;

    /**
     * DatabaseManager constructor.
     * @param $host
     * @param $user
     * @param $password
     * @param $db
     */
    public function __construct($host, $user, $password, $db)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;
    }


    public function connect() {
        $dbConnection =  mysqli_connect($this->host, $this->user, $this->password, $this->db);
        mysqli_query($dbConnection,"Set names UTF8");
        return $dbConnection;
    }

    public static function getDatabaseConnection() {
        $dbManager = new DatabaseManager("localhost", "root", "root", "NetMap");
        return $dbManager->connect();
    }

}