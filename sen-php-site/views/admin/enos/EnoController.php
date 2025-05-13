<?php
// views/admin/enos/EnoController.php

require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/EnoModel.php';

class EnoController {
    public function list() {
        return EnoModel::fetchAll();
    }

    public function getAllZones() {
        return EnoModel::getAllZones();
    }

    public function getById($id) {
        return EnoModel::find($id);
    }

    public function add($data) {
        $estDisponible = isset($data['estDisponible']) ? 1 : 0;
        
        try {
            EnoModel::create(
                $data['code'],
                $data['nom'],
                $data['adresse'],
                $data['telephone'],
                $data['zone_id'],
                $estDisponible,
                isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($data) {
        $estDisponible = isset($data['estDisponible']) ? 1 : 0;
        
        try {
            EnoModel::update(
                $data['id'],
                $data['code'],
                $data['nom'],
                $data['adresse'],
                $data['telephone'],
                $data['zone_id'],
                $estDisponible,
                isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            EnoModel::delete($id);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}