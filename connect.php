<?php
   session_start();
   //echo "Tentative de connexion à la base de données...<br>"; // Message de débogage

   try {
       $db = new PDO('mysql:host=localhost;dbname=chatplace', "root", "root", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
       //echo "Connexion réussie à la base de données.<br>"; // Message de débogage
   } catch(PDOException $e) {
       $db = NULL;
       echo ("Erreur: " . $e->getMessage());
   }
?>