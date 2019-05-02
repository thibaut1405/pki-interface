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

}

if ($taille > $taille_maxi) {

    $erreur = 'Le fichier est trop gros...';

}

if (!isset($erreur)) //S'il n'y a pas d'erreur, on upload

{

    //On formate le nom du fichier ici...

    $fichier = strtr($fichier,

        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',

        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

    $fichier = preg_replace('/([^.a-z0-9]+)/i', '_', $fichier);


    $lefichierSplit = mb_split(" ", $fichier, -1);

    $name =  $_FILES['file']['tmp_name']."_".$fichier;

    $name =  strtr($name,

        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',

        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

    $name = str_replace("/", '_', $name);

    var_dump($name);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $dossier . $name)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...

    {

        $createCert = $bdd->prepare('INSERT INTO certificates ( path_certificate, id_demandeur ) VALUES (:path, :idPersonne)');

        $createCert->execute(array(

            'path' => $name,

            'idPersonne' => $_SESSION['id']
        ));


        echo 'Upload effectué avec succès !';




    } else //Sinon (la fonction renvoie FALSE).

    {

        echo 'Echec de l\'upload !';




    }

} else {

    echo $erreur;

}

