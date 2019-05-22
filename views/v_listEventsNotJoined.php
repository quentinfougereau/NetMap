<?php
include_once('../views/header.php');

?>

    <header class="cd-main-header js-cd-main-header">
        <div class="cd-logo-wrapper">
            <a href="#0" class="cd-logo">
                <img src="../img/cd-logo.svg" alt="Logo">
                <!-- <img src="assets/img/cd-logo.old.svg" alt="Logo"> -->
            </a>
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
            <ul>
                <?php
                while ($event = mysqli_fetch_assoc($events)) {
                    $html = "<li>";
                    $html .= "<a class='link-netmap' href='../route/route_event.php?get_event=1&id_event=" . $event["idEvent"] . "'>Voir plus de détail sur " . $event["libelle"] . "</a>";
                    $html .= "</li>";
                    echo $html;
                    //echo '<a href="../route/route_event.php?join_event=1&id_event=' . $event["idEvent"] . '">S\'inscrire à ' . $event["libelle"] . '</a>';
                }
                ?>
            </ul>

            <div class="col-md-12">
                <a class="link-netmap" href="../views/v_accueil.php">Retour accueil</a>
            </div>
        </div> <!-- .content-wrapper -->
    </main> <!-- .cd-main-content -->


<?php
include_once '../views/footer.php';
?>