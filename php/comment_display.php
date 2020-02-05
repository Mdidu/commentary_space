<?php
session_start();
include "connect.php";
include "function.php";
include "../htmlBase/header.php";
?>

<span id="welcomeUser">Bienvenue, <span class="commentPseudo"><?= $_SESSION['pseudo'];?></span> !</span>
<a href="logout.php" id="logout">Déconnexion</a>
<h1>Commentaire : </h1>
<?php
$limit = 10;
$page = (!empty($_GET['page'])?$_GET['page'] : 1);

pagination($limit, $page);
?>
<a href="comment_display.php?page=<?php echo $page - 1; ?>">Page précédente</a>
<a href="comment_display.php?page=<?php echo $page + 1; ?>">Page suivante</a>

<a href="comment.php">Ecrire un commentaire</a>
<?php
include "../htmlBase/footer.php";