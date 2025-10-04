<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: log.php");
    exit();
}

require_once 'connection_db.php';

$error = '';
$inscriptions = [];

try {
    $sql_etudiant = "SELECT id, email FROM etudiant WHERE login = :login";
    $stmt_etudiant = $connexion->prepare($sql_etudiant);
    $stmt_etudiant->execute([':login' => $_SESSION["user"]]);
    $etudiant = $stmt_etudiant->fetch(PDO::FETCH_OBJ);

    if ($etudiant) {
        $sql = "SELECT i.*, f.titre as formation_titre, f.image 
                FROM inscriptions i
                JOIN formation f ON i.formation_id = f.id 
                WHERE i.etudiant_id = :etudiant_id 
                ORDER BY i.date_inscription DESC";
        $stmt = $connexion->prepare($sql);
        $stmt->execute([':etudiant_id' => $etudiant->id]);
        $inscriptions = $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        $error = "Erreur : Étudiant non trouvé";
    }
} catch(PDOException $e) {
    $error = "Erreur lors de la récupération des inscriptions : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Enrollments</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: sans-serif; background: #f4f4f4; }
        .main-navbar { background: #208245; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .main-navbar .logo img { height: 40px; }
        .main-navbar .nav-list { display: flex; gap: 20px; list-style: none; }
        .main-navbar .nav-list li a { color: #fff; text-decoration: none;  }
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
        .inscriptions-header h1 { color: #333; }

        .inscriptions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .inscription-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .inscription-card:hover { transform: translateY(-5px); }
        .inscription-image { width: 100%; height: 200px; object-fit: cover; }
        .inscription-content { padding: 20px; }
        .inscription-title { font-size: 1.2em; color: #333; margin-bottom: 10px; }
        .inscription-info { color: #666; font-size: 0.9em; margin-bottom: 15px; }

        .inscription-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .status-active { background: #e3fcef; color: #00a854; }
        .status-completed { background: #e6f7ff; color: #1890ff; }
        .status-cancelled { background: #fff1f0; color: #f5222d; }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 0.9em;
            background: #4a90e2;
            color: white;
            cursor: pointer;
        }

        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; text-align: center; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .no-inscriptions {
            text-align: center;
            padding: 50px;
            color: #666;
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
            <li><a href="inscriptions.php">My Dashboard</a></li>
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
                <li><a href="inscriptions.php" class="active"><i class="fas fa-clipboard-list"></i> Mes Inscriptions</a></li>
                <li><a href="messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
                <li><a href="profile.php"><i class="fas fa-user"></i> Mon Profil</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <!-- Contenu -->
        <div class="inscriptions-container">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Section Inscriptions -->
            <section id="inscriptions">
                <h2>Mes Inscriptions</h2>
                <?php if (empty($inscriptions)): ?>
                    <div class="no-inscriptions">
                        <i class="fas fa-book-open fa-3x" style="color: #ccc;"></i>
                        <h2>Aucune inscription trouvée</h2>
                        <a href="index.php#courses" class="btn" style="margin-top: 30px;">Découvrir les formations</a>
                    </div>
                <?php else: ?>
                    <div class="inscriptions-grid">
                        <?php foreach ($inscriptions as $inscription): ?>
                            <div class="inscription-card">
                                <img src="image/<?php echo ($inscription->image); ?>" class="inscription-image">
                                <div class="inscription-content">
                                    <h3 class="inscription-title"><?php echo ($inscription->formation_titre); ?></h3>
                                    <p class="inscription-info">
                                        <i class="fas fa-calendar"></i> Inscrit le <?php echo date('d/m/Y', strtotime($inscription->date_inscription)); ?>
                                    </p>
                                    <span class="inscription-status status-<?php echo strtolower($inscription->statut); ?>">
                                        <?php echo ucfirst($inscription->statut); ?>
                                    </span>
                                    <div class="inscription-actions" style="margin-top: 15px;">
                                        <a href="inf.php?id=<?php echo $inscription->formation_id; ?>" class="btn">
                                            <i class="fas fa-eye"></i> Voir la formation
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</body>
</html>
