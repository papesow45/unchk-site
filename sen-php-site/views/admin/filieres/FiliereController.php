<?php
// views/admin/filieres/FiliereController.php

require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/FiliereModel.php';

class FiliereController {
    /**
     * Récupère toutes les filières
     * 
     * @return array Tableau contenant toutes les filières
     */
    public function list() {
        return FiliereModel::fetchAll();
    }

    /**
     * Récupère tous les pôles disponibles pour le formulaire
     * 
     * @return array Tableau contenant tous les pôles disponibles
     */
    public function getAllPoles() {
        return FiliereModel::getAllPoles();
    }

    /**
     * Récupère une filière par son identifiant
     * 
     * @param int $id Identifiant de la filière
     * @return array|null Données de la filière ou null si non trouvée
     */
    public function getById($id) {
        return FiliereModel::find($id);
    }

    /**
     * Affiche les détails d'une filière
     * 
     * @param int $id Identifiant de la filière
     * @return array Données de la filière
     */
    public function details($id) {
        global $filiere;
        $filiere = $this->getById($id);
        
        if (!$filiere) {
            header('Location: ../filieres');
            exit();
        }
        
        return $filiere;
    }

    /**
     * Ajoute une nouvelle filière
     * 
     * @param array $data Données du formulaire
     * @return bool|string True en cas de succès, message d'erreur sinon
     */
    public function add($data) {
        $estDisponible = isset($data['estDisponible']) ? 1 : 0;
        
        try {
            FiliereModel::create(
                $data['code'],
                $data['nom'],
                $data['description'],
                $data['pole_id'],
                $estDisponible,
                isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Met à jour une filière existante
     * 
     * @param array $data Données du formulaire
     * @return bool|string True en cas de succès, message d'erreur sinon
     */
    public function update($data) {
        $estDisponible = isset($data['estDisponible']) ? 1 : 0;
        
        try {
            FiliereModel::update(
                $data['id'],
                $data['code'],
                $data['nom'],
                $data['description'],
                $data['pole_id'],
                $estDisponible,
                isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Supprime une filière
     * 
     * @param int $id Identifiant de la filière à supprimer
     * @return bool|string True en cas de succès, message d'erreur sinon
     */
    public function delete($id) {
        try {
            FiliereModel::delete($id);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
