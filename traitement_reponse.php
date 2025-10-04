<?php
session_start();
require_once "connection_db.php";

// Vérifier si l'utilisateur est connecté en tant qu'admin
if (!isset($_SESSION["user"]) || !isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) {
    header("Location: log.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_commentaire = $_POST["id_commentaire"];
    $reponse = trim($_POST["reponse"]);
    
    if (empty($reponse)) {
        header("Location: comment.php?error=empty_response");
        exit();
    }

    try {
        // Insérer la réponse dans la table reponses_commentaires
        $sql = "INSERT INTO reponses_commentaires (id_commentaire, reponse, date_reponse) VALUES (:id_commentaire, :reponse, NOW())";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([
            ':id_commentaire' => $id_commentaire,
            ':reponse' => $reponse
        ]);

        header("Location: comment.php?success=response_added");
    } catch (PDOException $e) {
        header("Location: comment.php?error=database_error");
    }
} else {
    header("Location: comment.php");
}
exit(); 