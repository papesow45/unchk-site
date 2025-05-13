<?php
// views/admin/notes/NoteController.php

require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/NoteModel.php';

class NoteController {
    public function list() {
        return NoteModel::fetchAll();
    }

    public function getById($id) {
        return NoteModel::find($id);
    }

    public function add($data, $created_by) {
        try {
            NoteModel::create(
                $data['etudiant_id'],
                $data['matiere_id'],
                $data['note'],
                $created_by
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update($data, $updated_by) {
        try {
            NoteModel::update(
                $data['id'],
                $data['note'],
                $updated_by
            );
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            NoteModel::delete($id);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}