<?php
    define("DBHOST", "localhost"); 
    define("DBUSER", "root");
    define("DBPASS", "");
    define("DBNAME", "mspr_evenements_musique");
 
    try {
        //connexion à la base avec la classe PDO et le dsn
        $conn = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", //on s'assure de communiquer en utf8
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, //on récupère nos données en array associatif par défaut
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING         //on affiche les erreurs. À modifier en prod. 
        ));
    }catch (PDOException $e) { //attrappe les éventuelles erreurs de connexion
        echo 'Erreur de connexion : ' . $e->getMessage();
    }