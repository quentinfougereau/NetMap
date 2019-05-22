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
            <div class="col-md-12">
                <?php
                $html = "<h1>Evénement n° " . $event["idEvent"] . "</h1>";
                $html .= "<h2>" . $event["libelle"] . "</h2>";
                $html .= "<p>Lieu : " . $event["place"] . "</p>";
                $html .= "<p>Adresse : " . $event["street"] . ", " . $event["postcode"] . ", " . $event["city"] . "</p>";
                $html .= "<p>Date : " . $event["date"] . "</p>";
                $html .= "<p>Heure de début : " . $event["start"] . "</p>";
                $html .= "<p>Heure de fin : " . $event["end"] . "</p>";
                echo $html;
                ?>
            </div>

            <div class="col-md-12">
                <?php
                if (!$hasJoined) {
                    $html = '<a class="link-netmap" href="../route/route_event.php?fetch_events_not_joined=1">Retour aux événements</a>';
                    echo $html;
                } else {
                    $html = '<a class="link-netmap" href="../route/route_event.php?list_user_events=1">Retour aux événements</a>';
                    echo $html;
                }
                ?>

            </div>

            <?php if (!$hasJoined) { ?>
                <div class="col-md-12">
                    <p>
                        <?php
                        $html = '<a class="btn btn-netmap" href="../route/route_event.php?join_event=1&id_event=' . $event["idEvent"] . '" role="button">S\'inscrire</a>';
                        echo $html;
                        ?>
                    </p>
                </div>
            <?php } else { ?>
                <div class="col-md-12">
                    <h3>Informations complémentaires et commentaires.</h3>

                    <form action="../route/route_comment.php?action=addComment" method="POST">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Vous pouvez discuter de cet événement ou bien ajouter des renseignements.</label>
                            <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <?php
                            $html = '<input type="hidden" name="id_event" value="' . $event["idEvent"] . '">';
                            echo $html;
                            ?>
                            <input class="btn btn-netmap" type="submit" value="Valider">
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <p>
                        <a class="btn btn-netmap" data-toggle="collapse" href="#collapseCommentSection" role="button" aria-expanded="true" aria-controls="collapseCommentSection">
                            Afficher / Masquer les commentaires
                        </a>
                    </p>
                    <div class="show" id="collapseCommentSection">
                        <?php
                        while ($comment = mysqli_fetch_assoc($comments)) {
                            $html = "<div class='card'>";
                            $html .= "<div class='card-body'>";
                            $html .= "<h5 class='card-title'>" . $comment["userLogin"] . " : </h5>";
                            $html .= "<h6 class='card-subtitle mb-2 text-muted'>" . $comment["datetime"] . "</h6>";
                            $html .= "<p class='card-text'>" . $comment["content"] . "</p>";
                            $html .= "</div>";
                            $html .= "</div>";
                            echo $html;
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div> <!-- .content-wrapper -->
    </main> <!-- .cd-main-content -->



<?php
include_once '../views/footer.php';
?>