<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?= uniqid()?>">
    <title>accueil</title>
</head>
<body>
    <?php
        include('nav.php');
        include('connexion.php');
        //fetch data from bdd
        $req = $db->query('SELECT *  FROM utilisateurs;');
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h1> HOME </h1>
    <table class="listUser">
            <tr>
                <th>Utilisateur</th>
                <th>Session</th>
                
            </tr>
            <?php foreach ($data as $row): ?>    
            <tr>
                <td><?= $row['utilisateur_prenom'] ?></td>
                <?php 
                $etat = !empty($row['session_id']) ? 'En ligne' : 'Hors ligne';?>
                <td><?= htmlspecialchars($etat) ?></td>  
            </tr>
            <?php endforeach; ?>
    </table>
</body>
</html>