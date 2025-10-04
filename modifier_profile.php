<?php
session_start();
require_once 'connection_db.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION["user"])) {
    header("Location: log.php");
    exit();
}

// Récupérer les données de l'étudiant connecté
$sql = "SELECT * FROM etudiant WHERE login = :login";
$stmt = $connexion->prepare($sql);
$stmt->execute([':login' => $_SESSION["user"]]);
$user = $stmt->fetch(PDO::FETCH_OBJ);

// Vérifie si les données sont envoyées par POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validation simple
    if (empty($email) || empty($login) || empty($password)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header("Location: profile.php");
        exit();
    }

    try {
        // Hasher le nouveau mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Mise à jour dans la base de données
        $sql = "UPDATE etudiant SET login = :login, email = :email, password = :password WHERE id = :id";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([
            ':login' => $login,
            ':email' => $email,
            ':password' => $hashed_password,
            ':id' => $id
        ]);

        // Mettre à jour la session si le login change
        $_SESSION["user"] = $login;
        $_SESSION['success'] = "Profil mis à jour avec succès.";
        header("Location: profile.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la mise à jour : " . $e->getMessage();
        header("Location: profile.php");
        exit();
    }
} else {
    header("Location: profile.php");
    exit();
}
?>
