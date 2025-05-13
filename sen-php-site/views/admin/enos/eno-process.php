<?php
// views/admin/enos/eno-process.php

session_start();
require_once __DIR__ . '/EnoController.php';

header('Content-Type: application/json');

$ctrl = new EnoController();
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
            $response['message'] = 'ENO ajouté avec succès';
        } else {
            $response['error'] = $result;
        }
    } 
    elseif ($action === 'update') {
        $result = $ctrl->update($_POST);
        
        if ($result === true) {
            $response['success'] = true;
            $response['message'] = 'ENO mis à jour avec succès';
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
                $response['message'] = 'ENO supprimé avec succès';
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
        $eno = $ctrl->getById($id);
        
        if ($eno) {
            $response['success'] = true;
            $response['eno'] = $eno;
        } else {
            $response['error'] = 'ENO non trouvé';
        }
    }
} else {
    $response['error'] = 'Méthode non autorisée';
}

echo json_encode($response);