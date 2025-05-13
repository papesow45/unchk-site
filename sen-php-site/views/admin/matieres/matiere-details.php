<?php
// views/admin/matieres/matiere-details.php

require_once __DIR__ . '/MatiereController.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<div class="alert alert-danger">ID de la matière non spécifié</div>';
    exit;
}

$ctrl = new MatiereController();
$matiere = $ctrl->getById($_GET['id']);

if (!$matiere) {
    echo '<div class="alert alert-danger">Matière non trouvée</div>';
    exit;
}
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($matiere['nom']) ?></h5>
        <p class="card-text"><strong>Code :</strong> <?= htmlspecialchars($matiere['code']) ?></p>
        <p class="card-text"><strong>Filière :</strong> <?= htmlspecialchars($matiere['filiere_nom']) ?></p>
        <p class="card-text"><strong>Description :</strong> <?= $matiere['description'] ? htmlspecialchars($matiere['description']) : 'Non spécifiée' ?></p>
        <p class="card-text"><strong>Disponible :</strong> <?= $matiere['estDisponible'] ? 'Oui' : 'Non' ?></p>
        <p class="card-text"><strong>Créé le :</strong> <?= date('d/m/Y H:i', strtotime($matiere['created_at'])) ?></p>
        <?php if (!empty($matiere['updated_at'])): ?>
            <p class="card-text"><strong>Dernière mise à jour :</strong> <?= date('d/m/Y H:i', strtotime($matiere['updated_at'])) ?></p>
        <?php endif; ?>
    </div>
</div>