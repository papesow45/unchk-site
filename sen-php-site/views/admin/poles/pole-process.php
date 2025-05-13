<?php
// poles/pole-process.php
// pole-process.php ne fait que convertir l'input POST + session en appels aux méthodes du contrôleur, 
// et renvoie toujours du JSON.

// Démarrer la session
session_start();

// Désactiver l'affichage des erreurs pour éviter de corrompre le JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Vérifier si le script est appelé directement (via AJAX) ou inclus
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    // Appelé directement, on peut définir les en-têtes
    header('Content-Type: application/json');
}

require_once __DIR__ . '/PoleController.php';

// Vérif. d'accès
if (!isset($_SESSION['role']) || (strtolower($_SESSION['role']) !== 'admin' && $_SESSION['role'] !== 'admin')) {
    http_response_code(403);
    echo json_encode(['success'=>false,'error'=>'Accès refusé. Rôle actuel: ' . ($_SESSION['role'] ?? 'non défini')]);
    exit;
}

$ctrl = new PoleController();
$action = $_POST['action'] ?? '';

try {
    // ID de l'utilisateur courant issu de la session
    $userId = $_SESSION['user_id'] ?? 0;
    switch ($action) {
        case 'add':
            $code = trim($_POST['code'] ?? '');
            $nom = trim($_POST['nom'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $ctrl->add($code, $nom, $description, $userId);
            echo json_encode(['success'=>true,'message'=>'Pôle ajouté']);
            break;

        case 'edit':
            $id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
            $code = trim($_POST['code'] ?? '');
            $nom = trim($_POST['nom'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $ctrl->edit($id, $code, $nom, $description, $userId);
            echo json_encode(['success'=>true,'message'=>'Pôle modifié']);
            break;

        case 'delete':
            $id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
            $ctrl->delete($id);
            echo json_encode(['success'=>true,'message'=>'Pôle supprimé']);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success'=>false,'error'=>'Action inconnue']);
    }
} catch (Exception $e) {
    http_response_code(500);
    error_log("PoleController error: " . $e->getMessage());
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}