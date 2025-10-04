<?php 
session_start();
$isLoggedIn = isset($_SESSION["user"]);
if (!isset($_SESSION["user"])) {
    header("Location: log.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Formation - Bright Future</title>
    <link rel="stylesheet" href="style.css">
    <!--  *****   Link To Font Awsome Icons   *****  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <style>
        .course-details {
            padding: 80px 20px 40px;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .course-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
        }

        .course-info {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .course-image {
            
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .course-title {
            font-size: 32px;
            color: #208245;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .course-description {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 30px;
        }

        .course-price {
            font-size: 24px;
            color: #208245;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .course-price i {
            font-size: 20px;
        }

        .course-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .stars {
            display: flex;
            gap: 5px;
        }

        .stars i {
            color: #ffd700;
            font-size: 20px;
        }

        .rating-count {
            color: #666;
            font-size: 14px;
        }

        .course-features {
            margin-bottom: 30px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: #555;
        }

        .feature-item i {
            color: #208245;
            font-size: 18px;
        }

        /* Styles pour le formulaire d'inscription */
        .enrollment-form {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        

        .form-title {
            font-size: 28px;
            color: #1a1a1a;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }

        .form-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #208245;
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #4a4a4a;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            color: #1a1a1a;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #208245;
            outline: none;
            box-shadow: 0 0 0 4px rgba(32, 130, 69, 0.1);
            background: white;
        }

        .form-group input:focus + label,
        .form-group select:focus + label {
            color: #208245;
        }

        .form-group input::placeholder {
            color: #adb5bd;
        }

        .form-group select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23208245' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
            padding-right: 45px;
        }

        .enroll-button {
            width: 100%;
            padding: 18px;
            background: #208245;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .enroll-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .enroll-button:hover {
            background: #1a6b38;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(32, 130, 69, 0.2);
        }

        .enroll-button:hover::before {
            left: 100%;
        }

        @media (max-width: 768px) {
            .course-container {
                grid-template-columns: 1fr;
            }

            .enrollment-form {
                padding: 25px;
                position: static;
            }

            .form-title {
                font-size: 24px;
            }

            .form-group input,
            .form-group select {
                padding: 12px;
            }

            .enroll-button {
                padding: 15px;
                font-size: 16px;
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
			<li><a href="index.php#contact">contact</a></li>
            <li><a href="profile.php">Mon Espace</a></li>
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

    <div class="course-details">
        <?php
        require_once 'connection_db.php';

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']);

            $sql = "SELECT id, titre, prix, image, description FROM formation WHERE id = :id";
            $stmt = $connexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount()) {
                while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "
                    <div class='course-container'>
                        <div class='course-info'>
                            <img src='image/{$row->image}' alt='{$row->titre}' class='course-image'>
                            <h1 class='course-title'>{$row->titre}</h1>
                            <div class='course-rating'>
                                <div class='stars'>
                                    <i class='fas fa-star'></i>
                                    <i class='fas fa-star'></i>
                                    <i class='fas fa-star'></i>
                                    <i class='fas fa-star'></i>
                                    <i class='fas fa-star'></i>
                                </div>
                                <span class='rating-count'>(4.9 - 128 avis)</span>
                            </div>
                            <p class='course-description'>{$row->description}</p>
                            <div class='course-features'>
                                <div class='feature-item'>
                                    <i class='fas fa-clock'></i>
                                    <span>Durée: 10 semaines</span>
                                </div>
                                <div class='feature-item'>
                                    <i class='fas fa-video'></i>
                                    <span>45 leçons vidéo</span>
                                </div>
                                <div class='feature-item'>
                                    <i class='fas fa-certificate'></i>
                                    <span>Certificat inclus</span>
                                </div>
                            </div>
                            <div class='course-price'>
                                <i class='fas fa-tag'></i>
                                <span>{$row->prix} dh</span>
                            </div>
                        </div>
                        <div class='enrollment-form'>
                            <h2 class='form-title'>S'inscrire à cette formation</h2>
                            <form action='traitement_inscription.php' method='POST'>
                                <input type='hidden' name='formation_id' value='{$row->id}'>
                                <div class='form-group'>
                                    <label for='nom'>Nom complet</label>
                                    <input type='text' id='nom' name='nom' required>
                                </div>
                                <div class='form-group'>
                                    <label for='email'>Email</label>
                                    <input type='email' id='email' name='email' required>
                                </div>
                                <div class='form-group'>
                                    <label for='telephone'>Téléphone</label>
                                    <input type='tel' id='telephone' name='telephone' required>
                                </div>
                                <div class='form-group'>
                                    <label for='niveau'>Niveau d'études</label>
                                    <select id='niveau' name='niveau' required>
                                        <option value=''>Sélectionnez votre niveau</option>
                                        <option value='debutant'>Débutant</option>
                                        <option value='intermediaire'>Intermédiaire</option>
                                        <option value='avance'>Avancé</option>
                                    </select>
                                </div>
                               <button type='submit' class='enroll-button'>S'inscrire maintenant</button>
                            </form>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p class='error-message'>Aucune formation trouvée.</p>";
            }
        } else {
            echo "<p class='error-message'>ID non valide.</p>";
        }
        ?>
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
