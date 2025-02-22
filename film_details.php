<?php
include('config.php');  // Connexion à la base de données
session_start();

// Récupérer l'ID du film depuis l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête pour récupérer les détails du film
    $query = "SELECT * FROM film WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Récupérer les résultats
    $film = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour extraire l'ID de la vidéo YouTube
function getYouTubeID($url) {
    preg_match('/(?:https?:\/\/(?:www\.)?youtube\.com\/(?:watch\?v=|v\/|e\/|.*\?v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches);
    return $matches[1] ?? null;  // Si un ID est trouvé, le retourner, sinon null
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du film</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclusion du fichier CSS -->
    <link rel="stylesheet" href="film_details.css"> <!-- Inclusion du fichier CSS spécifique pour cette page -->
</head>
<body>
    <!-- Logo -->
    <img src="netflixx.png" alt="Image marketing" class="hero-img">
    <?php if ($film): ?>
        <?php include('menu.php'); ?>
        <br>
        <h1><?php echo strtoupper($film['title']); ?></h1>
        <br>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($film['description']); ?></p>
        <br>
        <img src="<?php echo $film['urlphoto']; ?>" alt="<?php echo $film['title']; ?>">

        <?php 
            $youtubeID = getYouTubeID($film['urlvideo']); 
            if ($youtubeID): 
        ?>
        <br>
            <p><strong>Vidéo:</strong></p>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $youtubeID; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <?php else: ?>
            <p>Vidéo non disponible.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Film non trouvé.</p>
    <?php endif; ?>
</body>
<footer>
    <p>&copy; 2025 NETFLIXX. Tous droits réservés.</p>
    <p><a href="https://youtu.be/o-YBDTqX_ZU?si=1YFnqo9j9NWdPuXF"> 1 MOIS GRATUIT*</a></p>
    <P>* Valable pour toute nouvelle inscription, puis 5,99 € /mois </P>
</footer>
</html>


