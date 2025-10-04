<?php
session_start();
$isLoggedIn = isset($_SESSION["user"]);
require_once 'connection_db.php';

if (!$isLoggedIn) {
    header("Location: log.php");
    exit();
}

$etudiant = null;
$error = null;

try {
    $sql = "SELECT * FROM etudiant WHERE login = :login";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([':login' => $_SESSION["user"]]);
    $etudiant = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$etudiant) {
        $error = "Informations de profil non trouvées.";
    }
} catch (PDOException $e) {
    $error = "Erreur de connexion : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit my profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: sans-serif; background: #f4f4f4; }
        .main-navbar { background: #208245; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .main-navbar .logo img { height: 40px; }
        .main-navbar .nav-list { display: flex; gap: 20px; list-style: none; }
        .main-navbar .nav-list li a { color: #fff; text-decoration: none; }
        .get-started-btn-container button { background: #208245; color: #fff; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; }

        .page-wrapper { display: flex; }
        .dashboard-sidebar {
            width: 220px;
            background-color: #208245;
            padding: 30px 15px;
            color: white;
            min-height: 100vh;
        }
        .dashboard-sidebar ul { list-style: none; padding: 0; }
        .dashboard-sidebar ul li { margin-bottom: 20px; }
        .dashboard-sidebar ul li a { color: white; text-decoration: none; display: block; padding: 10px; border-radius: 6px; }
        .dashboard-sidebar ul li a:hover,
        .dashboard-sidebar ul li a.active { background-color: #ccc; }

        .inscriptions-container { flex: 1; padding: 30px; }
        .inscriptions-header h1 { color: #333; margin-bottom: 10px; }

        .profile-form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 500px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .btn-submit {
            background: #208245;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .alert {
            padding: 15px;
            background: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Styles du tableau de bord */
        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .welcome-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .welcome-header p {
            color: #666;
            font-size: 16px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 24px;
            color: #208245;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
        }

        .recent-courses {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }

        .section-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
        }

        .course-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .course-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .course-title {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }

        .course-progress {
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            margin: 10px 0;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: #208245;
            border-radius: 3px;
        }

        .course-stats {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
        }

        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .course-list {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .page-wrapper { flex-direction: column; }
            .dashboard-sidebar { width: 100%; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="main-navbar">
    <a href="#" class="logo">
        <img src="images/home/logo.png">
    </a>
    <ul class="nav-list">
        <li><a href="index.php#home">Home</a></li>
        <li><a href="index.php#services">Services</a></li>
        <li><a href="index.php#courses">Courses</a></li>
        <li><a href="index.php#categories">Categories</a></li>
        <li><a href="index.php#contact">Contact</a></li>
        <li><a href="inscriptions.php">Mon Espace</a></li>
    </ul>
    <a href="logout.php" class="get-started-btn-container">
        <button class="get-started-btn btn">Déconnexion</button>
    </a>
</nav>

<!-- DASHBOARD -->
<div class="page-wrapper">
    <!-- Sidebar -->
    <aside class="dashboard-sidebar">
        <ul>
            <li><a href="tableau.php"><i class="fas fa-home"></i> Progress</a></li>
            <li><a href="inscriptions.php"><i class="fas fa-clipboard-list"></i> Mes Inscriptions</a></li>
            <li><a href="messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
            <li><a href="profile.php" class="active"><i class="fas fa-user"></i> Mon Profil</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
        </ul>
    </aside>

    <!-- Contenu -->
    <div class="inscriptions-container">
        <div class="inscriptions-header">
            <h1>Mon Profil</h1>
        </div>

        <?php if ($error): ?>
            <div class="alert"><?php echo $error; ?></div>
        <?php elseif ($etudiant): ?>
            <form class="profile-form" method="POST" action="modifier_profile.php">
                <div class="form-group">
                    <label for="id">Id :</label>
                    <input type="text" name="id" value="<?php echo $etudiant->id; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="login">Nom complet :</label>
                    <input type="text" id="login" name="login" value="<?php echo $etudiant->login; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo $etudiant->email; ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" placeholder="Nouveau mot de passe" required>
                </div>

                <div class="form-group">
                    <label for="niveau">Date de Rejoindre :</label>
                    <p><?php echo $etudiant->dateRejoindre; ?></p>
                </div>

                <button type="submit" class="btn-submit">Enregistrer</button>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
