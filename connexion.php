<?php
session_start();
include('config.php'); // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Préparation de la requête pour vérifier les identifiants de connexion
    $query = "SELECT id, password FROM user WHERE login = :login";
    $stmt = $connection->prepare($query);
    $stmt->execute([':login' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe
    if ($user && password_verify($password, $user['password'])) {
        // Connexion réussie, stockage de l'ID utilisateur dans la session
        $_SESSION['user_id'] = $user['id'];

        // Redirection vers l'espace admin
        header('Location: admin.php');
        exit;
    } else {
        // Si les identifiants sont incorrects
        $error = "Login ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclusion du fichier CSS -->
</head>
<body>
    <!-- Logo -->
    <img src="netflixx.png" alt="Image marketing" class="hero-img">

    <?php include_once('menu.php'); ?>
    <?php
    // Affichage du message d'erreur, si nécessaire
    if (isset($error)) {
        echo '<p style="color:red;">' . $error . '</p>';
    }
    ?>

    <form method="POST">
        <label for="login">Login :</label>
        <input type="text" name="login" id="login" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Se connecter">
    </form>

</body>
<footer>
    <p>&copy; 2025 NETFLIXX. Tous droits réservés.</p>
    <p><a href="https://youtu.be/o-YBDTqX_ZU?si=1YFnqo9j9NWdPuXF"> 1 MOIS GRATUIT*</a></p>
    <P>* Valable pour toute nouvelle inscription, puis 5,99 € /mois </P>
</footer>
</html>