<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="style.css">
  <?php
        include_once "parametres.php";
    ?>
  <title>Prendre un vehicule - Etape 2</title>
  </head>
  
  <body>
<?php
	// on verifie que la variable idPersonne existe et que c'est un nombre entier
   if (isset($_GET['idPersonne']) && ctype_digit($_GET['idPersonne']))
  	{
      // la variable idPersonne existe et c'est un nombre
      //echo "la variable idPersonne existe, elle est egale a : " . $_GET['idPersonne'] . "<br/>";
      
      $idPersonne = $_GET['idPersonne'];
      
      $requete = 'SELECT prenom FROM personne WHERE idPersonne=?';
      
      // $reponse est un objet de type PDOStatement
      $reponse = $connexionALaBdD->prepare($requete);
      $reponse->execute(array($_GET['idPersonne']));
      
      // $donnees est un objet de type PDOStatement
      // On affiche chaque entree une a une
      while ( $donnees = $reponse->fetch() )
      {
?>
          Bonjour <strong> <?php echo  $donnees['prenom']; ?></strong>
      
<?php
      }
?>

, vous souhaitez prendre un vehicule.<br/>
	Merci de selectionner le vehicule que vous souhaitez utiliser :<br/><br/>


<div class="monContainer">
    
          <div class="maTabulation">
              <strong>Type :             Marque :             Immatriculation :</strong>
          </div>
</div>
<?php
          $requete = 'SELECT idVehicule, type, marque, immatriculation FROM vehicule';
          
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
              <strong><?php echo "<a href=\"prendreUnVehiculeEtape3.php?idPersonne=" . $idPersonne . "&idVehicule=" . $donnees['idVehicule'] . "\">" . $donnees['type'] . "</a>"; ?></strong>
              <strong><?php echo "<a href=\"prendreUnVehiculeEtape3.php?idPersonne=" . $idPersonne . "&idVehicule=" . $donnees['idVehicule'] . "\">" . $donnees['marque'] . "</a>"; ?></strong>
              <?php echo "<a href=\"prendreUnVehiculeEtape3.php?idPersonne=" . $idPersonne . "&idVehicule=" . $donnees['idVehicule'] . "\">" . $donnees['immatriculation'] . "</a>"; ?><br/>
          </div>
      </div>
      
<?php
      }
?>

	<br/><br/><a href="prendreUnVehiculeEtape1.php">precedent</a>

<?php
      
      // on termine le traitement de la requete
      $reponse->closeCursor();
	            
	}
  	else
	{
		echo 'la page n\'a pas recu les parametres demandes !';
	}
?>

</body>
</html>

