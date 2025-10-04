<?php
require_once "connection_db.php";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $username = trim($_POST['login']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        // Hasher le nouveau mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE etudiant SET login = :username, email = :email, password = :password WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
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
        $stmt = $connexion->prepare("SELECT * FROM etudiant WHERE id = :id");
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
    header('location: etudiant.php');
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
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="login" value="<?= $user->login ?? '' ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= $user->email ?? '' ?>">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Nouveau mot de passe" required>
        </div>
        
        <button type="submit" name="edit" class="btn btn-primary">Edit</button>
        <button name="cancel" class="btn btn-warning">Cancel</button>
    </form>
</div>
</body>
</html>
