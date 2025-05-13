<?php
session_start();

// Message de succès optionnel
$_SESSION['success_message'] = "Vous avez été déconnecté avec succès.";

// Destruction de la session
session_unset();
session_destroy();

// Redirection vers la page de connexion
header('Location: ' . BASE_URL . '/index.php?page=login');
exit();