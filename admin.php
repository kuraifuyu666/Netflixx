<?php
ob_start();
session_start();
include('config.php'); // Connexion à la base de données

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');  // Redirige vers la page de connexion si non connecté
    exit;
}

// Déconnexion
if (isset($_POST['logout'])) {
    session_destroy();  // Détruit la session
    header('Location: index.php');  // Redirige vers la page de connexion
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $title = $_POST['title'];
    $description = $_POST['description'];
    $urlphoto = $_POST['urlphoto']; // On récupère maintenant l'URL de la photo
    $urlvideo = $_POST['urlvideo'];

    // Préparer la requête d'insertion avec PDO
    $query = "INSERT INTO film (title, description, urlphoto, urlvideo) VALUES (:title, :description, :urlphoto, :urlvideo)";
    $stmt = $connection->prepare($query);
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':urlphoto' => $urlphoto,
        ':urlvideo' => $urlvideo
    ]);

    // Rediriger vers la page d'accueil après l'ajout
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Admin</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclusion du fichier CSS -->
</head>
<body>
    <header>
        <h1>Ajouter un film</h1>
    </header>

    <div class="container">
        <form method="POST">
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" placeholder="Titre" required>

            <label for="description">Description :</label>
            <textarea name="description" id="description" placeholder="Description" required></textarea>

            <label for="urlphoto">URL de la photo :</label>
            <input type="text" name="urlphoto" id="urlphoto" placeholder="URL de la photo" required>

            <label for="urlvideo">URL de la vidéo YouTube :</label>
            <input type="text" name="urlvideo" id="urlvideo" placeholder="URL de la vidéo" required>

            <input type="submit" value="Ajouter le film">
        </form>

        <!-- Formulaire pour la déconnexion -->
        <form method="POST">
            <input type="submit" name="logout" value="Se déconnecter" />
        </form>
    </div>
</body>
</html>