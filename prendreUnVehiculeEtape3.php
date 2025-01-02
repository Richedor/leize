<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="style.css">
  <?php
        include_once "parametres.php";
    ?>
  <title>Prendre un vehicule - Etape 3</title>
  </head>
  
  <body>
      <?php include 'menu.php'; ?>
      <div class="content">
      <?php
	// on verifie que la variable idPersonne et que la variable idVehicule existent et que ce sont des nombres entiers
   if (isset($_GET['idPersonne']) && ctype_digit($_GET['idPersonne']) && isset($_GET['idVehicule']) && ctype_digit($_GET['idVehicule']))
  	{
      // la variable idPersonne et la variable idVehicule existent et ce sont des nombres
      //echo "la variable idPersonne et la variable idVehicule existent,";
      //echo " elles sont egalent a : " . $_GET['idPersonne'] . $_GET['idVehicule'] . "<br/>";
      
      $idPersonne = $_GET['idPersonne'];
      $idVehicule = $_GET['idVehicule'];
      
      $requete = 'SELECT prenom FROM personne WHERE idPersonne=?';
      
      // $reponse est un objet de type PDOStatement
      $reponse = $connexionALaBdD->prepare($requete);
      $reponse->execute(array($_GET['idPersonne']));
      
      // $donnees est un objet de type PDOStatement
      // On affiche chaque entree une a une
      while ( $donnees = $reponse->fetch() )
      {
?>
          <strong> <?php echo  $donnees['prenom'] ." ,"; ?></strong>
      
<?php
      }
      
      $requete = 'SELECT idVehicule, marque, immatriculation, type FROM vehicule WHERE idVehicule=?';
      
      // $reponse est un objet de type PDOStatement
      $reponse = $connexionALaBdD->prepare($requete);
      $reponse->execute(array($_GET['idVehicule']));
      
      // $donnees est un objet de type PDOStatement
      // On affiche chaque entree une a une
      while ( $donnees = $reponse->fetch() )
      {
          $typeVehicule = $donnees['type'];
          if ($donnees['type'] == "Velo")
          {
              // la personne souhaite prendre un velo
              // on va afficher : vous souhaitez prendre le velo
              echo "vous souhaitez prendre le velo " . $donnees['marque'] . "<br/>";
              
          }
          else if ($donnees['type'] == "Velo Electrique")
          {
              // la personne souhaite prendre un velo electrique
              // on va afficher : vous souhaitez prendre le velo electrique 
              echo "vous souhaitez prendre le velo electrique<br/>";
          }
          else
          {
              // la personne souhaite prendre une voiture
              // on va afficher : vous souhaitez prendre le marque type immatricule immatriculation
              echo "vous souhaitez prendre le " . $donnees['marque'] . " " . $donnees['type'] . " immatricule " . $donnees['immatriculation'] . "<br/>";
          }
?>
      
<?php
      }
?>
<br/>
<br/>
<p>
    Merci de completer les elements ci-dessous afin de finaliser votre demande :
</p>
<br/>
<br/>

  <form id="idFormulaire" name="enregistrerDonnees" method="post" onsubmit="return validerSaisie('prendreUnVehiculeEtape4.php')" action="">
  	<label for="dateDepart">Date de depart : </label>
  	<input type="date" name="dateDepart" id="dateDepart" required pattern="\d{4}-\d{2}-\d{2}" value="2023-10-16" />
  	<br/><br/>
	<label for="heureDepart">Heure de depart : </label>
  	<input type="time" name="heureDepart" id="heureDepart" required value="12:25" />
  	<br/><br/>
	<label for="natureDeLaMission">Nature de la mission : </label>
  	<input type="text" name="natureDeLaMission" id="natureDeLaMission" required value="Visite stagiaire" />
  	<br/><br/>
	<?php
  	    if (!($typeVehicule == "Velo" || $typeVehicule == "Velo Electrique"))
          {
              // la personne veut utiliser une voiture
              // on affiche les champs permettant de saisir les acompagnants
              echo "<label for=\"nomAccompagnant\">NOM et prenom des accompagnants : </label><br/>";
              echo "<input type=\"text\" name=\"nomAccompagnant1\" id=\"nomAccompagnant1\" placeholder=\"Facultatif\" />";
              echo "<input type=\"text\" name=\"prenomAccompagnant1\" id=\"prenomAccompagnant1\" placeholder=\"Facultatif\" /><br/>";
              echo "<input type=\"text\" name=\"nomAccompagnant2\" id=\"nomAccompagnant2\" placeholder=\"Facultatif\" />";
              echo "<input type=\"text\" name=\"prenomAccompagnant2\" id=\"prenomAccompagnant2\" placeholder=\"Facultatif\" /><br/>";
              echo "<input type=\"text\" name=\"nomAccompagnant3\" id=\"nomAccompagnant3\" placeholder=\"Facultatif\" />";
              echo "<input type=\"text\" name=\"prenomAccompagnant3\" id=\"prenomAccompagnant3\" placeholder=\"Facultatif\" />";
              echo "<br/><br/>";
          }
  	?>
  	
	<label for="lieuDeDepart">Lieu de depart : </label>
  	<input type="text" name="lieuDeDepart" id="lieuDeDepart" required value="Roanne" />
  	<br/><br/>
	<label for="destination">Destination : </label>
  	<input type="text" name="destination" id="destination" required value="Lyon" />
  	<br/><br/>
  	<?php
  	    if (!($typeVehicule == "Velo" || $typeVehicule == "Velo Electrique"))
          {
              // la personne veut utiliser une voiture
              // on affiche le champ permettant de saisir le kilometrage de depart
              echo "<label for=\"kilometrageDeDepart\">Kilometrage de depart : </label>";
              echo "<input type=\"text\" name=\"kilometrageDeDepart\" id=\"kilometrageDeDepart\" required />";
              echo "<br/><br/>";
          }
  	?>
	
	<button type="submit" name="envoyer">Enregistrer</button>
  </form>
  <br/><br/>
  <a href="prendreUnVehiculeEtape2.php?idPersonne=<?php echo $idPersonne; ?>">precedent</a>

<?php
      
      // on termine le traitement de la requete
      $reponse->closeCursor();
	            
	}
  	else
	{
		echo 'la page n\'a pas recu les parametres demandes !';
	}
