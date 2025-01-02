<style>
    .navbar {
        background-color: #333;
        overflow: hidden;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .navbar ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
    }

    .navbar li {
        float: left;
    }

    .navbar li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 20px;
        text-decoration: none;
    }

    .navbar li a:hover {
        background-color: #ddd;
        color: black;
    }

    .content {
        margin-top: 60px;
    }
</style>

<nav class="navbar">
    <ul>
        <li><a href="gestionVehicule.htm">Accueil</a></li>
        <li><a href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a></li>
        <li><a href="selectionVehiculeRetour.php">Retour de véhicule</a></li>
    </ul>
</nav>