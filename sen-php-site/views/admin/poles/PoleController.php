<?php
// poles/PoleController.php
// Le PoleController délègue toute la logique à PoleModel.

require_once __DIR__ . '/PoleModel.php';

class PoleController
{
    /** Récupère tous les pôles */
    public function list(): array
    {
        return PoleModel::fetchAll();
    }

    /** Récupère un pôle par son ID */
    public function view(int $id): ?array
    {
        return PoleModel::find($id);
    }

    /**
     * Ajoute un pôle
     *
     * @param string $code
     * @param string $nom
     * @param string $description
     * @param int    $createdBy
     * @throws Exception
     */
    public function add(string $code, string $nom, string $description, int $createdBy): void
    {
        PoleModel::create($code, $nom, $description, $createdBy);
    }

    /**
     * Modifie un pôle existant
     *
     * @param int    $id
     * @param string $code
     * @param string $nom
     * @param string $description
     * @param int    $updatedBy
     * @throws Exception
     */
    public function edit(int $id, string $code, string $nom, string $description, int $updatedBy): void
    {
        PoleModel::update($id, $code, $nom, $description, $updatedBy);
    }

    /**
     * Supprime un pôle
     *
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id): void
    {
        PoleModel::delete($id);
    }
}