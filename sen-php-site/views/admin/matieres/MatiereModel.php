<?php
// matieres/MatiereModel.php

require_once __DIR__ . '/../../../config/db.php'; // charge getPDO()

/**
 * Classe MatiereModel - Gère toutes les interactions avec la table 'matieres'
 * Utilise des méthodes statiques pour faciliter l'accès sans instanciation
 */
class MatiereModel
{
    /**
     * Récupère toutes les matières avec le nom de la filière associée
     * @return array
     */
    public static function fetchAll(): array
    {
        $sql = "SELECT m.id, m.code, m.nom, m.description, m.filiere_id, f.nom as filiere_nom,
                       m.estDisponible, m.created_at, m.updated_at
                FROM matieres m
                LEFT JOIN filieres f ON m.filiere_id = f.id
                ORDER BY m.created_at DESC";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Recherche une matière par son identifiant
     * @param int $id
     * @return array|null
     */
    public static function find(int $id): ?array
    {
        $sql = "SELECT m.*, f.nom as filiere_nom
                FROM matieres m
                LEFT JOIN filieres f ON m.filiere_id = f.id
                WHERE m.id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        $matiere = $stmt->fetch();
        return $matiere ?: null;
    }

    /**
     * Récupère toutes les filières disponibles pour le formulaire
     * @return array
     */
    public static function getAllFilieres(): array
    {
        $sql = "SELECT id, nom FROM filieres WHERE estDisponible = 1 ORDER BY nom";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les matières d'une filière spécifique
     * @param int $filiere_id
     * @return array
     */
    public static function getByFiliere(int $filiere_id): array
    {
        $sql = "SELECT id, code, nom FROM matieres WHERE filiere_id = ? AND estDisponible = 1 ORDER BY nom";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$filiere_id]);
        return $stmt->fetchAll();
    }

    /**
     * Crée une nouvelle matière après validation des données
     * @throws Exception
     */
    public static function create(string $code, string $nom, string $description, int $filiere_id, bool $estDisponible): void
    {
        if ($code === '') {
            throw new Exception("Le code de la matière est requis");
        }
        if ($nom === '') {
            throw new Exception("Le nom de la matière est requis");
        }
        if ($filiere_id <= 0) {
            throw new Exception("La filière est requise");
        }
        if (self::codeExists($code)) {
            throw new Exception("Ce code de matière existe déjà");
        }

        $sql = "INSERT INTO matieres (code, nom, description, filiere_id, estDisponible, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$code, $nom, $description, $filiere_id, $estDisponible ? 1 : 0]);
    }

    /**
     * Vérifie si un code de matière existe déjà
     * @param string $code
     * @param int|null $excludeId
     * @return bool
     */
    public static function codeExists(string $code, ?int $excludeId = null): bool
    {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) FROM matieres WHERE code = ? AND id != ?";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute([$code, $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) FROM matieres WHERE code = ?";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute([$code]);
        }
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Met à jour une matière existante
     * @throws Exception
     */
    public static function update(int $id, string $code, string $nom, string $description, int $filiere_id, bool $estDisponible): void
    {
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        if ($code === '') {
            throw new Exception("Le code de la matière est requis");
        }
        if ($nom === '') {
            throw new Exception("Le nom de la matière est requis");
        }
        if ($filiere_id <= 0) {
            throw new Exception("La filière est requise");
        }
        if (self::codeExists($code, $id)) {
            throw new Exception("Ce code de matière existe déjà");
        }

        $sql = "UPDATE matieres
                SET code = ?, nom = ?, description = ?, filiere_id = ?, estDisponible = ?, updated_at = NOW()
                WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$code, $nom, $description, $filiere_id, $estDisponible ? 1 : 0, $id]);
        if ($stmt->rowCount() === 0) {
            throw new Exception("Matière introuvable ou non modifiée");
        }
    }

    /**
     * Supprime une matière
     * @throws Exception
     */
    public static function delete(int $id): void
    {
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        $sql = "DELETE FROM matieres WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) {
            throw new Exception("Matière introuvable");
        }
    }
}