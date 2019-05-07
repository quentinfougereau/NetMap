<?php 
include('../views/header.php');
?>
	
	<div class="container">
	<h1>Accueil - NetMap</h1>
	<h2>Register</h2>
		<form action="../controllers/routes.php?action=register" method="POST">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="inputEmail4">Email</label>
					<input type="email" name="username" class="form-control" id="inputEmail4" placeholder="Email">
				</div>
				<div class="form-group col-md-6">
				<label for="inputAddress">Pseudo</label>
				<input type="text" name="pseudo" class="form-control" id="inputAddress" placeholder="First Name">
			</div>
			</div>
			<div class="form-group col-md-6">
				<label for="inputPassword4">Password</label>
				<input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password">
			</div>
			<div class="form-group col-md-6">
				<label for="inputPassword4">Verify Password</label>
				<input type="password" name="verifypassword" class="form-control" id="inputPassword4" placeholder="Password">
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
			<button type="submit" class="btn btn-primary">Sign in</button>
			
		</form>
		<a href="../views/login.php">J'ai déjà un compte</a>
	</div>
<?php
include('../views/footer.php'); 
?>