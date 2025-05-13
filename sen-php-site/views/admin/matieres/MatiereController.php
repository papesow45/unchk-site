<?php
// views/admin/matieres/MatiereController.php

require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/MatiereModel.php';

class MatiereController {
    public function list() {
        return MatiereModel::fetchAll();
    }

    public function getAllFilieres() {
        return MatiereModel::getAllFilieres();
    }

    public function getById($id) {
        return MatiereModel::find($id);
    }

    public function add($data) {
        $estDisponible = isset($data['estDisponible']) ? 1 : 0;

        try {
            MatiereModel::create(
                $data['code'],
                $data['nom'],
                $data['description'],
                $data['filiere_id'],
                $estDisponible
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($data) {
        $estDisponible = isset($data['estDisponible']) ? 1 : 0;

        try {
            MatiereModel::update(
                $data['id'],
                $data['code'],
                $data['nom'],
                $data['description'],
                $data['filiere_id'],
                $estDisponible
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            MatiereModel::delete($id);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}