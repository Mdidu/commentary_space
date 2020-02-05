<?php
session_start();
include "connect.php";
include "function.php";

//check the origin page
switch ($_SESSION['page']){
    case "register":

        //condition from register.php
        if(isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['checkPassword'])) {
            if ($_POST['password'] === $_POST['checkPassword']) {
                addUser($_POST['pseudo'], password_hash($_POST['password'], PASSWORD_DEFAULT));
            } else {
                echo "Erreur !";
            }
        }
        break;

    case 'login':
    //condition from login.php
    if(isset($_POST['pseudo']) && isset($_POST['password'])){
        checkLog($_POST['pseudo'], $_POST['password']);
    } else {
        echo "Au moins un champ n'est pas remplie !";
    }
    break;

    case 'comment':
        //condition from comment.php
        if(isset($_SESSION['pseudo']) && (isset($_POST['comment']) || $_POST['comment'] !== '')){
            addComment($_SESSION['pseudo'], $_POST['comment']);
        }else {
            echo "Au moins un champ n'est pas remplie !";
        }
        break;

    case 'comment_update':

        //condition from comment.php If a modified commentary
        if(isset($_SESSION['pseudo']) && (isset($_POST['comment']) || $_POST['comment'] !== '') && isset($_POST['commentary_id'])){
            updateComment($_POST['commentary_id'], $_SESSION['pseudo'], $_POST['comment']);
        }else {
            echo "Au moins un champ n'est pas remplie !";
        }
        break;

    default:
        break;
}