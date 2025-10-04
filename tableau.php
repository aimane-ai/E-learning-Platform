<?php
session_start();
$isLoggedIn = isset($_SESSION["user"]);
require_once 'connection_db.php';

if (!$isLoggedIn) {
    header("Location: log.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Bright Future</title>
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

        .dashboard-container { flex: 1; padding: 30px; }
        .dashboard-header h1 { color: #333; margin-bottom: 10px; }

        /* Styles du tableau de bord */
        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
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
            .page-wrapper { flex-direction: column; }
            .dashboard-sidebar { width: 100%; }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .course-list {
                grid-template-columns: 1fr;
            }
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
        <button class="get-started-btn btn">Logout</button>
    </a>
</nav>

<!-- DASHBOARD -->
<div class="page-wrapper">
    <!-- Sidebar -->
    <aside class="dashboard-sidebar">
        <ul>
            <li><a href="tableau.php" class="active"><i class="fas fa-home"></i> Progress</a></li>
            <li><a href="inscriptions.php"><i class="fas fa-clipboard-list"></i> My Enrollments</a></li>
            <li><a href="messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> My Profile</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Contenu -->
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Your Progress</h1>
        </div>

        <div class="welcome-section">
            <div class="welcome-header">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION["user"]); ?>!</h1>
                <p>Here is an overview of your progress and ongoing courses</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <?php
                    // Débogage de la session
                    echo "<!-- Session user: " . $_SESSION['user'] . " -->";

                    // D'abord récupérer l'ID de l'étudiant
                    $sql_etudiant = "SELECT id FROM etudiant WHERE login = :login";
                    $stmt_etudiant = $connexion->prepare($sql_etudiant);
                    $stmt_etudiant->execute([':login' => $_SESSION['user']]);
                    $etudiant = $stmt_etudiant->fetch(PDO::FETCH_OBJ);

                    if ($etudiant) {
                        // Requête pour compter le nombre total de cours inscrits
                        $count_sql = "SELECT COUNT(*) as total_courses 
                                    FROM inscriptions 
                                    WHERE etudiant_id = :etudiant_id";
                        $count_stmt = $connexion->prepare($count_sql);
                        $count_stmt->bindParam(':etudiant_id', $etudiant->id, PDO::PARAM_INT);
                        $count_stmt->execute();
                        $total_courses = $count_stmt->fetch(PDO::FETCH_OBJ)->total_courses;
                    } else {
                        $total_courses = 0;
                    }
                    ?>
                    <div class="stat-number"><?php echo $total_courses; ?></div>
                    <div class="stat-label">Enrolled Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="stat-number">2</div>
                    <div class="stat-label">Certificates Earned</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">12h</div>
                    <div class="stat-label">Learning Time</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-number">4.8</div>
                    <div class="stat-label">Average Rating</div>
                </div>
            </div>

            <div class="recent-courses">
                <h2 class="section-title">Ongoing Courses</h2>
                <div class="course-list">
                    <?php
                    if ($etudiant) {
                        // Requête pour récupérer les cours de l'utilisateur
                        $sql = "SELECT f.titre, f.categorie, f.description, f.image, i.statut, i.id as inscription_id
                               FROM formation f 
                               INNER JOIN inscriptions i ON f.id = i.formation_id 
                               WHERE i.etudiant_id = :etudiant_id 
                               AND i.statut = 'active'
                               LIMIT 3";
                        $stmt = $connexion->prepare($sql);
                        $stmt->bindParam(':etudiant_id', $etudiant->id, PDO::PARAM_INT);
                        $stmt->execute();

                        // Débogage des résultats
                        echo "<!-- Nombre de résultats : " . $stmt->rowCount() . " -->";
                        
                        if ($stmt->rowCount() == 0) {
                            echo "<div class='course-item'>
                                    <h3 class='course-title'>No active courses found</h3>
                                    <p>You are not enrolled in any courses yet or all your courses are completed.</p>
                                    <a href='allcourses.php' class='btn-submit' style='display: inline-block; margin-top: 10px;'>Explore courses</a>
                                  </div>";
                        }

                        while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "
                            <div class='course-item'>
                                <h3 class='course-title'>{$row->titre}</h3>
                                <div class='course-progress'>
                                    <div class='progress-bar' style='width: 65%'></div>
                                </div>
                                <div class='course-stats'>
                                    <span>Progress: 65%</span>
                                    <span>Status: " . ucfirst($row->statut) . "</span>
                                </div>
                            </div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
