<?php
session_start();

define('HOST', '127.0.0.1');
define('DB_NAME', 'gestion_stagiaires');
define('USER', 'root');
define('PASS', '');

/**
 * @return PDO
 */
function db() {
	$db = new PDO("mysql:host=" .HOST. ";charset=utf8;dbname=" .DB_NAME , USER, PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $db;
}

/**
 * Recupération des stagiaires depuis la base de donnéé
 * 
 * @return array
 */
function get_stagiaires() {
    $result = db()->query("SELECT * FROM stagiaires ORDER BY nom");
    
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    return $data;
}

/**
 * Recupération d'un stagiaire depuis la base de donnéé
 * 
 * @param int $id L'id du stagiaire
 * @return array $result
 */
function find_stagiaire($id) {
    $query = db()->prepare('SELECT * FROM stagiaires WHERE id = ?');
    $query->execute([$id]);

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;
}
/**
 * Création d'un nouveau compte de stagiaire
 * @param string $nom le nom du stagiaire
 * @param string $prenom le prénom du stagiaire
 * @param string $email l'email' du stagiaire
 * @param string $photo la photo du stagiaire
 * @param string $date_debut la datede debut du stagiaire
 * @param string $date_fin la datede fin du stagiaire
 * @param string $commentaires le commentaire du stagiaire
 * 
 * 
 */

function create_stagiaire($nom, $prenom, $email, $photo, $date_debut, $date_fin, $commentaire) {
    $query = db()->prepare("INSERT INTO stagiaires (nom, prenom, email, photo, date_debut, date_fin, commentaire) VALUES (:nom, :prenom, :email, :photo, :date_debut ,:date_fin, :commentaire)");
    $query->execute([ 
    "nom" => $nom,
    "prenom" =>  $prenom,
    "email" =>  $email,
    "photo" =>  $photo,
    "date_debut" =>  $date_debut,
    "date_fin" =>  $date_fin,
    "commentaire" =>  $commentaire
]);
}
/**
 * Modification d'un' stagiaire
 * @param int $id l'id du stagiaire
 */
function update_stagiaire($id, $nom, $prenom, $email, $photo, $date_debut, $date_fin, $commentaire) {
    $query = db()->prepare("UPDATE stagiaires SET  nom = :nom, prenom = :prenom, email = :email, date_debut = :date_debut, date_fin = :date_fin, commentaire = :commentaire, photo = :photo WHERE id = :id");
    $query->execute([
    "id" => $id,
    "nom" => $nom,
    "prenom" =>  $prenom,
    "email" =>  $email,
    "photo" =>  $photo,
    "date_debut" =>  $date_debut,
    "date_fin" =>  $date_fin,
    "commentaire" =>  $commentaire
]);
}

/**
 * Upload de l'image dans le dossier ./imgages
 * et renvoie le chemin de l'image en question ou null
 * s'il y a eu une erreur
 * 
 * @return string|null chemin de l'image
 */
function uploadImage(): ?string {
    $extentionValide = ['jpg', 'png', 'jpeg'];

    if($_FILES['image']['error'] != UPLOAD_ERR_OK){
       return null;
    }

    $fileName = $_FILES['image']['name'];
    $extention = pathinfo($fileName, PATHINFO_EXTENSION);


    if(!in_array($extention, $extentionValide)) {
        return null;
    }

    $tmpName = $_FILES['image']['tmp_name'];
    $uniqueName = md5(uniqid(rand(), true));
    $filePath = "image/". $uniqueName . '.' .  $extention;
    
    move_uploaded_file($tmpName, $filePath);
    
    return $filePath;
}

/**
 * Génération d'un input group avec les comportements par défault
 * 
 * @param string $name l'attribut name du input
 * @param string $label le label de linput
 * @param string $type l'attribut' type de l'input
 * @param bool $required l'attribut' required de l'input
 * @param null|string $default l'attribut' value de l'input
 * @return string Le html correspondant
 */
function input($name, $label, $type = 'text', $required = true, $default = null): string {
    $defaultValue = $_POST[$name] ?? $default ?? '';

    $isRequired = $required ? 'required' : '';

    $html = '<div class="form-group">';
    $html .= '<label for="'. $name .'" class="">'. $label .'</label>';
    
    if($type === 'textarea') {
        $html .= '<textarea class="form-control" id="'. $name .'" name="'. $name .'" '. $isRequired .'>'. $defaultValue .'</textarea>';
    } else {
        $html .= '<input class="form-control" id="'. $name .'" name="'. $name .'" type="'. $type .'" '. $isRequired .' value="'. $defaultValue .'" />';
    }
    
    $html .= '</div>';

    return $html;
}

/**
 * Envoie d'un message flash
 * 
 * @param string $message
 * @param string $type
 */
function flash($message, $type = 'success') {
    $flash = [
        'message' => $message,
        'type' => $type
    ];

    $_SESSION['flash'] = $flash;
}

/**
 * Lecture d'un message flash
 * 
 * @return string $html le code du message
 */
function read_flash_message() {
    $flash = $_SESSION['flash'] ?? null;

    if($flash) {
        unset($_SESSION['flash']);

        $html = '<div class="alert alert-'. $flash['type'] .'">'. $flash['message'] .'</div>';

        return $html;
    }

    return '';
}