?>
  </div>
  </body>
  
  <script type="text/javascript">
  function validerSaisie(url)
  {
      var dateDepart = document.forms["enregistrerDonnees"]["dateDepart"];
      var heureDepart = document.forms["enregistrerDonnees"]["heureDepart"];
      var natureDeLaMission = document.forms["enregistrerDonnees"]["natureDeLaMission"];
      var lieuDeDepart = document.forms["enregistrerDonnees"]["lieuDeDepart"];
      var destination = document.forms["enregistrerDonnees"]["destination"];
      var strAnneeDepart = dateDepart.value.slice(0,4);
      var strMoisDepart = dateDepart.value.slice(5,7);
      var strJourDepart = dateDepart.value.slice(8,10);
      var texte;
      
      
      url = url + "?idPersonne=<?php echo $idPersonne; ?>" + "&idVehicule=<?php echo $idVehicule; ?>";
      url = url + "&dateDepart=" + dateDepart.value + "&heureDepart=" + heureDepart.value;
      
      // on vérifie que l'utilisateur n'a pas saisi que des espaces pour le lieu de départ
      lieuDeDepart.value = lieuDeDepart.value.trim();
      if (lieuDeDepart.value == "")
      {
          alert("Merci de saisir un lieu de départ");
          document.forms["enregistrerDonnees"]["lieuDepart"].focus()
          return false;
      }
      else
      {
          url = url + "&lieuDepart=" + lieuDeDepart.value;
      }
      
      // on vérifie que l'utilisateur n'a pas saisi que des espaces pour la destination
      destination.value = destination.value.trim();
      if (destination.value == "")
      {
          alert("Merci de saisir une destination");
          document.forms["enregistrerDonnees"]["destination"].focus()
          return false;
      }
      else
      {
          url = url + "&destination=" + destination.value;
      }
      
      // on vérifie que l'utilisateur n'a pas saisi que des espaces pour la nature de la mission
      natureDeLaMission.value = natureDeLaMission.value.trim();
      if (natureDeLaMission.value == "")
      {
          alert("Merci de saisir la nature de la mission (visite stagiaire, réunion,...)");
          document.forms["enregistrerDonnees"]["natureDeLaMission"].focus()
          return false;
      }
      else
      {
          url = url + "&natureMission=" + natureDeLaMission.value;
      }
      
      
      if (document.getElementById("kilometrageDeDepart") != null)
      {
        if (isNaN(document.getElementById("kilometrageDeDepart").value))
        {
            alert("Entrez uniquement une valeur numerique pour le kilometrage de depart");
            document.forms["enregistrerDonnees"]["kilometrageDeDepart"].focus()
            return false;
        }
        else
        {
            url = url + "&kilometrageDeDepart=" + document.forms["enregistrerDonnees"]["kilometrageDeDepart"].value;
        }
          
      }
      
      if (document.getElementById("nomAccompagnant1") != null)
      {
          url = url + "&nomAccompagnant1=" + document.forms["enregistrerDonnees"]["nomAccompagnant1"].value;
      }
      if (document.getElementById("prenomAccompagnant1") != null)
      {
          url = url + "&prenomAccompagnant1=" + document.forms["enregistrerDonnees"]["prenomAccompagnant1"].value;
      }
      if (document.getElementById("nomAccompagnant2") != null)
      {
          url = url + "&nomAccompagnant2=" + document.forms["enregistrerDonnees"]["nomAccompagnant2"].value;
      }
      if (document.getElementById("prenomAccompagnant2") != null)
      {
          url = url + "&prenomAccompagnant2=" + document.forms["enregistrerDonnees"]["prenomAccompagnant2"].value;
      }
      if (document.getElementById("nomAccompagnant3") != null)
      {
          url = url + "&nomAccompagnant3=" + document.forms["enregistrerDonnees"]["nomAccompagnant3"].value;
      }
      if (document.getElementById("prenomAccompagnant3") != null)
      {
          url = url + "&prenomAccompagnant3=" + document.forms["enregistrerDonnees"]["prenomAccompagnant3"].value;
      }
      
      document.forms["enregistrerDonnees"].action = url;
      
      texte = "Merci de verifier votre saisie avant envoi : \n"
          + "date de la mission : " + strJourDepart + "/" + strMoisDepart + "/" + strAnneeDepart + "\n"
          + "heure de debut de la mission : " + heureDepart.value + "\n"
          + "nature de la mission : " + natureDeLaMission.value + "\n"
          + "Lieu de depart : " + lieuDeDepart.value + "\n"
          + "Destination : " + destination.value + "\n";
      
      // si le champ kilometrage de depart est dans le formulaire
      if (document.getElementById("kilometrageDeDepart") != null)
      {
          texte = texte + "Kilometrage du vehicule : " + document.forms["enregistrerDonnees"]["kilometrageDeDepart"].value + "\n";
                
      }
      
      if (document.getElementById("nomAccompagnant1")!=null && document.forms["enregistrerDonnees"]["nomAccompagnant1"].value!="")
      {
          texte = texte + "Nom accompagnant 1 : " + document.forms["enregistrerDonnees"]["nomAccompagnant1"].value + "\n";
                
      }
      if (document.getElementById("prenomAccompagnant1") != null && document.forms["enregistrerDonnees"]["prenomAccompagnant1"].value!="")
      {
          texte = texte + "Prenom accompagnant 1 : " + document.forms["enregistrerDonnees"]["prenomAccompagnant1"].value + "\n";
                
      }
      
      if (document.getElementById("nomAccompagnant2") != null && document.forms["enregistrerDonnees"]["nomAccompagnant2"].value!="")
      {
          texte = texte + "Nom accompagnant 2 : " + document.forms["enregistrerDonnees"]["nomAccompagnant2"].value + "\n";
                
      }
      if (document.getElementById("prenomAccompagnant2") != null && document.forms["enregistrerDonnees"]["prenomAccompagnant2"].value!="")
      {
          texte = texte + "Prenom accompagnant 2 : " + document.forms["enregistrerDonnees"]["prenomAccompagnant2"].value + "\n";
                
      }
      
      if (document.getElementById("nomAccompagnant3") != null && document.forms["enregistrerDonnees"]["nomAccompagnant3"].value!="")
      {
          texte = texte + "Nom accompagnant 3 : " + document.forms["enregistrerDonnees"]["nomAccompagnant3"].value + "\n";
                
      }
      if (document.getElementById("prenomAccompagnant3") != null && document.forms["enregistrerDonnees"]["prenomAccompagnant3"].value!="")
      {
          texte = texte + "Prenom accompagnant 3 : " + document.forms["enregistrerDonnees"]["prenomAccompagnant3"].value + "\n";
                
      }
      
      if(confirm(texte))
        document.forms["enregistrerDonnees"].submit();
      else
        return false;
      
  }
</script>

</html>
