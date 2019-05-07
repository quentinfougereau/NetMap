<?php
include_once('../controllers/controller.php');
include_once('../models/models.php');

class C_login extends Controller {

	function __construct()
	{
		parent::__construct();
	//constructor code here
	}
	
	public function login()
	{
		$reslt = $this->model->getlogin();
		if(empty($reslt))
		{
			echo "<p style='color:red'>Login failed</p>";
		}
		else
		{
			session_start();
			$_SESSION['login_user'] = $reslt;
			$data = $this->isAdmin($reslt);
			if($data == "1" || $data == "2"){
				header('Location: ../views/v_backofficeUtil.php');
			}else{
				header('Location: ../views/v_accueil.php');
			}
		}
	}
	
	public function register()
	{
		$reslt = $this->model->register();
		return $reslt;
	}
	
	public function getUserData($adresse){
		$data = $this->model->getUserData($adresse);
		return $data;
	}
	
	public function isAdmin($adresse){
		$data = $this->getUserData($adresse);
		return $data['admin'];
	}
	
	public function connectBDD(){
		$this->model->bddConnect();
	}

	/**
	 * @return mixed
	 */
	public function getDbConnection()
	{
		return $this->model->getDbConnection();
	}



}
?>
