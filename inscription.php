<?php
session_start();
include('config.php'); // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe pour plus de sécurité

    try {
        // Préparation de la requête d'insertion avec PDO
        $query = "INSERT INTO user (login, password) VALUES (:login, :password)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);

        // Exécution de la requête
        $stmt->execute();

        // Redirection vers la page de connexion
        header('Location: connexion.php');
        exit;
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Logo -->
    <img src="netflixx.png" alt="Image marketing" class="hero-img">
    
    <?php include('menu.php'); // Inclusion du menu ?>
    <form method="POST" action="inscription.php">
        <input type="text" name="login" placeholder="Login" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="submit" value="S'inscrire">
    </form>
</body>
<footer>
    <p>&copy; 2025 NETFLIXX. Tous droits réservés.</p>
    <p><a href="https://youtu.be/o-YBDTqX_ZU?si=1YFnqo9j9NWdPuXF"> 1 MOIS GRATUIT*</a></p>
    <P>* Valable pour toute nouvelle inscription, puis 5,99 € /mois </P>
</footer>
</html>