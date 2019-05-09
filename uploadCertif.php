<?php
include('includes/connexion.php');

session_start();
$dossier = 'request/';

$fichier = basename($_FILES['file']['name']);

$fichier = strtolower($fichier);

$taille_maxi = 999999999999999;

$taille = filesize($_FILES['file']['tmp_name']);

$extensions = array('.csr','.CSR');

$extension = strrchr($_FILES['file']['name'], '.');


//Début des vérifications de sécurité...

if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau

{
    $erreur = 'Vous devez uploader un fichier de type csr';
    echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
    echo "<script type='text/javascript'>document.location.replace('index.php');</script>";

}

if ($taille > $taille_maxi) {

    $erreur = 'Le fichier est trop gros...';
    echo '<script type="text/javascript">window.alert("'.$erreur.'");</script>';
    echo "<script type='text/javascript'>document.location.replace('index.php');</script>";

}

if (!isset($erreur)) //S'il n'y a pas d'erreur, on upload

{

    //On formate le nom du fichier ici...

    $fichier = strtr($fichier,

        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',

        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

    $fichier = preg_replace('/([^.a-z0-9]+)/i', '_', $fichier);


    $lefichierSplit = mb_split(" ", $fichier, -1);


    if (move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...

    {

        $createCert = $bdd->prepare('INSERT INTO certificates ( path_certificate, id_demandeur, fqdn_certificate ) VALUES (:path, :idPersonne, :fqdn)');

        $createCert->execute(array(

            'path' => $fichier,

            'idPersonne' => $_SESSION['id'],

            'fqdn' => $_POST['fqdn']
        ));

        $page =  shell_exec("sudo -u root /bin/bash /root/pki/csr '".$_POST['fqdn']."' '".$fichier."'");

        echo "<script type='text/javascript'>document.location.replace('listeCSR.php');</script>";


    } else //Sinon (la fonction renvoie FALSE).

    {
        var_dump($_FILES);

        echo 'Echec de l\'upload !';

        echo "<script type='text/javascript'>document.location.replace('importCSR.php');</script>";


    }

} else {

    echo $erreur;

}

