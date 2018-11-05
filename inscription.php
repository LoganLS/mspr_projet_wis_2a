<?php 
	session_start();
	require("php/db.php");
	$error = "";
    $title='';
    $description='';

	//Si formulaire envoyé
    if($_POST){
        if (!empty($_POST['username']) and !empty($_POST['email']) and !empty($_POST['password']) and !empty($_POST['password_bis'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordBis = $_POST['password_bis'];

            //On vérifie que les champs requis sont bien remplis
            if (empty($username)){
                $error = "Veuillez renseigner votre pseudo !";
            }
            else if(empty($email)){
                $error = "Veuillez renseigner votre email !";
            }
            else if(empty($password)){
                $error = "Veuillez renseigner votre mot de passe !";
            }
            else if(empty($passwordBis)){
                $error = "Veuillez confirmer votre mot de passe !";
            }

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
    }

?>
<?php include_once('layouts/header.php');?>
<main>
    <h1>Inscription</h1>
	<form method="post">
        <div>
            <label for="username">Pseudo</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <label for="password_bis">Confirmation du mot de passe</label>
            <input type="password" name="password_bis" id="password_bis">
        </div>
        <div class="error"><?php echo $error; ?></div>
        <div>
            <button type="submit">S'inscrire</button>
        </div>
	</form>
</main>
<?php include_once('layouts/footer.php');?>