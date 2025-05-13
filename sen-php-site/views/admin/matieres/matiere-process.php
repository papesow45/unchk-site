<?php
// views/admin/matieres/matiere-process.php

session_start();
require_once __DIR__ . '/MatiereController.php';

header('Content-Type: application/json');

$ctrl = new MatiereController();
$response = ['success' => false];

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'Vous devez être connecté pour effectuer cette action';
    echo json_encode($response);
    exit;
}

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $result = $ctrl->add($_POST);

        if ($result === true) {
            $response['success'] = true;
            $response['message'] = 'Matière ajoutée avec succès';
        } else {
            $response['error'] = $result;
        }
    }
    elseif ($action === 'update') {
        $result = $ctrl->update($_POST);

        if ($result === true) {
            $response['success'] = true;
            $response['message'] = 'Matière mise à jour avec succès';
        } else {
            $response['error'] = $result;
        }
    }
    elseif ($action === 'delete') {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            $response['error'] = 'ID invalide';
        } else {
            $result = $ctrl->delete($id);

            if ($result === true) {
                $response['success'] = true;
                $response['message'] = 'Matière supprimée avec succès';
            } else {
                $response['error'] = $result;
            }
        }
    } else {
        $response['error'] = 'Action non reconnue';
    }
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        $response['error'] = 'ID invalide';
    } else {
        $matiere = $ctrl->getById($id);

        if ($matiere) {
            $response['success'] = true;
            $response['matiere'] = $matiere;
        } else {
            $response['error'] = 'Matière non trouvée';
        }
    }
} else {
    $response['error'] = 'Méthode non autorisée';
}

echo json_encode($response);
