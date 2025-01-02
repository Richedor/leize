<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Rendre un véhicule</title>
</head>
<body>
    Bonjour, vous souhaitez rendre un véhicule.</br>
    Merci de sélectionner la personne qui souhaite rendre un véhicule :</br></br>

    <?php
    // Connexion à la base de données
    include_once 'parametres.php';

    // Requête pour obtenir les personnes ayant pris un véhicule
    $reponse = $connexionALaBdD->query('SELECT idPersonne, civilite, nom, prenom FROM personne WHERE idPersonne IN (SELECT idPersonne FROM trajet WHERE dateArrivee IS NULL)');

    while ($donnees = $reponse->fetch()) {
        echo '<div class="monContainer">';
        echo '<div class="maTabulation">';
        echo '<strong><a href="selectionVehiculeRetour.php?idPersonne=' . $donnees['idPersonne'] . '">' . $donnees['civilite'] . ' ' . $donnees['nom'] . ' ' . $donnees['prenom'] . '</a></strong><br/>';
        echo '</div>';
        echo '</div>';
    }

    $reponse->closeCursor();
    ?>
    </br></br><a href="gestionVehicule.htm">Précédent</a>
</body>
</html>

