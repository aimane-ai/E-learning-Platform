<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bright Future</title>
    <link rel="stylesheet" href="style.css">
    <!--  *****   Link To Font Awsome Icons   *****  -->
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
<?php
require_once 'connection_db.php';
if (isset($_POST["inscrire"])) {
    if (!empty($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $login = $_POST["login"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        try {
            // Vérifier si le login existe déjà
            $stmt = $connexion->prepare("SELECT * FROM etudiant WHERE login = :login");
            $stmt->bindParam(':login', $login, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<div class='alert alert-warning mt-4'>Ce login existe déjà. Veuillez en choisir un autre.</div>";
            } else {
                // Insérer le nouvel utilisateur avec mot de passe hashé
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO etudiant (login, email, password) VALUES (:login, :email, :password)";
                $stmt = $connexion->prepare($sql);
                $stmt->bindParam(':login', $login, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                $stmt->execute();

                header("Location: log.php");
                exit();
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger mt-4'>Erreur : " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-4'>Tous les champs sont obligatoires !</div>";
    }
}
?>
<section class="home" id="home">
	<!--   === Main Navbar Starts ===   -->
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
            <h1>Inscription</h1>
            <div class="inputbox">
                <input type="text" name="login" placeholder="Nom d'utilisateur" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="inputbox">
                <input type="email" name="email" placeholder="Adresse Email" required>
                <i class="fas fa-envelope"></i>
            </div>
            <div class="inputbox">
                <input type="password" name="password" placeholder="Mot de passe" required>
                <i class="fas fa-lock"></i>
            </div>
        
            <button type="submit" name="inscrire" class="btn">S'inscrire</button>
            <div class="registerlink">
                <p>Vous avez deja un compte ? <a href="log.php">Se connecter</a></p>
            </div>
        </form>
    </div>
</section>

<!--  *****   Link To JQuery   *****  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!--  *****   Link To Custom JavaScript File   *****  -->
<script type="text/javascript" src="script.js"></script>
</body>
</html>