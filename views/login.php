<?php 
include('../views/header.php');
?>
	
	<div class="container">
	<h1>Accueil - NetMap</h1>
	<h2>Login</h2>
		<form action="../controllers/routes.php?action=login" method="POST">
			<div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			</div>
			<div class="form-check">
				<input type="checkbox" name="conditions" class="form-check-input" id="exampleCheck1">
				<label class="form-check-label" for="exampleCheck1">Je certifie avoir lu et accepté les <a href="../views/ConditionUtilisation.html">Conditions Générales d'Utilisation</a></label>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
		<a href="../views/register.php">Créer un compte</a>
	</div>
<?php
include('../views/footer.php'); 
?>