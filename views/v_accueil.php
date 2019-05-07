<?php
session_start();
include("../controllers/c_login.php");
$controller = new C_login();
$adresse = '';
$adresse = $_SESSION['login_user'];
$infoUser = $controller->getUserData($adresse);
include('../views/header.php');
?>
<div class="container">
	<div class="col-md-12">
		<h1>ACCUEIL</h1>
		<?php
			echo '<h2>Bienvenue, '. $infoUser['pseudo'] .'</h2>';
		?>
		
	</div>
</div>
<a href="../controllers/c_logout.php">Se dÃ©connecter</a>

<?php
include('../views/footer.php'); 
?>