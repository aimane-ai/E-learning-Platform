<?php
session_start();
require_once 'connection_db.php';

if (isset($_POST["connect"])) {
    $username = $_POST["login"];
    $password = $_POST["password"];

    // Gérer les cookies si "Se souvenir de moi" est coché (SEULEMENT le nom d'utilisateur)
    if(!empty($_POST["remember"])){
        setcookie("login", $username, time() + (365 * 24 * 60 * 60)); // 1 an
    }else{
        setcookie("login", "", time() - 3600);
    }

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
            $_SESSION["is_admin"] = true;
            $_SESSION["admin_id"] = $admin['id'];
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
            $_SESSION["is_admin"] = false;
            $_SESSION["user_id"] = $etudiant['id'];
            header("Location: index.php");
            exit();
        }
    }

    echo "<div class='alert alert-danger mt-4'>Identifiants incorrects.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bright Future</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <style>
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
            background: transparent;
        }
        .wrapper form {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            margin-top: 100px;
        }
        .wrapper h1 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 30px;
        }
        .inputbox {
            position: relative;
            margin-bottom: 20px;
        }
        .inputbox input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .inputbox input:focus {
            border-color: #208245;
            outline: none;
        }
        .inputbox i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }
        .rememberforgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .rememberforgot label {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
        }
        .rememberforgot a {
            color: #208245;
            text-decoration: none;
        }
        .rememberforgot a:hover {
            text-decoration: underline;
        }
        .btn {
            width: 100%;
            padding: 12px;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .registerlink {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .registerlink a {
            color: #208245;
            text-decoration: none;
            font-weight: bold;
        }
        .registerlink a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<section class="home" id="home">
    <nav class="main-navbar">
        <a href="index.php" class="logo">
            <img src="images/home/logo.png">
        </a>
        <ul class="nav-list">
            <li><a href="index.php#home">Home</a></li>
            <li><a href="index.php#services">Services</a></li>
            <li><a href="index.php#courses">Courses</a></li>
            <li><a href="index.php#categories">Categories</a></li>
            <li><a href="index.php#contact">contact</a></li>
            <li><a href="index.php#testimonials">Testimonials</a></li>
        </ul>
        <div class="menu-btn">
            <span></span>
        </div>
    </nav>
    <div class="wrapper">
        <form method="POST">
            <h1>Connexion</h1>
            <div class="inputbox">
                <input type="text" name="login" placeholder="Nom d'utilisateur" required
                       value="<?php echo isset($_COOKIE['login']) ? $_COOKIE['login'] : ''; ?>">
                <i class="fas fa-user"></i>
            </div>
            <div class="inputbox">
                <input type="password" name="password" placeholder="Mot de passe" required>
                <i class="fas fa-lock"></i>
            </div>
            <div class="rememberforgot">
                <label><input type="checkbox" name="remember" <?php echo isset($_COOKIE['login']) ? 'checked' : ''; ?>> Se souvenir de moi</label>
                <a href="#">Mot de passe oublié ?</a>
            </div>
            <button type="submit" name="connect" class="btn">Se connecter</button>
            <div class="registerlink">
                <p>Vous n'avez pas de compte ? <a href="register.php">S'inscrire</a></p>
            </div>
        </form>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="script.js"></script>
</body>
</html>
