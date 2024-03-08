<?php 

session_start()?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Domaine de Malakoff</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SYopr4z+L4pDP+UAfm4MWfRdZx2uNoEFe8rLlQ" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="styles/style.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="images/Logo2.png" type="image/x-icon">
		<link rel="stylesheet" href="node_modules/flatpickr/dist/flatpickr.min.css">

		<div
			class="fb-like"
			data-share="true"
			data-width="450"
			data-show-faces="true">
		</div>

		


	</head>
	<body>
		<?php
			include_once 'controller/controleurPrincipal.php';

		?>
		<script src="scripts/script.js"></script>
		<script src="scripts/facebook.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<script src="node_modules/flatpickr/dist/flatpickr.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/selenium-webdriver@4.0.0-alpha.7/dist/selenium-webdriver.min.js"></script>
		<script src="https://smtpjs.com/v3/smtp.js"></script>
		<script>    
			addEventListener("keydown", function(event) {
			if (event.key === "<" || event.key === ">") {
				event.preventDefault();
			}
			}, true);
		</script>
	</body>
</html>
