<!DOCTYPE HTML>
<html lang="en">

<head>
	<title><?= $title ?? 'Bōna | blog personnel' ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Ropa+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
	<link href="public/common-css/bootstrap.css" rel="stylesheet">
	<link href="public/common-css/ionicons.css" rel="stylesheet">
	<link href="public/layout-1/css/styles.css" rel="stylesheet">
	<link href="public/layout-1/css/responsive.css" rel="stylesheet">
	<link href="public/single-post-3/css/styles.css" rel="stylesheet">
	<link href="public/single-post-3/css/responsive.css" rel="stylesheet">
	<link href="public/css/style.css" rel="stylesheet">
</head>

<body>
	<header>
		<div class="container-fluid position-relative no-side-padding">
			<a href="post&home" class="logo"><img src="public/images/logo.png" alt="Logo Image"></a>
			<ul class="main-menu visible-on-click">
				<?php if (isset($_SESSION['id'])) { ?>
					<li><a href="user&disconnect">Se déconnecter</a></li>
					<?php if (($_SESSION['role']) == 1) { ?>
						<li><a href="post&newPost">Nouvel article</a></li>
					<?php } ?>
					<li><a href="user&profile"><?php echo $_SESSION['firstName'] ?></a></li>
				<?php } else { ?>
					<li><a href="user&connect">Se connecter</a></li>
					<li><a href="user&register">S’inscrire</a></li>
				<?php } ?>
				<li><a href="service&contact">Contact</a></li>
			</ul>
		</div>
	</header>
	<?= $content ?>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6">
					<div class="footer-section">
						<a class="logo" href="#"><img src="public/images/logo.png" alt="Logo Image"></a>
						<p class="copyright">AllanFontaine @ <?= date("Y") ?> All rights reserved</p>
						<ul class="icons">
							<li><a href="#"><i class="ion-social-facebook-outline"></i></a></li>
							<li><a href="#"><i class="ion-social-twitter-outline"></i></a></li>
							<li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
							<li><a href="#"><i class="ion-social-vimeo-outline"></i></a></li>
							<li><a href="#"><i class="ion-social-pinterest-outline"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="footer-section">
						<h4 class="title"><b>CATÉGORIES</b></h4>
						<ul>
							<li><a href="service&contact">CONTACT</a></li>
							<li><a href="https://github.com/zakariaeddouh">GITHUB</a></li>
							<li><a href="#">MENTION LÉGALE</a></li>
						</ul>
						<ul>
							<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 1) { ?>
								<li><a href="admin&userManagement">ADMINISTRATION</a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="footer-section">
						<h4 class="title"><b>S'ABONNER</b></h4>
						<div class="input-area">
							<form>
								<input class="email-input" type="text" placeholder="Entrez votre email">
								<button class="submit-btn" type="submit"><i class="icon ion-ios-email-outline"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- SCIPTS -->
	<script src="public/common-js/jquery-3.1.1.min.js" type="text/javascript"></script>
	<script src="public/common-js/tether.min.js" type="text/javascript"></script>
	<script src="public/common-js/bootstrap.js" type="text/javascript"></script>
	<script src="public/common-js/scripts.js" type="text/javascript"></script>
</body>

</html>