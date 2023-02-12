 <?php /* librairie-res.php */
 define("APP","/srv/http/");

 /* Cette fonction ne doit être appelée que lors de la création d'un nouveau post */
 function prendre_un_post() {
	/* on récupère le contenu du fichier dans la variable $nbPost */
	$nbPost = file_get_contents(APP.'/DATA/nb-post.txt');
	//echo "nbPostavantlepost=$nbPost<br/>";
	/* on incrémente le nombre de posts */
	$nouveau_nbPost = $nbPost+1;
	/* on stocke la nouvelle valeur dans le fichier texte */
	file_put_contents(APP.'/DATA/nb-post.txt', $nouveau_nbPost,LOCK_EX);
	return $nbPost ;
}

/* Cette fonction est appelée quand l'image reçue est trop grande */
function reduit_image($image, $dimension, $fichier) {
	$useGD = True ;
	$to = APP."/DATA/IMG/".$fichier ;
	/* le ratio permet de conserver les propotions de l'image */
	$ratio = $dimension[0]/$dimension[1];
	$hauteur = 300 ;
	$largeur = round($hauteur*$ratio);
	// Création de limage
	if($useGD) {
		/* on crée une image aux nouvelles dimensions */
		$chemin = imagecreatetruecolor($largeur, $hauteur);
		/* on conserve le type de l'image d'origine (jpeg, gig, png) */
		$type = mime_content_type($image);
		switch (substr($type, 6)) {
			case 'jpeg':
				$img = imagecreatefromjpeg($image);
				break;
			case 'gif':
				$img = imagecreatefromgif($image);
				break;
			case 'png':
				$img = imagecreatefrompng($image);
				break;
		}
		imagecopyresampled($chemin, $img, 0, 0, 0, 0, $largeur, $hauteur, $dimension[0], $dimension[1]);
		imagedestroy($img);
		/* on stocke l'image dans le dossier indiqué */
		imagejpeg($chemin, $to, 100);
	}

}

/* Fonction qui vérifie si l'image choisie est bien une image de taille inférieure à la taille maximale */
function verifie_image($fichier) {
	/* on récupère le nom de l'image choisie */
	$image = $_FILES['post_img']['tmp_name'];
	/* on récupère sa taille */
	$dimension = getimagesize($image);
	/* s'il s'agit bien d'une image, et que sa taille est inférieure à la taille maximale, on accepte l'image */
	if (preg_match("#^image/#", mime_content_type($image)) && ($_FILES['post_img']['size'] <= $_POST['MAX_FILE_SIZE']))
	{
		/* si elle est trop large ou trop haute, on la réduit */
		if ($dimension[0]>2000 or $dimension[1]>2000) {
			$img = reduit_image($image, $dimension, $fichier) ;
		/* sinon, on la stocke juste dans le répertoire DATA/IMG */
		} else {
			$dossier = APP.'/DATA/IMG/';
			if (move_uploaded_file($_FILES['post_img']['tmp_name'], $dossier . $fichier)) 		{
				return True ;
			}
		}
		return True ;
	/* si l'image est trop lourde ou n'est pas une image (un pdf par exemple), elle n'est pas stockée et la fonction retourne False */
	} else {
		return False ;
	}
}

// renvoie le nom du fichier correspondant au dernier post, sous la forme
// 0-msg.txt ou 1-img.txt
function retourne_dernier_post() {
	// on récupère le nombre total de post
	$nbPost = file_get_contents(APP.'/DATA/nb-post.txt');

	// on cherche le dernier post qui n'est pas un commentaire
	$i = $nbPost - 1;
	while (file_exists(APP.'/DATA/'.$i.'-com.txt') && $i > 0)
		$i = $i - 1;

	if (file_exists(APP.'/DATA/'.$i.'-msg.txt'))
		$dernier_post = $i.'-msg.txt';
	elseif (file_exists(APP.'/DATA/'.$i.'-img.txt'))
		$dernier_post = $i.'-img.txt';

	if (empty($dernier_post))
	{
		echo "Le dernier post a un format non valide. Du coup, on retourne 0-msg.txt <br />";
		$dernier_post = "0-msg.txt";
	}

	// on retourne le nom du fichier qui correspond au dernier post de type msg ou img
	return $dernier_post;
}

// Aimer $fichier
function aimer($fichier){
	/* on récupère le contenu du fichier dans un tableau */
	$lines = file(APP.'/DATA/'.$fichier.'.txt');
	/* on incrémente le nombre de like qui se trouve sur la 4e ligne du fichier */
	$nb_Like= (int) $lines[3]+1;
	/* on affecte la nouvelle valeur à la bonne ligne, en faisant attention au saut de ligne */
	$lines[3]= $nb_Like."\n";
	/* on remet le contenu du tableau dans le fichier texte */
	file_put_contents(APP.'/DATA/'.$fichier.'.txt', $lines);
}

