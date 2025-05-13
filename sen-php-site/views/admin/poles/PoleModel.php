<?php
// poles/PoleModel.php
// Le PoleModel gère toutes les opérations CRUD pour les pôles

require_once __DIR__ . '../../../../config/db.php';  // charge getPDO()

class PoleModel
{
    /**
     * Récupère tous les pôles
     * @return array
     */
    public static function fetchAll(): array
    {
        $sql = "SELECT id, code, nom, description, created_at, created_by, updated_at, updated_by
                FROM poles
                ORDER BY created_at DESC";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère un pôle par son ID
     * @param int $id
     * @return array|null
     */
    public static function find(int $id): ?array
    {
        $sql = "SELECT id, code, nom, description, created_at, created_by, updated_at, updated_by
                FROM poles
                WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        $pole = $stmt->fetch();
        return $pole ?: null;
    }
    
    /**
     * Vérifie si un code existe déjà
     * @param string $code
     * @param int|null $excludeId ID à exclure de la vérification (pour les mises à jour)
     * @return bool
     */
    public static function codeExists(string $code, ?int $excludeId = null): bool
    {
        if ($excludeId) {
            $sql = "SELECT COUNT(*) FROM poles WHERE code = ? AND id != ?";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute([$code, $excludeId]);
        } else {
            $sql = "SELECT COUNT(*) FROM poles WHERE code = ?";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute([$code]);
        }
        
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Crée un nouveau pôle
     * @param string $code
     * @param string $nom
     * @param string $description
     * @param int $createdBy
     * @throws Exception
     */
    public static function create(string $code, string $nom, string $description, int $createdBy): void
    {
        if ($code === '') {
            throw new Exception("Le code du pôle est requis");
        }
        
        if ($nom === '') {
            throw new Exception("Le nom du pôle est requis");
        }
        
        // Vérifier si le code existe déjà
        if (self::codeExists($code)) {
            throw new Exception("Ce code de pôle existe déjà");
        }
        
        $sql = "INSERT INTO poles (code, nom, description, created_at, created_by)
                VALUES (?, ?, ?, NOW(), ?)";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$code, $nom, $description, $createdBy]);
    }

    /**
     * Met à jour un pôle existant
     * @param int $id
     * @param string $code
     * @param string $nom
     * @param string $description
     * @param int $updatedBy
     * @throws Exception
     */
    public static function update(int $id, string $code, string $nom, string $description, int $updatedBy): void
    {
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        
        if ($code === '') {
            throw new Exception("Le code du pôle est requis");
        }
        
        if ($nom === '') {
            throw new Exception("Le nom du pôle est requis");
        }
        
        // Vérifier si le code existe déjà pour un autre pôle
        if (self::codeExists($code, $id)) {
            throw new Exception("Ce code de pôle existe déjà");
        }

        $sql = "UPDATE poles
                SET code = ?, nom = ?, description = ?, updated_at = NOW(), updated_by = ?
                WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$code, $nom, $description, $updatedBy, $id]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Pôle introuvable ou non modifié");
        }
    }

    /**
     * Supprime un pôle
     * @param int $id
     * @throws Exception
     */
    public static function delete(int $id): void
    {
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        
        // Vérifier si le pôle est utilisé par des filières ou des cours
        $sql = "SELECT COUNT(*) FROM filieres WHERE pole_id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("Ce pôle est associé à des filières et ne peut pas être supprimé");
        }

        $sql = "DELETE FROM poles WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() === 0) {
            throw new Exception("Pôle introuvable");
        }
    }
}