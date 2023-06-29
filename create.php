<?php
// Declaration variable de message et d'erreur
$message = "";
$erreur = "";

//Traitement du formulair d'inscription
if (isset($_POST['inscrir'])) {
  //Verification si les champs ne sont pas vides
  if (!empty($_POST["nom"] && $_POST["prenom"] && $_POST["email"] && $_POST["date_debut"] && $_POST["date_fin"])) {


    $imagStage = null;

    if (isset($_FILES['image'])) {
      $imagStage = uploadImage();
    }

    create_stagiaire(
      nom: $_POST['nom'],
      prenom: $_POST['prenom'],
      email: $_POST['email'],
      photo: $imagStage,
      date_debut: $_POST['date_debut'],
      date_fin: $_POST['date_fin'],
      commentaire: $_POST['commentaire']
    );

    flash("Le stagiaire à bien été créer");

    header('Location: /?read');
    die();
  } else {
    //Erreur
    $erreur = "Veuillez remplir les champs important";
  }
}
?>

<div class="py-4">
  <div class="container">
    <div class="d-flex justify-content-between mb-4">
      <h1>Nouveau stagiaire</h1>
      <div><a href="/?read" class="btn btn-primary">Liste des stagaires</a></div>
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
              <?= input(name: "nom", label: "Nom") ?>

              <?= input(name: "prenom", label: "Prénom") ?>
              <?= input(name: "email", label: "Email", type: "email") ?>

              <div class="form-group">
                <label for="image">Photo</label>
                <input type="file" name="image" class="form-control">
              </div>

              <?= input(name: "date_debut", label: "Date début", type: "date") ?>
              <?= input(name: "date_fin", label: "Date fin", type: "date") ?>

              <?= input(name: "commentaire", label: "Commentaire", type: "textarea") ?>

              <div class="submit text-center">
                <button type="submit" class="btn btn-outline-info text-center rounded-pill">Créer le compte</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>