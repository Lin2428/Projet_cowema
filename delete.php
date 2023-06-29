<?php

require 'functions.php';

if (!empty($_POST['id'])) {

  $data = find_stagiaire($_POST['id']);

  $q = db()->prepare("DELETE FROM stagiaires WHERE id = ?");
  $q->execute([$_POST['id']]);

  unlink($data['photo']);

  flash('Le stagiaire a bien été supprimer');
} else {
  flash("Il ne s'est absolument rien passé", type: "danger");
}

header('Location: /?read');
exit;