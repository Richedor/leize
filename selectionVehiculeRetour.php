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
        <p>Bonjour, vous souhaitez rendre un véhicule.<br>
        Merci de sélectionner le véhicule que vous souhaitez rendre :</p>

        <?php
        include_once 'parametres.php';

        $idPersonne = $_GET['idPersonne'];

        // Requête pour obtenir les véhicules pris par la personne et non encore retournés
        $reponse = $connexionALaBdD->prepare('SELECT idVehicule, immatriculation, marque, type FROM vehicule WHERE idVehicule IN (SELECT idVehicule FROM trajet WHERE idPersonne = ? AND dateArrivee IS NULL)');
        $reponse->execute([$idPersonne]);

        $vehiculesTrouves = false;
        while ($donnees = $reponse->fetch()) {
            $vehiculesTrouves = true;
            echo '<div class="monContainer">';
            echo '<div class="maTabulation">';
            echo '<strong><a href="detailsRetourVehicule.php?idVehicule=' . $donnees['idVehicule'] . '&idPersonne=' . $idPersonne . '">' . $donnees['marque'] . ' ' . $donnees['type'] . ' (' . $donnees['immatriculation'] . ')</a></strong><br/>';
            echo '</div>';
            echo '</div>';
        }

        if (!$vehiculesTrouves) {
            echo 'Cette personne n\'a pas de véhicule en sa possession.';
        }

        $reponse->closeCursor();
        ?>
        <br><br><a href="selectionPersonneRetour.php">Précédent</a>
    </div>
</body>
</html>