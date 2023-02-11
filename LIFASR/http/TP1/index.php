<!doctype html>
<!-- calculatrice.php -->
<html>
	<head>
		<meta charset="utf-8" />
		<title>Calculatrice</title>
		<style type="text/css">
			h1 {
				text-align: center;
			}

			.calculatrice {
				margin-left: 25%;
				margin-right:25%;
				width: 50%;
				text-align: center;
				background-color: #0080f8;
				border-radius: 20px;
				padding: 15px;
				color: white;
			}

			input, select {
				margin-bottom: 5px;
			}

			input[type="submit"] {
				border: 1px solid #004e97;
				border-radius: 5px;
				background-color: rgb(98, 202, 243);
				margin-bottom: 0;
			}
		</style>
	</head>
	
	<?php
		if (isset($_GET['operation']) && isset($_GET['nombre1']) && isset($_GET['nombre2'])) {
			$op= $_GET['operation'];
			$nombre1 = $_GET['nombre1'];
			$nombre2 = $_GET['nombre2'];
			calculatrice($nombre1, $nombre2, $op);
		}


		function calculatrice($nb1, $nb2, $op) {
			if (is_numeric($nb1) && is_numeric($nb2)) {
				global $resultat;

				switch ($op) {
					case "plus":
						$resultat = $nb1 + $nb2;
						break;
					case "moins":
						$resultat = $nb1 - $nb2;
						break;
					case "fois":
						$resultat = $nb1 * $nb2;
						break;
					case "barre":
						if ($nb2 == 0)
							$resultat = "Division par 0";
						else
							$resultat = $nb1 / $nb2;
					break;
				}
			}
		}
	?>
            
	<body>
		<h1>Calculatrice</h1>

		<div class="calculatrice">
			<p>Entrez deux nombres et l'opération choisie :</p>

			<form name="nom" method="get">
				<label for="nombre1">Nombre 1 :</label>
				<input name="nombre1" type="number" name="nombre1" value="<?php if (isset($nombre1)) echo $nombre1 ?>"/>
				<br />
				<select name="operation">
					<option value="plus" selected>+</option>
					<option value="moins">-</option>
					<option value="fois">*</option>
					<option value="barre">/</option>
				</select>
				<br />
				<label for="nombre2">Nombre 2 :</label>
				<input name="nombre2" type="number" name="nombre2" value="<?php if (isset($nombre1)) echo $nombre2 ?>" />
				<br />
				<br />
				<input type="submit" value="Valider"></input>
			</form>

			<h2>Resultat : 
				<?php
					if (isset($resultat)){
						echo $resultat;
					}
				?>
			</h2>
				
			<h3>Paramètres envoyés au serveur :</h3>
			<?php 
				foreach ($_GET as $k => $v) {
					echo $k . " : " . $v;
					echo "<br />";
				}
			?>
		</div>
	</body>
</html>
