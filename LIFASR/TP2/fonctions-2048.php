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

		if ($_GET['action-joueur'] == "Nouvelle partie") {
			$score++;
		}
	}
?>