<?php
include('../views/header.php');
?>

<div class="col-md-12">
    <form method="POST" action="../route/route_event.php?action=add_event">
        <div class="form-group">
            <label for="event_name">Nom de l'événement :</label>
            <input class="form-control" type="text" name="event_name">
        </div>
        <div class="form-group">
            <label for="event_date">Date de l'événement :</label>
            <input class="form-control" type="date" name="event_date">
        </div>
        <div class="form-group">
            <label for="event_start_time">Heure de début :</label>
            <input class="form-control" type="text" name="event_start_time" id="event_start_time">
            <label for="event_end_time">Heure de fin :</label>
            <input class="form-control" type="text" name="event_end_time" id="event_end_time">
        </div>
        <div class="form-group">
            <label for="cities">Ville</label>
            <select name="city" class="form-control" id="cities">
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
            <select name="place" class="form-control" id="placeList"></select>
        </div>
        <!--
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
        -->
        <div class="form-group">
            <input class="btn btn-primary" type="submit" value="Valider">
        </div>
    </form>
</div>

<div class="col-md-12">
    <a href="../views/v_accueil.php">Retour accueil</a>
</div>

<script type="text/javascript">
    $("#placeListGroup").hide();

    $("#event_start_time").timepicker({ 'timeFormat' : 'H:i', 'scrollDefault': 'now' });
    $("#event_end_time").timepicker({ 'timeFormat' : 'H:i', 'scrollDefault': 'now' });

    $("#cities").change(function() {
        $("#placeList").children().remove();
        var city = $(this).val();
        $.ajax({
            type: "POST",
            url: "http://localhost/NetMap/route/route_place.php?action=getPlacesFromCity",
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