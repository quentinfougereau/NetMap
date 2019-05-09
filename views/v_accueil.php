<?php
session_start();
include("../controllers/c_login.php");
$controller = new C_login();
$adresse = '';
$adresse = $_SESSION['login_user'];
$infoUser = $controller->getUserData($adresse);
include('../views/header.php');
?>
<div class="col-md-3">
    <h1>ACCUEIL</h1>
    <?php
        echo '<h2>Bienvenue '. $infoUser['pseudo'] .'</h2>';
    ?>
    <a href="../views/login.php">Se connecter</a>
</div>

<div class="col-md-3">
    <a href="../controllers/c_logout.php">Se déconnecter</a>
</div>
<br/>

<div class="col-md-3">
    <a href="../route/route_event.php?new_event=1">Ajouter un événement</a>
</div>

<div class="col-md-3">
    <a href="../route/route_event.php?list_user_events=1">Voir mes événements</a>
</div>

<?php
include('../views/footer.php'); 
?>