<?php
include('includes/connexion.php');
$fqdn = $_GET["fqdn"];

$page = shell_exec("sudo -u root /root/pki/issue $fqdn");


$update_cert = $bdd->prepare("UPDATE certificates set state_certificate = 1 where fqdn_certificate = :fqdn ");

$update_cert->execute(array(
    'fqdn' => $fqdn
));

$cert = $bdd->prepare('SELECT path_certificate, id_demandeur FROM certificates WHERE fqdn_certificate = :fqdn');

$cert->execute(array(
    'fqdn' => $fqdn
));
$certif = $cert->fetch();


$createCert = $bdd->prepare('INSERT INTO real_certificates(path_real_certificate, state_real_certificate, id_demandeur, fqdn_real_certificate ) VALUES (:path, :state, :idPersonne, :fqdn)');

$createCert->execute(array(
    'path' => $certif['path_certificate'],

    'state' => 0,

    'idPersonne' => $certif['id_demandeur'],

    'fqdn' => $fqdn
));


echo "<script type='text/javascript'>document.location.replace('listeCSR.php');</script>";
