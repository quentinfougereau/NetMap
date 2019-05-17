<?php
if (!session_id()) session_start();
if (!$_SESSION['user']){ 
    header("Location:../index.php");
    die();
}
include_once("../controllers/c_login.php");
$controller = new C_login();
$adresse = '';
$adresse = $_SESSION['login_user'];
$infoUser = $controller->getUserData($adresse);
include('../views/header.php');
?>
<div class="container">
	<h1>Accueil - NetMap</h1>
	<h2>Register</h2>
		<form action="../controllers/routes.php?action=registerUpdate" method="POST">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="disabledInput" class="col-sm-2 control-label">Email</label>
					<input name="username" class="form-control" id="disabledInput" type="email" value="<?php echo $adresse;?>" readonly>
				</div>
				<div class="form-group col-md-6">
				<label for="inputAddress">Pseudo</label>
				<input type="text" name="pseudo" class="form-control" id="inputAddress" value="<?php echo $infoUser['pseudo'];?>">
			</div>
			</div>
			<div class="form-group col-md-6">
				<label for="inputPassword4">Password</label>
				<input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="inputCity">Adresse</label>
					<input type="text" name="adresse" class="form-control" id="inputCity">
				</div>
				<div class="form-group col-md-4">
					<label for="inputCity">Ville</label>
					<input type="text" name="city" class="form-control" id="inputCity">
				</div>
				<div class="form-group col-md-2">
					<label for="inputZip">Code Postal</label>
					<input type="text" name="CP" class="form-control" id="inputZip">
				</div>
			</div>
			<div class="form-group">
				<div class="form-check">
					<input class="form-check-input" type="checkbox" id="gridCheck">
					<label class="form-check-label" for="gridCheck">
					Check me out
					</label>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Update</button>
		</form>
		<a href="#">Forgot your password?</a>
	</div>

<?php
include('../views/footer.php'); 
?>