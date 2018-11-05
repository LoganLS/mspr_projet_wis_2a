<?php
session_start();
unset($_SESSION['error']);
require("db.php");

if (!empty($_POST['last_name']) and !empty($_POST['first_name']) and !empty($_POST['date_birthday']) and !empty($_POST['username']) and !empty($_POST['email']) and !empty($_POST['password']) and !empty($_POST['password_bis'])){
    $last_name=$_POST['last_name'];
    $first_name=$_POST['first_name'];
    $date_birthday=$_POST['date_birthday'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordBis = $_POST['password_bis'];
    
    //Vérification formulaire
    if (strlen($username) < 2 || strlen($username) > 20){
        $error = "Votre pseudo doit avoir entre 2 et 20 caractères !";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Votre email n'est pas valide !";
    }
    else if ($password != $passwordBis){
        $error = "Vos mots de passe ne correspondent pas !";
    }
    else{
        //Vérification que le pseudo n'est pas pris
        $sql="SELECT username FROM users
              WHERE username=:username";
        $stmt=$conn->prepare($sql);
        $stmt->bindValue(":username",$username);
        $stmt->execute();
        if($stmt->rowCount()===1){
            $error="Pseudo déjà utilisé !";
        }else{
            //Vérification que le mail n'est pas pris
            $sql="SELECT email FROM users
                  WHERE email=:email";
            $stmt=$conn->prepare($sql);
            $stmt->bindValue(":email",$email);
            $stmt->execute();
            if($stmt->rowCount()===1){
                $error="Adresse email déjà utilisée !";
            }
        }
    }
    //Si pas d'erreur
    if (empty($error)){
        $sql = "INSERT INTO users 
                VALUES (NULL, :username, :email, :password, 'utilisateur', NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":username", $username);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", md5($password));
        $stmt->execute();
        //Création de la variable de session : id
        $_SESSION['id']=$conn->lastInsertId();
        header("Location:index.php");
    }
}else{
    $error="Veuillez saisir tous les champs !";
}