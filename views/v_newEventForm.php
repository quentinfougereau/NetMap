<?php
include('../views/header.php');
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
                <form method="POST" action="../route/route_event.php?action=add_event">
                    <div class="form-group">
                        <label for="event_name">Nom de l'événement :</label>
                        <input class="form-control" type="text" name="event_name" required>
                    </div>
                    <div class="form-group">
                        <label for="event_date">Date de l'événement :</label>
                        <input class="form-control" type="date" name="event_date" required>
                    </div>
                    <div class="form-group">
                        <label for="event_start_time">Heure de début :</label>
                        <input class="form-control" type="text" name="event_start_time" id="event_start_time">
                        <label for="event_end_time">Heure de fin :</label>
                        <input class="form-control" type="text" name="event_end_time" id="event_end_time">
                    </div>
                    <div class="form-group">
                        <label for="cities">Ville</label>
                        <select name="city" class="form-control" id="cities" required>
                            <?php
                            while ($city = mysqli_fetch_assoc($cities)) {
                                $html = "<option value='" . $city["ville"] . "'>";
                                $html .= $city["ville"];
                                $html .= "</option>";
                                echo $html;
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" id="placeListGroup">
                        <label for="placeList">Lieu</label>
                        <select name="place" class="form-control" id="placeList" required></select>
                    </div>

                    <div class="form-group">
                        <input class="btn btn-netmap" type="submit" value="Valider">
                    </div>
                </form>
            </div>

            <div class="col-md-12">
                <a href="../views/v_accueil.php">Retour accueil</a>
            </div>
        </div> <!-- .content-wrapper -->
    </main> <!-- .cd-main-content -->

<script type="text/javascript">
    $("#placeListGroup").hide();

    $("#event_start_time").timepicker({ 'timeFormat' : 'H:i', 'scrollDefault': 'now' });
    $("#event_end_time").timepicker({ 'timeFormat' : 'H:i', 'scrollDefault': 'now' });

    $("#cities").change(function() {
        $("#placeList").children().remove();
        var city = $(this).val();
        $.ajax({
            type: "POST",
            url: "../route/route_place.php?action=getPlacesFromCity",
            data: {city : city},
            success: function(places) {
                if (places != null && places.length != 0) {
                    for (let place of places) {
                        var html = "<option value='" + place.id + "'>";
                        html += place.place + " - " + place.street + " - " + place.postcode;
                        html += "</option>";
                        $("#placeList").append(html);
                    }
                    $("#placeListGroup").show();
                }
            },
            dataType: 'json'
        });
    });

    $("#placeList").change(function() {

    });
</script>

<?php
include_once "../views/footer.php";
?>