<?php
// zones/ZoneModel.php

require_once __DIR__ . '../../../../config/db.php';  // charge getPDO()

class ZoneModel
{
    public static function fetchAll(): array
    {
        $sql = "SELECT id, nom, estDisponible, created_at, created_by, updated_at, updated_by
                FROM zones
                ORDER BY created_at DESC";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $sql = "SELECT id, nom, estDisponible, created_at, created_by, updated_at, updated_by
                FROM zones
                WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        $zone = $stmt->fetch();
        return $zone ?: null;
    }

    /**
     * Crée une nouvelle zone
     *
     * @param string $nom
     * @param bool   $estDisponible
     * @param int    $createdBy  ID de l'utilisateur créateur
     * @throws Exception
     */
    public static function create(string $nom, bool $estDisponible, int $createdBy): void
    {
        if ($nom === '') {
            throw new Exception("Le nom de la zone est requis");
        }
        $sql = "INSERT INTO zones (nom, estDisponible, created_at, created_by)
                VALUES (?, ?, NOW(), ?)";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$nom, $estDisponible ? 1 : 0, $createdBy]);
    }

    /**
     * Met à jour une zone existante
     *
     * @param int    $id
     * @param string $nom
     * @param bool   $estDisponible
     * @param int    $updatedBy  ID de l'utilisateur ayant modifié
     * @throws Exception
     */
    public static function update(int $id, string $nom, bool $estDisponible, int $updatedBy): void
    {
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        if ($nom === '') {
            throw new Exception("Le nom de la zone est requis");
        }

        $sql = "UPDATE zones
                SET nom = ?, estDisponible = ?, updated_at = NOW(), updated_by = ?
                WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$nom, $estDisponible ? 1 : 0, $updatedBy, $id]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Zone introuvable ou non modifiée");
        }
    }

    /**
     * Supprime une zone
     *
     * @param int $id
     * @throws Exception
     */
    public static function delete(int $id): void
    {
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        $sql = "DELETE FROM zones WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) {
            throw new Exception("Zone introuvable");
        }
    }
}