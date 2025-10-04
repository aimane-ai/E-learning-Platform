<?php
require_once 'connection_db.php';
if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: formation.php?error=invalid_id');
    exit();
}

$id = intval($_GET['id']);

try {
    $sql = "DELETE * FROM formation WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        header('Location: formation.php?success=user_deleted');
        
    } else {
        header('Location: formation.php?error=delete_failed');
    }
    exit();
    
} catch (PDOException $e) {
    // Redirection en cas d'erreur
    header('Location: formation.php?error=delete_failed');
    exit();
}
?>

