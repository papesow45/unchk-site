<?php
    // Fonction pour se connecter à la base de données
    function db_connect() {
        $host = 'localhost'; // Adresse du serveur
        $db = 'unchk_db'; // Nom de la base de données
        $user = 'root'; // Nom d'utilisateur
        $pass = ''; // Mot de passe

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
            return null;
        }
    }

    // Fonction pour vérifier si un utilisateur est connecté
    function is_logged_in() {
        return isset($_SESSION['user_id']);
    }

    // Fonction pour rediriger vers une autre page
    function redirect($url) {
        header("Location: $url");
        exit();
    }

    // Fonction pour afficher un message flash
    function flash_message($message) {
        $_SESSION['flash_message'] = $message;
    }

    // Fonction pour récupérer un message flash
    function get_flash_message() {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        }
        return null;
    }

    /**
     * Vérifie si la page courante correspond à la page demandée
     * @param string $page_name Nom de la page à vérifier
     * @return string Retourne 'active' si la page correspond
     */
    function isActive($page_name) {
        $current_page = $_GET['page'] ?? 'accueil';
        return ($current_page === $page_name) ? 'active fw-bold' : '';
    }

?>