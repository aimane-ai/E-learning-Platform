<?php
session_start();
require_once 'connection_db.php';

if (isset($_POST["connect"])) {
    $username = $_POST["login"];
    $password = $_POST["password"];

    // Vérifier si c'est un admin
    $sqlAdmin = "SELECT * FROM admin WHERE username = :username";
    $stmtAdmin = $connexion->prepare($sqlAdmin);
    $stmtAdmin->bindParam(':username', $username);
    $stmtAdmin->execute();

    if ($stmtAdmin->rowCount() > 0) {
        $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);
        // Vérifier le mot de passe avec password_verify
        if (password_verify($password, $admin['password'])) {
            $_SESSION["user"] = $username;
            $_SESSION["is_admin"] = true; // Indique que c'est un admin
            $_SESSION["admin_id"] = $admin['id']; // Stocke l'id de l'admin connecté
            header("Location: adm.php");
            exit();
        }
    }

    // Vérifier si c'est un étudiant
    $sqlEtudiant = "SELECT * FROM etudiant WHERE login = :login";
    $stmtEtudiant = $connexion->prepare($sqlEtudiant);
    $stmtEtudiant->bindParam(':login', $username);
    $stmtEtudiant->execute();

    if ($stmtEtudiant->rowCount() > 0) {
        $etudiant = $stmtEtudiant->fetch(PDO::FETCH_ASSOC);
        // Vérifier le mot de passe avec password_verify
        if (password_verify($password, $etudiant['password'])) {
            $_SESSION["user"] = $username;
            $_SESSION["is_admin"] = false; // Indique que c'est un étudiant
            $_SESSION["user_id"] = $etudiant['id'];
            header("Location: index.php");
            exit();
        }
    }

    // Aucun compte trouvé
    echo "<div class='alert alert-danger mt-4'>Identifiants incorrects.</div>";
}
?> 