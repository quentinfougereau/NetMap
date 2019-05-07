<?php
	//Ce fichier est appellĂ© quand on clique sur le bouton de connexion
	session_start();
	session_destroy();
	header('Location: ../index.php');
	exit;
?>