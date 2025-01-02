<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Rendre un véhicule</title>
</head>
<body>
    Zonjour, vous souhaitez rendre un véhicule.</br>
    Merci de sélectionner la personne qui souhaite rendre un véhicule :</br></br>

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

    $reponse->closeCursor();
    ?>
    </br></br><a href="gestionVehicule.htm">Précédent</a>
</body>
</html>