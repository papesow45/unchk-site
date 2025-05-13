<?php
// etudiants/etudiant.php

// session_start();
require_once __DIR__ . '/EtudiantController.php';

$ctrl = new EtudiantController();
$etudiants = $ctrl->list();
$poles = $ctrl->getAllPoles();
$zones = $ctrl->getAllZones();
$filieres = $ctrl->getAllFilieres();
$enos = $ctrl->getAllEnos();
?>

<div class="container py-5">
    <div id="etudiant-message"></div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Gestion des étudiants</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            <i class="bi bi-plus"></i>
            Nouvel étudiant
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body px-3">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>INE</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Filière</th>
                        <th>Zone</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($etudiants as $e): ?>
                        <tr data-id="<?= $e['id'] ?>">
                            <td><?= htmlspecialchars($e['INE'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($e['nom'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($e['prenom'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($e['email'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($e['nom_filiere'], ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($e['nom_zone'], ENT_QUOTES) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($e['created_at'])) ?></td>
                            <td class="d-flex gap-3">
                                <button class="btn btn-sm btn-info btn-details" data-id="<?= $e['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalDetails"><i class="fas fa-eye"></i></button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvel étudiant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form-add">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" name="telephone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Âge</label>
                                <input type="number" name="age" class="form-control" required min="16" max="100">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sexe</label>
                                <select name="sexe" class="form-select" required>
                                    <option value="">Sélectionner</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">INE</label>
                                <input type="text" name="INE" class="form-control" required>
                                <small class="form-text text-muted">Identifiant National Étudiant unique</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pôle</label>
                                <select name="pole_id" id="addPoleId" class="form-select" required>
                                    <option value="">Sélectionner un pôle</option>
                                    <?php foreach ($poles as $pole): ?>
                                        <option value="<?= $pole['id'] ?>"><?= htmlspecialchars($pole['nom']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Filière</label>
                                <select name="filiere_id" id="addFiliereId" class="form-select" required>
                                    <option value="">Sélectionner une filière</option>
                                    <?php foreach ($filieres as $filiere): ?>
                                        <option value="<?= $filiere['id'] ?>"><?= htmlspecialchars($filiere['nom']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Zone</label>
                                <select name="zone_id" id="addZoneId" class="form-select" required>
                                    <option value="">Sélectionner une zone</option>
                                    <?php foreach ($zones as $zone): ?>
                                        <option value="<?= $zone['id'] ?>"><?= htmlspecialchars($zone['nom']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ENO</label>
                                <select name="eno_id" id="addEnoId" class="form-select" required>
                                    <option value="">Sélectionner un ENO</option>
                                </select>
                            </div>
                        </div>
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
                <h5 class="modal-title">Modifier l'étudiant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form-edit">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="editId">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" id="editPrenom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" id="editNom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="editEmail" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" id="editPassword" class="form-control">
                                <small class="form-text text-muted">Laissez vide pour conserver le mot de passe actuel</small>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" name="telephone" id="editTelephone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Âge</label>
                                <input type="number" name="age" id="editAge" class="form-control" required min="16" max="100">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sexe</label>
                                <select name="sexe" id="editSexe" class="form-select" required>
                                    <option value="">Sélectionner</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">INE</label>
                                <input type="text" name="INE" id="editINE" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                            <div class="mb-3">
                                <label class="form-label">Filière</label>
                                <select name="filiere_id" id="editFiliereId" class="form-select" required>
                                    <option value="">Sélectionner une filière</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Zone</label>
                                <select name="zone_id" id="editZoneId" class="form-select" required>
                                    <option value="">Sélectionner une zone</option>
                                    <?php foreach ($zones as $zone): ?>
                                        <option value="<?= $zone['id'] ?>"><?= htmlspecialchars($zone['nom']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">ENO</label>
                                <select name="eno_id" id="editEnoId" class="form-select" required>
                                    <option value="">Sélectionner un ENO</option>
                                </select>
                            </div>
                        </div>
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
                <h5 class="modal-title">Détails de l'étudiant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Prénom:</label>
                            <p id="detailPrenom"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Nom:</label>
                            <p id="detailNom"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Email:</label>
                            <p id="detailEmail"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Téléphone:</label>
                            <p id="detailTelephone"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Âge:</label>
                            <p id="detailAge"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Sexe:</label>
                            <p id="detailSexe"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">INE:</label>
                            <p id="detailINE"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Pôle:</label>
                            <p id="detailPole"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Filière:</label>
                            <p id="detailFiliere"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Zone:</label>
                            <p id="detailZone"></p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">ENO:</label>
                            <p id="detailEno"></p>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Créé le:</label>
                    <p id="detailCreatedAt"></p>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Créé par:</label>
                    <p id="detailCreatedBy"></p>
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

            fetch('<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Afficher un message de succès
                    document.getElementById('etudiant-message').innerHTML = 
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        'Étudiant ajouté avec succès!' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';
                    
                    // Fermer le modal et recharger la page
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalAdd'));
                    modal.hide();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Afficher un message d'erreur
                    document.getElementById('etudiant-message').innerHTML = 
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        'Erreur: ' + data.error +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>';
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });

        // Formulaire de modification
        // Mise à jour du handler de formulaire d'édition
        document.getElementById('form-edit').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', data.message);
                    if (data.reload) {
                        setTimeout(() => window.location.reload(), 1500);
                    }
                } else {
                    showMessage('danger', data.error);
                }
            })
            .catch(error => showMessage('danger', 'Erreur réseau'));
        });
        
        // Fonction de gestion des messages
        function showMessage(type, text) {
            const messageDiv = document.getElementById('etudiant-message');
            messageDiv.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show">
                    ${text}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
        }

        // Chargement des données pour le modal d'édition
        document.querySelectorAll('[data-bs-target="#modalEdit"]').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=get&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const etudiant = data.etudiant;
                        
                        // Remplir le formulaire avec les données
                        document.getElementById('editId').value = etudiant.id;
                        document.getElementById('editPrenom').value = etudiant.prenom;
                        document.getElementById('editNom').value = etudiant.nom;
                        document.getElementById('editEmail').value = etudiant.email;
                        document.getElementById('editTelephone').value = etudiant.telephone;
                        document.getElementById('editAge').value = etudiant.age;
                        document.getElementById('editSexe').value = etudiant.sexe;
                        document.getElementById('editINE').value = etudiant.INE;
                        
                        // Sélectionner le pôle et déclencher l'événement change pour charger les filières
                        const poleSelect = document.getElementById('editPoleId');
                        poleSelect.value = etudiant.pole_id;
                        poleSelect.dispatchEvent(new Event('change'));
                        
                        // Sélectionner la zone et déclencher l'événement change pour charger les ENOs
                        const zoneSelect = document.getElementById('editZoneId');
                        zoneSelect.value = etudiant.zone_id;
                        zoneSelect.dispatchEvent(new Event('change'));
                        
                        // Définir la filière et l'ENO après un court délai pour s'assurer que les options sont chargées
                        setTimeout(() => {
                            document.getElementById('editFiliereId').value = etudiant.filiere_id;
                            document.getElementById('editEnoId').value = etudiant.eno_id;
                        }, 500);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            });
        });

        // Boutons de détails
        document.querySelectorAll('.btn-details').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=get&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remplir les champs du modal avec les données
                            document.getElementById('detailPrenom').textContent = data.etudiant.prenom;
                            document.getElementById('detailNom').textContent = data.etudiant.nom;
                            document.getElementById('detailEmail').textContent = data.etudiant.email;
                            document.getElementById('detailTelephone').textContent = data.etudiant.telephone;
                            document.getElementById('detailAge').textContent = data.etudiant.age;
                            document.getElementById('detailSexe').textContent = data.etudiant.sexe === 'M' ? 'Masculin' : 'Féminin';
                            document.getElementById('detailINE').textContent = data.etudiant.INE;
                            document.getElementById('detailPole').textContent = data.etudiant.nom_pole;
                            document.getElementById('detailFiliere').textContent = data.etudiant.nom_filiere;
                            document.getElementById('detailZone').textContent = data.etudiant.nom_zone;
                            document.getElementById('detailEno').textContent = data.etudiant.nom_eno;
                            document.getElementById('detailCreatedAt').textContent = new Date(data.etudiant.created_at).toLocaleString();
                            document.getElementById('detailCreatedBy').textContent = data.etudiant.created_by_name || 'N/A';
                            document.getElementById('detailUpdatedAt').textContent = data.etudiant.updated_at ? new Date(data.etudiant.updated_at).toLocaleString() : 'N/A';
                            document.getElementById('detailUpdatedBy').textContent = data.etudiant.updated_by_name || 'N/A';
                        } else {
                            console.error('Erreur:', data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des données:', error);
                    });
            });
        });

        // Boutons de suppression
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')) {
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id', id);
                    
                    fetch('<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Afficher un message de succès
                            document.getElementById('etudiant-message').innerHTML = 
                                '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                'Étudiant supprimé avec succès!' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>';
                            
                            // Supprimer la ligne du tableau
                            document.querySelector(`tr[data-id="${id}"]`).remove();
                        } else {
                            // Afficher un message d'erreur
                            document.getElementById('etudiant-message').innerHTML = 
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                'Erreur: ' + data.error +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                    });
                }
            });
        });

        // Fonction pour charger les filières en fonction du pôle sélectionné
        function loadFilieres(poleId, targetSelect, selectedFiliereId = null) {
            fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=getFilieres&pole_id=${poleId}`)
                .then(response => response.json())
                .then(data => {
                    targetSelect.innerHTML = '<option value="">Sélectionner une filière</option>';
                    if (data.success && data.filieres) {
                        data.filieres.forEach(filiere => {
                            const option = document.createElement('option');
                            option.value = filiere.id;
                            option.textContent = filiere.nom;
                            if (selectedFiliereId && filiere.id == selectedFiliereId) {
                                option.selected = true;
                            }
                            targetSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des filières:', error));
        }

        // Fonction pour charger les ENOs en fonction de la zone sélectionnée
        function loadEnos(zoneId, targetSelect, selectedEnoId = null) {
            fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=getEnos&zone_id=${zoneId}`)
                .then(response => response.json())
                .then(data => {
                    targetSelect.innerHTML = '<option value="">Sélectionner un ENO</option>';
                    if (data.success && data.enos) {
                        data.enos.forEach(eno => {
                            const option = document.createElement('option');
                            option.value = eno.id;
                            option.textContent = eno.nom;
                            if (selectedEnoId && eno.id == selectedEnoId) {
                                option.selected = true;
                            }
                            targetSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des ENOs:', error));
        }

        // Événements pour charger les filières et ENOs dynamiquement
        document.getElementById('addPoleId').addEventListener('change', function() {
            const poleId = this.value;
            if (poleId) {
                loadFilieres('add', poleId);
            }
        });

        document.getElementById('editPoleId').addEventListener('change', function() {
            const poleId = this.value;
            if (poleId) {
                loadFilieres('edit', poleId);
            }
        });

        document.getElementById('addZoneId').addEventListener('change', function() {
            const zoneId = this.value;
            if (zoneId) {
                loadEnos('add', zoneId);
            }
        });

        document.getElementById('editZoneId').addEventListener('change', function() {
            const zoneId = this.value;
            if (zoneId) {
                loadEnos('edit', zoneId);
            }
        });
    });

    // Gestion dynamique des filières/ENO dans le modal d'ajout
    const addPoleSelect = document.getElementById('addPoleId');
    const addFiliereSelect = document.getElementById('addFiliereId');
    const addZoneSelect = document.getElementById('addZoneId');
    const addEnoSelect = document.getElementById('addEnoId');
    
    // Mise à jour des filières selon le pôle sélectionné (Ajout)
    addPoleSelect.addEventListener('change', function() {
        const poleId = this.value;
        addFiliereSelect.innerHTML = '<option value="">Chargement...</option>';
        
        fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=getFilieres&pole_id=${poleId}`)
            .then(response => response.json())
            .then(data => {
                addFiliereSelect.innerHTML = '<option value="">Sélectionner une filière</option>';
                data.forEach(filiere => {
                    addFiliereSelect.innerHTML += `<option value="${filiere.id}">${filiere.nom}</option>`;
                });
            });
    });
    
    // Mise à jour des ENO selon la zone sélectionnée (Ajout)
    addZoneSelect.addEventListener('change', function() {
        const zoneId = this.value;
        addEnoSelect.innerHTML = '<option value="">Chargement...</option>';
        
        fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=getEnos&zone_id=${zoneId}`)
            .then(response => response.json())
            .then(data => {
                addEnoSelect.innerHTML = '<option value="">Sélectionner un ENO</option>';
                data.forEach(eno => {
                    addEnoSelect.innerHTML += `<option value="${eno.id}">${eno.nom}</option>`;
                });
            });
    });
    
    // Gestion dynamique pour le modal d'édition
    const editPoleSelect = document.getElementById('editPoleId');
    const editFiliereSelect = document.getElementById('editFiliereId');
    const editZoneSelect = document.getElementById('editZoneId');
    const editEnoSelect = document.getElementById('editEnoId');
    
    // Mise à jour des filières selon le pôle sélectionné (Édition)
    editPoleSelect.addEventListener('change', function() {
        const poleId = this.value;
        editFiliereSelect.innerHTML = '<option value="">Chargement...</option>';
        
        fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=getFilieres&pole_id=${poleId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Vérification du format des données
                if (!Array.isArray(data)) {
                    console.error('Format de données inattendu:', data);
                    throw new Error('Réserveur a retourné un format invalide');
                }
                
                addFiliereSelect.innerHTML = '<option value="">Sélectionner une filière</option>';
                data.forEach(filiere => {
                    addFiliereSelect.innerHTML += `<option value="${filiere.id}">${filiere.nom}</option>`;
                });
            })
            .catch(error => {
                console.error('Erreur lors du chargement des filières:', error);
                addFiliereSelect.innerHTML = '<option value="">Erreur de chargement</option>';
            });
    });
    
    // Mise à jour des ENO selon la zone sélectionnée (Édition)
    editZoneSelect.addEventListener('change', function() {
        const zoneId = this.value;
        editEnoSelect.innerHTML = '<option value="">Chargement...</option>';
        
        fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=getEnos&zone_id=${zoneId}`)
            .then(response => response.json())
            .then(data => {
                editEnoSelect.innerHTML = '<option value="">Sélectionner un ENO</option>';
                data.forEach(eno => {
                    const selected = eno.id == editEnoSelect.dataset.current ? 'selected' : '';
                    editEnoSelect.innerHTML += `<option value="${eno.id}" ${selected}>${eno.nom}</option>`;
                });
            });
    });

    // Charger les données associées lors de l'édition d'un étudiant
    document.querySelectorAll('[data-bs-target="#modalEdit"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            // Charger les données de l'étudiant
            fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=get&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const etudiant = data.etudiant;
                        
                        // Remplir le formulaire avec les données
                        document.getElementById('editId').value = etudiant.id;
                        document.getElementById('editPrenom').value = etudiant.prenom;
                        document.getElementById('editNom').value = etudiant.nom;
                        document.getElementById('editEmail').value = etudiant.email;
                        document.getElementById('editTelephone').value = etudiant.telephone;
                        document.getElementById('editAge').value = etudiant.age;
                        document.getElementById('editSexe').value = etudiant.sexe;
                        document.getElementById('editINE').value = etudiant.INE;
                        
                        // Sélectionner le pôle et déclencher l'événement change pour charger les filières
                        const poleSelect = document.getElementById('editPoleId');
                        poleSelect.value = etudiant.pole_id;
                        poleSelect.dispatchEvent(new Event('change'));
                        
                        // Sélectionner la zone et déclencher l'événement change pour charger les ENOs
                        const zoneSelect = document.getElementById('editZoneId');
                        zoneSelect.value = etudiant.zone_id;
                        zoneSelect.dispatchEvent(new Event('change'));
                        
                        // Définir la filière et l'ENO après un court délai pour s'assurer que les options sont chargées
                        setTimeout(() => {
                            document.getElementById('editFiliereId').value = etudiant.filiere_id;
                            document.getElementById('editEnoId').value = etudiant.eno_id;
                        }, 500);
                    }
                })
                .catch(error => console.error('Erreur:', error));
        });
    });
    
    // Charger les détails d'un étudiant
    document.querySelectorAll('.btn-details').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=get&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const etudiant = data.etudiant;
                        
                        // Remplir les détails
                        document.getElementById('detailPrenom').textContent = etudiant.prenom;
                        document.getElementById('detailNom').textContent = etudiant.nom;
                        document.getElementById('detailEmail').textContent = etudiant.email;
                        document.getElementById('detailTelephone').textContent = etudiant.telephone;
                        document.getElementById('detailAge').textContent = etudiant.age;
                        document.getElementById('detailSexe').textContent = etudiant.sexe === 'M' ? 'Masculin' : 'Féminin';
                        document.getElementById('detailINE').textContent = etudiant.INE;
                        document.getElementById('detailPole').textContent = etudiant.nom_pole;
                        document.getElementById('detailFiliere').textContent = etudiant.nom_filiere;
                        document.getElementById('detailZone').textContent = etudiant.nom_zone;
                        document.getElementById('detailEno').textContent = etudiant.nom_eno;
                        document.getElementById('detailCreatedAt').textContent = new Date(etudiant.created_at).toLocaleString('fr-FR');
                        document.getElementById('detailCreatedBy').textContent = etudiant.created_by_name || 'N/A';
                        document.getElementById('detailUpdatedAt').textContent = etudiant.updated_at ? new Date(etudiant.updated_at).toLocaleString('fr-FR') : 'N/A';
                        document.getElementById('detailUpdatedBy').textContent = etudiant.updated_by_name || 'N/A';
                    }
                })
                .catch(error => console.error('Erreur:', error));
        });
    });

    // Fonction de pré-remplissage du modal d'édition
    function loadEditData(id) {
        fetch(`<?= BASE_URL ?>/views/admin/etudiants/etudiant-process.php?action=get&id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const etudiant = data.etudiant;
                    
                    // Remplir le formulaire avec les données
                    document.getElementById('editId').value = etudiant.id;
                    document.getElementById('editPrenom').value = etudiant.prenom;
                    document.getElementById('editNom').value = etudiant.nom;
                    document.getElementById('editEmail').value = etudiant.email;
                    document.getElementById('editTelephone').value = etudiant.telephone;
                    document.getElementById('editAge').value = etudiant.age;
                    document.getElementById('editSexe').value = etudiant.sexe;
                    document.getElementById('editINE').value = etudiant.INE;
                    
                    // Sélectionner le pôle et déclencher l'événement change pour charger les filières
                    const poleSelect = document.getElementById('editPoleId');
                    poleSelect.value = etudiant.pole_id;
                    poleSelect.dispatchEvent(new Event('change'));
                    
                    // Sélectionner la zone et déclencher l'événement change pour charger les ENOs
                    const zoneSelect = document.getElementById('editZoneId');
                    zoneSelect.value = etudiant.zone_id;
                    zoneSelect.dispatchEvent(new Event('change'));
                    
                    // Définir la filière et l'ENO après un court délai pour s'assurer que les options sont chargées
                    setTimeout(() => {
                        document.getElementById('editFiliereId').value = etudiant.filiere_id;
                        document.getElementById('editEnoId').value = etudiant.eno_id;
                    }, 500);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    }
</script>