<?php
$DB_NAME = "chatplace";
$DB_USER = "root";
$DB_PASS = "root";

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=' . $DB_NAME, $DB_USER, $DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


if (isset($_GET['query']) && !empty($_GET['query'])) {
    // Non sécurisé, permet l'injection SQL: "; UPDATE table_test SET nom_attribut='Att000';' -- 
    // $req = $bdd->query('UPDATE table_test SET valeur_attribut="' . $_GET['query'] . '" WHERE nom_attribut="Attribut 1"');
    // $req->execute();
    // $req->closeCursor();

    // Requête préparée sécurisée, empêche l'injection SQL de s'exécuter
    $req = $bdd->prepare('UPDATE table_test SET valeur_attribut=:valeur_attribut WHERE nom_attribut="Att000"');
    $req->bindParam(':valeur_attribut', $_GET['query']);
    $req->execute();
    $req->closeCursor();
}

$req = $bdd->query('SELECT * FROM table_test;');
$data = $req->fetchAll(PDO::FETCH_ASSOC);
$req->closeCursor();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="sqlTest.php" method="get">
        <input type="text" name="query" id="">
        <input type="submit" value="Envoyer">
    </form>

    <table>
        <tr>
            <th>Nom attribut</th>
            <th>Valeur attribut</th>
        </tr>
        <?php foreach ($data as $value) { ?>
            <tr>
                <td><?= $value['nom_attribut'] ?></td>
                <td><?= $value['valeur_attribut'] ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>