<?php
// views/admin/filieres/filiere-process.php

session_start();
require_once __DIR__ . '/FiliereController.php';

header('Content-Type: application/json');

$ctrl = new FiliereController();
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
            $response['message'] = 'Filière ajoutée avec succès';
            $response['reload'] = true;
        } else {
            $response['error'] = $result;
        }
    } 
    elseif ($action === 'update') {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            $response['error'] = 'ID invalide';
        } else {
            $result = $ctrl->update($_POST);
            
            if ($result === true) {
                $response['success'] = true;
                $response['message'] = 'Filière mise à jour avec succès';
                $response['reload'] = true;
            } else {
                $response['error'] = $result;
            }
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
                $response['message'] = 'Filière supprimée avec succès';
                $response['reload'] = true;
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
        $filiere = $ctrl->getById($id);
        
        if ($filiere) {
            $response['success'] = true;
            $response['filiere'] = $filiere;
        } else {
            $response['error'] = 'Filière non trouvée';
        }
    }
} else {
    $response['error'] = 'Méthode non autorisée';
}

echo json_encode($response);
