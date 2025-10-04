<?php 
$isLoggedIn = isset($_SESSION["user"]);
?>
<?php
session_start();
require_once 'connection_db.php';


// Récupérer le terme de recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Préparer la requête SQL avec une recherche LIKE
$sql = "SELECT id, titre, prix, categorie, description, image 
        FROM formation 
        WHERE titre LIKE :search 
        OR categorie LIKE :search 
        ORDER BY id";
$stmt = $connexion->prepare($sql);
$stmt->execute([':search' => "%$search%"]);
$formations = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Résultats de recherche - Bright Future</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        .search-results {
            padding: 80px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .search-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .search-header h1 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .search-header p {
            color: #666;
        }
        
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .course-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
        }
        
        .course-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .course-card .category {
            padding: 15px;
            background: #f8f9fa;
        }
        
        .course-card .category h3 {
            color: #208245;
            margin: 0;
        }
        
        .course-card .course-title {
            padding: 15px;
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .course-card .course-desc {
            padding: 0 15px;
            display: flex;
            justify-content: space-between;
            color: #666;
        }
        
        .course-card .course-ratings {
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
        }
        
        .course-card .course-ratings i {
            color: #ffc107;
        }
        
        .no-results {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #208245;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background 0.3s ease;
        }
        
        .back-btn:hover {
            background: #1a6b38;
        }
    </style>
</head>
<body>
    <div class="website-container">
        <!-- Inclure la barre de navigation -->
    <section class="home" id="home">
	<!--   === Main Navbar Starts ===   -->
	<nav class="main-navbar">
		<a href="#" class="logo">
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
		<?php if ($isLoggedIn): ?>
			<a href="logout.php" class="get-started-btn-container">
				<button class="get-started-btn btn">Deconnexion</button>
		    </a>
		<?php else: ?>
			<a href="log.php" class="get-started-btn-container">
				<button class="get-started-btn btn">Connexion</button>
		    </a>		
		<?php endif; ?>
		<div class="menu-btn">
			<span></span>
		</div>
	</nav>


        <div class="search-results">
            <div class="search-header">
                <h1>Résultats de recherche pour "<?= htmlspecialchars($search) ?>"</h1>
                <p>Nous avons trouvé <?= count($formations) ?> formation(s) correspondant à votre recherche</p>
            </div>

            <?php if (count($formations) > 0): ?>
                <div class="results-grid">
                    <?php foreach ($formations as $formation): ?>
                        <div class='course-card'>
                        <a href='inf.php?id=<?= $formation->id ?>'><img src='image/<?= $formation->image ?>'></a>
                        <div class='category'>
                            <div class='subject'><h3><?= $formation->categorie ?></h3></div>
                            <img src='image/<?= $formation->image ?>'>
                        </div>
                        <h2 class='course-title'><?= $formation->description ?></h2>
                        <div class='course-desc'>
                            <span><i class='fa-solid fa-video'></i> 45 Videos</span>
                            <span><i class='fa-solid fa-users'></i> 2154+ Students</span>
                        </div>
                        <div class='course-ratings'>
                            <span>4.9 <i class='fa-solid fa-star'></i></span>
                            <span><b>$</b><?= $formation->prix ?></span>
                        </div>
		        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <h2>Aucun résultat trouvé</h2>
                    <p>Essayez avec d'autres mots-clés ou consultez toutes nos formations.</p>
                    <a href="index.php" class="back-btn">Retour à l'accueil</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html> 