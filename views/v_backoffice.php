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
			<ul class="listul">
				<li class="listil"><a class="listla" href="#home">Paramètres</a></li>
				<li class="listil"><a class="listla" href="../views/v_backofficeUtil.php">Utilisateurs</a></li>
				<li class="listil"><a class="listla" href="../views/v_backofficeLieu.php">Lieux</a></li>
				<li class="listil"><a class="listla" href="#about">Evénements</a></li>
			</ul>
		</div>