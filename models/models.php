<?php

require("../utils/DatabaseManager.php");

class Model {

    private $dbConnection;

    /**
     * @return mixed
     */
    public function getDbConnection()
    {
        return $this->dbConnection;
    }
	
	public function bddConnect() {
        $this->dbConnection = DatabaseManager::getDatabaseConnection();
	}
	
	public function getlogin()
	{
		$this->bddConnect();
		if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){

            $myusername = mysqli_real_escape_string($this->dbConnection, $_REQUEST['username']);
            $mypassword = mysqli_real_escape_string($this->dbConnection, $_REQUEST['password']);

			$query = "SELECT login, password FROM User WHERE login = '$myusername'";
			$sql = mysqli_query($this->dbConnection, $query);

			if($sql->num_rows > 0) {
				$data = $sql->fetch_array();
				//Verify if hash = password
				if(password_verify($mypassword, $data['password'])){
					return $myusername;
				}
			}else{
				return '';
			}
		}
	}
	
	public function register(){
		$this->bddConnect();
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			
			$esusername = mysqli_real_escape_string($this->dbConnection, $_REQUEST['username']);
			$espassword = mysqli_real_escape_string($this->dbConnection, $_REQUEST['password']);
			$esverifypassword = mysqli_real_escape_string($this->dbConnection, $_REQUEST['verifypassword']);
			$espseudo = mysqli_real_escape_string($this->dbConnection, $_REQUEST['pseudo']);
			$esAdresse = mysqli_real_escape_string($this->dbConnection, $_REQUEST['adresse']);
			$esville = mysqli_real_escape_string($this->dbConnection, $_REQUEST['city']);
			$escp = mysqli_real_escape_string($this->dbConnection, $_REQUEST['CP']);
			
			if($espassword == $esverifypassword){
				
				$respseudo = mysqli_query($this->dbConnection, "SELECT pseudo FROM User WHERE pseudo='$espseudo' LIMIT 1");
				
				if ($respseudo && mysqli_fetch_row($respseudo)) {
					$reslt = 'pseudocheck';
				} else {
					$pswHash = password_hash($espassword, PASSWORD_BCRYPT);
		
					$sql = "INSERT INTO User (login, password, pseudo)
					VALUES ('$esusername', '$pswHash', '$espseudo')";



					if (mysqli_query($this->dbConnection, $sql) === TRUE) {
						$reslt = 'success';
					} else {
						$reslt = "Error: " . $sql . "<br>" . mysqli_error($this->dbConnection);
					}
				}
			}else{
				$reslt = 'passwordcheck';
			}
			mysqli_close($this->dbConnection);
			return $reslt;
		}
	}
	
	public function getUserData($adresse){
		$this->bddConnect();

		$infoUser = null;
		
		$result = mysqli_query($this->dbConnection, "SELECT * FROM User WHERE `login` = '$adresse'");
		
		while($resrow = mysqli_fetch_assoc($result)) {
			$infoUser['adresse'] = $resrow['login'];
			$infoUser['pseudo'] = $resrow['pseudo'];
			$infoUser['admin'] = $resrow['isAdmin'];
		}
		
		return $infoUser;
	}
}
?>