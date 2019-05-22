<?php
include('../views/header.php');
?>

<!--
<div class="col-md-3">
	<h1>ACCUEIL VISITEUR</h1>
	<a href="../views/login.php">Se connecter</a>
</div>
<br/>
-->


    <header class="cd-main-header js-cd-main-header">
        <div class="cd-logo-wrapper">
            <a href="#0" class="cd-logo">
                <img src="../img/cd-logo.svg" alt="Logo">
            </a>
        </div>
        <!-- Affichage d'éventuels messages d'erreurs lors de la géolocalisation -->
        <div id="infoposition" class="error"></div>

        <div class="cd-search js-cd-search">
            <form>
                <input class="reset" id="addrArea" type="search" placeholder="Search...">
                <input type="button" class="addrConfirmButton" value="Bouton" onClick="locateByAddress()"></input>
            </form>
            <button id="location-pin" onClick="askForGeolocalisation()"/>
        </div>
        <button class="reset cd-nav-trigger js-cd-nav-trigger" aria-label="Toggle menu"><span></span></button>

        <ul class="cd-nav__list js-cd-nav__list">
            <li class="cd-nav__item cd-nav__item--has-children cd-nav__item--account js-cd-item--has-children">
                <a href="#0">
                    <!-- <img src="assets/img/cd-avatar.svg" alt="avatar"> -->
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
                <li class="cd-side__item cd-side__item--overview">
                    <a href="../views/login.php">Se Connecter</a>
                </li>
            </ul>

            <ul class="cd-side__list js-cd-side__list">
                <li class="cd-side__label"><span>Action</span></li>
            </ul>
        </nav>

        <div class="cd-content-wrapper">
            <div id='mapid'></div>
        </div> <!-- .content-wrapper -->
    </main> <!-- .cd-main-content -->

    <!-- map -->
    <script src="../assets/visitor/js/map/map.js"></script>
    <script src="../assets/visitor/js/map/map-custom-icons.js"></script>
    <script src="../assets/visitor/js/map/center-button.js"></script>
    <!-- loading -->
    <script src="../assets/visitor/js/loading.js"></script>
    <!-- évènements -->
    <script src="../assets/visitor/js/events/eventTest.js"></script>
    <!-- css -->
    <script src="../assets/visitor/js/css.js"></script>

    <!-- Include de l'API PHOTON-->
    <script src="../assets/autocomplete/typeahead.bundle.js"></script>
    <script src="../assets/autocomplete/typeahead-address-photon.js"></script>

    <!-- searchbar -->
    <script src="../assets/visitor/searchbar/geolocation-button.js"></script>
    <script src="../assets/visitor/searchbar/form-confirm-button.js"></script>

<?php
include('../views/footer.php'); 
?>