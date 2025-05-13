<?php
// enos/eno.php

// session_start();
require_once __DIR__ . '/EnoController.php';

$ctrl = new EnoController();
$enos = $ctrl->list();
$zones = $ctrl->getAllZones();
?>

<div class="container py-5">
    <div id="eno-message"></div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Gestion des enos</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            <i class="bi bi-plus"></i>
            Nouvel eno
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body px-3">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Zone</th>
                        <th>Disponible</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enos as $e): ?>
                        <tr data-id="<?= $e['id'] ?>">
                            <td><?= htmlspecialchars($e['code'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($e['nom'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($e['zone_nom'], ENT_QUOTES) ?></td>
                            <td><?= $e['estDisponible'] ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>' ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($e['created_at'])) ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" data-id="<?= $e['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalDetail"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning" data-id="<?= $e['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $e['id'] ?>"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvel eno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form-add">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Adresse</label>
                                <input type="text" name="adresse" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="text" name="telephone" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Zone</label>
                        <select name="zone_id" class="form-select" required>
                            <option value="">Sélectionner une zone</option>
                            <?php foreach ($zones as $zone): ?>
                                <option value="<?= $zone['id'] ?>"><?= htmlspecialchars($zone['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="addDisponible" name="estDisponible" checked>
                        <label class="form-check-label" for="addDisponible">Disponible</label>
                    </div>
                    <input type="hidden" name="action" value="add">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'eno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form-edit">
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="editId">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" id="editCode" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" id="editNom" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Adresse</label>
                                <input type="text" name="adresse" id="editAdresse" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="text" name="telephone" id="editTelephone" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Zone</label>
                        <select name="zone_id" id="editZoneId" class="form-select" required>
                            <option value="">Sélectionner une zone</option>
                            <?php foreach ($zones as $zone): ?>
                                <option value="<?= $zone['id'] ?>"><?= htmlspecialchars($zone['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="editDisponible" name="estDisponible">
                        <label class="form-check-label" for="editDisponible">Disponible</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de détail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Détails de l'eno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Le contenu sera chargé dynamiquement -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Formulaire d'ajout
        document.getElementById('form-add').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('<?= BASE_URL ?>/views/admin/enos/eno-process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('eno-message').innerHTML =
                            `<div class="alert alert-success">${data.message}</div>`;
                        if (data.reload) {
                            location.reload();
                        }
                        // Fermer le modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalAdd'));
                        modal.hide();
                    } else {
                        document.getElementById('eno-message').innerHTML =
                            `<div class="alert alert-danger">${data.error}</div>`;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('eno-message').innerHTML =
                        '<div class="alert alert-danger">Une erreur est survenue</div>';
                });
        });

        // Formulaire d'édition
        document.getElementById('form-edit').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('<?= BASE_URL ?>/views/admin/enos/eno-process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('eno-message').innerHTML =
                            `<div class="alert alert-success">${data.message}</div>`;
                        if (data.reload) {
                            location.reload();
                        }
                        // Fermer le modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEdit'));
                        modal.hide();
                    } else {
                        document.getElementById('eno-message').innerHTML =
                            `<div class="alert alert-danger">${data.error}</div>`;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('eno-message').innerHTML =
                        '<div class="alert alert-danger">Une erreur est survenue</div>';
                });
        });

        // Boutons d'édition
        document.querySelectorAll('[data-bs-target="#modalEdit"]').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;

                fetch(`<?= BASE_URL ?>/views/admin/enos/eno-process.php?action=get&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('editId').value = data.eno.id;
                            document.getElementById('editCode').value = data.eno.code;
                            document.getElementById('editNom').value = data.eno.nom;
                            document.getElementById('editAdresse').value = data.eno.adresse || '';
                            document.getElementById('editTelephone').value = data.eno.telephone || '';
                            document.getElementById('editZoneId').value = data.eno.zone_id;
                            document.getElementById('editDisponible').checked = data.eno.estDisponible == 1;
                        } else {
                            document.getElementById('eno-message').innerHTML =
                                `<div class="alert alert-danger">${data.error}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        document.getElementById('eno-message').innerHTML =
                            '<div class="alert alert-danger">Une erreur est survenue</div>';
                    });
            });
        });

        // Boutons de suppression
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Êtes-vous sûr de vouloir supprimer cet eno ?')) {
                    const id = this.dataset.id;
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id', id);

                    fetch('<?= BASE_URL ?>/views/admin/enos/eno-process.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('eno-message').innerHTML =
                                    `<div class="alert alert-success">${data.message}</div>`;
                                // Supprimer la ligne du tableau
                                document.querySelector(`tr[data-id="${id}"]`).remove();
                            } else {
                                document.getElementById('eno-message').innerHTML =
                                    `<div class="alert alert-danger">${data.error}</div>`;
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            document.getElementById('eno-message').innerHTML =
                                '<div class="alert alert-danger">Une erreur est survenue</div>';
                        });
                }
            });
        });

        // Modal de détails
        document.querySelectorAll('[data-bs-target="#modalDetail"]').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;

                fetch(`<?= BASE_URL ?>/views/admin/enos/Eno-details.php?id=${id}`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modalBody').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        document.getElementById('modalBody').innerHTML =
                            '<div class="alert alert-danger">Une erreur est survenue lors du chargement des détails</div>';
                    });
            });
        });
    });
</script>