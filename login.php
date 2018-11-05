<?php 
    $title='';
    $description='';
?>
<!DOCTYPE html>
<?php include_once('layouts/header.php');?>
<main>
    <h1>Connexion</h1>
	<form action="php/login.php" method="post">
	   <div>
           <label for="email">Adresse mail</label>
           <input type="mail" name="email" id="email">
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="error">
            <?php if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            } 
            ?>
        </div>
        <div>
			<button type="submit">Connexion</button>
        </div>
	</form>
</main>
<?php include_once('layouts/footer.php');?>