<!DOCTYPE html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@500&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="../assets/css/style.css?v=1">
		<link rel="stylesheet" href="../assets/css/card-page.css?v=1">
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/d1269851a5.js" crossorigin="anonymous"></script>
		
		<link rel="icon" href="../assets/favicon.png">
		<title>Suggest a feature - Maple</title>
	</head>
	<body>
		<nav class="navbar navbar-dark navbar-expand-lg fixed-top">
			<a class="navbar-brand" href="https://maple.software/">
				<img src="../assets/favicon.png" width="30" height="30" class="d-inline-block align-top" alt="">
				Maple
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav mx-auto">
					<li class="nav-item">
						<a class="nav-link" href="https://maple.software/"><i class="fa-solid fa-house"></i> Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="../help"><i class="fa-solid fa-headset"></i> Help</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="../discord"><i class="fa-brands fa-discord"></i> Community</a>
					</li>
				</ul>
				<?php
					require_once "../backend/Database/databaseHandler.php";
					require_once "../backend/Sessions/sessionHandler.php";
					$LoggedIn = getSession($dbConn) != null;
				?>
				<span>
					<button type="button" onclick="location.href='<?= $LoggedIn ? "../dashboard" : "../auth/login" ?>';" class="btn btn-outline-primary"><?= $LoggedIn ? "Dashboard" : "Log in" ?></button>
					<button type="button" onclick="location.href='<?= $LoggedIn ? "../auth/logout" : "../auth/signup" ?>';" class="btn btn-outline-primary"><?= $LoggedIn ? "Log out" : "Sign up" ?></button>
				</span>
			</div>
		</nav>
		
		<div id="content" class="d-flex flex-column justify-content-center align-items-center">
			<div class="card plan-card mb-4 shadow-sm">
				<div class="card-header">
					<h4 class="my-0 fw-normal text-center">Report a bug</h4>
				</div>
				<div class="card-body">
					<h5>How can I suggest a feature?</h5>
					<p>
						You can suggest a feature by opening a new issue in our <a href="https://github.com/maplesyrupuwu/Maple-tracker-for-osu">GitHub repository</a>. Alternatively you can also do so in the <b>#suggestions</b> channel on our <a href="../discord">discord server</a>, but we highly encourage everyone to use <b>GitHub</b> instead because it's much more organized.
					</p>
				</div>
			</div>
		</div>
		
		<footer class="footer mt-auto">
			<div class="footer-container container d-flex justify-content-between">
				<p class="my-auto">Copyright © 2021-2022 maple.software. All rights reserved.</p>
				<ul class="nav flex-column flex-sm-row">
					<li class="nav-item">
						<a class="nav-link" href="contact-us">Contact Us</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="terms-of-service">Terms of Service</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="privacy-policy">Privacy Policy</a>
					</li>
				</ul>
			</div>
		</footer>
	</body>
</html>