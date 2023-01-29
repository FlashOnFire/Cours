<?php 
    require_once 'jeu-2048.php'
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
        <h2>Règles du jeu :</h2>
        <p>Le but du jeu est de faire glisser des tuiles sur une grille.</p>

        <form>
            <input type="submit" name="action-joueur" value="Lancer une nouvelle partie" />
            
            <br />
            <br />

            <input type="submit" name="action-joueur" value="Haut" />
            <br />
            <input type="submit" name="action-joueur" value="Gauche" />
            <input type="submit" name="action-joueur" value="Bas" />
            <input type="submit" name="action-joueur" value="Droite" />
        </form>



        <h4>Score : 0</h4>

        <table>
            <tr>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
            <tr>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
            <tr>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
            <tr>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
            </tr>
        </table>


        <br /><br /><br />
	</body> 
</html>