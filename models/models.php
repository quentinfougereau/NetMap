<?php

require("../utils/DatabaseManager.php");

/**
* Gathers and treats data from database
* And returns it to the controller
*/
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
	
	/**
	* Check user login
	*/
	public function getlogin()
	{
		$this->bddConnect();
		//Check both fields are not empty
		if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
			
			//Escape strings to avoid sql injection
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
	
	/**
	* Registers new user
	* Returns sql result string (errors)
	*/
	public function register(){
		$this->bddConnect();
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			
			//escape strings
			$esusername = mysqli_real_escape_string($this->dbConnection, $_REQUEST['username']);
			$espassword = mysqli_real_escape_string($this->dbConnection, $_REQUEST['password']);
			$esverifypassword = mysqli_real_escape_string($this->dbConnection, $_REQUEST['verifypassword']);
			$espseudo = mysqli_real_escape_string($this->dbConnection, $_REQUEST['pseudo']);
			$esAdresse = mysqli_real_escape_string($this->dbConnection, $_REQUEST['adresse']);
			$esville = mysqli_real_escape_string($this->dbConnection, $_REQUEST['city']);
			$escp = mysqli_real_escape_string($this->dbConnection, $_REQUEST['CP']);
			
			//check password and password verification fields
			if($espassword == $esverifypassword){
				
				$respseudo = mysqli_query($this->dbConnection, "SELECT pseudo FROM User WHERE pseudo='$espseudo' LIMIT 1");
				
				//Check if pseudo already exists
				if ($respseudo && mysqli_fetch_row($respseudo)) {
					$reslt = 'pseudocheck';
				} else {
					//Password hash method
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
	
	/**
	* Updates user infos from his email
	*/
	public function registerUpdate(){
		$this->bddConnect();
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			
			//escape strings
			$esusername = mysqli_real_escape_string($this->dbConnection, $_REQUEST['username']);
			$espassword = mysqli_real_escape_string($this->dbConnection, $_REQUEST['password']);
			$espseudo = mysqli_real_escape_string($this->dbConnection, $_REQUEST['pseudo']);
			$esAdresse = mysqli_real_escape_string($this->dbConnection, $_REQUEST['adresse']);
			$esville = mysqli_real_escape_string($this->dbConnection, $_REQUEST['city']);
			$escp = mysqli_real_escape_string($this->dbConnection, $_REQUEST['CP']);
			
			if($espassword){
				$query = "SELECT login, password FROM User WHERE login = '$esusername'";
				$sql = mysqli_query($this->dbConnection, $query);

				if($sql->num_rows > 0) {
					$data = $sql->fetch_array();
					//Verify if hash = password
					if(password_verify($espassword, $data['password'])){
						$sql = "UPDATE User SET pseudo = '$espseudo' WHERE login='$esusername'";
							if (mysqli_query($this->dbConnection, $sql) === TRUE) {
							$reslt = 'success';
						} else {
							$reslt = "Error: " . $sql . "<br>" . mysqli_error($this->dbConnection);
						}
					}
				}
			}else{
				$reslt = "Entrez un mdp";
			}

			mysqli_close($this->dbConnection);
			return $reslt;
		}
	}
	
	/**
	* Returns an array of user data (login, pseudo, isAdmin)
	*/
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
	
	/**
	* Updates user rights
	*/
	public function manageUser($id, $oper){
		$this->bddConnect();
		if($oper == 'admin'){
			$sql = "UPDATE User SET isAdmin='2' WHERE login='$id'";
		}else{
			if($oper == 'modo'){
				$sql = "UPDATE User SET isAdmin='1' WHERE login='$id'";
			}else{
				if($oper == 'util'){
					$sql = "UPDATE User SET isAdmin='0' WHERE login='$id'";
				}else{
					$reslt = 'Controller error';
				}	
			}
		}
		if ($this->dbConnection->query($sql) === TRUE) {
			$reslt = '';
		}else{
			$reslt = 'SQL error';
		}
		return $reslt;
	}
	
	/**
	* Verifies comment
	*/
	public function manageComment($comment){
		$this->bddConnect();

		$sql = "UPDATE Comment SET status='approved' WHERE idComment='$comment'";

		if ($this->dbConnection->query($sql) === TRUE) {
			$reslt = '';
		}else{
			$reslt = 'SQL error';
		}
		return $reslt;
	}
	
	/**
	* Adds or removes user warnings
	*/
	public function setUserWarning($user, $action){
		$this->bddConnect();
		$sql = '';
		if($action == 'add'){
			$sql = "UPDATE User SET warning = warning + 1 WHERE login='$user'";
		}	
		if($action == 'sub'){
			$sql = "UPDATE User SET warning = warning - 1 WHERE login='$user'";
		}
		
		if ($this->dbConnection->query($sql) === TRUE) {
			$reslt = '';
		}else{
			$reslt = 'SQL error';
		}
		return $reslt;
	}
}
?>