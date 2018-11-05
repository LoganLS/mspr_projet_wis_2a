<?php 
	session_start();
	require("php/db.php");
	$error = '';
    $title='';
    $description='';

	//Si formulaire envoyé
    if($_POST){
        if (!empty($_POST['username']) and !empty($_POST['password'])){

            $username=$_POST["username"];
            $password=md5($_POST["password"]);

            //on va chercher le member en bdd en fonction de son username
            $sql = "SELECT * 
                    FROM users 
                    WHERE username=:username";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":username", $username);
            $stmt->execute();
            $member = $stmt->fetch();

            //si on a trouvé un resultat
            if (!empty($member)){
                //si le mdp est le bon
                if ($password===$member['password']){
                    //on connecte le member
                    $_SESSION['id'] = $member['id'];
                }
                else {
                    $error = "Le mot de passe est incorrect !";
                }
            }
            else {
                $error = "Membre introuvable !";
            }
        }else{
            $error="Veuillez saisir tous les champs !";
        }
    }
?>
<!DOCTYPE html>
<?php include_once('layouts/header.php');?>
<main>
    <h1>Connexion</h1>
	<form method="post">
	   <div>
           <label for="username">Pseudo</label>
           <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="error"><?php echo $error; ?></div>
        <div>
			<button type="submit">Connexion</button>
        </div>
	</form>
</main>
<?php include_once('layouts/footer.php');?>