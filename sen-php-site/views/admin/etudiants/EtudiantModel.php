<?php
// etudiants/EtudiantModel.php
/**
 * Modèle de données pour la gestion des étudiants
 * Ce fichier contient toutes les opérations CRUD (Create, Read, Update, Delete)
 * ainsi que des fonctions utilitaires pour la gestion des étudiants
 */

require_once __DIR__ . '../../../../config/db.php';  // charge getPDO()

class EtudiantModel {

    /**
     * Récupère tous les étudiants de la base de données avec les informations associées
     * Les résultats sont triés par date de création (du plus récent au plus ancien)
     * 
     * @return array Tableau contenant tous les étudiants avec leurs informations complètes
     */
    public static function fetchAll(): array
    {
        $sql = "SELECT e.id, e.prenom, e.nom, e.email, e.telephone, e.age, e.sexe, e.INE,
                    r.nom as role_nom, p.code as pole_code, f.nom as nom_filiere, z.nom as nom_zone,
                    en.nom as nom_eno, e.created_at, e.created_by, e.updated_at
                FROM etudiants e
                JOIN poles p ON e.pole_id = p.id
                JOIN roles r ON e.role_id = r.id
                JOIN filieres f ON e.filiere_id = f.id
                JOIN zones z ON e.zone_id = z.id
                JOIN enos en ON e.eno_id = en.id
                ORDER BY e.created_at DESC";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Recherche un étudiant spécifique par son identifiant
     * Inclut les informations sur les entités associées et les administrateurs qui ont créé/modifié l'étudiant
     * 
     * @param int $id Identifiant unique de l'étudiant à rechercher
     * @return array|null Retourne les données de l'étudiant ou null si non trouvé
     */
    public static function find(int $id): ?array
    {
        $sql = "SELECT e.id, e.prenom, e.nom, e.email, e.telephone, e.age, e.sexe, e.INE,
                    r.nom as role_nom, p.code as pole_code, f.nom as nom_filiere, z.nom as nom_zone,
                    en.nom as nom_eno, e.created_at, c.nom as created_by_name, e.updated_at, u.nom as updated_by_name
                FROM etudiants e
                JOIN poles p ON e.pole_id = p.id
                JOIN roles r ON e.role_id = r.id
                JOIN filieres f ON e.filiere_id = f.id
                JOIN zones z ON e.zone_id = z.id
                JOIN enos en ON e.eno_id = en.id
                LEFT JOIN admins c ON e.created_by = c.id
                LEFT JOIN admins u ON e.updated_by = u.id
                WHERE e.id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        $etudiant = $stmt->fetch();
        return $etudiant ?: null;
    }

    /**
     * Récupère tous les pôles disponibles pour le formulaire de création/modification d'étudiant
     * 
     * @return array Tableau contenant tous les pôles, triés par code
     */
    public static function getAllPoles(): array
    {
        $sql = "SELECT id, code, nom FROM poles ORDER BY code";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère toutes les zones disponibles pour le formulaire de création/modification d'étudiant
     * 
     * @return array Tableau contenant toutes les zones, triées par nom
     */
    public static function getAllZones(): array
    {
        $sql = "SELECT id, nom FROM zones WHERE estDisponible = 1 ORDER BY nom";
        $stmt = getPDO()->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère toutes les filières disponibles pour le formulaire de création/modification d'étudiant
     * 
     * @param int|null $pole_id Optionnel: filtre les filières par pôle
     * @return array Tableau contenant toutes les filières, triées par nom
     */
    public static function getAllFilieres(?int $pole_id = null): array
    {
        if ($pole_id) {
            $sql = "SELECT id, nom FROM filieres WHERE estDisponible = 1 AND pole_id = ? ORDER BY nom";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute([$pole_id]);
        } else {
            $sql = "SELECT id, nom FROM filieres WHERE estDisponible = 1 ORDER BY nom";
            $stmt = getPDO()->query($sql);
        }
        return $stmt->fetchAll();
    }

    /**
     * Récupère tous les ENOs disponibles pour le formulaire de création/modification d'étudiant
     * 
     * @param int|null $zone_id Optionnel: filtre les ENOs par zone
     * @return array Tableau contenant tous les ENOs, triés par nom
     */
    public static function getAllEnos(?int $zone_id = null): array
    {
        if ($zone_id) {
            $sql = "SELECT id, nom FROM enos WHERE estDisponible = 1 AND zone_id = ? ORDER BY nom";
            $stmt = getPDO()->prepare($sql);
            $stmt->execute([$zone_id]);
        } else {
            $sql = "SELECT id, nom FROM enos WHERE estDisponible = 1 ORDER BY nom";
            $stmt = getPDO()->query($sql);
        }
        return $stmt->fetchAll();
    }

    /**
     * Vérifie si un email existe déjà
     * 
     * @param string $email
     * @param int|null $excludeId ID à exclure de la vérification (pour les mises à jour)
     * @return bool
     */
    private static function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM etudiants WHERE email = ?";
        $params = [$email];
        
        if ($excludeId !== null) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = getPDO()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Vérifie si un INE existe déjà
     * 
     * @param string $ine
     * @param int|null $excludeId ID à exclure de la vérification (pour les mises à jour)
     * @return bool
     */
    private static function ineExists(string $ine, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM etudiants WHERE INE = ?";
        $params = [$ine];
        
        if ($excludeId !== null) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = getPDO()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Crée un nouvel étudiant dans la base de données après validation des données
     *
     * @param string $prenom Prénom de l'étudiant
     * @param string $nom Nom de famille de l'étudiant
     * @param string $email Email unique de l'étudiant
     * @param string $password Mot de passe (sera hashé)
     * @param string $telephone Numéro de téléphone
     * @param int $age Âge de l'étudiant
     * @param string $sexe Genre de l'étudiant (M ou F)
     * @param string $ine Identifiant National Étudiant unique
     * @param int $pole_id ID du pôle
     * @param int $filiere_id ID de la filière
     * @param int $zone_id ID de la zone
     * @param int $eno_id ID de l'ENO
     * @param int $createdBy ID de l'administrateur qui crée l'enregistrement
     * @throws Exception Si les données ne sont pas valides ou si l'email/INE existe déjà
     */
    public static function create(
        string $prenom, 
        string $nom, 
        string $email, 
        string $password, 
        string $telephone, 
        int $age, 
        string $sexe, 
        string $ine, 
        int $pole_id, 
        int $filiere_id, 
        int $zone_id, 
        int $eno_id, 
        int $createdBy
    ): void {
        // Validation des données
        if (empty($prenom) || empty($nom) || empty($email) || empty($password) || empty($ine)) {
            throw new Exception("Tous les champs obligatoires doivent être remplis");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide");
        }

        if (self::emailExists($email)) {
            throw new Exception("Cet email est déjà utilisé par un autre étudiant");
        }

        if (self::ineExists($ine)) {
            throw new Exception("Ce numéro INE est déjà utilisé par un autre étudiant");
        }

        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertion dans la base de données
        $sql = "INSERT INTO etudiants (prenom, nom, email, password, telephone, age, sexe, INE, 
                role_id, pole_id, filiere_id, zone_id, eno_id, created_by, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 2, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([
            $prenom, $nom, $email, $hashedPassword, $telephone, $age, $sexe, $ine,
            $pole_id, $filiere_id, $zone_id, $eno_id, $createdBy
        ]);
    }

    /**
     * Met à jour un étudiant existant
     *
     * @param int $id ID de l'étudiant à modifier
     * @param string $prenom Prénom de l'étudiant
     * @param string $nom Nom de famille de l'étudiant
     * @param string $email Email unique de l'étudiant
     * @param string|null $password Mot de passe (sera hashé) ou null si inchangé
     * @param string $telephone Numéro de téléphone
     * @param int $age Âge de l'étudiant
     * @param string $sexe Genre de l'étudiant (M ou F)
     * @param string $ine Identifiant National Étudiant unique
     * @param int $pole_id ID du pôle
     * @param int $filiere_id ID de la filière
     * @param int $zone_id ID de la zone
     * @param int $eno_id ID de l'ENO
     * @param int $updatedBy ID de l'administrateur qui modifie l'enregistrement
     * @throws Exception Si les données ne sont pas valides ou si l'email/INE existe déjà
     */
    public static function update(
        int $id,
        string $prenom, 
        string $nom, 
        string $email, 
        ?string $password, 
        string $telephone, 
        int $age, 
        string $sexe, 
        string $ine, 
        int $pole_id, 
        int $filiere_id, 
        int $zone_id, 
        int $eno_id, 
        int $updatedBy
    ): void {
        // Validation des données
        if (empty($prenom) || empty($nom) || empty($email) || empty($ine)) {
            throw new Exception("Tous les champs obligatoires doivent être remplis");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide");
        }

        if (self::emailExists($email, $id)) {
            throw new Exception("Cet email est déjà utilisé par un autre étudiant");
        }

        if (self::ineExists($ine, $id)) {
            throw new Exception("Ce numéro INE est déjà utilisé par un autre étudiant");
        }

        // Préparation de la requête SQL
        if ($password) {
            // Si un nouveau mot de passe est fourni, le hasher et l'inclure dans la mise à jour
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE etudiants SET 
                    prenom = ?, nom = ?, email = ?, password = ?, telephone = ?, age = ?, sexe = ?, INE = ?,
                    pole_id = ?, filiere_id = ?, zone_id = ?, eno_id = ?, updated_by = ?, updated_at = NOW()
                    WHERE id = ?";
            $params = [
                $prenom, $nom, $email, $hashedPassword, $telephone, $age, $sexe, $ine,
                $pole_id, $filiere_id, $zone_id, $eno_id, $updatedBy, $id
            ];
        } else {
            // Si aucun nouveau mot de passe n'est fourni, ne pas modifier le mot de passe existant
            $sql = "UPDATE etudiants SET 
                    prenom = ?, nom = ?, email = ?, telephone = ?, age = ?, sexe = ?, INE = ?,
                    pole_id = ?, filiere_id = ?, zone_id = ?, eno_id = ?, updated_by = ?, updated_at = NOW()
                    WHERE id = ?";
            $params = [
                $prenom, $nom, $email, $telephone, $age, $sexe, $ine,
                $pole_id, $filiere_id, $zone_id, $eno_id, $updatedBy, $id
            ];
        }

        // Exécution de la requête
        $stmt = getPDO()->prepare($sql);
        $stmt->execute($params);
        
        if ($stmt->rowCount() === 0) {
            throw new Exception("Aucune modification effectuée ou étudiant introuvable");
        }
    }

    /**
     * Supprime un étudiant
     *
     * @param int $id ID de l'étudiant à supprimer
     * @throws Exception Si l'étudiant ne peut pas être supprimé
     */
    public static function delete(int $id): void
    {
        if ($id <= 0) {
            throw new Exception("ID d'étudiant invalide");
        }

        // Vérifier si l'étudiant existe
        $sql = "SELECT COUNT(*) FROM etudiants WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() == 0) {
            throw new Exception("Étudiant introuvable");
        }

        // Supprimer l'étudiant
        $sql = "DELETE FROM etudiants WHERE id = ?";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$id]);
        
        if ($stmt->rowCount() === 0) {
            throw new Exception("Échec de la suppression de l'étudiant");
        }
    }

    /**
     * Récupère les filières disponibles pour un pôle spécifique
     * 
     * @param int $pole_id Identifiant du pôle
     * @return array Tableau des filières du pôle, triées par nom
     */
    public static function getFilieresByPole(int $pole_id): array
    {
        $sql = "SELECT id, nom 
                FROM filieres 
                WHERE pole_id = ? 
                AND estDisponible = 1 
                ORDER BY nom";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$pole_id]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les ENOs disponibles pour une zone spécifique
     * 
     * @param int $zone_id Identifiant de la zone
     * @return array Tableau des ENOs de la zone, triés par nom
     */
    public static function getEnosByZone(int $zone_id): array
    {
        $sql = "SELECT id, nom 
                FROM enos 
                WHERE zone_id = ? 
                AND estDisponible = 1 
                ORDER BY nom";
        $stmt = getPDO()->prepare($sql);
        $stmt->execute([$zone_id]);
        return $stmt->fetchAll();
    }

}


    