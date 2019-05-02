<?php
include ('includes/menu.php');
include('includes/connexion.php');
?>
<html>
<form method="post" action="uploadCertif.php" enctype="multipart/form-data">
    <input type="file" name="file">
    <button type="submit"> Envoyer</button>
</form>
</html>

<?php

session_start();

$pers = $bdd->prepare('SELECT admin FROM personne WHERE id = :id ');

$pers->execute(array(
    'id' => $_SESSION['id'],
));


$personne = $pers->fetch();

if ($personne['admin'] == 1) {
    $cert = $bdd->prepare('SELECT path_certificate, nom, prenom FROM certificates INNER JOIN personne ON personne.id = certificates.id_demandeur');

    $cert->execute();
} else {
    $cert = $bdd->prepare('SELECT path_certificate, nom, prenom FROM certificates INNER JOIN personne ON personne.id = certificates.id_demandeur WHERE id = :id');

    $cert->execute(array(
            'id' => $_SESSION['id']
    ));
}


?>

<table>
    <thead>

    <tr>
        <th>Nom du certificat</th>
        <th>Nom du demandeur</th>
        <th>Prenom du demandeur</th>
        <th>Accepter</th>
        <th>Refuser</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($lesCerts = $cert->fetch()) {
        ?>
    <tr>
        <td><strong><?php echo $lesCerts['path_certificate'] ?></strong></td>
        <td><?php echo $lesCerts['nom']?></td>
        <td><?php echo $lesCerts['prenom']?></td>
        <td><a href="signing.php?csr=request/<?php echo $lesCerts['path_certificate']?>">Accepter</a></td>
        <td><button>Refuser</button></td>
    </tr>
    <?php } ?>
    </tbody>
</table>