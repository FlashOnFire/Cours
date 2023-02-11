<?php 
    global $score;
    global $grille;
    global $perdu;

    require_once 'fonctions-2048.php';

    //afffiche_sept_variables();

    affiche_score();
    fichier_vers_matrice();

    $perdu = grille_pleine() && fusion_impossible();

    if (isset($_GET['action-joueur'])) {
        $action = $_GET['action-joueur'];

        write_log($action);
        
        if ($action == "Nouvelle partie") {
            nouvelle_partie();
            $perdu = false;
        } else if (!$perdu) {
            if ($action == "Gauche" || $action == "Droite" || $action == "Haut" || $action == "Bas") {
                place_nouveau_nb();

                switch ($action) {
                    case "Gauche":
                        for ($i = 0; $i < 4; $i++) {
                            $grille[$i] = decale($grille[$i]);
                            $grille[$i] = fusion($grille[$i]);
                            $grille[$i] = decale($grille[$i]);
                        }
                        break;
                    case "Droite":
                        for ($i = 0; $i < 4; $i++) {
                            $grille[$i] = array_reverse($grille[$i]);

                            $grille[$i] = decale($grille[$i]);
                            $grille[$i] = fusion($grille[$i]);
                            $grille[$i] = decale($grille[$i]);

                            $grille[$i] = array_reverse($grille[$i]);
                        }
                        break;
                    case "Haut":
                        for ($i = 0; $i < 4; $i++) {
                            $col = array();
                            for ($j = 0; $j < 4; $j++) {
                                $col[$j] = $grille[$j][$i];
                            }

                            $col = decale($col);
                            $col = fusion($col);
                            $col = decale($col);

                            for ($j = 0; $j < 4; $j++) {
                                $grille[$j][$i] = $col[$j];
                            }
                        }
                        break;
                    case "Bas":
                        for ($i = 0; $i < 4; $i++) {
                            $col = array();
                            for ($j = 0; $j < 4; $j++) {
                                $col[$j] = $grille[$j][$i];
                            }

                            $col = array_reverse($col);

                            $col = decale($col);
                            $col = fusion($col);
                            $col = decale($col);

                            $col = array_reverse($col);

                            for ($j = 0; $j < 4; $j++) {
                                $grille[$j][$i] = $col[$j];
                            }
                        }
                        break;

                }

                score_vers_fichier();
            }
        }
    }

    matrice_vers_fichier();
?>

<!doctype html> 
<html> 
	<head>
	 	<meta charset="utf-8" />					
		<title>El 2048</title>
		<link rel="stylesheet" href="style.css" />
	</head> 
	<body> 
		<h1>2048</h1>
        <div class="regles">
            <h4>Règles du jeu :</h2>
            <p>Le but du jeu est de faire glisser des tuiles sur une grille.</p>
        </div>

        <form>
            <input class="bouton" type="submit" name="action-joueur" value="Nouvelle partie" />
            
            <br />
            <br />

            <input class="bouton-jeu" type="submit" name="action-joueur" value="Haut" />
            <input class="bouton-jeu" type="submit" name="action-joueur" value="Bas" />
            <input class="bouton-jeu" type="submit" name="action-joueur" value="Gauche" />
            <input class="bouton-jeu" type="submit" name="action-joueur" value="Droite" />
        </form>


        <h4 class="message">Score : <?php echo $score ?></h4>
        <?php 
            global $perdu;

            if ($perdu) {?>
                <h4 class="message">Perdu !</h4>
        <?php } ?>

        <table class="jeu">
            <?php 
                for ($i = 0; $i < 4 ; $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < 4; $j++) {
                        affiche_case($i, $j);
                    }
                    echo "</tr>";
                }
            ?>
        </table>

        <br /><br /><br />
	</body> 
</html>