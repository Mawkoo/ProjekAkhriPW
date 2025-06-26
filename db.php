<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "mice";
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(!$link){
    echo "not connect";
}

function unique_id(){
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength = strlen($chars);
    $randomString = '';
    for ($i=0; $i < 20; $i++) {
        $randomString.=$chars[mt_rand(0, $charLength - 1)];
    }
    return $randomString;
}

?>