<?php 
	session_start();
	session_destroy();
	//on redirige vers l'accueil
	header("Location: index.php");