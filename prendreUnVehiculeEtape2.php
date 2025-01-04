<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="style.css">
  <?php include_once "parametres.php"; ?>
  <title>Prendre un vehicule - Etape 2</title>
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
        border: 1px solid #88421d;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .monContainer:hover {
        background-color: #FECF67;
    }

    .maTabulation {
        display: flex;
        justify-content: space-between;
        margin: 5px;
    }

    .maTabulation a {
        color: #88421d;
        text-decoration: none;
    }

    .maTabulation a:hover {
        color: #FECF67;
    }

    .column {
        flex: 1;
        text-align: center;
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
    <?php
      // on verifie que la variable idPersonne existe et que c'est un nombre entier
      if (isset($_GET['idPersonne']) && ctype_digit($_GET['idPersonne'])) {
          // la variable idPersonne existe et c'est un nombre
          //echo "la variable idPersonne existe, elle est egale a : " . $_GET['idPersonne'] . "<br/>";
          
          $idPersonne = $_GET['idPersonne'];
          
          $requete = 'SELECT prenom FROM personne WHERE idPersonne=?';
          
          // $reponse est un objet de type PDOStatement
          $reponse = $connexionALaBdD->prepare($requete);
          $reponse->execute(array($_GET['idPersonne']));
          
          // $donnees est un objet de type PDOStatement
          // On affiche chaque entree une a une
          while ( $donnees = $reponse->fetch() ) {
              echo "Bonjour <strong>" . $donnees['prenom'] . "</strong>";
          }
    ?>
    , vous souhaitez prendre un vehicule.<br/>
    Merci de selectionner le vehicule que vous souhaitez utiliser :<br/><br/>

    <div class="monContainer">
        <div class="maTabulation">
            <div class="column"><strong>Type</strong></div>
            <div class="column"><strong>Marque</strong></div>
            <div class="column"><strong>Immatriculation</strong></div>
        </div>
    </div>
    <?php
          $requete = 'SELECT idVehicule, type, marque, immatriculation FROM vehicule';
          
          // $reponse est un objet de type PDOStatement
          $reponse = $connexionALaBdD->prepare($requete);
          $reponse->execute();
          
          // $donnees est un objet de type PDOStatement
          // On affiche chaque entree une a une
          while ( $donnees = $reponse->fetch() ) {
    ?>
    <div class="monContainer" onclick="location.href='prendreUnVehiculeEtape3.php?idPersonne=<?php echo $idPersonne; ?>&idVehicule=<?php echo $donnees['idVehicule']; ?>'">
        <div class="maTabulation">
            <div class="column"><?php echo $donnees['type']; ?></div>
            <div class="column"><?php echo $donnees['marque']; ?></div>
            <div class="column"><?php echo $donnees['immatriculation']; ?></div>
        </div>
    </div>
    <?php
          }
    ?>
    <br/><br/><a href="prendreUnVehiculeEtape1.php" class="button">Précédent</a>
    <?php
          // on termine le traitement de la requete
          $reponse->closeCursor();
      } else {
          echo 'la page n\'a pas recu les parametres demandes !';
      }
    ?>
  </div>
</body>
</html>
