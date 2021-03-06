<?php
include_once('../controllers/controller.php');
include_once('../models/models.php');

class C_backoffice extends Controller {
	
	function __construct()
	{
		parent::__construct();
	//constructor code here
	}
	
	public function manageUser($id, $oper)
	{
		$data = $this->model->manageUser($id, $oper);
		return $data;
	}
	
	public function setUserWarning($user, $action)
	{
		$data = $this->model->setUserWarning($user, $action);
		return $data;
	}
	
	public function manageComment($comment)
	{
		$data = $this->model->manageComment($comment);
		return $data;
	}
	
	public function connectBDD(){
		$con = $this->model->bddConnect();
		return $con;
	}
}
?>
