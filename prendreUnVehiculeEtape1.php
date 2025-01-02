<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="style.css">
   <style>
        /* Ajout de l'image en background dans le body */
        body {
            background-image: url('image.jpg'); /* Remplacez 'image.jpg' par le chemin de votre image */
            background-size: cover; /* L'image couvre toute la page */
            background-position: center; /* L'image est centrée */
            background-repeat: no-repeat; /* L'image ne se répète pas */
            margin: 0; /* Enlève les marges par défaut */
            height: 100vh; /* Assure que la page couvre toute la hauteur de l'écran */
            font-family: Arial, sans-serif; /* Définir la police de la page */
        }

        h1, p {
            color: white; /* Texte en blanc pour qu'il soit visible sur le fond */
            text-align: center;
            padding: 20px;
        }
    </style>
  <?php
        include_once "parametres.php";
  ?>
  <title>Prendre un vehicule - Etape 1</title>
  </head>
  
  <body>
	Bonjour, vous souhaitez prendre un vehicule.</br>
	Merci de selectionner la personne qui souhaite utiliser le véhicule :</br></br>

	<?php
          $requete = 'SELECT idPersonne, civilite, nom, prenom FROM personne';
          
          // $reponse est un objet de type PDOStatement
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

	</br></br><a href="gestionVehicule.htm">precedent</a>

</body>
</html>

