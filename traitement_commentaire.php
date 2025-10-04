<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["is_admin"] !== true) {
    header("Location: log.php");
    exit();
}

require_once "connection_db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $testimonial_id = $_POST["testimonial_id"];
    $action = $_POST["action"];

    if ($action === "approve") {
        // Mettre à jour le statut du témoignage
        $sql = "UPDATE testimonials SET statut = 'approuve' WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([':id' => $testimonial_id]);
        
        $_SESSION["message"] = "Le témoignage a été approuvé avec succès.";
    } 
    elseif ($action === "delete") {
        // Supprimer le témoignage
        $sql = "DELETE FROM testimonials WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([':id' => $testimonial_id]);
        
        $_SESSION["message"] = "Le témoignage a été supprimé avec succès.";
    }
}

header("Location: comment.php");
exit(); 