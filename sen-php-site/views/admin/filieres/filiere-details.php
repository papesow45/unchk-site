<?php
require_once 'FiliereController.php';

$controller = new FiliereController();
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    header('Location: ../filieres');
    exit();
}

$controller->details($id);
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2>Détails de la filière</h2>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informations générales</h5>
                            <p><strong>Code :</strong> <?php echo htmlspecialchars($filiere['code']); ?></p>
                            <p><strong>Nom :</strong> <?php echo htmlspecialchars($filiere['nom']); ?></p>
                            <p><strong>Description :</strong> <?php echo htmlspecialchars($filiere['description']); ?></p>
                            <p><strong>Pôle :</strong> <?php echo htmlspecialchars($filiere['pole_code']); ?></p>
                            <p><strong>Statut :</strong> 
                                <span class="badge <?php echo $filiere['estDisponible'] ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $filiere['estDisponible'] ? 'Disponible' : 'Non disponible'; ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Informations de suivi</h5>
                            <p><strong>Créé par :</strong> <?php echo htmlspecialchars($filiere['created_by_name']); ?></p>
                            <p><strong>Date de création :</strong> <?php echo date('d/m/Y H:i', strtotime($filiere['created_at'])); ?></p>
                            <?php if ($filiere['updated_at']): ?>
                            <p><strong>Modifié par :</strong> <?php echo htmlspecialchars($filiere['updated_by_name']); ?></p>
                            <p><strong>Date de modification :</strong> <?php echo date('d/m/Y H:i', strtotime($filiere['updated_at'])); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="../filieres" class="btn btn-secondary">Retour à la liste</a>
        <a href="filiere-edit.php?id=<?php echo $filiere['id']; ?>" class="btn btn-warning">Modifier</a>
        <button onclick="confirmDelete(<?php echo $filiere['id']; ?>)" class="btn btn-danger">Supprimer</button>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette filière ?')) {
        window.location.href = 'filiere-delete.php?id=' + id;
    }
}
</script>
