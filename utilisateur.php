<?php
Class Utilisateur
{
    private $db;
    private $insert;
    private $select;
    private $selectByEmail;
    private $updateSession;

    public function __construct($db)
    {
        // Préparation des requêtes SQL
        $this->db = $db;
        $this->insert = $db->prepare(
            "INSERT INTO utilisateurs (utilisateur_nom, utilisateur_prenom, utilisateur_pseudo, utilisateur_email, utilisateur_mdp, id_role, session_id)
            VALUES (:utilisateur_nom, :utilisateur_prenom, :utilisateur_pseudo, :utilisateur_email, :utilisateur_mdp, :id_role, :session_id);"
        );

        $this->select = $db->prepare(
            "SELECT utilisateurs.*, roles.libelle_role 
            FROM utilisateurs 
            JOIN roles ON utilisateurs.id_role = roles.role_id;"
        );

        $this->selectByEmail = $db->prepare(
            "SELECT * 
            FROM utilisateurs 
            WHERE utilisateur_email = :utilisateur_email;"
        );

        $this->updateSession = $db->prepare(
            "UPDATE utilisateurs 
             SET session_id = :session_id 
             WHERE utilisateur_id = :utilisateur_id"
        );
    }

    /**
     * Insérer un nouvel utilisateur.
     */
    public function insert($nom, $prenom, $pseudo, $email, $mdp, $role = 2)
    {
        $result = true;

        $this->insert->execute([
            ":utilisateur_nom" => strtoupper($nom),
            ":utilisateur_prenom" => ucfirst(strtolower($prenom)),
            ":utilisateur_pseudo" => $pseudo,
            ":utilisateur_email" => strtolower($email),
            ":utilisateur_mdp" => $mdp,
            ":id_role" => $role 
        ]);

        if ($this->insert->errorCode() != "00000") {
            print_r($this->insert->errorInfo());
            $result = false;
        }

        return $result;
    }

    /**
     * Sélectionner tous les utilisateurs avec leurs rôles.
     */
    public function select()
    {
        $this->select->execute();
        
        if ($this->select->errorCode() != "00000") {
            print_r($this->select->errorInfo());
            return [];
        }

        return $this->select->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Sélectionner un utilisateur par email.
     */
    public function selectByEmail($email)
    {
        $this->selectByEmail->execute([
            ":utilisateur_email" => $email
        ]);

        if ($this->selectByEmail->errorCode() != "00000") {
            print_r($this->selectByEmail->errorInfo());
            return null;
        }

        return $this->selectByEmail->fetch(PDO::FETCH_ASSOC);
    }

    public function updateSession($userId, $sessionId){
        $this->updateSession->execute([
            ":session_id" => $sessionId,
            ":utilisateur_id" => $userId
        ]);

        if ($this->updateSession->errorCode() != "00000") {
            print_r($this->updateSession->errorInfo());
            return false;
        }

        return true;
    }

}
