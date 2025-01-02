<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css">
<?php
    include_once "parametres.php";
?>
<title>Prendre un vehicule - Etape 1</title>
</head>

<body>
<?php include 'menu.php'; ?>

<div class="content">
    <h1>Prendre un véhicule - Etape 1</h1>
    <p>Bonjour, vous souhaitez prendre un véhicule.</br>
    Merci de sélectionner la personne qui souhaite utiliser le véhicule :</br></br></p>

    <?php
        $requete = 'SELECT idPersonne, civilite, nom, prenom FROM personne';
        $reponse = $connexionALaBdD->prepare($requete);
        $reponse->execute();
        
        // $donnees est un objet de type PDOStatement
        // On affiche chaque entree une a une
        while ( $donnees = $reponse->fetch() )
        {
    ?>
    <div class="monContainer">
        <div class="maTabulation">
            <strong><?php echo "<a href=\"prendreUnVehiculeEtape2.php?idPersonne=" . $donnees['idPersonne'] . "\">" . $donnees['civilite'] . "</a>"; ?></strong>
            <strong><?php echo "<a href=\"prendreUnVehiculeEtape2.php?idPersonne=" . $donnees['idPersonne'] . "\">" . $donnees['nom'] . "</a>"; ?></strong>
            <?php echo "<a href=\"prendreUnVehiculeEtape2.php?idPersonne=" . $donnees['idPersonne'] . "\">" . $donnees['prenom'] . "</a>"; ?><br/>
        </div>
    </div>
    <?php
        }
        
        // on termine le traitement de la requete
        $reponse->closeCursor();
    ?>
</div>

</br></br><a href="gestionVehicule.htm">Précédent</a>

</body>
</html>
