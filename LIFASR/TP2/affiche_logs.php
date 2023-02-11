<html>
 <head>
 	<meta charset="utf-8" />
 	<title>LOGS 2048</title>
     <meta http-equiv="refresh" content="5" />
 </head>
 <body>
 	<h2>Logs 2048</h2>

    <?php
        $logs = file("log.txt");

        $size = sizeof($logs);
        $toshow = min($size, 20);

        echo '<h4>Nombre de lignes total : ' . $size . "</h4><br />";

        for ($i = $size-$toshow; $i < $size; $i++) {

            switch ($logs[$i]) {
                case "Haut\n":
                    $style = 'style = "background: lightblue"';
                    break;
                case "Bas\n":
                    $style = 'style = "background: green"';
                    break;
                case "Gauche\n":
                    $style = 'style = "background: blue"';
                    break;
                case "Droite\n":
                    $style = 'style = "background: yellow"';
                    break;
                case "Lancer une nouvelle partie\n":
                    $style = 'style = "background: gold"';
                    break;
                default:
                    $style = '';
                    break;
            }

            echo "<p " . $style .  ">" . "Ligne " . ($i+1) . " : " . htmlspecialchars($logs[$i]) . "</p>";
        }
    ?>
 	
 </body>
</html>	