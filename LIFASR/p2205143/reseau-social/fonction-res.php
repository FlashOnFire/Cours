<?php
    require_once('../../LIB/librairie-res.php');

    function retourne_auteur() {
        return explode("/", $_SERVER['REQUEST_URI'])[1];
    }

    function ajout_post_msg() {
        global $auteur;

        $nb_post = prendre_un_post();
        $filename = "../../DATA/". $nb_post . "-msg.txt";

        file_put_contents($filename, "message\n", LOCK_EX);
        file_put_contents($filename, $auteur . "\n", FILE_APPEND|LOCK_EX);
        file_put_contents($filename, date("Y-m-d H:i:s") . "\n", FILE_APPEND|LOCK_EX);
        file_put_contents($filename, "0" . "\n", FILE_APPEND|LOCK_EX);
        file_put_contents($filename, "\n", FILE_APPEND|LOCK_EX);
        file_put_contents($filename, $_POST["message"], FILE_APPEND|LOCK_EX);
    }

    function ajout_post_img() {
        global $auteur;

        $nb_post = prendre_un_post();

        $fichier = $nb_post . "-" . $_FILES['post_img']['name'];
        if (verifie_image($fichier)) {

            $filename = "../../DATA/". $nb_post . "-img.txt";

            file_put_contents($filename, "image\n", LOCK_EX);
            file_put_contents($filename, $auteur . "\n", FILE_APPEND|LOCK_EX);
            file_put_contents($filename, date("Y-m-d H:i:s") . "\n", FILE_APPEND|LOCK_EX);
            file_put_contents($filename, "0" . "\n", FILE_APPEND|LOCK_EX);
            file_put_contents($filename, "\n", FILE_APPEND|LOCK_EX);
            file_put_contents($filename, "./IMG/" . $fichier . "\n", FILE_APPEND|LOCK_EX);
            file_put_contents($filename, $_POST["message"], FILE_APPEND|LOCK_EX);
        }
    }

    function ajout_post_com($post, $commentaire) {
        global $auteur;

        $nb_post = prendre_un_post();
        $filename = "../../DATA/". $nb_post . "-com.txt";

        file_put_contents($filename, "commentaire\n", LOCK_EX);
        file_put_contents($filename, $auteur . "\n", FILE_APPEND|LOCK_EX);
        file_put_contents($filename, date("Y-m-d H:i:s") . "\n", FILE_APPEND|LOCK_EX);
        file_put_contents($filename, "0" . "\n", FILE_APPEND|LOCK_EX);
        file_put_contents($filename, "\n", FILE_APPEND|LOCK_EX);
        file_put_contents($filename, "./" . $post . ".txt" . "\n", FILE_APPEND|LOCK_EX);
        file_put_contents($filename, $commentaire, FILE_APPEND|LOCK_EX);
    }

    function affiche_post($fichier) {
        echo "<div class='publication'>";
        $content = file("../../DATA/" . $fichier);

        $type = trim($content[0]);
        $nom = trim($content[1]);
        $date = trim($content[2]);
        $likes = trim($content[3]);

        $message = "";

        for ($i = ($type === "message" ? 5 : 6); $i < count($content); $i++) {
            $message = $message . $content[$i];

            if ($i < count($content) -1)
                $message = $message . "<br />";
        }

        echo "<h3>" . $nom . "</h3>";
        echo "<h3>" . $date . "</h3>";

        if ($type === "image") {
            $fichier = trim($content[5]);

            echo "<img src='" . "../../DATA/" . $fichier . "' />";

        }

        echo "<p>" . $message . "</p>";

        echo "<br/>";

        echo '<button name="action" value="Aimer_' . explode('.', $fichier)[0] .  '">Aimer</button>';
        echo '<span class="nbLikes" />' . $likes . '</span>';
        echo "<button name='action' value='Commenter_" . explode('.', $fichier)[0]  .  "'>Commenter</button>";
        
        echo "<br/>";
        
        echo '<textarea name="commentaire_' . explode('.', $fichier)[0] . '" placeholder="Votre commentaire ?"></textarea>';

        if (isset($_POST['choix_com']) && $_POST['choix_com'] === "Sans commentaires") {
            echo "</div>";
            return;
        }

        $coms = retourne_tab_coms($fichier);
        foreach ($coms as $com) {
            echo '<div class="commentaire">';
            $content = file("../../DATA/" . $com);

            $nom = trim($content[1]);
            $date = trim($content[2]);
            $likes = trim($content[3]);

            $message = "";

            for ($i = 6; $i < count($content); $i++) {
                $message = $message . $content[$i];
            }

            echo "<h3>" . $nom . "</h3>";
            echo "<h3>" . $date . "</h3>";

            echo "<p>" . $message . "</p>";

            echo '<button name="action" value="Aimer_' . explode('.', $com)[0] .  '">Aimer</button>';
            echo '<span class="nbLikes" />' . $likes . '</span>';
        
            echo "</div>";
            echo "<br/>";
        }

        echo "</div>";
    }
?>
