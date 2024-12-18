<?php

include('connect.php');
include('utilisateur.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!$db) {
    die("Erreur de connexion à la base de données.");
}

if(!empty($_POST["form_connexion"])) {

    $select = $db->prepare("SELECT * FROM utilisateurs WHERE utilisateur_email=:utilisateur_email;");
    $select->bindParam(":utilisateur_email", $_POST["form_email"]);
    $select->execute();
    var_dump($select->rowCount()); 

    if($select->rowCount() === 1) {
        $user = $select->fetch(PDO::FETCH_ASSOC);
        if(password_verify($_POST["form_password"], $user['utilisateur_mdp'])) {
            // On affecte les données de notre utilisateur dans notre super globale $_SESSION
            $_SESSION['utilisateur'] = $user;
            // Mettre à jour la session dans la base de données
            
            if (!isset($_SESSION['session_id'])) { // Vérifie si l'identifiant de session n'est pas déjà défini
                $_SESSION['session_id'] = uniqid('session_', true);
                var_dump($_SESSION['session_id']);
            }
            $sessionId = $_SESSION['session_id'];
            $utilisateur = new Utilisateur($db);
            if ($utilisateur->updateSession($user['utilisateur_id'], $sessionId)) {
                $_SESSION['user_id'] = $user['utilisateur_id'];
                $_SESSION['last_activity'] = time();
                header("Location: home.php");
                exit();
            } else {
                die("Erreur lors de la mise à jour de la session.");
            }
	    }else {
            echo "Mot de passe incorrect.";
        }
    } else {   
        echo "Aucun compte trouvé pour cet utilisateur.<a href='index.php'>Retour à la connexion</a>";
       
    }
}