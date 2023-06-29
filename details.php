<?php
$id = $_GET['details'];
$stagiaire = find_stagiaire($id);

?>



<div class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <h1>Détails du stagiaire <?= $stagiaire['nom'] . " " . $stagiaire['prenom'] ?></h1>
            <div><a href="?read" class="btn btn-primary">Liste des stagaires</a></div>
        </div>
        <a href="?update=<?= $stagiaire['id'] ?>" class="btn btn-primary">Modifier les informations</a>
        <div>
            <?php if ($stagiaire['photo']) : ?>
                <div class="block_detail_image mt-3">
                    <img src="<?= $stagiaire['photo'] ?>" class="detail_image" alt="Responsive image">
                </div>
            <?php endif ?>
        </div>
        <div>

            <?= details_stagiaire("Nom", $stagiaire['nom']) ?>
            <?= details_stagiaire("Préom", $stagiaire['prenom']) ?>
            <?= details_stagiaire("Email", $stagiaire['email']) ?>
            <?= details_stagiaire("Date debut", $stagiaire['date_debut']) ?>
            <?= details_stagiaire("Date fin", $stagiaire['date_fin']) ?>
            <?= details_stagiaire("Commentaire", $stagiaire['commentaire']) ?>
        </div>
        


    </div>
</div>