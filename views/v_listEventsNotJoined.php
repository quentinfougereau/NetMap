<?php
include('../views/header.php');

?>
<ul>
    <?php
    while ($event = mysqli_fetch_assoc($events)) {
    ?>
    <li>
        <?php
        echo '<a href="../route/route_event.php?join_event=1&id_event=' . $event["idEvent"] . '">S\'inscrire à ' . $event["libelle"] . '</a>';
        ?>
    </li>
    <?php
    }
    ?>
</ul>

<div class="col-md-12">
    <a href="../views/v_accueil.php">Retour accueil</a>
</div>