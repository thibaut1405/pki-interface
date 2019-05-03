<?php

$csrdata = $_GET["csr"];
$fqdn = "test.fr";


$page = shell_exec("sudo -u root /bin/bash /root/pki/csr '".$fqdn."' '".$csrdata."'2>&1");

var_dump($page);