<?php
$fqdn = $_GET["fqdn"];

$page = shell_exec("sudo -u root /root/pki/certs/$fqdn/checkCSR");

echo $page;