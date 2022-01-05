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

$name = "Volkswagen";
$query = sprintf("SELECT Id, Name, Price From Cars Where Name = '%s'", 
    mysqli_real_escape_string($r, $name));	//error

$rs = mysqli_query($r, $query);	//error
if (!$rs) {
    echo "Could not execute query: $query<br />";
    trigger_error(mysqli_error(), E_USER_ERROR); 
} else {
    echo "Query: $query executed<br />";
} 

while ($row = mysqli_fetch_object($rs)) {
    echo $row->Id;
    echo " ";
    echo $row->Name;
    echo " ";
    echo $row->Price;
    echo "<br />";
}

mysqli_close($r);	//error
?>
