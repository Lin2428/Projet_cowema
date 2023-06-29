<?php

$listes = get_stagiaires();

//Boutton retour
if (isset($_GET['accueil'])) {
  header('Location: create.php');
  exit();
}
?>

<div class="py-5">
  <div class="container">
    <!-- Condition pour le message -->
    <?= read_flash_message() ?>

    <div class="d-flex justify-content-between mb-4">
      <h1>Gestion de stagiaires</h1>
      <div><a href="/?create" class="btn btn-primary">Nouveau</a></div>
    </div>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">N°</th>
          <th scope="col">Photo</th>
          <th scope="col">Nom</th>
          <th scope="col">Prénom</th>
          <th scope="col">Email</th>
          <th scope="col">Date début</th>
          <th scope="col">Date fin</th>
          <th scope="col">Commentaire</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Boucle pour le remplissage automatique du tableau -->
        <?php foreach ($listes as $i => $stagiaire) : ?>
          <!-- Incrementation de la variable $i -->
          <tr>
            <th><?= $i + 1 ?></th>
            <td><img src="<?= $stagiaire['photo'] ?>" class="image"></td>
            <td><?= $stagiaire['nom'] ?></td>
            <td><?= $stagiaire['prenom'] ?></td>
            <td><?= $stagiaire['email'] ?></th>
            <td><?= $stagiaire['date_debut'] ?></td>
            <td><?= $stagiaire['date_fin'] ?></td>
            <td><?= $stagiaire['commentaire'] ?></td>
            <td>
              <a href="?update=<?= $stagiaire['id'] ?>" class="btn btn-sm btn-outline-info">Modifier</a>
              <form action="delete.php" method="POST" class="d-inline">
                <input type="hidden" name="id" value="<?= $stagiaire['id'] ?>">
                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>