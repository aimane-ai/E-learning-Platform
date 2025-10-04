<?php
include 'dash.php';
require_once "connection_db.php";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        // Hasher le nouveau mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE admin SET username = :username, password = :password WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

    } catch(PDOException $e) {
        echo "<div class='alert alert-danger mt-4'>Erreur : " . $e->getMessage() . "</div>";
    }

}

// Récupération des données
if (isset($_SESSION['admin_id'])) {
    $id = (int)$_SESSION['admin_id'];
    try {
        $stmt = $connexion->prepare("SELECT * FROM admin WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if (!$user) {
            echo "<div class='alert alert-danger mt-4'>Aucun administrateur trouvé avec cet ID</div>";
        }
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger mt-4'>Erreur : " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-danger mt-4'>Admin non connecté</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Settings - Admin</title>
  <link rel="stylesheet" href="style.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200..1000&display=swap');
    
    body {
      font-family: 'Nunito', sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .contenair {
      width: 80%;
      margin: 0 auto;
      text-align: center;
      padding: 20px;
    }

    .box {
      border-radius: 12px;
      background: #0481ff;
      padding: 40px 30px;
      max-width: 450px;
      margin: 0 auto;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }
    .box h2 {
      color: #fff;
      font-size: 28px;
      margin-bottom: 30px;
      font-weight: 700;
    }

    .styled-form {
      display: flex;
      flex-direction: column;
      gap: 25px;
      width: 100%;
      max-width: 400px;
      margin: 0 auto;
    }

    .styled-form input[type="text"],
    .styled-form input[type="password"] {
      width: 90%;
      padding: 15px 20px;
      background: #f8fafc;
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      font-size: 16px;
      color: #2d3748;
      outline: none;
      transition: all 0.3s ease;
      margin: 0 auto;
    }

    .styled-form input[type="text"]:focus,
    .styled-form input[type="password"]:focus {
      border-color: green;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(73, 61, 158, 0.1);
    }

    .styled-form input[type="submit"] {
      background-color: #28a745;
      color: #fff;
      border: none;
      padding: 15px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      font-size: 16px;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .styled-form input[type="submit"]:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(73, 61, 158, 0.2);
    }

  </style>
</head>
<body>
  <div class="contenair">
    <div class="box">
      <h2>Paramètre d'Admin</h2>
      <form method="post" class="styled-form">
        <input type="hidden" name="id" value="<?= $user->id ?? '' ?>">
        <input type="text" name="username" value="<?= $user->username ?? '' ?>" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Nouveau mot de passe" required>
        <input type="submit" name="edit" value="Modifier">
      </form>
    </div>
  </div>
</body>
</html>
