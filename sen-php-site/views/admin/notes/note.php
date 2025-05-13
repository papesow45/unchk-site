<?php
require_once __DIR__ . '/NoteController.php';
require_once __DIR__ . '/../etudiants/EtudiantModel.php';
require_once __DIR__ . '/../matieres/MatiereModel.php';

$ctrl = new NoteController();
$notes = $ctrl->list();
$etudiants = EtudiantModel::fetchAll();
$matieres = MatiereModel::fetchAll();
?>

<div class="container py-5">
    <div id="note-message"></div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Gestion des notes</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
            <i class="bi bi-plus"></i>
            Nouvelle note
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body px-3">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Étudiant</th>
                        <th>Matière</th>
                        <th>Note</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notes as $n): ?>
                        <tr data-id="<?= $n['id'] ?>">
                            <td><?= htmlspecialchars($n['prenom'] . ' ' . $n['nom']) ?> (<?= htmlspecialchars($n['INE']) ?>)</td>
                            <td><?= htmlspecialchars($n['matiere_nom']) ?> (<?= htmlspecialchars($n['matiere_code']) ?>)</td>
                            <td><?= htmlspecialchars($n['note']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($n['created_at'])) ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" data-id="<?= $n['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalDetail"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-warning" data-id="<?= $n['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="<?= $n['id'] ?>"><i class="fas fa-trash"></i></button>
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
                <h5 class="modal-title">Nouvelle note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form-add">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Étudiant</label>
                        <select name="etudiant_id" class="form-select" id="etudiantSelect" required>
                            <option value="">Sélectionner un étudiant</option>
                            <?php foreach ($etudiants as $etudiant): ?>
                                <option value="<?= $etudiant['id'] ?>" data-filiere-id="<?= $etudiant['filiere_id'] ?>">
                                    <?= htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['nom']) ?> (<?= htmlspecialchars($etudiant['INE']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Matière</label>
                        <select name="matiere_id" class="form-select" required>
                            <option value="">Sélectionner une matière</option>
                            <?php foreach ($matieres as $matiere): ?>
                                <option value="<?= $matiere['id'] ?>">
                                    <?= htmlspecialchars($matiere['nom']) ?> (<?= htmlspecialchars($matiere['code']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <input type="number" name="note" class="form-control" min="0" max="20" step="0.01" required>
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
                <h5 class="modal-title">Modifier la note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form-edit">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <input type="number" name="note" id="editNote" class="form-control" min="0" max="20" step="0.01" required>
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
                <h5 class="modal-title" id="modalDetailLabel">Détails de la note</h5>
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

            fetch('<?= BASE_URL ?>/views/admin/notes/note-process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('note-message').innerHTML =
                            `<div class="alert alert-success">${data.message}</div>`;
                        setTimeout(() => location.reload(), 1000);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalAdd'));
                        modal.hide();
                    } else {
                        document.getElementById('note-message').innerHTML =
                            `<div class="alert alert-danger">${data.error}</div>`;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('note-message').innerHTML =
                        '<div class="alert alert-danger">Une erreur est survenue</div>';
                });
        });

        // Formulaire d'édition
        document.getElementById('form-edit').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('<?= BASE_URL ?>/views/admin/notes/note-process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('note-message').innerHTML =
                            `<div class="alert alert-success">${data.message}</div>`;
                        setTimeout(() => location.reload(), 1000);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEdit'));
                        modal.hide();
                    } else {
                        document.getElementById('note-message').innerHTML =
                            `<div class="alert alert-danger">${data.error}</div>`;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('note-message').innerHTML =
                        '<div class="alert alert-danger">Une erreur est survenue</div>';
                });
        });

        // Boutons d'édition
        document.querySelectorAll('[data-bs-target="#modalEdit"]').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;

                fetch(`<?= BASE_URL ?>/views/admin/notes/note-process.php?action=get&id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('editId').value = data.note.id;
                            document.getElementById('editNote').value = data.note.note;
                        } else {
                            document.getElementById('note-message').innerHTML =
                                `<div class="alert alert-danger">${data.error}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        document.getElementById('note-message').innerHTML =
                            '<div class="alert alert-danger">Une erreur est survenue</div>';
                    });
            });
        });

        // Boutons de suppression
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Êtes-vous sûr de vouloir supprimer cette note ?')) {
                    const id = this.dataset.id;
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id', id);

                    fetch('<?= BASE_URL ?>/views/admin/notes/note-process.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('note-message').innerHTML =
                                    `<div class="alert alert-success">${data.message}</div>`;
                                document.querySelector(`tr[data-id="${id}"]`).remove();
                            } else {
                                document.getElementById('note-message').innerHTML =
                                    `<div class="alert alert-danger">${data.error}</div>`;
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            document.getElementById('note-message').innerHTML =
                                '<div class="alert alert-danger">Une erreur est survenue</div>';
                        });
                }
            });
        });

        // Modal de détails
        document.querySelectorAll('[data-bs-target="#modalDetail"]').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;

                fetch(`<?= BASE_URL ?>/views/admin/notes/note-details.php?id=${id}`)
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
    // Dynamique: filtrer les matières selon la filière de l'étudiant sélectionné
    document.getElementById('etudiantSelect').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const filiereId = selectedOption.getAttribute('data-filiere-id');
        const matiereSelect = document.querySelector('select[name="matiere_id"]');
        matiereSelect.innerHTML = '<option value="">Chargement...</option>';
    
        if (filiereId) {
            fetch('<?= BASE_URL ?>/views/admin/notes/note-process.php?action=matieres_by_filiere&filiere_id=' + filiereId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let options = '<option value=\"\">Sélectionner une matière</option>';
                        data.matieres.forEach(m => {
                            options += `<option value="${m.id}">${m.nom} (${m.code})</option>`;
                        });
                        matiereSelect.innerHTML = options;
                    } else {
                        matiereSelect.innerHTML = '<option value="">Aucune matière trouvée</option>';
                    }
                })
                .catch(() => {
                    matiereSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            matiereSelect.innerHTML = '<option value="">Sélectionner une matière</option>';
        }
    });
</script>