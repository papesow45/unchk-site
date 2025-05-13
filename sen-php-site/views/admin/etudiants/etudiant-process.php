<?php
// views/admin/etudiants/etudiant-process.php

session_start();
require_once __DIR__ . '/EtudiantController.php';

// Désactiver l'affichage des erreurs PHP pour éviter de corrompre la sortie JSON
ini_set('display_errors', 0);
error_reporting(0);

header('Content-Type: application/json');

$ctrl = new EtudiantController();
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
            $response['message'] = 'Étudiant ajouté avec succès';
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
                $response['message'] = 'Étudiant mis à jour avec succès';
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
                $response['message'] = 'Étudiant supprimé avec succès';
                $response['reload'] = true;
            } else {
                $response['error'] = $result;
            }
        }
    } else {
        $response['error'] = 'Action non reconnue';
    }
} 
// Gardez uniquement ces cas existants (pas besoin de les modifier)
if (isset($_GET['action']) && $_GET['action'] === 'getFilieres') {
    $pole_id = isset($_GET['pole_id']) ? intval($_GET['pole_id']) : null;
    $filieres = $ctrl->getAllFilieres($pole_id);
    echo json_encode($filieres);
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'getEnos') {
    $zone_id = isset($_GET['zone_id']) ? intval($_GET['zone_id']) : null;
    $enos = $ctrl->getAllEnos($zone_id);
    echo json_encode($enos);
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'get') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        $etudiant = $ctrl->getById($id);
        if ($etudiant) {
            $response = [
                'success' => true,
                'etudiant' => $etudiant
            ];
        } else {
            $response['error'] = 'Étudiant non trouvé';
        }
    } else {
        $response['error'] = 'ID invalide';
    }
    echo json_encode($response);
    exit;
} else {
    $response['error'] = 'Méthode non autorisée';
}

echo json_encode($response);
