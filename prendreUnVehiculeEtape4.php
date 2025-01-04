<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css">
<?php
    include_once "parametres.php";
?>
<title>Confirmation de réservation</title>
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
    <h1>Confirmation de réservation</h1>
    <?php
    // pour un vélo :
    //prendreUnVehiculeEtape4.php?idPersonne=2&idVehicule=3&dateDepart=2023-10-16&heureDepart=12:25&lieuDepart=Roanne&natureMission=Visite stagiaire&destination=Lyon

    // pour une voiture :
    //prendreUnVehiculeEtape4.php?idPersonne=2&idVehicule=2&dateDepart=2023-10-16&heureDepart=12:25&lieuDepart=Roanne&natureMission=Visite stagiaire&destination=Lyon&kilometrageDeDepart=145254&nomAccompagnant1=&prenomAccompagnant1=&nomAccompagnant2=&prenomAccompagnant2=&nomAccompagnant3=&prenomAccompagnant3=

    // on doit enregistrer dans la table trajet (et dans la table accompagnants s'il y a des accompagnants) les informations recues

    // on verifie que les variables idPersonne, idVehicule, dateDepart, heureDepart, natureDeLaMission et lieuDeDepart existent et que ce sont des nombres entiers pour certains
    if (isset($_GET['idPersonne']) && ctype_digit($_GET['idPersonne']) && isset($_GET['idVehicule']) && ctype_digit($_GET['idVehicule']) && isset($_GET['dateDepart']) && isset($_GET['heureDepart']) && isset($_GET['natureMission']) && isset($_GET['lieuDepart']) && isset($_GET['destination'])) {
        // les variables existent et ce sont des nombres pour certains

        try {
            // Vérifier si le véhicule est déjà réservé
            $requeteVerif = "SELECT COUNT(*) FROM trajet WHERE idVehicule = :idVehicule AND dateArrivee IS NULL";
            $reponseVerif = $connexionALaBdD->prepare($requeteVerif);
            $reponseVerif->bindParam(':idVehicule', $_GET['idVehicule']);
            $reponseVerif->execute();
            $vehiculeReserve = $reponseVerif->fetchColumn();

            if ($vehiculeReserve > 0) {
                echo 'Ce véhicule est déjà réservé.<br/><br/>';
                echo '<a href="gestionVehicule.htm" class="button">Retour à la gestion des véhicules</a>';
            } else {
                if (isset($_GET['kilometrageDepart']) && ctype_digit($_GET['kilometrageDepart'])) {
                    //echo "<br/>si la variable kilometrageDepart existe, c'est que c'est une voiture !!!<br/>";
                    $requete = "INSERT INTO trajet (nature, dateDepart, heureDepart, lieuDepart, destination, kilometrageDepart, idPersonne, idVehicule) VALUES (:nature, :dateDepart, :heureDepart, :lieuDepart, :destination, :kilometrageDepart, :idPersonne, :idVehicule)";
                    $reponse = $connexionALaBdD->prepare($requete);
                    //echo "kilometrage depart : " . $_GET['kilometrageDepart'] . "<br/>";
                    $reponse->bindParam(':kilometrageDepart', $_GET['kilometrageDepart']);
                } else {
                    //echo "<br/>ce n'est pas une voiture que l'utilisateur veut utiliser !!!<br/>";
                    $requete = "INSERT INTO trajet (nature, dateDepart, heureDepart, lieuDepart, destination, idPersonne, idVehicule) VALUES (:nature, :dateDepart, :heureDepart, :lieuDepart, :destination, :idPersonne, :idVehicule)";
                    $reponse = $connexionALaBdD->prepare($requete);
                }

                // $reponse est un objet de type PDOStatement
                //echo "nature mission : " . $_GET['natureMission'] . "<br/>";
                $reponse->bindParam(':nature', $_GET['natureMission']);
                //echo "date depart : " . $_GET['dateDepart'] . "<br/>";
                $reponse->bindParam(':dateDepart', $_GET['dateDepart']);
                //echo "heure depart : " . $_GET['heureDepart'] . "<br/>";
                $reponse->bindParam(':heureDepart', $_GET['heureDepart']);
                //echo "lieuDepart : " . $_GET['lieuDepart'] . "<br/>";
                $reponse->bindParam(':lieuDepart', $_GET['lieuDepart']);
                //echo "destination : " . $_GET['destination'] . "<br/>";
                $reponse->bindParam(':destination', $_GET['destination']);
                //echo "idPersonne : " . $_GET['idPersonne'] . "<br/>";
                $reponse->bindParam(':idPersonne', $_GET['idPersonne']);
                //echo "idVehicule : " . $_GET['idVehicule'] . "<br/>";
                $reponse->bindParam(':idVehicule', $_GET['idVehicule']);

                $reponse->execute();

                // on termine le traitement de la requete
                $reponse->closeCursor();

                // Récupérer l'email de la personne
                $requeteEmail = "SELECT mail FROM personne WHERE idPersonne = :idPersonne";
                $reponseEmail = $connexionALaBdD->prepare($requeteEmail);
                $reponseEmail->bindParam(':idPersonne', $_GET['idPersonne']);
                $reponseEmail->execute();
                $email = $reponseEmail->fetchColumn();

                // Envoyer un email de confirmation
                $to = $email;
                $subject = "Confirmation de réservation de véhicule";
                $message = "Bonjour,\n\nVotre réservation a été enregistrée avec succès.\n\nDétails de la réservation :\n";
                $message .= "Nature de la mission : " . $_GET['natureMission'] . "\n";
                $message .= "Date de départ : " . $_GET['dateDepart'] . "\n";
                $message .= "Heure de départ : " . $_GET['heureDepart'] . "\n";
                $message .= "Lieu de départ : " . $_GET['lieuDepart'] . "\n";
                $message .= "Destination : " . $_GET['destination'] . "\n";
                if (isset($_GET['kilometrageDepart'])) {
                    $message .= "Kilométrage de départ : " . $_GET['kilometrageDepart'] . "\n";
                }
                $headers = "From: noreply@leize.fr";

                mail($to, $subject, $message, $headers);

                // Message de confirmation
                echo 'Réservation enregistrée avec succès ! Un email de confirmation a été envoyé.<br/><br/>';
                echo '<a href="gestionVehicule.htm" class="button">Retour à la gestion des véhicules</a>';

                $traitement = true;
            }
        } catch (Exception $e) {
            // $e est un objet de type PDOException
            die('Erreur : ' . $e->getMessage());
        }
    } else {
        echo 'La page n\'a pas reçu les paramètres demandés !';
    }
    ?>
</div>
</body>
</html>
