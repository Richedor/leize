<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Rendre un véhicule</title>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="content">
        <h1>Rendre un véhicule</h1>
        <p>Bonjour, vous souhaitez rendre un véhicule.<br/>
        Merci de sélectionner la personne qui souhaite rendre un véhicule :</p>

        <?php
        // Connexion à la base de données
        include_once 'parametres.php';

        // Requête pour obtenir les personnes ayant pris un véhicule
        $reponse = $connexionALaBdD->query('SELECT idPersonne, civilite, nom, prenom FROM personne WHERE idPersonne IN (SELECT idPersonne FROM trajet WHERE dateArrivee IS NULL)');

        echo '<form method="GET" action="selectionVehiculeRetour.php">';
        echo '<select name="idPersonne" required>';
        echo '<option value="">Sélectionnez une personne</option>';

        while ($donnees = $reponse->fetch()) {
            echo '<option value="' . $donnees['idPersonne'] . '">' . $donnees['civilite'] . ' ' . $donnees['nom'] . ' ' . $donnees['prenom'] . '</option>';
        }

        echo '</select>';
        echo '<input type="submit" value="Sélectionner">';
        echo '</form>';
        ?>
    </div>
</body>
</html>