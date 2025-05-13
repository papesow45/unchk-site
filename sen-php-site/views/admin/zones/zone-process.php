<?php
// zones/zone-process.php
// zone-process.php ne fait que convertir l'input POST + session en appels aux méthodes du contrôleur, et renvoie toujours du JSON.

// Vérifier si le script est appelé directement (via AJAX) ou inclus
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {
    // Appelé directement, on peut définir les en-têtes
    header('Content-Type: application/json');
}

require_once __DIR__ . '/ZoneController.php';

// Vérif. d'accès
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success'=>false,'error'=>'Accès refusé']);
    exit;
}

$ctrl = new ZoneController();
$action = $_POST['action'] ?? '';

try {
    // ID de l'utilisateur courant issu de la session
    $userId = $_SESSION['user_id'] ?? 0;
    switch ($action) {
        case 'add':
            $nom  = trim($_POST['nom'] ?? '');
            $est  = isset($_POST['estDisponible']) ? (bool)$_POST['estDisponible'] : true;
            $ctrl->add($nom, $est, $userId);
            echo json_encode(['success'=>true,'message'=>'Zone ajoutée']);
            break;

        case 'edit':
            $id   = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
            $nom  = trim($_POST['nom'] ?? '');
            $est  = isset($_POST['estDisponible']) ? (bool)$_POST['estDisponible'] : true;
            $ctrl->edit($id, $nom, $est, $userId);
            echo json_encode(['success'=>true,'message'=>'Zone modifiée']);
            break;

        case 'delete':
            $id   = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);
            $ctrl->delete($id);
            echo json_encode(['success'=>true,'message'=>'Zone supprimée']);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success'=>false,'error'=>'Action inconnue']);
    }
} catch (Exception $e) {
    http_response_code(500);
    error_log("ZoneController error: " . $e->getMessage());
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}


