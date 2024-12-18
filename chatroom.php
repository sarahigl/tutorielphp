<?php /*
if(isset($_FILES['file'])){
    $extensions_ok= array('png','jpg');

     for($i=0; $i < sizeof($_FILES['file']['name']); $i++){
         // Cette ligne vient vérifier si l'extension du fichier importé est présente dans le tableau $extensions_ok
        if (!in_array(substr(strrchr($_FILES['file']['name'][$i], '.'), 1), $extensions_ok)) {
            echo '<span style="color: red;">Extension non autorisée</span>';
        }else if(filesize($_FILES['file']['tmp_name'][$i])>3145728){
            echo '<span style="color: red;">La taille du fichier dépasse les 3Mo ' . $i .'</span>';
        }else{
            // Cette ligne vient récupérer le nom originel du fichier
            $file_name = basename($_FILES['file']['name'][$i]);
            // replace les caractères accentués
            $accents = '/&([A-Za-z]{1,2})(grave|acute|circ|cedil|uml|lig);/';
            $string_encoded = htmlentities($file_name, ENT_NOQUOTES, 'UTF-8');
            $file_name = preg_replace($accents,'$1',$string_encoded);
            move_uploaded_file($_FILES['file']['tmp_name'][$i], "./imgs/" . $file_name);

        }  

     }
}

*/
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?= uniqid()?>">
    <title>importation de img et ajout websocket </title>
</head>
<body>
    <?php
        include('nav.php');
    ?>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <h2>importer une image</h2>
        <input type="text" name="nom">
        <input type="file" name="file[]" accept=".png, .jpg" multiple>
        <button type="submit">importer</button>
    </form>
    <div id="chat-container">
        <div id="chat-messages"></div>
        <form id="message-form">
            <input type="text" id="message-input" placeholder="Écrivez votre message..." required>
            <button type="submit">Envoyer</button>
        </form>
    </div>
    <script src="./script.js"></script>
</body>
</html>