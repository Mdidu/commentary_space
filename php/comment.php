<?php
session_start();
include "../htmlBase/header.php";
$_SESSION['page'] = "comment";
?>
    <span id="welcomeUser">Bienvenue, <span class="commentPseudo"><?= $_SESSION['pseudo'];?></span> !</span>
    <a href="logout.php" id="logout">Déconnexion</a>
    <h1>Envoie de commentaire</h1>

    <form action="checking.php" method="post">

        <label for="comment">Ecrivez votre commentaire : </label>
        <?php if(isset($_POST['comment'])):
            $_SESSION['page'] = "comment_update";
           ?>
        <textarea rows="15" cols="60" name="comment" id="comment"><?= $_POST['comment'];?></textarea>
        <input type="hidden" name="commentary_id" id="commentary_id" value="<?= $_POST['commentary_id']; ?>">
        <?php else: ?>
        <textarea rows="15" cols="60" name="comment" id="comment"></textarea>
        <?php endif ?>
        <input type="submit" class="submit">
    </form>

    <a href="comment_display.php">Voir les commentaires</a>
<?php
include "../htmlBase/footer.php";