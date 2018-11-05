<?php
session_start();
unset($_SESSION['error']);
require("../php/db.php");
if (!empty($_POST['email']) and !empty($_POST['password'])){

    $email=$_POST["email"];
    $password=md5($_POST["password"]);

    //on va chercher le member en bdd en fonction de son username
    $sql = "SELECT * 
            FROM users 
            WHERE email=:email";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":email", $email);
    $stmt->execute();
    $member = $stmt->fetch();

    //si on a trouvé un resultat
    if (!empty($member)){
        //si le mdp est le bon
        if ($password===$member->password){
            //on connecte le member
            $_SESSION['id'] = $member->id;
        }
        else {
            $_SESSION['error'] = "Le mot de passe est incorrect !";
        }
    }
    else {
        $_SESSION['error'] = "Membre introuvable !";
    }
}else{
    $_SESSION['error']="Veuillez saisir tous les champs !";
}

if(!empty($_SESSION['error'])){
    header('Location:../login.php');
}else{
    header('Location:../index.php');
}
?>