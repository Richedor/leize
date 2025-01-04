<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="style.css">
    <?php include_once "parametres.php"; ?>
    <title>Prendre un vehicule - Etape 3</title>
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

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form input[type="text"], form textarea, form input[type="date"], form input[type="time"] {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form input[type="submit"], form button[type="submit"] {
            padding: 10px 20px;
            background-color: #88421d;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover, form button[type="submit"]:hover {
            background-color: #FECF67;
            color: #88421d;
        }
    </style>
</head>
  
<body>
    <?php include 'menu.php'; ?>
    <div class="content">
        <div class="centered-container">
            <?php
                // on verifie que la variable idPersonne et que la variable idVehicule existent et que ce sont des nombres entiers
                if (isset($_GET['idPersonne']) && ctype_digit($_GET['idPersonne']) && isset($_GET['idVehicule']) && ctype_digit($_GET['idVehicule'])) {
                    $idPersonne = $_GET['idPersonne'];
                    $idVehicule = $_GET['idVehicule'];
                    
                    $requete = 'SELECT prenom FROM personne WHERE idPersonne=?';
                    $reponse = $connexionALaBdD->prepare($requete);
                    $reponse->execute(array($_GET['idPersonne']));
                    $donnees = $reponse->fetch();
                    $prenom = $donnees['prenom'];
                    
                    $requete = 'SELECT idVehicule, marque, immatriculation, type FROM vehicule WHERE idVehicule=?';
                    $reponse = $connexionALaBdD->prepare($requete);
                    $reponse->execute(array($_GET['idVehicule']));
                    $donnees = $reponse->fetch();
                    $marque = $donnees['marque'];
                    $type = $donnees['type'];
                    $immatriculation = $donnees['immatriculation'];
                    
                    echo "<p>$prenom, vous souhaitez prendre le $marque $type immatriculé $immatriculation</p>";
                    echo "<p>Merci de compléter les éléments ci-dessous afin de finaliser votre demande :</p>";
            ?>
            <form name="enregistrerDonnees" method="post" onsubmit="return validerFormulaire()">
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
                    if (!($type == "Velo" || $type == "Velo Electrique")) {
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
                    if (!($type == "Velo" || $type == "Velo Electrique")) {
                        echo "<label for=\"kilometrageDeDepart\">Kilometrage de depart : </label>";
                        echo "<input type=\"text\" name=\"kilometrageDeDepart\" id=\"kilometrageDeDepart\" required />";
                        echo "<br/><br/>";
                    }
                ?>
                <button type="submit" name="envoyer">Enregistrer</button>
            </form>
            <br/><br/><a href="prendreUnVehiculeEtape2.php" class="button">Précédent</a>
            <?php
                }
            ?>
        </div>
    </div>
    
    <script>
        function validerFormulaire() {
            var dateDepart = document.forms["enregistrerDonnees"]["dateDepart"];
            var heureDepart = document.forms["enregistrerDonnees"]["heureDepart"];
            var natureDeLaMission = document.forms["enregistrerDonnees"]["natureDeLaMission"];
            var lieuDeDepart = document.forms["enregistrerDonnees"]["lieuDeDepart"];
            var destination = document.forms["enregistrerDonnees"]["destination"];
            var strAnneeDepart = dateDepart.value.slice(0,4);
            var strMoisDepart = dateDepart.value.slice(5,7);
            var strJourDepart = dateDepart.value.slice(8,10);
            var texte;
            
            var url = "prendreUnVehiculeEtape4.php?idPersonne=<?php echo $idPersonne; ?>&idVehicule=<?php echo $idVehicule; ?>";
            url += "&dateDepart=" + dateDepart.value + "&heureDepart=" + heureDepart.value;
            
            lieuDeDepart.value = lieuDeDepart.value.trim();
            if (lieuDeDepart.value == "") {
                alert("Merci de saisir un lieu de départ");
                document.forms["enregistrerDonnees"]["lieuDeDepart"].focus();
                return false;
            } else {
                url += "&lieuDepart=" + lieuDeDepart.value;
            }
            
            destination.value = destination.value.trim();
            if (destination.value == "") {
                alert("Merci de saisir une destination");
                document.forms["enregistrerDonnees"]["destination"].focus();
                return false;
            } else {
                url += "&destination=" + destination.value;
            }
            
            natureDeLaMission.value = natureDeLaMission.value.trim();
            if (natureDeLaMission.value == "") {
                alert("Merci de saisir la nature de la mission (visite stagiaire, réunion,...)");
                document.forms["enregistrerDonnees"]["natureDeLaMission"].focus();
                return false;
            } else {
                url += "&natureMission=" + natureDeLaMission.value;
            }
            
            if (document.getElementById("kilometrageDeDepart") != null) {
                if (isNaN(document.getElementById("kilometrageDeDepart").value)) {
                    alert("Entrez uniquement une valeur numerique pour le kilometrage de depart");
                    document.forms["enregistrerDonnees"]["kilometrageDeDepart"].focus();
                    return false;
                } else {
                    url += "&kilometrageDeDepart=" + document.forms["enregistrerDonnees"]["kilometrageDeDepart"].value;
                }
            }
            
            if (document.getElementById("nomAccompagnant1") != null) {
                url += "&nomAccompagnant1=" + document.forms["enregistrerDonnees"]["nomAccompagnant1"].value;
            }
            if (document.getElementById("prenomAccompagnant1") != null) {
                url += "&prenomAccompagnant1=" + document.forms["enregistrerDonnees"]["prenomAccompagnant1"].value;
            }
            if (document.getElementById("nomAccompagnant2") != null) {
                url += "&nomAccompagnant2=" + document.forms["enregistrerDonnees"]["nomAccompagnant2"].value;
            }
            if (document.getElementById("prenomAccompagnant2") != null) {
                url += "&prenomAccompagnant2=" + document.forms["enregistrerDonnees"]["prenomAccompagnant2"].value;
            }
            if (document.getElementById("nomAccompagnant3") != null) {
                url += "&nomAccompagnant3=" + document.forms["enregistrerDonnees"]["nomAccompagnant3"].value;
            }
            if (document.getElementById("prenomAccompagnant3") != null) {
                url += "&prenomAccompagnant3=" + document.forms["enregistrerDonnees"]["prenomAccompagnant3"].value;
            }
            
            document.forms["enregistrerDonnees"].action = url;
            
            texte = "Merci de verifier votre saisie avant envoi : \n"
                + "date de la mission : " + strJourDepart + "/" + strMoisDepart + "/" + strAnneeDepart + "\n"
                + "heure de debut de la mission : " + heureDepart.value + "\n"
                + "nature de la mission : " + natureDeLaMission.value + "\n"
                + "Lieu de depart : " + lieuDeDepart.value + "\n"
                + "Destination : " + destination.value + "\n";
            
            if (document.getElementById("kilometrageDeDepart") != null) {
                texte += "Kilometrage du vehicule : " + document.forms["enregistrerDonnees"]["kilometrageDeDepart"].value + "\n";
            }
            
            if (document.getElementById("nomAccompagnant1") != null && document.forms["enregistrerDonnees"]["nomAccompagnant1"].value != "") {
                texte += "Nom accompagnant 1 : " + document.forms["enregistrerDonnees"]["nomAccompagnant1"].value + "\n";
            }
            if (document.getElementById("prenomAccompagnant1") != null && document.forms["enregistrerDonnees"]["prenomAccompagnant1"].value != "") {
                texte += "Prenom accompagnant 1 : " + document.forms["enregistrerDonnees"]["prenomAccompagnant1"].value + "\n";
            }
            if (document.getElementById("nomAccompagnant2") != null && document.forms["enregistrerDonnees"]["nomAccompagnant2"].value != "") {
                texte += "Nom accompagnant 2 : " + document.forms["enregistrerDonnees"]["nomAccompagnant2"].value + "\n";
            }
            if (document.getElementById("prenomAccompagnant2") != null && document.forms["enregistrerDonnees"]["prenomAccompagnant2"].value != "") {
                texte += "Prenom accompagnant 2 : " + document.forms["enregistrerDonnees"]["prenomAccompagnant2"].value + "\n";
            }
            if (document.getElementById("nomAccompagnant3") != null && document.forms["enregistrerDonnees"]["nomAccompagnant3"].value != "") {
                texte += "Nom accompagnant 3 : " + document.forms["enregistrerDonnees"]["nomAccompagnant3"].value + "\n";
            }
            if (document.getElementById("prenomAccompagnant3") != null && document.forms["enregistrerDonnees"]["prenomAccompagnant3"].value != "") {
                texte += "Prenom accompagnant 3 : " + document.forms["enregistrerDonnees"]["prenomAccompagnant3"].value + "\n";
            }
            
            if (confirm(texte)) {
                document.forms["enregistrerDonnees"].submit();
            } else {
                return false;
            }
        }
    </script>
</body>
</html>
