<?php
// roles/RoleModel.php
// Le RoleModel gère toutes les opérations CRUD pour les rôles

require_once __DIR__ . '../../../../config/db.php';  // charge getPDO()

class RoleModel
{
    /**
     * Récupère tous les rôles
     * @return array
     */
    public static function fetchAll(): array
    {
        $sql = "SELECT id, nom, created_at, created_by, updated_at, updated_by
                FROM roles
                ORDER BY created_at DESC";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère un rôle par son ID
     * @param int $id
     * @return array|null
     */
    public static function find(int $id): ?array
    {
        $sql = "SELECT id, nom, created_at, created_by, updated_at, updated_by
                FROM roles
                WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        $role = $stmt->fetch();
        return $role ?: null;
    }

    /**
     * Crée un nouveau rôle
     * @param string $nom
     * @param int $createdBy
     * @throws Exception
     */
    public static function create(string $nom, int $createdBy): void
    {
        if ($nom === '') {
            throw new Exception("Le nom du rôle est requis");
        }
        
        $sql = "INSERT INTO roles (nom, created_at, created_by)
                VALUES (?, NOW(), ?)";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$nom, $createdBy]);
    }

    /**
     * Met à jour un rôle existant
     * @param int $id
     * @param string $nom
     * @param int $updatedBy
     * @throws Exception
     */
    public static function update(int $id, string $nom, int $updatedBy): void
    {
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        if ($nom === '') {
            throw new Exception("Le nom du rôle est requis");
        }

        $sql = "UPDATE roles
                SET nom = ?, updated_at = NOW(), updated_by = ?
                WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$nom, $updatedBy, $id]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Rôle introuvable ou non modifié");
        }
    }

    /**
     * Supprime un rôle
     * @param int $id
     * @throws Exception
     */
    public static function delete(int $id): void
    {
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        
        // Vérifier si le rôle est utilisé par des utilisateurs
        $sql = "SELECT COUNT(*) FROM users WHERE role_id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("Ce rôle est attribué à des utilisateurs et ne peut pas être supprimé");
        }

        // Vérifier si c'est un rôle système (admin ou etudiant)
        $sql = "SELECT nom FROM roles WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        $role = $stmt->fetch();
        if ($role && in_array($role['nom'], ['admin', 'etudiant'])) {
            throw new Exception("Les rôles système ne peuvent pas être supprimés");
        }

        $sql = "DELETE FROM roles WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() === 0) {
            throw new Exception("Rôle introuvable");
        }
    }
}