<?php
// filieres/FiliereModel.php
/**
 * Modèle de données pour la gestion des filières
 * Ce fichier contient toutes les opérations CRUD (Create, Read, Update, Delete)
 * ainsi que des fonctions utilitaires pour la gestion des filières
 */

require_once __DIR__ . '../../../../config/db.php';  // charge getPDO()

/**
 * Classe FiliereModel - Gère toutes les interactions avec la table 'filieres' de la base de données
 * Une filière appartient à un pôle (relation many-to-one)
 * Un pôle peut avoir plusieurs filières (relation one-to-many)
 */
class FiliereModel
{
    /**
     * Récupère toutes les filières de la base de données avec les informations de leur pôle
     * Les résultats sont triés par date de création (du plus récent au plus ancien)
     * 
     * @return array Tableau contenant toutes les filières avec leurs informations complètes
     */
    public static function fetchAll(): array
    {
        $sql = "SELECT f.id, f.code, f.nom, f.description, f.pole_id, p.code as pole_code, 
                f.estDisponible, f.created_at, f.created_by, f.updated_at, f.updated_by
                FROM filieres f
                JOIN poles p ON f.pole_id = p.id
                ORDER BY f.created_at DESC";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Recherche une filière spécifique par son identifiant
     * Inclut les informations sur le pôle associé et les administrateurs qui ont créé/modifié la filière
     * 
     * @param int $id Identifiant unique de la filière à rechercher
     * @return array|null Retourne les données de la filière ou null si non trouvée
     */
    public static function find(int $id): ?array
    {
        $sql = "SELECT f.id, f.code, f.nom, f.description, f.pole_id, p.code as pole_code, 
                f.estDisponible, f.created_at, f.created_by, f.updated_at, f.updated_by,
                c.nom as created_by_name, u.nom as updated_by_name
                FROM filieres f
                JOIN poles p ON f.pole_id = p.id
                LEFT JOIN admins c ON f.created_by = c.id
                LEFT JOIN admins u ON f.updated_by = u.id
                WHERE f.id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        $filiere = $stmt->fetch();
        return $filiere ?: null;
    }

    /**
     * Récupère tous les pôles disponibles pour le formulaire de création/modification de filière
     * 
     * @return array Tableau contenant tous les pôles, triés par nom
     */
    public static function getAllPoles(): array
    {
        $sql = "SELECT id, nom FROM poles ORDER BY nom";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Crée une nouvelle filière dans la base de données après validation des données
     *
     * @param string $code Code unique identifiant la filière (doit être unique dans la base)
     * @param string $nom Nom complet de la filière
     * @param string $description Description détaillée de la filière
     * @param int $pole_id Identifiant du pôle auquel la filière est rattachée
     * @param bool $estDisponible Statut de disponibilité de la filière (actif/inactif)
     * @param int $createdBy ID de l'administrateur qui crée l'enregistrement (pour l'audit)
     * @throws Exception Si les données ne sont pas valides ou si le code existe déjà
     */
    public static function create(string $code, string $nom, string $description, 
                                 int $pole_id, bool $estDisponible, int $createdBy): void
    {
        // Validation des données obligatoires
        if ($code === '') {
            throw new Exception("Le code de la filière est requis");
        }
        if ($nom === '') {
            throw new Exception("Le nom de la filière est requis");
        }
        if ($pole_id <= 0) {
            throw new Exception("Le pôle est requis");
        }

        // Vérification de l'unicité du code filière
        if (self::codeExists($code)) {
            throw new Exception("Ce code de filière existe déjà");
        }

        // Préparation et exécution de la requête d'insertion
        $sql = "INSERT INTO filieres (code, nom, description, pole_id, estDisponible, created_at, created_by)
                VALUES (?, ?, ?, ?, ?, NOW(), ?)";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$code, $nom, $description, $pole_id, $estDisponible ? 1 : 0, $createdBy]);
    }

    /**
     * Vérifie si un code de filière existe déjà dans la base de données
     * Utilisé pour garantir l'unicité des codes lors de la création ou mise à jour
     * 
     * @param string $code Le code à vérifier
     * @param int|null $excludeId ID à exclure de la vérification (utile lors des mises à jour)
     * @return bool True si le code existe déjà, False sinon
     */
    public static function codeExists(string $code, ?int $excludeId = null): bool
    {
        // Si un ID est fourni, on l'exclut de la recherche (cas d'une mise à jour)
        if ($excludeId) {
            $sql = "SELECT COUNT(*) FROM filieres WHERE code = ? AND id != ?";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute([$code, $excludeId]);
        } else {
            // Cas d'une création, on vérifie simplement si le code existe
            $sql = "SELECT COUNT(*) FROM filieres WHERE code = ?";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute([$code]);
        }
        
        // Retourne true si au moins un enregistrement a été trouvé
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Met à jour les informations d'une filière existante après validation
     *
     * @param int $id Identifiant de la filière à mettre à jour
     * @param string $code Code unique de la filière (peut être le même que l'original)
     * @param string $nom Nouveau nom de la filière
     * @param string $description Nouvelle description de la filière
     * @param int $pole_id Nouveau pôle d'affectation
     * @param bool $estDisponible Nouveau statut de disponibilité
     * @param int $updatedBy ID de l'administrateur effectuant la modification (pour l'audit)
     * @throws Exception Si les données sont invalides, si la filière n'existe pas, ou si le code existe déjà
     */
    public static function update(int $id, string $code, string $nom, string $description, 
                                 int $pole_id, bool $estDisponible, int $updatedBy): void
    {
        // Validation des données obligatoires
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        if ($code === '') {
            throw new Exception("Le code de la filière est requis");
        }
        if ($nom === '') {
            throw new Exception("Le nom de la filière est requis");
        }
        if ($pole_id <= 0) {
            throw new Exception("Le pôle est requis");
        }

        // Vérification de l'unicité du code (en excluant la filière actuelle)
        if (self::codeExists($code, $id)) {
            throw new Exception("Ce code de filière existe déjà");
        }

        // Préparation et exécution de la requête de mise à jour
        $sql = "UPDATE filieres
                SET code = ?, nom = ?, description = ?, pole_id = ?, 
                    estDisponible = ?, updated_at = NOW(), updated_by = ?
                WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$code, $nom, $description, $pole_id, $estDisponible ? 1 : 0, $updatedBy, $id]);

        // Vérification que la mise à jour a bien affecté une ligne
        if ($stmt->rowCount() === 0) {
            throw new Exception("Filière introuvable ou non modifiée");
        }
    }

    /**
     * Supprime une filière de la base de données
     * 
     * @param int $id Identifiant de la filière à supprimer
     * @throws Exception Si l'ID est invalide ou si la filière n'existe pas
     */
    public static function delete(int $id): void
    {
        // Validation de l'ID
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        
        // Exécution de la requête de suppression
        $sql = "DELETE FROM filieres WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        
        // Vérification que la suppression a bien affecté une ligne
        if ($stmt->rowCount() === 0) {
            throw new Exception("Filière introuvable");
        }
    }
}