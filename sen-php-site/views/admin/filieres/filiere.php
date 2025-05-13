<?php
// filieres/filiere.php

// session_start();
require_once __DIR__ . '/FiliereController.php';

$ctrl = new FiliereController();
$filieres = $ctrl->list();
$poles = $ctrl->getAllPoles();
?>

<div class="container py-5">
    <div id="filiere-message"></div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Gestion des filières</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            <i class="bi bi-plus"></i>
            Nouvelle filière
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body px-3">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Pôle</th>
                        <th>Disponible</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filieres as $f): ?>
                        <tr data-id="<?= $f['id'] ?>">
                            <td><?= htmlspecialchars($f['code'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($f['nom'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($f['pole_code'], ENT_QUOTES) ?></td>
                            <td><?= $f['estDisponible'] ? '<span class="badge bg-success">Oui</span>' : '<span class="badge bg-secondary">Non</span>' ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($f['created_at'])) ?></td>
                            <td class="d-flex gap-3">
                                <button class="btn btn-sm btn-info btn-details" data-id="<?= $f['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalDetails"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning" data-id="<?= $f['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $f['id'] ?>"><i class="fas fa-trash"></i></button>
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
                <h5 class="modal-title">Nouvelle filière</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form-add">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" class="form-control" required>
                                <small class="form-text text-muted">Code unique de la filière (ex: INFO, RESX)</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pôle</label>
                                <select name="pole_id" class="form-select" required>
                                    <option value="">Sélectionner un pôle</option>
                                    <?php foreach ($poles as $pole): ?>
                                        <option value="<?= $pole['id'] ?>"><?= htmlspecialchars($pole['nom']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="addDisponible" name="estDisponible" checked>
                                <label class="form-check-label" for="addDisponible">Disponible</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
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
                <h5 class="modal-title">Modifier la filière</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form-edit">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="editId">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" id="editCode" class="form-control" required>
                                <small class="form-text text-muted">Code unique de la filière (ex: INFO, RESX)</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" id="editNom" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pôle</label>
                                <select name="pole_id" id="editPoleId" class="form-select" required>
                                    <option value="">Sélectionner un pôle</option>
                                    <?php foreach ($poles as $pole): ?>
                                        <option value="<?= $pole['id'] ?>"><?= htmlspecialchars($pole['nom']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" id="editDisponible" name="estDisponible">
                                <label class="form-check-label" for="editDisponible">Disponible</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
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

<!-- Modal Details -->
<div class="modal fade" id="modalDetails" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de la filière</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Code:</label>
                            <p id="detailCode"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Nom:</label>
                            <p id="detailNom"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Pôle:</label>
                            <p id="detailPole"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Disponible:</label>
                            <p id="detailDisponible"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Créé le:</label>
                            <p id="detailCreatedAt"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Créé par:</label>
                            <p id="detailCreatedBy"></p>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Description:</label>
                    <p id="detailDescription"></p>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Dernière mise à jour:</label>
                    <p id="detailUpdatedAt"></p>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Mis à jour par:</label>
                    <p id="detailUpdatedBy"></p>
                </div>
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

            fetch('<?= BASE_URL ?>/views/admin/filieres/filiere-process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('filiere-message').innerHTML = 
                            `<div class="alert alert-success">${data.message}</div>`;
                        // Fermer le modal et recharger la page
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalAdd'));
                        modal.hide();
                        if (data.reload) {
                            location.reload();
                        } else {
                            setTimeout(() => location.reload(), 1000);
                        }
                    } else {
                        document.getElementById('filiere-message').innerHTML = 
                            `<div class="alert alert-danger">${data.error}</div>`;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('filiere-message').innerHTML = 
                        '<div class="alert alert-danger">Une erreur est survenue</div>';
                });
        });

        // Formulaire de modification
        document.getElementById('form-edit').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('<?= BASE_URL ?>/views/admin/filieres/filiere-process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('filiere-message').innerHTML = 
                        `<div class="alert alert-success">${data.message}</div>`;
                    // Fermer le modal et recharger la page
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEdit'));
                    modal.hide();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    document.getElementById('filiere-message').innerHTML = 
                        `<div class="alert alert-danger">${data.error}</div>`;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                document.getElementById('filiere-message').innerHTML = 
                    '<div class="alert alert-danger">Une erreur est survenue</div>';
            });
        });

        // Boutons de suppression
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')) {
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id', id);
                    
                    fetch('<?= BASE_URL ?>/views/admin/filieres/filiere-process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('filiere-message').innerHTML = 
                                `<div class="alert alert-success">${data.message}</div>`;
                            // Recharger la page
                            if (data.reload) {
                                location.reload();
                            } else {
                                setTimeout(() => location.reload(), 1000);
                            }
                        } else {
                            document.getElementById('filiere-message').innerHTML = 
                                `<div class="alert alert-danger">${data.error}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        document.getElementById('filiere-message').innerHTML = 
                            '<div class="alert alert-danger">Une erreur est survenue</div>';
                    });
                }
            });
        });

        // Chargement des données pour l'édition
        document.querySelectorAll('[data-bs-target="#modalEdit"]').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                fetch(`<?= BASE_URL ?>/views/admin/filieres/filiere-process.php?action=get&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const filiere = data.filiere;
                            document.getElementById('editId').value = filiere.id;
                            document.getElementById('editCode').value = filiere.code;
                            document.getElementById('editNom').value = filiere.nom;
                            document.getElementById('editDescription').value = filiere.description;
                            document.getElementById('editPoleId').value = filiere.pole_id;
                            document.getElementById('editDisponible').checked = filiere.estDisponible == 1;
                        } else {
                            alert(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors du chargement des données');
                    });
            });
        });

        // Chargement des détails pour le modal
        document.querySelectorAll('.btn-details').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                fetch(`<?= BASE_URL ?>/views/admin/filieres/filiere-process.php?action=get&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const filiere = data.filiere;
                            document.getElementById('detailCode').textContent = filiere.code;
                            document.getElementById('detailNom').textContent = filiere.nom;
                            document.getElementById('detailPole').textContent = filiere.pole_nom;
                            document.getElementById('detailDescription').textContent = filiere.description || 'Aucune description';
                            document.getElementById('detailDisponible').textContent = filiere.estDisponible == 1 ? 'Oui' : 'Non';
                            document.getElementById('detailCreatedAt').textContent = new Date(filiere.created_at).toLocaleString('fr-FR');
                            document.getElementById('detailCreatedBy').textContent = filiere.created_by_name || 'Non spécifié';
                            document.getElementById('detailUpdatedAt').textContent = filiere.updated_at ? new Date(filiere.updated_at).toLocaleString('fr-FR') : 'Jamais';
                            document.getElementById('detailUpdatedBy').textContent = filiere.updated_by_name || 'Non spécifié';
                        } else {
                            alert(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Une erreur est survenue lors du chargement des détails');
                    });
            });
        });
    });
</script>
