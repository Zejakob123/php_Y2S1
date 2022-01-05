<?php

$host = "localhost"; 
$user = "user12"; 
$pass = "34klq*"; 
$db = "mydb";

$r = mysqli_connect($host, $user, $pass);
if (!$r) {
    echo "Could not connect to server<br />";
    trigger_error(mysqli_error(), E_USER_ERROR);
} else {
    echo "Connection established<br />"; 
}

$r2 = mysqli_select_db($r, $db);	//error
if (!$r2) {
    echo "Cannot select database<br />";
    trigger_error(mysqli_error(), E_USER_ERROR); 
} else {
    echo "Database selected<br />";
}

$query = "SELECT * FROM Cars LIMIT 5";
$rs = mysqli_query($r, $query);	//error
if (!$rs) {
    echo "Could not execute query: $query";
    trigger_error(mysqli_error(), E_USER_ERROR); 
} else {
    echo "Query: $query executed<br />";
} 

while ($row = mysqli_fetch_assoc($rs)) {
    echo $row['Id'] . " " . $row['Name'] . " " . $row['Price'] . "<br />";
}

mysqli_close($r);	//error
?>
