<?php
session_start();
include "../htmlBase/header.php";
$_SESSION['page'] = "login";
?>
    <h1>Connexion</h1>
    <form action="checking.php" method="post">
        <label for="pseudo">Entrez votre pseudo : </label>
        <input type="text" name="pseudo" id="pseudo">

        <label for="password">Entrez votre mot de passe : </label>
        <input type="password" name="password" id="password">

        <input type="submit" value="Envoyer">
    </form>
    <a href="../index.html">Accueil</a>
<?php
include "../htmlBase/footer.php";
