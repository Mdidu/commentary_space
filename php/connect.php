<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "members_area";

try
{
    $bdd = new PDO('mysql:host='.$servername.';dbname='.$dbname.';charset=utf8', $username, $password);
}
catch (Exception $e)
{
    die('Erreur : '. $e->getMessage());
}