<?php
// poles/Pole-detail.php

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo "<div class='alert alert-danger'>Accès refusé</div>";
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    echo "<div class='alert alert-warning'>ID invalide</div>";
    exit;
}

require_once __DIR__ . '/PoleModel.php';
$pole = PoleModel::find($id);

if (!$pole) {
    echo "<div class='alert alert-warning'>Pôle non trouvé</div>";
    exit;
}
?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Détails du pôle #<?= htmlspecialchars($pole['id']) ?></h5>
    <p><strong>Nom :</strong> <?= htmlspecialchars($pole['nom']) ?></p>
    <p><strong>Description :</strong> <?= htmlspecialchars($pole['description'] ?? 'Non spécifiée') ?></p>
    <p><strong>Créé le :</strong> <?= date('d/m/Y H:i', strtotime($pole['created_at'])) ?></p>
    <?php if ($pole['updated_at']): ?>
    <p><strong>Dernière modification :</strong> <?= date('d/m/Y H:i', strtotime($pole['updated_at'])) ?></p>
    <?php endif; ?>
  </div>
</div>