// retourne le type de post de $fichier 0-msg.txt, sous la forme : msg.txt blabla
// fonction auxiliaire utilisée pour récupérer les fichiers de commentaires
function retourne_type_post($fichier) {
	$tab_fichier = explode("-", $fichier);
	$type_post = $tab_fichier[1];
	return $type_post ;
}

// Retourne un tableau de nom de fichiers de type commentaire relatifs à $fichier
function retourne_tab_coms($fichier){
	// tableau avec les noms complets des fichiers de type commentaire
	$tab_coms = [] ;
	//echo $fichier."<br />";
	// on ouvre le répertoire DATA
	if ($dossier = opendir(APP.'/DATA/'))
	{
		// on parcourt le répertoire DATA
		while (false !== ($fichier_com = readdir($dossier)))
		{
			if (is_file(APP.'/DATA/'.$fichier_com))
			{
			//echo APP."/DATA/$fichier_com <br/>";
			    $lines = file(APP.'/DATA/'.$fichier_com);
			    if (isset($lines[0]) && strcmp($lines[0],"commentaire\n")==0)
			    {
				//echo "commentaire<br />";
			    	if (strcmp($lines[5],"./${fichier}\n")==0)
				{
					//echo "commentaire de $fichier <br />";
			    		//ajoute le nom du fichier commentaire dans le tableau
			    		array_push($tab_coms, $fichier_com);
				}
			    }
            		}
		}
		closedir($dossier);
		// on trie les noms par ordre alphabétique donc selon l'ordre des posts
		sort($tab_coms, SORT_NATURAL);
	}
	// on renvoie la liste des noms complets
	// print_r($tab_coms);
	return $tab_coms;
}

// Pour conserver les choix du menu entre 2 submit
// Le principe est de récupérer pour chaque champ du menu le choix
// de la précédente soumission qui se trouve dans $_POST
// et de la remettre dans le formulaire qui est renvoyé au navigateur
function choix_courant($type_choix) {

	// Pour la case à cocher 'Messages'
	if ($type_choix=='messages') {
		if(isset($_POST['choix_msg'])) {
			echo 'checked' ;
		}
	}
	// Pour la case à cocher Images
	else if ($type_choix=='images') {
		if(isset($_POST['choix_img'])){
			echo 'checked' ;
		}
	}
	// Pour l'affichage ou non des commentaires
	else if ($type_choix=='sans commentaires') {
		if(isset($_POST['choix_com']) and $_POST['choix_com']=='Sans commentaires') {
			echo 'checked';
		}
	}
	// Pour l'affichage ou non des commentaires
	else if ($type_choix=='avec commentaires') {
		if (isset($_POST['choix_com']) and $_POST['choix_com']=='Avec commentaires') {
			echo 'checked';
		}
	}
	else
	{
		// Pour conserver le nombre de posts à afficher
		// le nombre de posts affichés par défaut est de 10
		$nbaffiche = 10;
		if (isset($_POST['choix_nbp'])) {
			$nbaffiche = $_POST['choix_nbp'];
		}
		if ($type_choix == strval($nbaffiche)) {
			echo 'selected="selected"' ;
		}
	}
}

// Retourne un tableau contenant le nom des 50 derniers posts selon la valeur de $indice
// $indice=0 signifie les 50 derniers posts de type message
// $indice=1 signifie les 50 derniers posts de type image
// $indice=2 signifie les 50 derniers posts de type message ou image
// Le tableau est rempli dans le bon ordre, c'est à dire du post le plus récent au post le plus ancien
function retourne_tab_50derniersposts($indice)
{
    $dir = APP."/DATA/";

    $lastposts = [];
    $pattern = "$dir/*-{msg,img}.txt";

    switch ($indice) {
        case 0:
            // Uniquement les posts de type message
            $pattern = "$dir/*-msg.txt";
            break;

        case 1:
            // Uniquement les posts de type image
            $pattern = "$dir/*-img.txt";
            break;

        case 2:
            // Uniquement les posts de type message ou image
            // pattern inchangé
            break;

        default:
            throw new Exception("Choix invalide $indice");
    }

    $dirfiles = glob($pattern, GLOB_BRACE);

    // Contains the number of the post present in filename
    $filenumbers = [];
    // Keep track of the file that has a given post number
    $filesmatch = [];

    foreach ($dirfiles as $i => $filepath) {
        $parts = explode("/", $filepath);
        $filename = $parts[sizeof($parts) - 1];
        $nbPost = explode("-", $filename)[0];
        if (intval($nbPost) != 0) {
            array_push($filenumbers, $nbPost);
            $filesmatch[$nbPost] = $filename;
        }
        else {
            if ($nbPost === "0") {
                array_push($filenumbers, $nbPost);
                $filesmatch[$nbPost] = $filename;
            }
        }
    }

    rsort($filenumbers);

    foreach (array_slice($filenumbers, 0, 50) as $nbPost) {
        array_push($lastposts, $filesmatch[$nbPost]);
    }

    return $lastposts;
}

?>
