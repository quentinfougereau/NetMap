<?php
include_once('../views/header.php');

?>
<ul>
    <?php
    while ($event = mysqli_fetch_assoc($events)) {
        $html = "<li>";
        $html .= "<a href='../route/route_event.php?get_event=1&id_event=" . $event["idEvent"] . "'>Voir plus de détail sur " . $event["libelle"] . "</a>";
        $html .= "</li>";
        echo $html;
        //echo '<a href="../route/route_event.php?join_event=1&id_event=' . $event["idEvent"] . '">S\'inscrire à ' . $event["libelle"] . '</a>';
    }
    ?>
</ul>

<div class="col-md-12">
    <a href="../views/v_accueil.php">Retour accueil</a>
</div>

<?php
include_once '../views/footer.php';
?>