<?php
session_start();
require_once 'connection_db.php';

// Vérifier si l'utilisateur est connecté et est admin
if (!isset($_SESSION["user"]) || $_SESSION["user"]->role !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];
    $prix = $_POST['prix'];
    
    try {
        // Si une nouvelle image est uploadée
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image'];
            $image_name = time() . '_' . $image['name'];
            $image_path = "image/" . $image_name;
            
            // Supprimer l'ancienne image
            $sql = "SELECT image FROM formation WHERE id = :id";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([':id' => $id]);
            $old_image = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($old_image && $old_image->image) {
                $old_image_path = "image/" . $old_image->image;
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            
            // Uploader la nouvelle image
            move_uploaded_file($image['tmp_name'], $image_path);
            
            // Mettre à jour avec la nouvelle image
            $sql = "UPDATE formation SET titre = :titre, description = :description, 
                    categorie = :categorie, prix = :prix, image = :image 
                    WHERE id = :id";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([
                ':titre' => $titre,
                ':description' => $description,
                ':categorie' => $categorie,
                ':prix' => $prix,
                ':image' => $image_name,
                ':id' => $id
            ]);
        } else {
            // Mettre à jour sans changer l'image
            $sql = "UPDATE formation SET titre = :titre, description = :description, 
                    categorie = :categorie, prix = :prix 
                    WHERE id = :id";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([
                ':titre' => $titre,
                ':description' => $description,
                ':categorie' => $categorie,
                ':prix' => $prix,
                ':id' => $id
            ]);
        }
        
        $_SESSION['success'] = "Formation mise à jour avec succès";
    } catch(PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la mise à jour : " . $e->getMessage();
    }
    
    header("Location: edit_formation.php?id=" . $id);
    exit();
}
?> 