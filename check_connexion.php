<?php

include('includes/connexion.php');


if (isset($_POST['identifiant']) && isset($_POST['password'])) {



// Vérification des identifiants

    $req = $bdd->prepare('SELECT * FROM personne WHERE identifiant = :id AND pwd = :password');

    $req->execute(array(

            'id' => $_POST['identifiant'],

            'password' => sha1($_POST['password']))

    );

    $resultat = $req->fetch();

    if ($resultat) {
        
            session_start();

            $_SESSION['connected'] = true;

            $_SESSION['id'] = $resultat['id'];

            $_SESSION['nom'] = $resultat['nom'];

        header('Location: index.php');
            
    } else {

        $_SESSION['connected'] = false;
        header('Location: connexion.php?erreurId');



    }

}



?>
