<?php
// poles/pole.php

// session_start();
require_once __DIR__ . '/PoleController.php';

$ctrl = new PoleController();
$poles = $ctrl->list();
?>

<div class="container py-5">
    <div id="pole-message"></div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Gestion des pôles</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            <i class="bi bi-plus"></i>
            Nouveau pôle
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body px-3">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Code pôle</th>
                        <th>Nom</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($poles as $p): ?>
                        <tr data-id="<?= $p['id'] ?>">
                            <td><?= htmlspecialchars($p['code'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($p['nom'], ENT_QUOTES) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" data-id="<?= $p['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalDetail"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning" data-id="<?= $p['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
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
                <h5 class="modal-title">Nouveau pôle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form-add">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" class="form-control" maxlength="10" required>
                        <small class="form-text text-muted">Code unique du pôle (ex: STN, LSHE, SEJA)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le pôle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form-edit">
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label class="form-label">Code</label>
                        <input type="text" name="code" id="editCode" class="form-control" maxlength="10" required>
                        <small class="form-text text-muted">Code unique du pôle (ex: STN, LSHE, SEJA)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" id="editNom" class="form-control" required>
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

<!-- Modal de détail -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Détails du pôle</h5>
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

        // Gestion des attributs ARIA pour les modals
        const modals = document.querySelectorAll('.modal');
        
        modals.forEach(modal => {
            // Lors de l'ouverture du modal
            modal.addEventListener('show.bs.modal', function() {
                // Supprimer aria-hidden quand le modal s'ouvre
                this.removeAttribute('aria-hidden');
            });
            
            // Lors de la fermeture du modal
            modal.addEventListener('hidden.bs.modal', function() {
                // Remettre aria-hidden quand le modal se ferme
                this.setAttribute('aria-hidden', 'true');
            });
        });
        
        // Formulaire d'ajout
        document.getElementById('form-add').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('<?= BASE_URL ?>/views/admin/poles/pole-process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('pole-message').innerHTML = 
                        `<div class="alert alert-success">${data.message}</div>`;
                    // Fermer le modal et recharger la page
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalAdd'));
                    modal.hide();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    document.getElementById('pole-message').innerHTML = 
                        `<div class="alert alert-danger">${data.error}</div>`;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                document.getElementById('pole-message').innerHTML = 
                    '<div class="alert alert-danger">Une erreur est survenue</div>';
            });
        });

        // Formulaire de modification
        document.getElementById('form-edit').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('<?= BASE_URL ?>/views/admin/poles/pole-process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('pole-message').innerHTML = 
                        `<div class="alert alert-success">${data.message}</div>`;
                    // Fermer le modal et recharger la page
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEdit'));
                    modal.hide();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    document.getElementById('pole-message').innerHTML = 
                        `<div class="alert alert-danger">${data.error}</div>`;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                document.getElementById('pole-message').innerHTML = 
                    '<div class="alert alert-danger">Une erreur est survenue</div>';
            });
        });

        // Boutons de suppression
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Êtes-vous sûr de vouloir supprimer ce pôle ?')) {
                    const id = this.closest('tr').dataset.id;
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id', id);
                    
                    fetch('<?= BASE_URL ?>/views/admin/poles/pole-process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('pole-message').innerHTML = 
                                `<div class="alert alert-success">${data.message}</div>`;
                            // Supprimer la ligne du tableau
                            this.closest('tr').remove();
                        } else {
                            document.getElementById('pole-message').innerHTML = 
                                `<div class="alert alert-danger">${data.error}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        document.getElementById('pole-message').innerHTML = 
                            '<div class="alert alert-danger">Une erreur est survenue</div>';
                    });
                }
            });
        });

        // Modal de détails
        document.querySelectorAll('[data-bs-target="#modalDetail"]').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                
                fetch(`<?= BASE_URL ?>/views/admin/poles/Pole-detail.php?id=${id}`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('modalBody').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        document.getElementById('modalBody').innerHTML = 
                            '<div class="alert alert-danger">Erreur lors du chargement des détails</div>';
                    });
            });
        });

        // Chargement des données pour le modal d'édition
        document.querySelectorAll('[data-bs-target="#modalEdit"]').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const row = this.closest('tr');
                const code = row.cells[0].textContent;
                const nom = row.cells[1].textContent;
                
                // Récupérer la description complète via une requête AJAX
                fetch(`<?= BASE_URL ?>/views/admin/poles/Pole-detail.php?id=${id}`)
                    .then(response => response.text())
                    .then(html => {
                        // Créer un élément temporaire pour parser le HTML
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = html;
                        
                        // Extraire la description
                        const descriptionElement = tempDiv.querySelector('p:nth-child(3)');
                        let description = '';
                        if (descriptionElement) {
                            description = descriptionElement.textContent.replace('Description :', '').trim();
                            if (description === 'Non spécifiée') {
                                description = '';
                            }
                        }
                        
                        document.getElementById('editId').value = id;
                        document.getElementById('editCode').value = code;
                        document.getElementById('editNom').value = nom;
                        document.getElementById('editDescription').value = description;
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors du chargement des données');
                    });
            });
        });
    });
</script>