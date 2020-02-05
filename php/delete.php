<?php
session_start();
include 'connect.php';

if(isset($_POST['commentary_id'])){
    $sql = $bdd->prepare("DELETE FROM commentary WHERE id = :id");

    $sql->bindParam(":id", $_POST['commentary_id']);

    $sql->execute();
    header('location: comment_display.php');
    $sql->closeCursor();
}else {
    echo "Message non supprimé !";
}