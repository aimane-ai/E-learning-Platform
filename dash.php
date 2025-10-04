<?php
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["is_admin"] !== true) {
    header("Location: log.php");
    exit();
}

// Récupérer les informations de l'admin connecté
require_once "connection_db.php";
$sql_admin = "SELECT * FROM admin WHERE username = :username";
$stmt_admin = $connexion->prepare($sql_admin);
$stmt_admin->execute([':username' => $_SESSION["user"]]);
$admin = $stmt_admin->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="projet2.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>
<body>
<div class="menu">
        <ul>
            <li class="profile">
                <div class="img-box">
                    <?php if (isset($admin->photo) && !empty($admin->photo)): ?>
                        <img src="image/<?php echo($admin->photo); ?>" alt="Photo de profil">
                    <?php else: ?>
                        <i class="fas fa-user"></i>
                    <?php endif; ?>
                </div>
                <h2><?php echo($_SESSION["user"]) ?></h2>
            </li>
            <li>
                <a class="active" href="adm.php">
                    <i class="fas fa-home"></i>
                    <p>dashboard</p>
                </a>
            </li>
            <li>
                <a href="etudiant.php">
                    <i class="fas fa-user-group"></i>
                    <p>etudiants</p>
                </a>
            </li>
            <li>
                <a href="formation.php">
                    <i class="fas fa-book"></i>
                    <span>Formations</span>
                </a>
            </li>
            <li>
                <a href="admin_inscriptions.php">
                    <i class="fas fa-user-graduate"></i>
                    <span>Inscriptions</span>
                </a>
            </li>
            <li>
                <a href="ajouter.php">
                    <i class="fas fa-pen"></i>
                    <p>ajouter</p>
                </a>
            </li>
            <li>
                <a href="comment.php">
                    <i class="fa-solid fa-comment"></i>
                    <span>Messages</span>
                </a>
            </li>
            <li>
                <a href="settings.php">
                    <i class="fas fa-cog"></i>
                    <p>settings</p>
                </a>
            </li>
            <li class="log-out">
                <a href="logout.php">
                    <i class="fas fa-sign-out"></i>
                    <p>log out</p>
                </a>
            </li>
        </ul>
    </div>
</body>
</html>