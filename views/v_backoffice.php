<?php
if (!session_id()) session_start();
//Check if user is Admin
if (!$_SESSION['admin']){ 
    header("Location:../views/v_accueil.php");
    die();
}
include("../controllers/c_login.php");
$controller = new C_login();
$controller->connectBDD();
$con = $controller->getDbConnection();
$adresse = $_SESSION['login_user'];

$infoUser = $controller->getUserData($adresse);
include('../views/header.php'); 
?>
<div class="container-fluid">
	<div class="row">
		<div id="bo_menu" class="col-lg-2 col-md-12">
			<div style="padding-top:10px;padding-left:10px;" class="pcoded-navigation-label"><p style="color:#fdd4b1;font-weight:bold">APPLICATION</p></div>
			<ul class="listul">
				<li class="listil"><a class="listla" href="../views/v_accueil.php">Homepage</a></li>
			</ul>
			<div style="padding-top:10px;padding-left:10px;" class="pcoded-navigation-label"><p style="color:#fdd4b1;font-weight:bold">BACKOFFICE</p></div>
			<ul class="listul">
				<li class="listil"><a class="listla" href="../views/v_backofficeDashboard.php">Dashboard</a></li>
				<li class="listil"><a class="listla" href="../views/v_backofficeParam.php">Settings</a></li>
				<li class="listil"><a class="listla" href="../views/v_backofficeUtil.php">Users</a></li>
				<li class="listil"><a class="listla" href="../views/v_backofficeLieu.php">Places</a></li>
				<li class="listil"><a class="listla" href="../views/v_backofficeEvents.php">Events</a></li>
				<li class="listil"><a class="listla" href="../views/v_backofficeComment.php">Comments</a></li>
			</ul>
		</div>
		