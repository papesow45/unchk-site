<?php
// views/admin/enos/Eno-details.php

require_once __DIR__ . '/EnoController.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<div class="alert alert-danger">ID de l\'ENO non spécifié</div>';
    exit;
}

$ctrl = new EnoController();
$eno = $ctrl->getById($_GET['id']);

if (!$eno) {
    echo '<div class="alert alert-danger">ENO non trouvé</div>';
    exit;
}
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($eno['nom']) ?></h5>
        <p class="card-text"><strong>Code:</strong> <?= htmlspecialchars($eno['code']) ?></p>
        <p class="card-text"><strong>Zone:</strong> <?= htmlspecialchars($eno['zone_nom']) ?></p>
        <p class="card-text"><strong>Adresse:</strong> <?= htmlspecialchars($eno['adresse'] ?: 'Non spécifiée') ?></p>
        <p class="card-text"><strong>Téléphone:</strong> <?= htmlspecialchars($eno['telephone'] ?: 'Non spécifié') ?></p>
        <p class="card-text"><strong>Disponible:</strong> <?= $eno['estDisponible'] ? 'Oui' : 'Non' ?></p>
        <p class="card-text"><strong>Créé le:</strong> <?= date('d/m/Y H:i', strtotime($eno['created_at'])) ?></p>
        <?php if ($eno['updated_at']): ?>
            <p class="card-text"><strong>Dernière mise à jour:</strong> <?= date('d/m/Y H:i', strtotime($eno['updated_at'])) ?></p>
        <?php endif; ?>
    </div>
</div>