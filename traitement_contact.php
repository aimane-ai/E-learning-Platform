<?php
session_start();
require_once 'connection_db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $sujet = $_POST['sujet'];
    $message = $_POST['message'];
    
    try {
        // Vérifier si la table testimonials existe, sinon la créer
        $sql = "CREATE TABLE IF NOT EXISTS testimonials (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            sujet VARCHAR(200) NOT NULL,
            message TEXT NOT NULL,
            date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $connexion->exec($sql);

        // Insérer le message dans la base de données
        $sql = "INSERT INTO testimonials (nom, email, sujet, message) VALUES (:nom, :email, :sujet, :message)";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':email' => $email,
            ':sujet' => $sujet,
            ':message' => $message
        ]);

        echo json_encode(['success' => true, 'message' => 'Votre message a été envoyé avec succès !']);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi du message : ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
?> 