<?php
// roles/RoleController.php
// Le RoleController délègue toute la logique à RoleModel.

require_once __DIR__ . '/RoleModel.php';

class RoleController
{
    /** Récupère tous les rôles */
    public function list(): array
    {
        return RoleModel::fetchAll();
    }

    /** Récupère un rôle par son ID */
    public function view(int $id): ?array
    {
        return RoleModel::find($id);
    }

    /**
     * Ajoute un rôle
     *
     * @param string $nom
     * @param int    $createdBy
     * @throws Exception
     */
    public function add(string $nom, int $createdBy): void
    {
        RoleModel::create($nom, $createdBy);
    }

    /**
     * Modifie un rôle existant
     *
     * @param int    $id
     * @param string $nom
     * @param int    $updatedBy
     * @throws Exception
     */
    public function edit(int $id, string $nom, int $updatedBy): void
    {
        RoleModel::update($id, $nom, $updatedBy);
    }

    /**
     * Supprime un rôle
     *
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id): void
    {
        RoleModel::delete($id);
    }
}