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

    <header class="cd-main-header js-cd-main-header">
        <div class="cd-logo-wrapper">
            <a href="#0" class="cd-logo">
                <img src="../img/cd-logo.svg" alt="Logo">
                <!-- <img src="assets/img/cd-logo.old.svg" alt="Logo"> -->
            </a>
        </div>
        <!-- Affichage d'éventuels messages d'erreurs lors de la géolocalisation -->
        <div id="infoposition" class="error"></div>

        <div class="cd-search js-cd-search">
            <form>
                <input class="reset" type="search" placeholder="Search...">
                <input type="button" class="addrConfirmButton" value="Localisez-moi" onClick="locateByAddress()"/>

            </form>
            <button id="location-pin" onClick="askForGeolocalisation()"/>
        </div>
        <button class="reset cd-nav-trigger js-cd-nav-trigger" aria-label="Toggle menu"><span></span></button>

        <ul class="cd-nav__list js-cd-nav__list">
            <li class="cd-nav__item cd-nav__item--has-children cd-nav__item--account js-cd-item--has-children">
                <a href="#0">
                    <i class="far fa-user-circle"></i>&nbsp;
                    <span>Mon compte</span>
                </a>

                <ul class="cd-nav__sub-list">
                    <li class="cd-nav__sub-item"><a href="../views/login.php">Se connecter</a></li>
                    <li class="cd-nav__sub-item"><a href="../controllers/c_logout.php">Se deconnecter</a></li>
                </ul>
            </li>
        </ul>
    </header> <!-- .cd-main-header -->

    <main class="cd-main-content">
        <nav class="cd-side-nav js-cd-side-nav">
            <ul class="cd-side__list js-cd-side__list">
                <li class="cd-side__label"><span>Main</span></li>
                <li class="cd-side__item cd-side__item--has-children cd-side__item--overview js-cd-item--has-children">
                    <?php if (!isset($_SESSION["login_user"])) {
                        echo '<a href="../views/login.php">Se Connecter</a>';
                    } else {
                        echo '<a href="../controllers/c_logout.php">Se deconnecter</a>';
                    } ?>
                </li>
            </ul>

            <ul class="cd-side__list js-cd-side__list">
                <li class="cd-side__label"><span>Action</span></li>
                <li class="cd-side__btn">
                    <a class="btn btn-netmap btn-sidebar" href="../route/route_event.php?new_event=1">Ajouter un événement</a>
                </li>
                <li class="cd-side__btn">
                    <a class="btn btn-netmap btn-sidebar" href="../route/route_event.php?list_user_events=1">Voir mes événements</a>
                </li>
                <li class="cd-side__btn">
                    <a class="btn btn-netmap btn-sidebar" href="../route/route_event.php?fetch_events_not_joined=1">S'inscrire aux événements</a>
                </li>
            </ul>
        </nav>

        <div class="cd-content-wrapper">
            <div id='mapid'></div>
            <div id="sidebar"></div>
        </div> <!-- .content-wrapper -->
    </main> <!-- .cd-main-content -->


    <!-- Include de la bibliothèque JQuery -->
    <script src="https://code.jquery.com/jquery-3.0.0.js" integrity="sha256-jrPLZ+8vDxt2FnE1zvZXCkCcebI/C8Dt5xyaQBjxQIo=" crossorigin="anonymous"></script>
    <!-- Include de l'API leaflet -->
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
            crossorigin=""></script>
    <!-- Sidebear leaflet -->
    <script src="../assets/sidebar/L.Control.Sidebar.js"></script>
    <!-- Include de l'API PHOTON-->
    <script src="../assets/autocomplete/typeahead.bundle.js"></script>
    <script src="../assets/autocomplete/typeahead-address-photon.js"></script>
    <!-- Include de EasyButton -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>


    <!-- SCRIPTS PERSOS -->

    <!-- searchbar -->
    <script src="../assets/user/js/searchbar/geolocation-button.js"></script>
    <script src="../assets/user/js/searchbar/form-confirm-button.js"></script>
    <!-- map -->
    <script src="../assets/user/js/map/map.js"></script>
    <script src="../assets/user/js/map/map-custom-icons.js"></script>
    <script src="../assets/user/js/map/control.js"></script>
    <script src="../assets/user/js/map/selflocalisation-button.js"></script>
    <script src="../assets/user/js/map/center-button.js"></script>
    <!-- checkbox -->
    <script src="../assets/user/js/checkbox/checkbox.js"></script>
    <!-- loading -->
    <script src="../assets/user/js/loading.js"></script>
    <!-- évènements-->
    <script src="../assets/user/js/events/eventTest.js"></script>

<?php
include('../views/footer.php'); 
?>