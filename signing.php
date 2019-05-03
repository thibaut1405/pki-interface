<?php

$fqdn = $_GET["fqdn"];

var_dump($fqdn);
$page = shell_exec("sudo -u root /root/pki/issue test.fr");

var_dump($page);