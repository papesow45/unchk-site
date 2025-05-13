<?php
// roles/Role-detail.php

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

require_once __DIR__ . '/RoleModel.php';
$role = RoleModel::find($id);

if (!$role) {
    echo "<div class='alert alert-warning'>Rôle non trouvé</div>";
    exit;
}
?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Détails du rôle #<?= htmlspecialchars($role['id']) ?></h5>
    <p><strong>Nom :</strong> <?= htmlspecialchars($role['nom']) ?></p>
    <p><strong>Créé le :</strong> <?= date('d/m/Y H:i', strtotime($role['created_at'])) ?></p>
  </div>
</div>