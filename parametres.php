<?php
    //c'est la date d'aujourd'hui au format AAAA-MM-JJ, par exemple : 2013-10-02
    $dateMariaDb = date('Y-m-d');

    //c'est l'heure d'aujourd'hui au format HH:MM:SS, par exemple : 12:34:23
    $heureMariaDb = date('H:i:s');
    
    //$lieuDepart = "Roanne";

    // parametres pour se connecter a la base de donnees :
    $hoteBdD = 'localhost';$nomBdD = 'u653158109_user25';
    $port = '3306';
    $nomUtilisateur = 'u653158109_user25';
    $motDePasse = 'user25L3Spi';
    
    // on essaye de se connecter a la base de donnees
    try
    {
        // $connexionALaBdD est un objet de type PDO
        $connexionALaBdD = new PDO('mysql:host='.$hoteBdD.';port='.$port.';dbname='.$nomBdD.';charset=utf8',$nomUtilisateur,$motDePasse);
    }
    catch (Exception $e)
    {
        // $e est un objet de type PDOException
        die('Erreur : ' . $e->getMessage());
    }
    
    //echo "On est connecte a la base de donnees<br/>";
?>