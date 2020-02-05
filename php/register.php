<?php
session_start();
include "connect.php";
include "../htmlBase/header.php";
$_SESSION['page'] = "register";
?>
    <h1>Inscription</h1>
    <form action="checking.php" method="post">
        <label for="pseudo">Entrez votre pseudo : </label>
        <input type="text" name="pseudo" id="pseudo">

        <label for="password">Entrez votre mot de passe : </label>
        <input type="password" name="password" id="password">

        <label for="checkPassword">Entrez de nouveau votre mot de passe : </label>
        <input type="password" name="checkPassword" id="checkPassword">

        <input type="submit" value="Envoyer">
    </form>
    <a href="../index.html">Accueil</a>

<?php
include "../htmlBase/footer.php";