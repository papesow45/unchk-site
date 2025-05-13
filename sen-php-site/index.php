<?php 
    session_start();
    require_once 'config/config.php';  // D'abord config.php
    require_once 'config/db.php';      // Ensuite db.php
    require_once 'includes/functions.php';

    // Récupération de la page demandée
    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) ?? 'accueil';

    // Vérification des droits d'accès
    $restricted_pages = ['etudiant', 'admin'];
    if(in_array($page, $restricted_pages) && !isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/index.php?page=login');
        exit();
    }

    // Routing des pages avec chemins absolus
    $page_path = '';
    switch($page) {
        
        // Pages publiques
        case 'accueil':
            $page_path = PAGES_PATH . '/public/accueil.php';
            break;
        case 'about':
            $page_path = PAGES_PATH . '/public/about.php';
            break;
        case 'blog':
            $page_path = PAGES_PATH . '/public/blog.php';
            break;
        case 'contact':
            $page_path = PAGES_PATH . '/public/contact.php';
            break;

        // Pages d'authentification
        case 'login':
            $page_path = PAGES_PATH . '/auth/login.php';
            break;
        case 'login_process':
            $page_path = PAGES_PATH . '/auth/login_process.php';
            break;
        case 'logout':
            // Destruction de la session
            session_start();
            session_unset();
            session_destroy();
            
            // En-têtes pour empêcher la mise en cache
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            
            // Redirection vers la page de connexion
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit();
            break;
        case 'register':
            $page_path = PAGES_PATH . '/auth/register.php';
            break;
        case 'reset-password':
            $page_path = PAGES_PATH . '/auth/forgotPass.php';
            break;

        // Pages du dashboard
        case 'dashboard':
            if(isset($_SESSION['role'])) {
                $section = $_GET['section'] ?? 'home';
                
                if($_SESSION['role'] === 'admin') {
                    switch($section) {
                        case 'users':
                            $content_path = PAGES_PATH . '/admin/users/page.php';
                            break;
                        case 'users-process':
                            $content_path = PAGES_PATH . '/admin/users/page-process.php';
                            break;
                        case 'roles':
                            $content_path = PAGES_PATH . '/admin/roles/role.php';
                            break;
                        case 'roles-process':
                            $content_path = PAGES_PATH . '/admin/roles/role-process.php';
                            break;
                        case 'poles':
                            $content_path = PAGES_PATH . '/admin/poles/pole.php';
                            break;
                        case 'poles-process':
                            $content_path = PAGES_PATH . '/admin/poles/pole-process.php';
                            break;
                        case 'zones':
                            $content_path = PAGES_PATH . '/admin/zones/zone.php';
                            break;
                        case 'zones-process':
                            $content_path = PAGES_PATH . '/admin/zones/zone-process.php';
                            break;
                        case 'enos':
                            $content_path = PAGES_PATH . '/admin/enos/eno.php';
                            break;
                        case 'enos-process':
                            $content_path = PAGES_PATH . '/admin/enos/eno-process.php';
                            break;
                        case 'filieres':
                            $content_path = PAGES_PATH . '/admin/filieres/filiere.php';
                            break;
                        case 'filieres-process':
                            $content_path = PAGES_PATH . '/admin/filieres/filiere-process.php';
                            break;
                        case 'matieres':
                            $content_path = PAGES_PATH . '/admin/matieres/matiere.php';
                            break;
                        case 'matieres-process':
                            $content_path = PAGES_PATH . '/admin/matieres/matiere-process.php';
                            break;
                        case 'notes':
                            $content_path = PAGES_PATH . '/admin/notes/note.php';
                            break;
                        case 'notes-process':
                            $content_path = PAGES_PATH . '/admin/notes/note-process.php';
                            break;
                        case 'etudiants':
                            $content_path = PAGES_PATH . '/admin/etudiants/etudiant.php';
                            break;
                        case 'etudiants-process':
                            $content_path = PAGES_PATH . '/admin/etudiants/etudiant-process.php';
                            break;
                        case 'formations':
                            $content_path = PAGES_PATH . '/admin/formations/page.php';
                            break;
                        default:
                            $content_path = PAGES_PATH . '/admin/dashboard.php';
                    }
                } else {
                    switch($section) {
                        case 'cours':
                            $content_path = PAGES_PATH . '/etudiant/cours/page.php';
                            break;
                        case 'forums':
                            $content_path = PAGES_PATH . '/etudiant/forums/page.php';
                            break;
                        case 'profil':
                            $content_path = PAGES_PATH . '/etudiant/profil/page.php';
                            break;
                        default:
                            $content_path = PAGES_PATH . '/etudiant/dashboard.php';
                    }
                }
                require_once ROOT_PATH . '/layouts/dashboard.php';
                exit();
            } else {
                header('Location: ' . BASE_URL . '/index.php?page=login');
                exit();
            }
            break;

        default:
            $page_path = PAGES_PATH . '/public/404.php';
            break;
    }

    // Vérification de l'existence du fichier
    if (!file_exists($page_path)) {
        $page_path = PAGES_PATH . '/public/404.php';
    }

    // Affichage de la page avec le layout approprié
    if ($page === 'dashboard') {
        // Le dashboard est déjà inclus dans le switch
        return;
    } else if (in_array($page, ['login', 'register', 'reset-password'])) {
        // Pages d'authentification sans header/footer
        require_once $page_path;
    } else {
        // Pages publiques avec header/footer
        require_once INCLUDES_PATH . '/header.php';
        require_once $page_path;
        require_once INCLUDES_PATH . '/footer.php';
    }
?>