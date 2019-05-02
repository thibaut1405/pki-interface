<?php

/*$csrdata = $_GET["csr"];
$cacert = 'file:///etc/pki/openssl/certs/ca.cert.pem';
$private = array(file_get_contents('/etc/pki/openssl/private/ca.key.pem'), 'root');

*/


$res = openssl_pkey_new();
openssl_pkey_export($res, $privkey);
var_dump(openssl_error_string());
var_dump($privkey);



/*$usercert = openssl_csr_sign($csrdata, $cacert, $private, 365, array('digest_alg'=>'sha256') );

openssl_x509_export($usercert, $certout);

echo $certout;*/

//$usercert = openssl_csr_sign($csrstring, $cacert, $private, 365);

/*
while (($e = openssl_error_string()) !== false) {
    echo $e . "\n";
}*/