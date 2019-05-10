<?php
include('../views/header.php');
?>

<div class="col-md-12">
    <form method="POST" action="../route/route_event.php">
        <div class="form-group">
            <label for="event_name">Nom de l'événement :</label>
            <input class="form-control" type="text" name="event_name">
        </div>
        <div class="form-group">
            <label for="event_date">Date de l'événement :</label>
            <input class="form-control" type="date" name="event_date">
        </div>
        <div class="form-group">
            <label for="place_name">Nom du lieu :</label>
            <input class="form-control" type="text" name="place_name">
        </div>
        <div class="form-group">
            <label for="street">Rue :</label>
            <input class="form-control" type="text" name="street">
        </div>
        <div class="form-group">
            <label for="postcode">Code postal :</label>
            <input class="form-control" type="text" name="postcode">
        </div>
        <div class="form-group">
            <label for="city">Ville :</label>
            <input class="form-control" type="text" name="city">
        </div>
        <div class="form-group">
            <input type="hidden" name="add_event" value="1">
            <input class="btn btn-primary" type="submit" value="Valider">
        </div>
    </form>
</div>

<div class="col-md-12">
    <a href="../views/v_accueil.php">Retour accueil</a>
</div>