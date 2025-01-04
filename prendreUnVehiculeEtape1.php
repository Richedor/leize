<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css">
<?php
    include_once "parametres.php";
?>
<title>Prendre un vehicule - Etape 1</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .content {
        margin-top: 60px;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 60px auto;
    }

    h1 {
        text-align: center;
        color: #88421d;
    }

    p {
        text-align: center;
        color: #333;
    }

    .monContainer {
        margin: 10px;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 5px;
        border: 1px solid #FECF67;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .monContainer:hover {
        background-color: #FECF67;
    }

    .maTabulation {
        margin: 5px;
    }

    .maTabulation a {
        color: #88421d;
        text-decoration: none;
    }

    .maTabulation a:hover {
        color: #FECF67;
    }

    a.button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: #88421d;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    a.button:hover {
        background-color: #FECF67;
        color: #88421d;
    }
</style>
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
    <div class="monContainer" onclick="location.href='prendreUnVehiculeEtape2.php?idPersonne=<?php echo $donnees['idPersonne']; ?>'">
        <div class="maTabulation">
            <strong><?php echo $donnees['civilite']; ?></strong>
            <strong><?php echo $donnees['nom']; ?></strong>
            <?php echo $donnees['prenom']; ?><br/>
        </div>
    </div>
    <?php
        }
        
        // on termine le traitement de la requete
        $reponse->closeCursor();
    ?>

    </br></br><a href="gestionVehicule.htm" class="button">Précédent</a>
</div>

</body>
</html>
