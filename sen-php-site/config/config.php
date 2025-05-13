<?php
// Configuration des chemins
define('BASE_URL', 'http://localhost/Projet-php/sen-php-site');
define('ROOT_PATH', dirname(__DIR__));
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('PAGES_PATH', ROOT_PATH . '/views');

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'unchk_db_last');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuration erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Démarrage session si non active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}