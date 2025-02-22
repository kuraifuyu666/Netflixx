<?php
ob_start();
session_start();
include('config.php'); // Connexion à la base de données
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclusion du fichier CSS -->
</head>
<body>
    <!-- Logo -->
    <img src="netflixx.png" alt="Image marketing" class="hero-img">

    <?php include('menu.php'); // Inclusion du menu ?>
    <br>

    <h2>Les 5 derniers films ajoutés :</h2>
    
    <!-- Conteneur pour afficher les films en grille -->
    <div class="film-horizontal">
        <?php
        // Utilisation de PDO pour exécuter la requête
        $query = "SELECT * FROM film ORDER BY id DESC LIMIT 5";
        $stmt = $connection->prepare($query);  // Utilisation de $connection (PDO) pour préparer la requête
        $stmt->execute();
        
        // Affichage des résultats
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="film-item">';
            echo '<a href="film_details.php?id=' . $row['id'] . '">';
            echo '<img src="' . $row['urlphoto'] . '" alt="' . $row['title'] . '" class="film-img">';
            echo '<h3>' . strtoupper($row['title']) . '</h3>';
            echo '</a>';
            echo '</div>';
        }
        ?>
    </div>
</body>
<footer>
    <p>&copy; 2025 NETFLIXX. Tous droits réservés.</p>
    <p><a href="https://youtu.be/o-YBDTqX_ZU?si=1YFnqo9j9NWdPuXF"> 1 MOIS GRATUIT*</a></p>
    <P>* Valable pour toute nouvelle inscription, puis 5,99 € /mois </P>
</footer>
</html>