<?php
// zones/ZoneController.php
// Le ZoneController délègue toute la logique à ZoneModel.

require_once __DIR__ . '/ZoneModel.php';

class ZoneController
{
    /** Récupère toutes les zones */
    public function list(): array
    {
        return ZoneModel::fetchAll();
    }

    /** Récupère une zone par son ID */
    public function view(int $id): ?array
    {
        return ZoneModel::find($id);
    }

    /**
     * Ajoute une zone
     *
     * @param string $nom
     * @param bool   $estDisponible
     * @param int    $createdBy
     * @throws Exception
     */
    public function add(string $nom, bool $estDisponible, int $createdBy): void
    {
        ZoneModel::create($nom, $estDisponible, $createdBy);
    }

    /**
     * Modifie une zone existante
     *
     * @param int    $id
     * @param string $nom
     * @param bool   $estDisponible
     * @param int    $updatedBy
     * @throws Exception
     */
    public function edit(int $id, string $nom, bool $estDisponible, int $updatedBy): void
    {
        ZoneModel::update($id, $nom, $estDisponible, $updatedBy);
    }

    /**
     * Supprime une zone
     *
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id): void
    {
        ZoneModel::delete($id);
    }
}
