<?php
require_once "connection_db.php";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $titre = trim($_POST['titre']);
    $categorie = trim($_POST['categorie']);
    $description = $_POST['description'];
    $prix = $_POST['prix'];

    try {
        $sql = "UPDATE formation SET titre = :titre, categorie = :categorie,prix =:prix, description = :description WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':prix', $prix, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

    } catch(PDOException $e) {
        echo "<div class='alert alert-danger mt-4'>Erreur : " . $e->getMessage() . "</div>";
    }

}

// Récupération des données
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    try {
        $stmt = $connexion->prepare("SELECT * FROM formation WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger mt-4'>Erreur : " . $e->getMessage() . "</div>";
    }
}
?>
<?php
if(isset($_POST["cancel"])){
    header('location: formation.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            background-color: #123;
        }
        .container {
            max-width: 500px;
            margin: 100px auto;
            background-color: #f9f9f9;
            padding: 30px 40px;
            border-radius: 15px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        form label.form-label {
            font-weight: bold;
            color: #333;
        }

        form .form-control {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            font-size: 16px;
        }

        form .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.4);
            outline: none;
        }

        form .btn-primary {
            background-color: #4a90e2;
            border: none;
            padding: 10px 25px;
            font-size: 16px;
            border-radius: 10px;
            transition: 0.3s ease-in-out;
        }

        form .btn-primary:hover {
            background-color: #357ABD;
        }

        form .btn-warning {
            color: #f9f9f9;
            background-color: #f0ad4e;
            border: none;
            padding: 10px 25px;
            font-size: 16px;
            border-radius: 10px;
            margin-left: 10px;
            transition: 0.3s ease-in-out;
        }

        form .btn-warning:hover {
            background-color: #ec971f;
        }

    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            
        </div>
    </div>
    <form method="post">
        <input type="hidden" name="id" value="<?= $user->id ?? '' ?>">
        
        <div class="mb-3">
            <label class="form-label">titre</label>
            <input type="text" class="form-control" name="titre" value="<?= $user->titre ?? '' ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label">categorie</label>
            <input type="text" class="form-control" name="categorie" value="<?= $user->categorie ?? '' ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">prix</label>
            <input type="text" class="form-control" name="prix" value="<?= $user->prix ?? '' ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label">description</label>
            <input type="text" class="form-control" name="description" value="<?= $user->description ?? '' ?>">
        </div>
        
        <button type="submit" name="edit" class="btn btn-primary">Edit</button>
        <button name="cancel" class="btn btn-warning">Cancel</button>
    </form>
</div>
</body>
</html>
