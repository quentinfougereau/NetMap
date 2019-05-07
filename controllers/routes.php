<?php 
include_once('../controllers/c_login.php');
include_once('../controllers/c_backoffice.php');
$controller = new C_login();
$c_backoffice = new C_backoffice();

if(isset($_REQUEST['action']))
	$action = $_REQUEST['action'];
else
	$action = '';

switch($action)
{
	case 'manageUser':
		$id = $_REQUEST['user'];
		$oper = $_REQUEST['oper'];
		$c_backoffice->manageUser($id, $oper);
		break;
		
	case 'login':
		$controller->login();
		break;
		
	case 'register':
		$reslt = $controller->register();
		if($reslt == 'success'){
			echo '<p style=color:green>Successfully Registered</p>';
			include('../views/login.php');	
		}else{
			if($reslt == 'passwordcheck'){
				echo '<p style=color:red>Please check your passwords</p>';
				include('../views/register.php');
			}else{
				if($reslt == 'pseudocheck'){
					echo '<p style=color:red>Pseudo already used</p>';
					include('../views/register.php');
				}else{
					echo '<p style=color:red>Registration Failed</p>';
					include('../views/register.php');
				}
			}
		}
		break;
}
?>
