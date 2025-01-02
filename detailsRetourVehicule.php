<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'parametres.php';

$idVehicule = $_GET['idVehicule'];
$idPersonne = $_GET['idPersonne'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retour de Véhicule</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Retour de Véhicule</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kilometrageRetour = $_POST['kilometrageRetour'];
            $etatVehicule = $_POST['etatVehicule'];
            $dateArrivee = date('Y-m-d');
            $heureArrivee = date('H:i:s');

            // Mise à jour de la base de données
            $requete = $connexionALaBdD->prepare('UPDATE trajet SET dateArrivee = ?, heureArrivee = ?, kilometrageRetour = ?, etatVehicule = ? WHERE idVehicule = ? AND idPersonne = ? AND dateArrivee IS NULL');
            $requete->execute([$dateArrivee, $heureArrivee, $kilometrageRetour, $etatVehicule, $idVehicule, $idPersonne]);

            // Récupérer l'email de la personne
            $requeteEmail = "SELECT mail FROM personne WHERE idPersonne = :idPersonne";
            $reponseEmail = $connexionALaBdD->prepare($requeteEmail);
            $reponseEmail->bindParam(':idPersonne', $idPersonne);
            $reponseEmail->execute();
            $email = $reponseEmail->fetchColumn();

            // Envoyer un email de confirmation
            $to = $email;
            $subject = "Confirmation de retour de véhicule";
            $message = "Bonjour,\n\nVotre retour de véhicule a été enregistré avec succès.\n\nDétails du retour :\n";
            $message .= "Date de retour : " . $dateArrivee . "\n";
            $message .= "Heure de retour : " . $heureArrivee . "\n";
            $message .= "Kilométrage de retour : " . $kilometrageRetour . "\n";
            $message .= "État du véhicule : " . $etatVehicule . "\n";
            $headers = "From: noreply@leize.fr";

            if (mail($to, $subject, $message, $headers)) {
                echo '<div class="message success">Véhicule rendu avec succès ! Un email de confirmation a été envoyé.</div>';
            } else {
                echo '<div class="message error">Véhicule rendu avec succès ! Mais l\'email de confirmation n\'a pas pu être envoyé.</div>';
            }
            echo '<div class="link"><a href="gestionVehicule.htm">Retour à la gestion des véhicules</a></div>';
        } else {
            echo '<form method="POST">';
            echo '<label for="kilometrageRetour">Kilométrage retour:</label>';
            echo '<input type="text" id="kilometrageRetour" name="kilometrageRetour" required>';
            echo '<label for="etatVehicule">État du véhicule:</label>';
            echo '<textarea id="etatVehicule" name="etatVehicule" required></textarea>';
            echo '<input type="submit" value="Rendre le véhicule">';
            echo '</form>';
        }
        ?>
        <div class="link"><a href="selectionVehiculeRetour.php?idPersonne=<?php echo $idPersonne; ?>">Précédent</a></div>
    </div>
</body>
</html>