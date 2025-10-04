<?php 
session_start();
$isLoggedIn = isset($_SESSION["user"]);
?>

<!DOCTYPE html>
<html>
<head>
	<!--  *****   Link To Custom CSS Style Sheet   *****  -->
	<link rel="stylesheet" type="text/css" href="style.css">

	<!--  *****   Link To Font Awsome Icons   *****  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>

	<!--  *****   Link To Owl Carousel   *****  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Bright Future</title>

	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
		
		.notifications {
			position: fixed;
			top: 30px;
			right: 20px;
			z-index: 9999;
		}
		
		.toast {
			position: relative;
			padding: 10px;
			color: #fff;
			margin-bottom: 10px;
			width: 300px;
			display: grid;
			grid-template-columns: 50px 1fr 50px;
			border-radius: 5px;
			--color: #0abf30;
			background-image: linear-gradient(to right, #0abf3055, #22242f 30%);
			animation: show 0.3s ease 1 forwards;
		}
		
		.toast i {
			color: var(--color);
			display: flex;
			justify-content: center;
			align-items: center;
			font-size: large;
		}
		
		.toast .title {
			font-size: large;
			font-weight: bold;
		}
		
		.toast span, .toast i:nth-child(3) {
			color: #fff;
			opacity: 0.6;
		}
		
		@keyframes show {
			0% { transform: translateX(100%); }
			40% { transform: translateX(-5%); }
			80% { transform: translateX(0%); }
			100% { transform: translateX(-10%); }
		}
		
		.toast::before {
			position: absolute;
			bottom: 0;
			left: 0;
			background-color: var(--color);
			width: 100%;
			height: 3px;
			content: '';
			box-shadow: 0 0 10px var(--color);
			animation: timeOut 5s linear 1 forwards;
		}
		
		@keyframes timeOut {
			to { width: 0; }
		}
	</style>
</head>
<body>
<!--   *** Website Container Starts ***   -->
<div class="website-container">
	
<!--   *** Home Section Starts ***   -->
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
			<li><a href="index.php#contact">Contact</a></li>
			<?php if (isset($_SESSION["user"])): ?>
				<li><a href="tableau.php">My Dashboard</a></li>
			<?php endif; ?>
		</ul>
		<?php if ($isLoggedIn): ?>
			<a href="logout.php" class="get-started-btn-container">
				<button class="get-started-btn btn">Logout</button>
		    </a>
		<?php else: ?>
			<a href="log.php" class="get-started-btn-container">
				<button class="get-started-btn btn">Login</button>
		    </a>		
		<?php endif; ?>
		<div class="menu-btn">
			<span></span>
		</div>
	</nav>
	<!--   === Main Navbar Ends ===   -->
	<!--   === Banner Starts ===   -->
	<div class="banner">
		
		<div class="banner-desc">
			<h2>Start Learning With Our Experts, Anywhere, Anytime</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
			<form class="search-bar" method="get" action="sea.php">
				<input type="search" name="search" placeholder="Search Your Course">
				<i class="fa-solid fa-search"></i>
			</form>
		</div>

		<div class="banner-img">
			<div class="banner-img-container">
				<img src="images/home/student.png">

				<div class="states">
					<div class="total-courses">
						<div class="icon">
							<i class="fa-solid fa-book"></i>
						</div>
						<div class="desc">
							<span>284+</span>
							<span>Total Courses</span>
						</div>
					</div>

					<div class="courses-ratings">
						<span>4.7<i class="fa-solid fa-star"></i></span>
						<span>Ratings (58k)</span>
					</div>
				</div>

				<div class="pattern">
					<img src="images/home/pattern.png">
				</div>

			</div>
		</div>

	</div>
	<!--   === Banner Ends ===   -->
</section>
<!--   *** Home Section Ends ***   -->

<!--   *** Partners Section Starts ***   -->
<section class="partners">
	<h3>Our trusted partners around the world</h3>
	<div class="owl-carousel owl-theme partners-slider">

    	<div class="item brand-item">
    		<img src="images/brand-logos/matoontapa.png">
    	</div>
    	<div class="item brand-item">
    		<img src="images/brand-logos/khostan.png">
    	</div>
    	<div class="item brand-item">
    		<img src="images/brand-logos/etimadya.png">
    	</div>
    	<div class="item brand-item">
    		<img src="images/brand-logos/torghar.png">
    	</div>
    	<div class="item brand-item">
    		<img src="images/brand-logos/nadershakot.png">
    	</div>
    	<div class="item brand-item">
    		<img src="images/brand-logos/almarah.png">
    	</div>

	</div>
</section>
<!--   *** Partners Section Ends ***   -->

<!--   *** Services Section Starts ***   -->
<section class="services" id="services">
	<!--   *** Services Header Starts ***   -->
	<header class="section-header">
		<h1>Why Choose Us</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	</header>
	<!--   *** Services Header Ends ***   -->
	<!--   *** Services Contents Starts ***   -->
	<div class="services-contents">

		<div class="service-box">
			<div class="service-icon">
				<i class="fa-solid fa-calendar"></i>
			</div>
			<div class="service-desc">
				<h2>Flexible Timing</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>

		<div class="service-box">
			<div class="service-icon">
				<i class="fa-solid fa-users"></i>
			</div>
			<div class="service-desc">
				<h2>Expert Teachers</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>

		<div class="service-box">
			<div class="service-icon">
				<i class="fa-solid fa-clock"></i>
			</div>
			<div class="service-desc">
				<h2>24/7 Live Support</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>

	</div>
	<!--   *** Services Contents Ends ***   -->
</section>
<!--   *** Services Section Ends ***   -->

<!--   *** Courses Section Starts ***   -->
	
<?php
require_once 'connection_db.php';
$sql = "SELECT id, titre, prix, categorie, description, image, imgFormateur FROM formation ORDER BY id LIMIT 6";
$stmt=$connexion->query($sql);
$count = $stmt->rowCount();
if($count){
?>
<section class='courses' id='courses'>
<header class='section-header'>
	<div class='header-text'>
		<h1>Choose Your Favourite Course</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	</div>
	<a href="allcourses.php"><button class='courses-btn btn'>View All</button></a>
</header>

<div class='course-contents'> <!-- ✅ Ce div doit être en dehors de la boucle -->
	<?php while($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
		<div class='course-card'>
			<a href='inf.php?id=<?= $row->id ?>'><img src='image/<?= $row->image ?>'></a>
			<div class='category'>
				<div class='subject'><h3><?= $row->categorie ?></h3></div>
				<img src='image/<?= $row->imgFormateur ?>'>
			</div>
			<h2 class='course-title'><?= $row->description ?></h2>
			<div class='course-desc'>
				<span><i class='fa-solid fa-video'></i> 45 Videos</span>
				<span><i class='fa-solid fa-users'></i> 2154+ Students</span>
			</div>
			<div class='course-ratings'>
				<span>4.9 <i class='fa-solid fa-star'></i></span>
				<span><b>$</b><?= $row->prix ?></span>
			</div>
		</div>
	<?php } ?>
	<?php } ?>
</div> <!-- ✅ fin du .course-contents -->
</section>
	<!--   *** Courses Contents Ends ***   -->
</section>
<!--   *** Courses Section Ends ***   -->

<!--   *** Courses Categories Section Starts ***   -->
<section class="categories" id="categories">
	<!--   === Categories Section Header Starts ===   -->
	<header class="section-header">
		<h1>Browse Courses By Categories</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	</header>
	<!--   === Categories Section Header Ends ===   -->
	<!--   === Categories Section Contents Starts ===   -->
	<div class="categories-contents">
		
		<div class="category-item">
			<div class="category-icon">
				<i class="fa-solid fa-palette"></i>
			</div>
			<div class="category-desc">
				<h3>Designing</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>

		<div class="category-item">
			<div class="category-icon">
				<i class="fa-solid fa-code"></i>
			</div>
			<div class="category-desc">
				<h3>Development</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>

		<div class="category-item">
			<div class="category-icon">
				<i class="fa-solid fa-bullhorn"></i>
			</div>
			<div class="category-desc">
				<h3>Marketing</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>

		<div class="category-item">
			<div class="category-icon">
				<i class="fa-solid fa-camera"></i>
			</div>
			<div class="category-desc">
				<h3>Photography</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div>
		</div>

	</div>
	<!--   === Categories Section Contents Ends ===   -->
</section>
<!--   *** Courses Categories Section Ends ***   -->

<!--   *** Teacher Section Starts ***   -->
<section class="instructor">
	<div class="instructor-container">
		<h2>Become an instructor with Bright Future Platform</h2>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
	</div>
</section>
<!--   *** Teacher Section Ends ***   -->
<section class="instructor" id="contact">
	<?php if(isset($_SESSION['success'])): ?>
		<div class="alert alert-success">
			<?= $_SESSION['success']; ?>
			<?php unset($_SESSION['success']); ?>
		</div>
	<?php endif; ?>
	
	<?php if(isset($_SESSION['error'])): ?>
		<div class="alert alert-error">
			<?= $_SESSION['error']; ?>
			<?php unset($_SESSION['error']); ?>
		</div>
	<?php endif; ?>
	
	<header class="section-header">
		<h1>Contact us</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	</header>
    <div class="contact-container">
        <div class="contact-info">
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h3>Our Address</h3>
                    <p>123 Safi Street, SAFI</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <div>
                    <h3>Phone</h3>
                    <p>+212 123 456 789</p>
                </div>
            </div>
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <h3>Email</h3>
                    <p>thegoat6864@gmail.com</p>
                </div>
            </div>
        </div>
        <div class="contact-form">
            <form action="traitement_contact.php" method="POST">
                <div class="form-group">
                    <input type="text" name="nom" placeholder="Your name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="sujet" placeholder="Subject" required>
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Your message" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </div>
</section>
<!--   *** Testimonials Section Starts ***   -->
<section class="testimonials" id="testimonials">
    <!--   === Testimonials Section Header Starts ===   -->
    <header class="section-header">
        <h1>Testimonials</h1>
        <p>Discover what our users say about us</p>
    </header>
    <!--   === Testimonials Section Header Ends ===   -->
    <!--   === Testimonials Contents Starts ===   -->
    <div class="owl-carousel owl-theme testimonials-slider">
        <?php
        require_once 'connection_db.php';
        $sql = "SELECT * FROM testimonials ORDER BY date_creation DESC";
        $stmt = $connexion->query($sql);
        while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        ?>
        <div class="item testimonials-item">
            <div class="profile">
                <div class="profile-image">
                    <img src="images/testimonials/student-1.jpg">
                </div>
                <div class="profile-desc">
                    <span><?= htmlspecialchars($row->nom) ?></span>
                    <span><?= htmlspecialchars($row->sujet) ?></span>
                </div>
            </div>
            <p><?= htmlspecialchars($row->message) ?></p>
            <div class="quote">
                <i class="fa fa-quote-left"></i>
            </div>
            <div class="ratings">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
            </div>
        </div>
        <?php } ?>
    </div>
    <!--   === Testimonials Contents Ends ===   -->
