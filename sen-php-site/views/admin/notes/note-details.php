<?php
// views/admin/notes/note-details.php

require_once __DIR__ . '/NoteController.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo '<div class="alert alert-danger">ID de la note non spécifié</div>';
    exit;
}

$ctrl = new NoteController();
$note = $ctrl->getById($_GET['id']);

if (!$note) {
    echo '<div class="alert alert-danger">Note non trouvée</div>';
    exit;
}
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Note de <?= htmlspecialchars($note['prenom'] . ' ' . $note['nom']) ?> (<?= htmlspecialchars($note['INE']) ?>)</h5>
        <p class="card-text"><strong>Matière :</strong> <?= htmlspecialchars($note['matiere_nom']) ?> (<?= htmlspecialchars($note['matiere_code']) ?>)</p>
        <p class="card-text"><strong>Note :</strong> <?= htmlspecialchars($note['note']) ?></p>
        <p class="card-text"><strong>Créé le :</strong> <?= date('d/m/Y H:i', strtotime($note['created_at'])) ?></p>
        <?php if (!empty($note['updated_at'])): ?>
            <p class="card-text"><strong>Dernière mise à jour :</strong> <?= date('d/m/Y H:i', strtotime($note['updated_at'])) ?></p>
        <?php endif; ?>
    </div>
</div>