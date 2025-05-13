<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = getPDO();
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        $user = null;
        $role = null;

        // Rechercher dans les admins
        $stmt = $pdo->prepare("SELECT a.*, 'admin' AS role_nom FROM admins a WHERE a.email = ? AND a.is_active = 1");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $user = $admin;
            $role = 'admin';
        } else {
            // Rechercher dans les étudiants
            $stmt = $pdo->prepare("SELECT e.*, 'etudiant' AS role_nom FROM etudiants e WHERE e.email = ?");
            $stmt->execute([$email]);
            $etudiant = $stmt->fetch();

            if ($etudiant && password_verify($password, $etudiant['password'])) {
                $user = $etudiant;
                $role = 'etudiant';
            }
        }

        if ($user) {
            // Connexion réussie : stocker en session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['role'] = $role;

            // Redirection vers le dashboard
            header('Location: ' . BASE_URL . '/index.php?page=dashboard');
            exit();
        } else {
            $_SESSION['login_error'] = "❌ Email ou mot de passe incorrect.";
            header('Location: ' . BASE_URL . '/index.php?page=login');
            exit();
        }

    } catch (PDOException $e) {
        $_SESSION['login_error'] = "❌ Une erreur est survenue.";
        error_log("Erreur PDO: " . $e->getMessage());
        header('Location: ' . BASE_URL . '/index.php?page=login');
        exit();
    }
}
