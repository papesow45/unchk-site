<?php
// views/admin/notes/note-process.php

session_start();
require_once __DIR__ . '/NoteController.php';

header('Content-Type: application/json');

$ctrl = new NoteController();
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
        $result = $ctrl->add($_POST, $_SESSION['user_id']);

        if ($result === true) {
            $response['success'] = true;
            $response['message'] = 'Note ajoutée avec succès';
        } else {
            $response['error'] = $result;
        }
    }
    elseif ($action === 'update') {
        $result = $ctrl->update($_POST, $_SESSION['user_id']);

        if ($result === true) {
            $response['success'] = true;
            $response['message'] = 'Note mise à jour avec succès';
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
                $response['message'] = 'Note supprimée avec succès';
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
        $note = $ctrl->getById($id);

        if ($note) {
            $response['success'] = true;
            $response['note'] = $note;
        } else {
            $response['error'] = 'Note non trouvée';
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'matieres_by_filiere') {
    $filiere_id = filter_input(INPUT_GET, 'filiere_id', FILTER_VALIDATE_INT);

    if (!$filiere_id) {
        $response['error'] = 'ID de filière invalide';
    } else {
        require_once __DIR__ . '/../matieres/MatiereModel.php';
        $matieres = MatiereModel::getByFiliere($filiere_id);
        $response['success'] = true;
        $response['matieres'] = $matieres;
    }
    echo json_encode($response);
    exit;
}
else {
    $response['error'] = 'Méthode non autorisée';
}

echo json_encode($response);