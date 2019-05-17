<?php
if (!session_id()) session_start();
//Check if user is logged in
if (!$_SESSION['user']){ 
    header("Location:../index.php");
    die();
}
include("../controllers/c_login.php");
$controller = new C_login();
$adresse = '';
$adresse = $_SESSION['login_user'];
$infoUser = $controller->getUserData($adresse);
include('../views/header.php');
?>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <h1>ACCUEIL</h1>
            <?php
                echo '<h2>Bienvenue '. $infoUser['pseudo'] .'</h2>';
            ?>
            <a class="link-netmap" href="../views/login.php">Se connecter</a>
        </div>

        <div class="col-md-3">
            <a class="link-netmap" href="../controllers/c_logout.php">Se déconnecter</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <a class="btn btn-netmap" href="../route/route_event.php?new_event=1">Ajouter un événement</a>
        </div>

        <div class="col-md-2">
            <a class="btn btn-netmap" href="../route/route_event.php?list_user_events=1">Voir mes événements</a>
        </div>

        <div class="col-md-2">
            <a class="btn btn-netmap" href="../route/route_event.php?fetch_events_not_joined=1">S'inscrire aux événements</a>
        </div>
    </div>
</div>

<?php
include('../views/footer.php'); 
?>