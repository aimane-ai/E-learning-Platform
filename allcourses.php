<?php 
session_start();
$isLoggedIn = isset($_SESSION["user"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les Cours - Bright Future</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <style>
        .all-courses {
            padding: 80px 0 40px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .courses-header {
            max-width: 1200px;
            margin: 0 auto 40px;
            text-align: center;
        }

        .courses-header h1 {
            font-size: 36px;
            color: #1a1a1a;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .courses-header p {
            font-size: 18px;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .courses-description {
            width: 100%;
            background: white;
            padding: 60px 0;
            margin-bottom: 50px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .description-header {
            max-width: 1200px;
            margin: 0 auto 50px;
            text-align: center;
            padding: 0 20px;
        }

        .description-header h1 {
            font-size: 36px;
            color: #1a1a1a;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .description-header p {
            font-size: 18px;
            color: #666;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto;
        }

        .description-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 0 20px;
        }

        .description-item {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .description-item:hover {
            transform: translateY(-5px);
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .description-item i {
            font-size: 40px;
            color: #208245;
            margin-bottom: 20px;
        }

        .description-item h3 {
            font-size: 20px;
            color: #1a1a1a;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .description-item p {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
        }

        .courses-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px;
        }

        .course-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        .course-card:hover {
            transform: translateY(-10px);
        }

        .course-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .course-content {
            padding: 25px;
        }

        .course-category {
            display: inline-block;
            padding: 6px 12px;
            background: #208245;
            color: white;
            border-radius: 20px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .course-title {
            font-size: 20px;
            color: #1a1a1a;
            margin-bottom: 15px;
            font-weight: 600;
            line-height: 1.4;
        }

        .course-description {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .course-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .course-price {
            font-size: 24px;
            color: #208245;
            font-weight: 700;
        }

        .course-rating {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .course-rating i {
            color: #ffd700;
        }

        .view-course-btn {
            display: inline-block;
            padding: 12px 25px;
            background: #208245;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .view-course-btn:hover {
            background: #1a6b38;
            transform: translateY(-2px);
        }

        @media (max-width: 992px) {
            .description-content {
                grid-template-columns: repeat(2, 1fr);
            }

            .description-header h1 {
                font-size: 32px;
            }
        }

        @media (max-width: 768px) {
            .courses-description {
                padding: 40px 0;
            }

            .description-content {
                grid-template-columns: 1fr;
            }

            .description-header h1 {
                font-size: 28px;
            }

            .description-header p {
                font-size: 16px;
            }

            .courses-grid {
                grid-template-columns: 1fr;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
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
            <li><a href="index.php#contact">Contact</a></li>
            <?php if ($isLoggedIn): ?>
                <li><a href="profile.php">Mon Espace</a></li>
            <?php endif; ?>
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

    <div class="all-courses">
        <div class="courses-description">
            <div class="description-header">
                <h1>Explorez Notre Catalogue de Formations</h1>
                <p>Découvrez une sélection complète de formations professionnelles conçues pour vous aider à développer vos compétences et à atteindre vos objectifs de carrière. Que vous soyez débutant ou expert, nos cours sont adaptés à tous les niveaux.</p>
            </div>
            <div class="description-content">
                <div class="description-item">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Formations de Qualité</h3>
                    <p>Des cours créés par des experts du domaine pour vous garantir un apprentissage de qualité.</p>
                </div>
                <div class="description-item">
                    <i class="fas fa-clock"></i>
                    <h3>Apprentissage Flexible</h3>
                    <p>Apprenez à votre rythme, où que vous soyez, avec un accès illimité au contenu.</p>
                </div>
                <div class="description-item">
                    <i class="fas fa-certificate"></i>
                    <h3>Certification</h3>
                    <p>Obtenez un certificat reconnu à la fin de chaque formation pour valoriser vos compétences.</p>
                </div>
            </div>
        </div>

        <div class="courses-grid">
            <?php
            require_once 'connection_db.php';
            $sql = "SELECT id, titre, prix, categorie, description, image FROM formation ORDER BY id";
            $stmt = $connexion->query($sql);
            
            while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                echo "
                <div class='course-card'>
                    <img src='image/{$row->image}' alt='{$row->titre}' class='course-image'>
                    <div class='course-content'>
                        <span class='course-category'>{$row->categorie}</span>
                        <h2 class='course-title'>{$row->titre}</h2>
                        <p class='course-description'>{$row->description}</p>
                        <div class='course-footer'>
                            <div class='course-price'>{$row->prix} dh</div>
                            <div class='course-rating'>
                                <i class='fas fa-star'></i>
                                <span>4.9</span>
                            </div>
                        </div>
                        <a href='inf.php?id={$row->id}' class='view-course-btn'>Voir le cours</a>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</section>
<section class="footer" id="footer">
	
	<!--   === Footer Contents Starts ===   -->
	<div class="footer-contents">
		
		<div class="footer-col footer-col-1">
			<div class="col-title">
				<img src="images/home/logo.png">
			</div>
			<div class="col-contents">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.</p>
			</div>
		</div>

		<div class="footer-col footer-col-2">
			<div class="col-title">
				<h3>Contact</h3>
			</div>
			<div class="col-contents">
				<div class="contact-row">
					<span>Address</span>
					<span>1234 Street, SAFI, MOROCCO</span>
				</div>
				<div class="contact-row">
					<span>Phone</span>
					<span>+212 634 23456</span>
				</div>
				<div class="contact-row">
					<span>Website</span>
					<span>Bright Future</span>
				</div>
				<div class="contact-row">
					<span>Email</span>
					<span>thegoat6864@gmail.com</span>
				</div>
			</div>
		</div>

		<div class="footer-col footer-col-3">
			<div class="col-title">
				<h3>Quick Links</h3>
			</div>
			<div class="col-contents">
				<a href="#">Home</a>
				<a href="#">Services</a>
				<a href="#">Courses</a>
				<a href="#">Categories</a>
				<a href="#">Testimonials</a>
			</div>
		</div>

		<div class="footer-col footer-col-4">
			<div class="col-title">
				<h3>Newsletter</h3>
			</div>
			<div class="col-contents">
				<form class="newsletter">
					<input type="email" placeholder="Your Email">
					<button class="newsletter-btn btn" type="submit">Subscribe</button>
				</form>
			</div>
		</div>

	</div>
	<!--   === Footer Contents Ends ===   -->
	<div class="copy-rights">
		<p>Created By <b>Aimane Elouarrate</b> All Rights Reserved</p>
	</div>

</section>

<!--  *****   Link To JQuery   *****  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!--  *****   Link To Custom JavaScript File   *****  -->
<script type="text/javascript" src="script.js"></script>
</body>
</html>
