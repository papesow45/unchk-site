<?php
// enos/EnoModel.php
/**
 * Modèle de données pour la gestion des ENOs (Établissements Nationaux d'Orientation)
 * Ce fichier contient toutes les opérations CRUD (Create, Read, Update, Delete)
 * ainsi que des fonctions utilitaires pour la gestion des ENOs
 */

// Inclusion du fichier de configuration de la base de données qui contient la fonction getPDO()
require_once __DIR__ . '../../../../config/db.php';  // charge getPDO()

/**
 * Classe EnoModel - Gère toutes les interactions avec la table 'enos' de la base de données
 * Utilise des méthodes statiques pour faciliter l'accès sans instanciation
 */
class EnoModel
{
    /**
     * Récupère tous les ENOs de la base de données avec les informations de leur zone
     * Les résultats sont triés par date de création (du plus récent au plus ancien)
     * 
     * @return array Tableau contenant tous les ENOs avec leurs informations complètes
     */
    public static function fetchAll(): array
    {
        // Requête SQL avec jointure pour récupérer les informations de la zone associée à chaque ENO
        $sql = "SELECT e.id, e.code, e.nom, e.adresse, e.telephone, e.zone_id, z.nom as zone_nom, 
                e.estDisponible, e.created_at, e.created_by, e.updated_at, e.updated_by
                FROM enos e
                JOIN zones z ON e.zone_id = z.id
                ORDER BY e.created_at DESC";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Recherche un ENO spécifique par son identifiant
     * 
     * @param int $id Identifiant unique de l'ENO à rechercher
     * @return array|null Retourne les données de l'ENO ou null si non trouvé
     */
    public static function find(int $id): ?array
    {
        // Requête SQL avec jointure et paramètre pour récupérer un ENO spécifique
        $sql = "SELECT e.id, e.code, e.nom, e.adresse, e.telephone, e.zone_id, z.nom as zone_nom, 
                e.estDisponible, e.created_at, e.created_by, e.updated_at, e.updated_by
                FROM enos e
                JOIN zones z ON e.zone_id = z.id
                WHERE e.id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        $eno = $stmt->fetch();
        // Retourne les données de l'ENO ou null si non trouvé
        return $eno ?: null;
    }

    /**
     * Récupère toutes les zones disponibles pour le formulaire de création/modification d'ENO
     * Ne retourne que les zones marquées comme disponibles (estDisponible = 1)
     * 
     * @return array Tableau contenant toutes les zones disponibles, triées par nom
     */
    public static function getAllZones(): array
    {
        $sql = "SELECT id, nom FROM zones WHERE estDisponible = 1 ORDER BY nom";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Crée un nouvel ENO dans la base de données après validation des données
     *
     * @param string $code Code unique identifiant l'ENO (doit être unique dans la base)
     * @param string $nom Nom complet de l'ENO
     * @param string $adresse Adresse physique de l'ENO
     * @param string $telephone Numéro de téléphone de contact de l'ENO
     * @param int $zone_id Identifiant de la zone à laquelle l'ENO est rattaché
     * @param bool $estDisponible Statut de disponibilité de l'ENO (actif/inactif)
     * @param int $createdBy ID de l'utilisateur qui crée l'enregistrement (pour l'audit)
     * @throws Exception Si les données ne sont pas valides ou si le code existe déjà
     */
    public static function create(string $code, string $nom, string $adresse, string $telephone, 
                                 int $zone_id, bool $estDisponible, int $createdBy): void
    {
        // Validation des données obligatoires
        if ($code === '') {
            throw new Exception("Le code de l'eno est requis");
        }
        if ($nom === '') {
            throw new Exception("Le nom de l'eno est requis");
        }
        if ($zone_id <= 0) {
            throw new Exception("La zone est requise");
        }

        // Vérification de l'unicité du code ENO
        if (self::codeExists($code)) {
            throw new Exception("Ce code d'eno existe déjà");
        }

        // Préparation et exécution de la requête d'insertion
        $sql = "INSERT INTO enos (code, nom, adresse, telephone, zone_id, estDisponible, created_at, created_by)
                VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$code, $nom, $adresse, $telephone, $zone_id, $estDisponible ? 1 : 0, $createdBy]);
    }

    /**
     * Vérifie si un code d'ENO existe déjà dans la base de données
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
            $sql = "SELECT COUNT(*) FROM enos WHERE code = ? AND id != ?";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute([$code, $excludeId]);
        } else {
            // Cas d'une création, on vérifie simplement si le code existe
            $sql = "SELECT COUNT(*) FROM enos WHERE code = ?";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute([$code]);
        }
        
        // Retourne true si au moins un enregistrement a été trouvé
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Met à jour les informations d'un ENO existant après validation
     *
     * @param int $id Identifiant de l'ENO à mettre à jour
     * @param string $code Code unique de l'ENO (peut être le même que l'original)
     * @param string $nom Nouveau nom de l'ENO
     * @param string $adresse Nouvelle adresse de l'ENO
     * @param string $telephone Nouveau numéro de téléphone
     * @param int $zone_id Nouvelle zone d'affectation
     * @param bool $estDisponible Nouveau statut de disponibilité
     * @param int $updatedBy ID de l'utilisateur effectuant la modification (pour l'audit)
     * @throws Exception Si les données sont invalides, si l'ENO n'existe pas, ou si le code existe déjà
     */
    public static function update(int $id, string $code, string $nom, string $adresse, string $telephone, 
                                 int $zone_id, bool $estDisponible, int $updatedBy): void
    {
        // Validation des données obligatoires
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        if ($code === '') {
            throw new Exception("Le code de l'eno est requis");
        }
        if ($nom === '') {
            throw new Exception("Le nom de l'eno est requis");
        }
        if ($zone_id <= 0) {
            throw new Exception("La zone est requise");
        }

        // Vérification de l'unicité du code (en excluant l'ENO actuel)
        if (self::codeExists($code, $id)) {
            throw new Exception("Ce code d'eno existe déjà");
        }

        // Préparation et exécution de la requête de mise à jour
        $sql = "UPDATE enos
                SET code = ?, nom = ?, adresse = ?, telephone = ?, zone_id = ?, 
                    estDisponible = ?, updated_at = NOW(), updated_by = ?
                WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$code, $nom, $adresse, $telephone, $zone_id, $estDisponible ? 1 : 0, $updatedBy, $id]);

        // Vérification que la mise à jour a bien affecté une ligne
        if ($stmt->rowCount() === 0) {
            throw new Exception("Eno introuvable ou non modifié");
        }
    }

    /**
     * Supprime un ENO de la base de données
     * 
     * @param int $id Identifiant de l'ENO à supprimer
     * @throws Exception Si l'ID est invalide ou si l'ENO n'existe pas
     */
    public static function delete(int $id): void
    {
        // Validation de l'ID
        if ($id <= 0) {
            throw new Exception("ID invalide");
        }
        
        // Exécution de la requête de suppression
        $sql = "DELETE FROM enos WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        
        // Vérification que la suppression a bien affecté une ligne
        if ($stmt->rowCount() === 0) {
            throw new Exception("Eno introuvable");
        }
    }
}