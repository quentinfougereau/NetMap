<?php
include_once('../views/header.php');
?>
<div class="col-md-12">
    <?php
        $html = "<h1>Evénement n° " . $event["idEvent"] . "</h1>";
        $html .= "<h2>" . $event["libelle"] . "</h2>";
        $html .= "<p>Lieu : " . $event["place"] . "</p>";
        $html .= "<p>Adresse : " . $event["street"] . ", " . $event["postcode"] . ", " . $event["city"] . "</p>";
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
            <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
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

<?php
include_once '../views/footer.php';
?>