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

$query = "SELECT Id, Name, Price From Cars LIMIT 5";
$rs = mysqli_query($r, $query);	//error
if (!$rs) {
    echo "Could not execute query: $query";
    trigger_error(mysqli_error(), E_USER_ERROR); 
} else {
    echo "Query: $query executed<br />";
} 

$nrows = mysqli_num_rows($rs);
for ($i = 0; $i < $nrows; $i++) {
    $row = mysqli_fetch_row($rs);
    echo $row[0];
    echo " ";
    echo $row[1];
    echo " ";
    echo $row[2];	//error
echo "<br />";
}

mysqli_close($r);	//error
?>
