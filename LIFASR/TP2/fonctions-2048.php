<?php
    function afffiche_sept_variables() {
 	    echo "HTTP_USER_AGENT="; echo $_SERVER['HTTP_USER_AGENT']; echo "<br />";
 	    echo "HTTP_HOST="; echo $_SERVER['HTTP_HOST']; echo "<br />";
 	    echo "DOCUMENT_ROOT="; echo $_SERVER['DOCUMENT_ROOT']; echo "<br />";
 	    echo "SCRIPT_FILENAME="; echo $_SERVER['SCRIPT_FILENAME']; echo "<br />";
 	    echo "PHP_SELF="; echo $_SERVER['PHP_SELF']; echo "<br />";
 	    echo "REQUEST_URI="; echo $_SERVER['REQUEST_URI']; echo "<br />";
 	    echo "action-joueur="; echo $_GET['action-joueur']; echo "<br />";	
    }

    function write_log($mesg) {
		$filename = "log.txt";

		$logs = file($filename);
		if (sizeof($logs) == 50) {
			unset($logs[0]);
  			file_put_contents($filename, $logs);
		}


        file_put_contents($filename, $mesg . "\n", FILE_APPEND);
    }

	function affiche_score() {
		global $score;
		fichier_vers_score();
	}

	function score_vers_fichier() {
		global $score;

		$filename = "score.txt";
		$score_file = file($filename);

        file_put_contents($filename, $score);
	}

	function fichier_vers_score() {
		global $score;

		$score = file_get_contents("score.txt");

		if ($score == "")
			$score = 0;
	}

	function nouvelle_partie() {
		global $score;
		$score = 0;
		score_vers_fichier();

		global $grille;
		$grille = array_fill(0, 4,array_fill(0, 4, 0));

		for ($k = 0; $k < 2; $k++) {
			$case = tirage_position_vide();

			$grille[$case[0]][$case[1]] = 2;
		}
	}

	function matrice_vers_fichier() {
		global $grille;

		$filename = "grille.txt";

		file_put_contents($filename, "");

		for ($i = 0; $i < 4; $i++) {
			for ($j = 0; $j < 4; $j++) {
				file_put_contents($filename, $grille[$i][$j], FILE_APPEND);

				if ($j < 3)
				file_put_contents($filename, " ", FILE_APPEND);
			}
			file_put_contents($filename, "\n", FILE_APPEND);
		}
	}

	function fichier_vers_matrice() {
		global $grille;

		// $chaine va contenir tout ce qu'il y a dans le fichier 'grille.txt'
		$chaine = file_get_contents('grille.txt');
		// on remplace dans $chaine tous les sauts de ligne par des espaces
		$chaine = str_replace("\n", " ", $chaine);
		// $valeurs est un tableau 1D qui va contenir tous les nombres de la grille
		$valeurs = explode(' ', $chaine);
		$n = 0;
		for ($i = 0; $i < 4 ; $i++) {
			for ($j = 0; $j < 4; $j++) {
				$grille[$i][$j] = (int) ($valeurs[$n]);
				$n++;
			}
		}
	}

	function affiche_case($i, $j) {
		global $grille;

		$valeur = $grille[$i][$j];

		switch ($valeur) {
			case 0:
				echo "<td class='c0'>" . $valeur . "</td>";
				break;
			case 2:
				echo "<td class='c2'>" . $valeur . "</td>";
				break;
			case 4:
				echo "<td class='c4'>" . $valeur . "</td>";
				break;
			case 8:
				echo "<td class='c8'>" . $valeur . "</td>";
				break;
			case 16:
				echo "<td class='c16'>" . $valeur . "</td>";
				break;
			case 32:
				echo "<td class='c32'>" . $valeur . "</td>";
				break;
			case 64:
				echo "<td class='c64'>" . $valeur . "</td>";
				break;
			case 128:
				echo "<td class='c128'>" . $valeur . "</td>";
				break;
			case 256:
				echo "<td class='c256'>" . $valeur . "</td>";
				break;
			case 512:
				echo "<td class='c512'>" . $valeur . "</td>";
				break;
			case 1024:
				echo "<td class='c1024'>" . $valeur . "</td>";
				break;
			case 2048:
				echo "<td class='c2048'>" . $valeur . "</td>";
				break;
		}
	}

	function tirage_position_vide() {
		global $grille;
		$i = 0;
		$j = 0;

		do {
			$i = rand(0, 3);
			$j = rand(0, 3);
		} while ($grille[$i][$j] != 0);

		return array($i, $j);
	}

	function grille_pleine() {
		global $grille;

		for ($i = 0; $i < 4; $i++) {
			for ($j = 0; $j < 4; $j++) {
				if ($grille[$i][$j] == 0) {
					return false;
				}
			}
		}
		return true;
	}

	function tirage_2ou4() {
		return rand(1,2)*2;
	}

	function place_nouveau_nb() {
		global $grille;

		if (!grille_pleine()) {
			$case = tirage_position_vide();
			$grille[$case[0]][$case[1]] = tirage_2ou4();
		}
	}

	function decale($tab) {
		$arr = array_fill(0,4,0);
		$i = 0;
		for ($j = 0; $j < 4; $j++) {
			if ($tab[$j] != 0) {
				$arr[$i] = $tab[$j];
				$i++;
			}
		}

		return $arr;
	}

	function fusion($tab) {
		global $score;

		if ($tab[0] == $tab[1]) {
			$tab[0] = 2 * $tab[0];
			$tab[1] = 0;

			$score += $tab[0];

			if ($tab[2] == $tab[3]) {
				$tab[2] = 2 * $tab[2];
				$tab[3] = 0;
				
				$score += $tab[2];
			}		
		} else if ($tab[1] == $tab[2]) {
			$tab[1] = 2 * $tab[1];
			$tab[2] = 0;

			$score += $tab[1];
		} else if ($tab[2] == $tab[3]) {
			$tab[2] = 2 * $tab[2];
			$tab[3] = 0;

			$score += $tab[2];
		}

		return $tab;
	}
?>