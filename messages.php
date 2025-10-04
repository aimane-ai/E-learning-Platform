<?php
session_start();
require_once 'connection_db.php';

if (!isset($_SESSION["user"])) {
    header("Location: log.php");
    exit();
}

$messages = [];
$error = null;

try {
    $sql_etudiant = "SELECT id, email FROM etudiant WHERE login = :login";
    $stmt_etudiant = $connexion->prepare($sql_etudiant);
    $stmt_etudiant->execute([':login' => $_SESSION["user"]]);
    $etudiant = $stmt_etudiant->fetch(PDO::FETCH_OBJ);

    if ($etudiant) {
        // Récupérer les messages avec leurs réponses
        $sql_messages = "SELECT t.*, r.reponse, r.date_reponse 
                        FROM testimonials t 
                        LEFT JOIN reponses_commentaires r ON t.id = r.id_commentaire
                        WHERE t.email = :email 
                        ORDER BY t.date_creation DESC";
        $stmt_messages = $connexion->prepare($sql_messages);
        $stmt_messages->execute([':email' => $etudiant->email]);
        $messages = $stmt_messages->fetchAll(PDO::FETCH_OBJ);
    } else {
        $error = "Erreur : Étudiant non trouvé";
    }
} catch(PDOException $e) {
    $error = "Erreur lors de la récupération des messages : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Messages</title>
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

        .messages-container { flex: 1; padding: 30px; }
        .messages-header h1 { color: #333; }

        .message-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .message-content {
            margin-bottom: 15px;
        }

        .message-date {
            color: #666;
            font-size: 0.9em;
        }

        .admin-response {
            margin-top: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #208245;
            border-radius: 0 5px 5px 0;
        }

        .admin-response h4 {
            color: #208245;
            margin: 0 0 10px 0;
        }

        .no-messages {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            <button class="get-started-btn btn">Logout</button>
        </a>
    </nav>

    <!-- DASHBOARD -->
    <div class="page-wrapper">
        <!-- Sidebar -->
        <aside class="dashboard-sidebar">
            <ul>
                <li><a href="inscriptions.php"><i class="fas fa-home"></i> Progress</a></li>
                <li><a href="inscriptions.php"><i class="fas fa-clipboard-list"></i> Mes Inscriptions</a></li>
                <li><a href="messages.php" class="active"><i class="fas fa-envelope"></i> Messages</a></li>
                <li><a href="profile.php"><i class="fas fa-user"></i> Mon Profil</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <!-- Contenu -->
        <div class="messages-container">
            <div class="messages-header">
                <h1>Mes Messages</h1>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (empty($messages)): ?>
                <div class="no-messages">
                    <i class="fas fa-envelope fa-3x" style="color: #ccc;"></i>
                    <h2>Aucun message</h2>
                    <p>Vous n'avez pas encore envoyé de message</p>
                </div>
            <?php else: ?>
                <?php foreach ($messages as $message): ?>
                    <div class="message-card">
                        <div class="message-content">
                            <p style="margin: 0 0 10px 0;"><strong>Vous :</strong></p>
                            <p style="margin: 0;"><?php echo htmlspecialchars($message->message); ?></p>
                            <span class="message-date"><?php echo date('d/m/Y H:i', strtotime($message->date_creation)); ?></span>
                        </div>
                        <?php if ($message->reponse): ?>
                            <div class="admin-response">
                                <h4><i class="fas fa-reply"></i> Réponse de l'administrateur</h4>
                                <p><?php echo htmlspecialchars($message->reponse); ?></p>
                                <span class="message-date"><?php echo date('d/m/Y H:i', strtotime($message->date_reponse)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 