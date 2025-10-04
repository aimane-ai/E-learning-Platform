<?php
require_once "connection_db.php";

try {
    // Création de la table reponses_commentaires
    $sql = "CREATE TABLE IF NOT EXISTS reponses_commentaires (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_commentaire INT NOT NULL,
        reponse TEXT NOT NULL,
        date_reponse DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_commentaire) REFERENCES testimonials(id) ON DELETE CASCADE
    )";
    
    $connexion->exec($sql);
    echo "La table reponses_commentaires a été créée avec succès.";
} catch(PDOException $e) {
    echo "Erreur lors de la création de la table : " . $e->getMessage();
}
?> 