<?php
// roles/role-process.php
// role-process.php ne fait que convertir l'input POST + session en appels aux méthodes du contrôleur, 
// et renvoie toujours du JSON.

// Démarrer la session
session_start();

// Au début de role-process.php après session_start()
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("Erreur PHP dans $errfile:$errline - $errstr");
    return true;
});

// Vérifier si le script est appelé directement (via AJAX) ou inclus
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    // Appelé directement, on peut définir les en-têtes
    header('Content-Type: application/json');
}

require_once __DIR__ . '/RoleController.php';

// Vérif. d'accès
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success'=>false,'error'=>'Accès refusé']);
    exit;
}

$ctrl = new RoleController();
$action = $_POST['action'] ?? '';

try {
    // ID de l'utilisateur courant issu de la session
    $userId = $_SESSION['user_id'] ?? 0;
    switch ($action) {
        case 'add':
            $nom = trim($_POST['nom'] ?? '');
            $ctrl->add($nom, $userId);
            echo json_encode(['success'=>true,'message'=>'Rôle ajouté']);
            break;

        case 'edit':
            $id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
            $nom = trim($_POST['nom'] ?? '');
            $ctrl->edit($id, $nom, $userId);
            echo json_encode(['success'=>true,'message'=>'Rôle modifié']);
            break;

        case 'delete':
            $id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
            $ctrl->delete($id);
            echo json_encode(['success'=>true,'message'=>'Rôle supprimé']);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success'=>false,'error'=>'Action inconnue']);
    }
} catch (Exception $e) {
    http_response_code(500);
    error_log("RoleController error: " . $e->getMessage());
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}