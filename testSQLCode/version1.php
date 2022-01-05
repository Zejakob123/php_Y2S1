<?php

$host = "localhost"; 
$user = "user12"; //give your own username & pwd
$pass = "34klq*"; 

$r = mysqli_connect($host, $user, $pass);
if (!$r) {
    echo "Could not connect to server";
    trigger_error(mysqli_error(), E_USER_ERROR);
} else {
    echo "Connection established :"; 
}

echo mysqli_get_server_info($r); 
mysqli_close($r);
?>
