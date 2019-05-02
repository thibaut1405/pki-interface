<?php
try
{
    $user='root';
    $password='';
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=pki',$user,$password);
    $bdd->exec('SET NAMES utf8');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}
