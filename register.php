<?php 
	session_start();
    $title='';
    $description='';
?>
<?php include_once('layouts/header.php');?>
<main>
    <h1>Inscription</h1>
	<form action="php/register.php" method="post">
        <div>
            <label for="last_name">Nom</label>
            <input type="text" name="last_name" id="last_name">
        </div>
        <div>
            <label for="first_name">Prénom</label>
            <input type="text" name="first_name" id="first_name">
        </div>
        <div>
            <label for="date_birthday">Date anniversaire</label>
            <input type="date" name="date_birthday" id="date_birthday">
        </div>
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
        <div class="error">
            <?php if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            } 
            ?>
        </div>
        <div>
            <button type="submit">S'inscrire</button>
        </div>
	</form>
</main>
<?php include_once('layouts/footer.php');?>