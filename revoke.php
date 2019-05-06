<?php
include('includes/connexion.php');
$fqdn = $_GET["fqdn"];

$certifRevok = $fqdn.".cer";

var_dump($certifRevok);

$page = shell_exec("sudo -u root /root/pki/revoke $certifRevok $fqdn");


$update_cert = $bdd->prepare("UPDATE real_certificates set state_real_certificate = 1 where fqdn_real_certificate = :fqdn ");

$update_cert->execute(array(
    'fqdn' => $fqdn
));

var_dump($update_cert);