</section>
<!--   *** Testimonials Section Ends ***   -->

<!--   *** Footer Section Starts ***   -->
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
<!--   *** Footer Section Ends ***   -->

<!--   *** Contact Section Ends ***   -->

<style>
.contact {
    padding: 80px 0;
}

.contact-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 40px;
    padding: 0 20px;
}

.contact-info {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 30px;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item i {
    font-size: 24px;
    color: #208245;
    margin-top: 5px;
}

.info-item h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 5px;
}

.info-item p {
    color: #666;
    font-size: 16px;
}

.contact-form {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 20px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-group textarea {
    height: 150px;
    resize: vertical;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #208245;
    outline: none;
    box-shadow: 0 0 5px rgba(32, 130, 69, 0.2);
}

.submit-btn {
    width: 100%;
    padding: 15px;
    background: #208245;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.submit-btn:hover {
    background: #1a6b38;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .contact-container {
        grid-template-columns: 1fr;
    }
}

.alert {
    padding: 15px;
    margin: 20px auto;
    max-width: 1200px;
    border-radius: 8px;
    text-align: center;
    font-weight: 500;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

</div>
<!--   *** Website Container Ends ***   -->

<!--  *****   Link To JQuery   *****  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!--  *****   Link To Owl Carousel JS   *****  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!--  *****   Link To Custom JavaScript File   *****  -->
<script type="text/javascript" src="script.js"></script>

<div class="notifications"></div>

<script>
function createToast(type, icon, title, text) {
    let notifications = document.querySelector('.notifications');
    let newToast = document.createElement('div');
    newToast.innerHTML = `
        <div class="toast ${type}">
            <i class="${icon}"></i>
            <div class="content">
                <div class="title">${title}</div>
                <span>${text}</span>
            </div>
            <i class="fa-solid fa-xmark" onclick="(this.parentElement).remove()"></i>
        </div>`;
    notifications.appendChild(newToast);
    newToast.timeOut = setTimeout(() => newToast.remove(), 5000);
}

// Modifier le formulaire de contact pour utiliser la notification
document.querySelector('.contact-form form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Récupérer les données du formulaire
    const formData = new FormData(this);
    
    // Envoyer les données via fetch
    fetch('traitement_contact.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        createToast(
            'success',
            'fa-solid fa-circle-check',
            'Success',
            'Your message has been sent successfully!'
        );
        this.reset();
    })
    .catch(error => {
        createToast(
            'error',
            'fa-solid fa-circle-exclamation',
            'Error',
            'An error occurred while sending the message.'
        );
    });
});
</script>
</body>
</html>