<?php
class Message{

    private $db;
    private $select;
    private $insert;	
    private $selectByIdSession;
    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare(
            "SELECT message_text, created_at FROM messages
         ");
        $this->insert = $db->prepare(
            "INSERT INTO messages (message_text, created_at, id_utilisateur)
             VALUES(:message_text, :created_at, :id_utilisateur)
        ");
       $this->selectByIdSession = $db->prepare(
            "SELECT message_text, created_at FROM messages 
            JOIN utilisateurs ON utilisateurs.utilisateur_id = messages.id_utilisateur
            WHERE utilisateurs.session_id = :utilisateurs.session_id
       ");
    }

    public function select(){
        $this->select->execute();

        if ($this->select->errorCode() != "00000") {
            print_r($this->select->errorInfo());
            return [];
        }

        return $this->select->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert($message, $time, $idUtilisateur){
        $result = true;
        $this->insert->execute([
            ":message_text"=> strtolower($message),
            ":created_at"=> $time,
            "id_utilisateur"=> $idUtilisateur
        ]);

        if ($this->insert->errorCode() != "00000") {
            print_r($this->insert->errorInfo());
            $result = false;
        }
    
        return $result;
    }
    public function selectByIdSession($message, $time){
        $this->selectByIdSession->execute([
            ":message_text"=> $message,
            ":created_at"=> $time
        ]);

        if ($this->selectByIdSession->errorCode() != "00000") {
            print_r($this->selectByIdSession->errorInfo());
            return null;
        }
        return $this->selectByIdSession->fetch(PDO::FETCH_ASSOC);
    }

}

include_once("connect.php");
include('chatroom.php');

function save(){
    if(!empty($_POST['message-input'])){
        $sendedMessage = htmlspecialchars($_POST['message-input'], ENT_QUOTES, 'UTF-8');
        $time = date('Y-m-d H:i:s');
        //regex
        //verify if msg alreadey saved ? how
    
         // Vérifiez si l'utilisateur est connecté et récupérez son ID
         if (isset($_SESSION['utilisateur_id'])) {
            $idUtilisateur = $_SESSION['utilisateur_id']; // Récupération de l'ID de l'utilisateur
        } else {
            die('<p> Vous devez être connecté pour envoyer un message.</p>');
        }
        error_log("Message reçu : " . $sendedMessage);
        error_log("Utilisateur ID : " . $idUtilisateur);
        include('_classes.php');
        if($saving = $message->insert($sendedMessage, $time, $idUtilisateur)) {
            $conn->send("Message enregistré avec succès.");
        }else{
            $conn->send("Erreur lors de l'enregistrement du message.");
        }
        if($saving) {
            die('<p> Ajout fait avec succès </p>');
        } else {
            die('<p> Une erreur est survenue lors de l\'enregistrement</p>');
        }
        
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    save();
}