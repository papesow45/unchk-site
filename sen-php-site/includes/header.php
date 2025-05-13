<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Université UNCHK</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary d-flex justify-content-center sticky-top">
        <div class="container-fluid d-flex justify-content-center">
            <a class="navbar-brand" href="index.php">UNCHK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav d-flex gap-5 justify-content-center justify-content-md-between">
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('accueil'); ?>" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('about'); ?>" href="?page=about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('blog'); ?>" href="?page=blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo isActive('contact'); ?>" href="?page=contact">Contact</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <?php if (isset($_SESSION['user'])) : ?>
                    <a href="?page=profile" class="btn btn-outline-light me-2">Mon Profil</a>
                    <a href="logout.php" class="btn btn-outline-light">Déconnexion</a>
                <?php else : ?>
                    <a href="?page=login" class="btn btn-outline-light me-2">Connexion</a>
                    <a href="?page=register" class="btn btn-outline-light">Inscription</a>
                <?php endif; ?>
        </div>
    </nav>
    <!-- Main Content -->
    <main class="container-fluid p-0">