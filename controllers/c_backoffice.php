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
		return;
	}
	
	public function connectBDD(){
		$con = $this->model->bddConnect();
		return $con;
	}
}
?>
