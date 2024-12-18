<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?= uniqid()?>">
    <title>Connexion</title>
</head>
<body>
    <div class="auth">
            <form action="connexion.php" method="POST" class="connexion">
                <h2 class="titleCo">Connexion</h2>
                <input type="hidden" name="form_connexion" value="1">
                <label for="form_email">Email:</label>
                <input type="text" name="form_email" id="form_email" placeholder="email@exemple.com" required>
            
                <label for="form_password">Mot de passe:</label>
                <input type="password" name="form_password" id="form_password" placeholder="1234" required>
                <input type="submit" value="Se connecter" id="button">
            </form>  
    </div>
</body>
</html>