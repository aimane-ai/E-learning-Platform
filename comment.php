<?php
// Récupérer les informations de l'admin connecté
require_once "connection_db.php";
include 'dash.php';
$sql_admin = "SELECT * FROM admin WHERE username = :username";
$stmt_admin = $connexion->prepare($sql_admin);
$stmt_admin->execute([':username' => $_SESSION["user"]]);
$admin = $stmt_admin->fetch(PDO::FETCH_OBJ);

// Récupérer tous les témoignages avec les noms des utilisateurs
$sql_testimonials = "SELECT t.*, u.login
                    FROM testimonials t 
                    LEFT JOIN etudiant u ON t.email = u.email 
                    ORDER BY t.date_creation DESC";
$stmt_testimonials = $connexion->query($sql_testimonials);
$testimonials = $stmt_testimonials->fetchAll(PDO::FETCH_OBJ);

?>

<div class="content">
    <div class="title-info">
        <p>commentaires</p>
        <i class="fa-solid fa-comment"></i>
    </div>
    
    <div class="data-info">
        <?php if (empty($testimonials)): ?>
            <div class="box">
                <i class="fas fa-info-circle"></i>
                <div class="data">
                    <p>Aucun témoignage</p>
                    <span>pour le moment</span>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="box" style="display: flex; align-items: center; padding: 10px 15px;">
                    <div class="data" style="display: flex; align-items: center; width: 100%;">
                        <div style="min-width: 150px;">
                            <p style="margin: 0;"><?php echo htmlspecialchars($testimonial->login); ?></p>
                        </div>
                        <div style="min-width: 150px;">
                            <span><?php echo date('d/m/Y H:i', strtotime($testimonial->date_creation)); ?></span>
                        </div>
                        <div style="flex-grow: 1; margin: 0 20px;">
                            <p class="testimonial-text" style="margin: 0;"><?php echo htmlspecialchars($testimonial->message); ?></p>
                        </div>
                        <div style="min-width: 200px;">
                            <form action="traitement_reponse.php" method="POST" style="display: flex; gap: 10px;">
                                <input type="hidden" name="id_commentaire" value="<?php echo $testimonial->id; ?>">
                                <input type="text" name="reponse" placeholder="Votre réponse..." required style="padding: 5px; border: 1px solid #ddd; border-radius: 4px; color: black;">
                                <button type="submit" style="padding: 5px 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                    Répondre
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>