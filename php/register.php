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
    $password = md5($_POST['password']);
    $passwordBis = md5($_POST['password_bis']);
    
    //Vérification formulaire
    if (strlen($username) < 2 || strlen($username) > 20){
        $_SESSION['error'] = "Votre pseudo doit avoir entre 2 et 20 caractères !";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['error'] = "Votre email n'est pas valide !";
    }
    else if ($password != $passwordBis){
        $_SESSION['error'] = "Vos mots de passe ne correspondent pas !";
    }
    else{
        //Vérification que le pseudo n'est pas pris
        $sql="SELECT username FROM users
              WHERE username=:username";
        $stmt=$conn->prepare($sql);
        $stmt->bindValue(":username",$username);
        $stmt->execute();
        if($stmt->rowCount()===1){
            $_SESSION['error']="Pseudo déjà utilisé !";
        }else{
            //Vérification que le mail n'est pas pris
            $sql="SELECT email FROM users
                  WHERE email=:email";
            $stmt=$conn->prepare($sql);
            $stmt->bindValue(":email",$email);
            $stmt->execute();
            if($stmt->rowCount()===1){
                $_SESSION['error']="Adresse email déjà utilisée !";
            }
        }
        if(empty($_SESSION['error'])){
            $sql = "INSERT INTO users(last_name,first_name, date_birthday, username,email,password,role,date_created)
                        VALUES(:last_name, :first_name, :date_birthday, :username, :email, :password, 'utilisateur', NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":last_name",$last_name);
            $stmt->bindValue(":first_name",$first_name);
            $stmt->bindValue("date_birthday",$date_birthday);
            $stmt->bindValue(":username", $username);
            $stmt->bindValue(":email", $email);
            $stmt->bindValue(":password",$password);
            $stmt->execute();
            //Création de la variable de session : id
            $_SESSION['id']=$conn->lastInsertId();
        }
    }
}else{
    $_SESSION['error']="Veuillez saisir tous les champs !";
}

if(!empty($_SESSION['error'])){
    header("Location:../register.php");
}else{
    header("Location:../index.php");
}