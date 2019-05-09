<?php
include('../views/header.php');
?>

    <form method="POST" action="../route/route_event.php">
        <div>
            <label for="event_name">Nom de l'événement :</label>
            <input type="text" name="event_name">
        </div>
        <div>
            <label for="event_date">Date de l'événement :</label>
            <input type="date" name="event_date">
        </div>
        <div>
            <label for="place_name">Nom du lieu :</label>
            <input type="text" name="place_name">
        </div>
        <div>
            <label for="street">Rue :</label>
            <input type="text" name="street">
        </div>
        <div>
            <label for="postcode">Code postal :</label>
            <input type="text" name="postcode">
        </div>
        <div>
            <label for="city">Ville :</label>
            <input type="text" name="city">
        </div>
        <div>
            <input type="hidden" name="add_event" value="1">
            <input type="submit" value="Valider">
        </div>
    </form>

<div class="col-md-12">
    <a href="../views/v_accueil.php">Retour accueil</a>
</div>