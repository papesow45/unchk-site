<?php
// views/admin/etudiants/EtudiantController.php

require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/EtudiantModel.php';

class EtudiantController {
    /**
     * Récupère tous les étudiants
     * 
     * @return array Tableau contenant tous les étudiants
     */
    public function list() {
        return EtudiantModel::fetchAll();
    }

    /**
     * Récupère tous les pôles disponibles pour le formulaire
     * 
     * @return array Tableau contenant tous les pôles disponibles
     */
    public function getAllPoles() {
        return EtudiantModel::getAllPoles();
    }

    /**
     * Récupère toutes les zones disponibles pour le formulaire
     * 
     * @return array Tableau contenant toutes les zones disponibles
     */
    public function getAllZones() {
        return EtudiantModel::getAllZones();
    }

    /**
     * Récupère toutes les filières disponibles pour le formulaire
     * 
     * @param int|null $pole_id Optionnel: filtre les filières par pôle
     * @return array Tableau contenant toutes les filières disponibles
     */
    public function getAllFilieres(?int $pole_id = null) {
        return EtudiantModel::getAllFilieres($pole_id);
    }

    /**
     * Récupère tous les ENOs disponibles pour le formulaire
     * 
     * @param int|null $zone_id Optionnel: filtre les ENOs par zone
     * @return array Tableau contenant tous les ENOs disponibles
     */
    public function getAllEnos(?int $zone_id = null) {
        return EtudiantModel::getAllEnos($zone_id);
    }

    /**
     * Récupère un étudiant par son identifiant
     * 
     * @param int $id Identifiant de l'étudiant
     * @return array|null Données de l'étudiant ou null si non trouvé
     */
    public function getById($id) {
        return EtudiantModel::find($id);
    }

    /**
     * Affiche les détails d'un étudiant
     * 
     * @param int $id Identifiant de l'étudiant
     * @return array Données de l'étudiant
     */
    public function details($id) {
        global $etudiant;
        $etudiant = $this->getById($id);
        
        if (!$etudiant) {
            header('Location: ../etudiants');
            exit();
        }
        
        return $etudiant;
    }

    /**
     * Ajoute un nouvel étudiant
     * 
     * @param array $data Données du formulaire
     * @return bool|string True en cas de succès, message d'erreur sinon
     */
    public function add($data) {
        try {
            EtudiantModel::create(
                $data['prenom'],
                $data['nom'],
                $data['email'],
                $data['password'],
                $data['telephone'],
                (int)$data['age'],
                $data['sexe'],
                $data['INE'],
                (int)$data['pole_id'],
                (int)$data['filiere_id'],
                (int)$data['zone_id'],
                (int)$data['eno_id'],
                isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Met à jour un étudiant existant
     * 
     * @param array $data Données du formulaire
     * @return bool|string True en cas de succès, message d'erreur sinon
     */
    public function update($data) {
        try {
            EtudiantModel::update(
                (int)$data['id'],
                $data['prenom'],
                $data['nom'],
                $data['email'],
                isset($data['password']) && !empty($data['password']) ? $data['password'] : null,
                $data['telephone'],
                (int)$data['age'],
                $data['sexe'],
                $data['INE'],
                (int)$data['pole_id'],
                (int)$data['filiere_id'],
                (int)$data['zone_id'],
                (int)$data['eno_id'],
                isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Supprime un étudiant
     * 
     * @param int $id Identifiant de l'étudiant à supprimer
     * @return bool|string True en cas de succès, message d'erreur sinon
     */
    public function delete($id) {
        try {
            EtudiantModel::delete($id);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

// Remplacez une requête comme celle-ci :
$sql = "SELECT e.*, p.nom as nom_pole, f.nom as nom_filiere, z.nom as nom_zone, eno.nom as nom_eno, 
        u1.nom as created_by_name, u2.nom as updated_by_name 
        FROM etudiants e
        LEFT JOIN poles p ON e.pole_id = p.id
        LEFT JOIN filieres f ON e.filiere_id = f.id
        LEFT JOIN zones z ON e.zone_id = z.id
        LEFT JOIN enos eno ON e.eno_id = eno.id
        LEFT JOIN users u1 ON e.created_by = u1.id
        LEFT JOIN users u2 ON e.updated_by = u2.id
        WHERE e.id = :id";

// Par une requête comme celle-ci :
$sql = "SELECT e.*, p.nom as nom_pole, f.nom as nom_filiere, z.nom as nom_zone, eno.nom as nom_eno, 
        u1.nom as created_by_name
        FROM etudiants e
        LEFT JOIN poles p ON e.pole_id = p.id
        LEFT JOIN filieres f ON e.filiere_id = f.id
        LEFT JOIN zones z ON e.zone_id = z.id
        LEFT JOIN enos eno ON e.eno_id = eno.id
        LEFT JOIN users u1 ON e.created_by = u1.id
        WHERE e.id = :id";