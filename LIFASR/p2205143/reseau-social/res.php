<?php
    require_once("fonction-res.php");
    global $auteur;
    $auteur = retourne_auteur();

    if (isset($_POST['action'])) {
        if ($_POST['action'] == "Poster") {
            if (!empty($_POST["message"]) && empty($_FILES['post_img']['name'])) {
                ajout_post_msg();
            } else if (!empty($_FILES["post_img"]['name'])) {
                ajout_post_img();
            }
            } else {
                $tab = explode("_", $_POST['action']);

            if ($tab[0] === "Aimer") {
                $post = $tab[1];

                aimer($post);
            } else if ($tab[0] === "Commenter") {
                $post = $tab[1];

                if (!empty($_POST['commentaire_' . $post])) {
                    ajout_post_com($post, $_POST['commentaire_' . $post]);
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le réseau social de LIFASR2</title>
    <link rel="stylesheet" href="style-res.css">
</head>
<body>
    <form id="actionform" method="post" enctype="multipart/form-data">
        <div class="menu">
            <input type="checkbox" name="choix_img" value="Images" <?php choix_courant("images") ?> />
            <label for="choix_img">Images</label>
            
            <br />

            <input type="checkbox" name="choix_msg" value="Messages" <?php choix_courant("messages") ?> />
            <label for="choix_msg">Messages</label>

            <br />

            <input type="radio" name="choix_com" value="Avec commentaires" <?php choix_courant("avec commentaires") ?> />
            <label for="choix_com">Avec commentaires</label>
            <br />
            <input type="radio" name="choix_com" value="Sans commentaires" <?php choix_courant("sans commentaires") ?> />
            <label for="choix_com">Sans commentaires</label>

            <br />

            <label for="choix_nbp">Nombre de posts ?</label>
            <select name="choix_nbp">
                <option <?php choix_courant("1") ?> >1</option>
                <option <?php choix_courant("5") ?> >5</option>
                <option <?php choix_courant("10") ?> >10</option>
                <option <?php choix_courant("25") ?> >25</option>
                <option <?php choix_courant("50") ?> >50</option>
            </select>

            <br />
            <br />

            <input type="submit" value="Afficher" />

        </div>
        <div class="contenu">
            <h1>Bonjour <?php echo $auteur ?></h1>
            <div class="nouveau_post">
                <textarea name="message" placeholder="Quoi de neuf ?"></textarea>
                <br/>
                <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                <label for="post_img">Ajouter une image :</label>
                <input type="file" name="post_img" />
                <br/>
                <input type="submit" name="action" value="Poster" />
            </div>
            <div class="affiche_post">
                <?php
                    if (isset($_POST["choix_img"]) || isset($_POST["choix_msg"])) {
                        $indice = 0;

                        if (isset($_POST["choix_img"]) && $_POST["choix_img"] === "Images") {
                            if (isset($_POST["choix_msg"]) && $_POST["choix_msg"] === "Messages")
                                $indice = 2;
                            else
                                $indice = 1;
                        }
                        $tab = retourne_tab_50derniersposts($indice);

                        $i = 0;
                        $nb = isset($_POST["choix_nbp"]) ? $_POST["choix_nbp"] : 15;
                        foreach ($tab as $post) {
                            affiche_post($post);
                            $i++;
                            if ($i >= $nb)
                                break;
                        }
                    }
                ?>
            </div>
        </div>
    </form>
</body>
</html>