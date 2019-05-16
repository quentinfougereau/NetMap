<?php
session_start();
include("../controllers/c_login.php");
$controller = new C_login();
$controller->connectBDD();
$con = $controller->getDbConnection();
$adresse = $_SESSION['login_user'];
$infoUser = $controller->getUserData($adresse);
include('../views/header.php'); 
?>
	<div style="background-color:#151a21" class="row">
		<div class="col-1">
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