<?php

$message = null;
$erreur = null;
//Recuperation de l'id à modifier
$id = $_GET['update'];
$stagiere = find_stagiaire($id);


//Code pour le traitement du formulaire
if (!empty($_POST)) {
  //Verification si les champs ne sont pas vides
  if (!empty($_POST["nom"] && $_POST["prenom"] && $_POST["email"] && $_POST["date_debut"] && $_POST["date_fin"])) {

    if (isset($_FILES['image'])) {
      $imagStage = uploadImage();
      unlink($stagiere['photo']);
    }
    $imagStage = $imagStage ?? $stagiere['photo'];

    update_stagiaire(
      $id,
      $_POST['nom'],
      $_POST['prenom'],
      $_POST['email'],
      $imagStage,
      $_POST['date_debut'],
      $_POST['date_fin'],
      $_POST['commentaire']
    );


    flash("Le stagiaire à bien été mis à jours");

    header('Location: ?read');
    die();
  } else {
    //Erreur
    $message = "Veuillez remplir les champs important";
  }
}
?>

<div class="py-4">
  <div class="container">
    <div class="d-flex justify-content-between mb-4">
      <h1>Edition stagiaire</h1>
      <div><a href="?read" class="btn btn-primary">Liste des stagaires</a></div>
    </div>

    <div class="row">

      <div class="col-md-8">
        <!-- Condition pour le message -->
        <?php if ($message) : ?>
          <div class="alert alert-success text-center">
            <?= $message ?>
          </div>
        <?php endif ?>

        <div class="card">

          <div class="card-body">
            <h4 class="card-title">Creer un compte</h4>
            <!-- Condition pour l'erreur' -->
            <?php if ($erreur) : ?>
              <div class="alert alert-danger text-center">
                <?= $erreur ?>
              </div>
            <?php endif ?>
            <form method="POST" enctype="multipart/form-data">

              <?= input("nom","Nom","text", true, $stagiere['nom']) ?>

              <?= input("prenom","Prénom", "text", true, $stagiere['prenom']) ?>
              <?= input("email", "Email", true,  "email", $stagiere['email']) ?>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="image">Photo</label>
                    <input type="file" name="image" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <?php if (!empty($stagiere['photo'])) : ?>
                    <img src="<?= $stagiere['photo'] ?>" style="width: auto; height: 80px;" alt="">
                  <?php endif; ?>
                </div>
              </div>

              <?= input("date_debut", "Date début", "date", true, $stagiere['date_debut']) ?>
              <?= input("date_fin", "Date fin",  "date", true, $stagiere['date_fin']) ?>

              <?= input("commentaire", "Commentaire","textarea", false,  $stagiere['commentaire']) ?>

              <div class="submit text-center">
                <button type="submit" class="btn btn-outline-info text-center rounded-pill">Modifier le compte</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>