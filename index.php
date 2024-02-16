<?php 

session_start()?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>Domaine de Malakoff</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SYopr4z+L4pDP+UAfm4MWfRdZx2uNoEFe8rLlQ" crossorigin="anonymous">
		<link href="styles/style.css" rel="stylesheet"/>
		<link rel="shortcut icon" href="images/logo.jpg" type="image/x-icon">
		<link rel="stylesheet" href="node_modules/flatpickr/dist/flatpickr.min.css">



		


	</head>
	<body>
		<?php
			include_once 'controller/controleurPrincipal.php';

		?>
		<script src="scripts/script.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<script src="node_modules/flatpickr/dist/flatpickr.min.js"></script>
	</body>
</html>
