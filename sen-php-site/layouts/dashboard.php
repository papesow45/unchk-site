<?php
// Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . '/index.php?page=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard <?php echo ucfirst($_SESSION['role']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/dashboard.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-dark">
            <div class="sidebar-header">
                <p class="text-light">UNCHK</p>
            </div>

            <!-- Menu Admin -->
            <ul class="list-unstyled components">
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li class="<?php echo !isset($_GET['section']) ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="<?php echo isset($_GET['section']) && $_GET['section'] === 'roles' ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard&section=roles">
                            <i class="fas fa-user-tag"></i> Roles
                        </a>
                    </li>
                    <li class="<?php echo isset($_GET['section']) && $_GET['section'] === 'enos' ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard&section=enos">
                            <i class="fas fa-school"></i> Enos
                        </a>
                    </li>
                    <li class="<?php echo isset($_GET['section']) && $_GET['section'] === 'poles' ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard&section=poles">
                            <i class="fas fa-layer-group"></i> Pôles
                        </a>
                    </li>
                    <li class="<?php echo isset($_GET['section']) && $_GET['section'] === 'etudiants' ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard&section=etudiants">
                            <i class="fas fa-users"></i> Etudiants
                        </a>
                    </li>
                    <li class="<?php echo isset($_GET['section']) && $_GET['section'] === 'filieres' ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard&section=filieres">
                            <i class="fas fa-graduation-cap"></i> Filiéres
                        </a>
                    </li>
                    <li class="<?php echo isset($_GET['section']) && $_GET['section'] === 'notes' ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard&section=notes">
                            <i class="fas fa-book"></i> Notes
                        </a>
                    </li>
                    <li class="<?php echo isset($_GET['section']) && $_GET['section'] === 'matieres' ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard&section=matieres">
                            <i class="fas fa-book"></i> Matieres
                        </a>
                    </li>
                    <li class="<?php echo isset($_GET['section']) && $_GET['section'] === 'zones' ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard&section=zones">
                            <i class="fas fa-globe"></i> Zones
                        </a>
                    </li>
                    <!-- ...autres menus admin... -->
                <?php else: ?>
                    <!-- Menu Étudiant -->
                    <li class="<?php echo !isset($_GET['section']) ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="<?php echo isset($_GET['section']) && $_GET['section'] === 'cours' ? 'active' : ''; ?>">
                        <a href="<?php echo BASE_URL; ?>/index.php?page=dashboard&section=cours">
                            <i class="fas fa-book-open"></i> Mes Cours
                        </a>
                    </li>
                    <!-- ...autres menus étudiant... -->
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content" class="overflow-scroll-y">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-dark">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle text-dark text-decoration-none" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['nom']); ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>/index.php?page=<?php echo $_SESSION['role']; ?>&section=profil">
                                        <i class="fas fa-user-cog"></i> Profil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="<?php echo BASE_URL; ?>/index.php?page=logout">
                                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="container-fluid py-4">
                <?php 
                if (file_exists($content_path)) {
                    include $content_path;
                } else {
                    echo '<div class="alert alert-danger">Erreur : Page non trouvée</div>';
                    error_log("Fichier non trouvé : " . $content_path);
                }
                ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/wicg-inert@3.1.2/dist/inert.min.js"></script> -->
</body>
</html>