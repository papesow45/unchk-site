<?php
// notes/NoteModel.php

require_once __DIR__ . '/../../../config/db.php';

class NoteModel
{
    /**
     * Récupère toutes les notes avec infos étudiant et matière
     * @return array
     */
    public static function fetchAll(): array
    {
        $sql = "SELECT n.id, n.note, n.created_at, n.updated_at,
                       e.id as etudiant_id, e.prenom, e.nom, e.INE,
                       m.id as matiere_id, m.code as matiere_code, m.nom as matiere_nom
                FROM notes n
                JOIN etudiants e ON n.etudiant_id = e.id
                JOIN matieres m ON n.matiere_id = m.id
                ORDER BY n.created_at DESC";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Recherche une note par son identifiant
     * @param int $id
     * @return array|null
     */
    public static function find(int $id): ?array
    {
        $sql = "SELECT n.*, e.prenom, e.nom, e.INE, m.code as matiere_code, m.nom as matiere_nom
                FROM notes n
                JOIN etudiants e ON n.etudiant_id = e.id
                JOIN matieres m ON n.matiere_id = m.id
                WHERE n.id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        $note = $stmt->fetch();
        return $note ?: null;
    }

    /**
     * Crée une nouvelle note
     * @throws Exception
     */
    public static function create(int $etudiant_id, int $matiere_id, float $note, int $created_by): void
    {
        if ($note < 0 || $note > 20) {
            throw new Exception("La note doit être comprise entre 0 et 20");
        }
        if (self::noteExists($etudiant_id, $matiere_id)) {
            throw new Exception("Une note existe déjà pour cet étudiant et cette matière");
        }
        $sql = "INSERT INTO notes (etudiant_id, matiere_id, note, created_at, created_by)
                VALUES (?, ?, ?, NOW(), ?)";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$etudiant_id, $matiere_id, $note, $created_by]);
    }

    /**
     * Vérifie si une note existe déjà pour un étudiant et une matière
     */
    public static function noteExists(int $etudiant_id, int $matiere_id): bool
    {
        $sql = "SELECT COUNT(*) FROM notes WHERE etudiant_id = ? AND matiere_id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$etudiant_id, $matiere_id]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Met à jour une note existante
     * @throws Exception
     */
    public static function update(int $id, float $note, int $updated_by): void
    {
        if ($note < 0 || $note > 20) {
            throw new Exception("La note doit être comprise entre 0 et 20");
        }
        $sql = "UPDATE notes
                SET note = ?, updated_at = NOW(), updated_by = ?
                WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$note, $updated_by, $id]);
        if ($stmt->rowCount() === 0) {
            throw new Exception("Note introuvable ou non modifiée");
        }
    }

    /**
     * Supprime une note
     * @throws Exception
     */
    public static function delete(int $id): void
    {
        $sql = "DELETE FROM notes WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) {
            throw new Exception("Note introuvable");
        }
    }
}