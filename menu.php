<nav>
    <a href="index.php">Accueil</a>
    <a href="liste_films.php">Consulter tous les films</a>
    <?php if (isset($_SESSION['user'])) { ?>
        <a href="admin.php">Espace admin</a>
        <a href="deconnexion.php">Se déconnecter</a>
    <?php } else { ?>
        <a href="inscription.php">Inscription</a> 
        <a href="connexion.php">Connexion</a>
    <?php } ?>
</nav>