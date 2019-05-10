<?php
include_once('../views/header.php');
?>
<div class="col-md-12">
    <ul>
        <?php
        foreach ($events as $event) {
            $html = "<li>";
            $html .= "<a href='../route/route_event.php?get_event=1&id_event=" . $event["idEvent"] . "'>Evenement n°" . $event["idEvent"] . "</a>";
            $html .= " : " . $event["libelle"] . " à " . $event["street"] . ", " . $event["postcode"];
            $html .= "</li>";
            echo $html;
        }
        ?>
    </ul>
</div>

<div class="col-md-12">
    <a href="../views/v_accueil.php">Retour accueil</a>
</div>

<?php
include_once '../views/footer.php';
?>