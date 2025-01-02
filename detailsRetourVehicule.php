<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'parametres.php';

$idVehicule = $_GET['idVehicule'];
$idPersonne = $_GET['idPersonne'];

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
        echo 'Véhicule rendu avec succès ! Un email de confirmation a été envoyé.<br/><br/>';
    } else {
        echo 'Véhicule rendu avec succès ! Mais l\'email de confirmation n\'a pas pu être envoyé.<br/><br/>';
    }
    echo '<a href="gestionVehicule.htm">Retour à la gestion des véhicules</a>';
} else {
    echo '<form method="POST">';
    echo 'Kilométrage retour: <input type="text" name="kilometrageRetour" required><br/>';
    echo 'État du véhicule: <textarea name="etatVehicule" required></textarea><br/>';
    echo '<input type="submit" value="Rendre le véhicule">';
    echo '</form>';
}
?>
<br/><br/><a href="selectionVehiculeRetour.php?idPersonne=<?php echo $idPersonne; ?>">Précédent</a>