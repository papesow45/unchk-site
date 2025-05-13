<?php
// zones/zone-details.php

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

require_once __DIR__ . '/ZoneModel.php';
$zone = ZoneModel::find($id);

if (!$zone) {
    echo "<div class='alert alert-warning'>Zone non trouvée</div>";
    exit;
}
?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Détails de la zone #<?= htmlspecialchars($zone['id']) ?></h5>
    <p><strong>Nom :</strong> <?= htmlspecialchars($zone['nom']) ?></p>
    <p><strong>Créée le :</strong> <?= date('d/m/Y H:i', strtotime($zone['created_at'])) ?></p>
  </div>
</div>
