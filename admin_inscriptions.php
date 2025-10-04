<?php
require_once 'connection_db.php';

// Vérifier si l'utilisateur est connecté et est admin

// Récupérer toutes les inscriptions avec les détails des formations et des étudiants
try {
    $sql = "SELECT i.*, f.titre as formation_titre, f.image, e.login as etudiant_nom, e.email 
            FROM inscriptions i 
            JOIN formation f ON i.formation_id = f.id 
            JOIN etudiant e ON i.etudiant_id = e.id 
            ORDER BY i.date_inscription DESC";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    $inscriptions = $stmt->fetchAll(PDO::FETCH_OBJ);
} catch(PDOException $e) {
    $error = "Erreur lors de la récupération des inscriptions : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Management - Admin</title>
    <link rel="stylesheet" href="projet2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .delete {
            text-decoration: none;
            background-color: red;
            padding: 5px 20px;
            border-radius: 7px;
            color: white;
        }
        .edit {
            text-decoration: none;
            background-color: green;
            padding: 5px 15px;
            border-radius: 7px;
            color: white;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
            display: inline-block;
        }
        .status-active {
            background: #e3fcef;
            color: #00a854;
        }
        .status-completed {
            background: #e6f7ff;
            color: #1890ff;
        }
        .status-cancelled {
            background: #fff1f0;
            color: #f5222d;
        }
    </style>
</head>
<body>
    <?php include 'dash.php'; ?>

    <div class="content">
        <div class="title-info">
            <p>Inscriptions</p>
            <i class="fas fa-user-graduate"></i>
    </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($inscriptions)): ?>
            <div class="no-inscriptions">
                <i class="fas fa-book-open"></i>
                <h2>Aucune inscription trouvée</h2>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Formation</th>
                        <th>Étudiant</th>
                        <th>Email</th>
                        <th>Date d'inscription</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inscriptions as $inscription): ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="image/<?php echo ($inscription->image); ?>" 
                                         alt="<?php echo ($inscription->formation_titre); ?>"
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    <?php echo ($inscription->formation_titre); ?>
                                </div>
                            </td>
                            <td><?php echo "<span class='price'>$inscription->etudiant_nom</span>"; ?></td>
                            <td><?php echo "<span class='count'>$inscription->email</span>"; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($inscription->date_inscription)); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($inscription->statut); ?>">
                                    <?php echo ucfirst($inscription->statut); ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="traitement_inscription.php" style="display: inline;">
                                    <input type="hidden" name="inscription_id" value="<?php echo $inscription->id; ?>">
                                    <?php if ($inscription->statut == 'active'): ?>
                                        <button type="submit" name="action" value="completer" class="edit">
                                            <i class="fas fa-check"></i> Terminer
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($inscription->statut != 'cancelled'): ?>
                                        <button type="submit" name="action" value="annuler" class="delete" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir annuler cette inscription ?')">
                                            <i class="fas fa-times"></i> Annuler
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html> 