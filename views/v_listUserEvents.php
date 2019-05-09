<?php
include('../views/header.php');
?>
<div class="col-md-12">
    <ul>
        <?php
        foreach ($events as $event) {
            echo "<li> Evenement n°" . $event["idEvent"] . " : " . $event["libelle"] . " à " . $event["street"] . ", " . $event["postcode"];
        }
        ?>
    </ul>
</div>

<div class="col-md-12">
    <a href="../views/v_accueil.php">Retour accueil</a>
</div>
