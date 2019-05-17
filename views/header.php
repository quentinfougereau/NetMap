<html>
<head>
	<title>NetMap</title>
	
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev" crossorigin="anonymous">
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
	integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
	crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
	integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
	crossorigin=""></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js%22%3E"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
</head>
<body class="d-flex flex-column h-100">
<main role="main">
<div id="divheader" class="col-md-12 header row">
    <div class="col">
		<p class="text-left">
		<a class="headlink" href="../views/v_accueil.php"><i style='padding:5px;' class='fas fa-home'></i></a>
		Projet NetMap</p>
	</div>
	<div class="col">
		<p class="text-right">
			<?php
				if (!session_id()) session_start();
				if (isset($_SESSION['login_user'])) {
					echo $_SESSION['login_user'];
					echo "<a href='../views/v_profile.php'><i style='padding:5px;' class='fas fa-user-circle'></i></a>";
				}
			?>
			<a class="headlink" href="../controllers/c_logout.php">Logout</a>
		</p>
	</div>
	
</div>
