<?php

$host = "localhost"; 
$user = "user12"; 
$pass = "34klq*"; 
$db = "mydb"; 

function execute_query($r, $query) {	//error
    $r = mysqli_query($r, $query);	//error
    if (!$r) {
        echo "Cannot execute query: $query<br />";
        trigger_error(mysqli_error(), E_USER_ERROR); 
    } else {
        echo "Query: $query executed<br />"; 
    }
}

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

$query = "DROP TABLE IF EXISTS Cars"; 
execute_query($r, $query);	//error

$query = "CREATE TABLE Cars(Id INT PRIMARY KEY, Name TEXT, Price INT) ENGINE=InnoDB";
execute_query($r, $query);	//error

$query = "INSERT INTO Cars VALUES(1,'Audi',52642)";
execute_query($r, $query);	//error

$query = "INSERT INTO Cars VALUES(2,'Mercedes',57127)";
execute_query($r, $query);	//error

$query = "INSERT INTO Cars VALUES(3,'Skoda',9000)";
execute_query($r, $query);	//error

$query = "INSERT INTO Cars VALUES(4,'Volvo',29000)";
execute_query($r, $query);	//error

$query = "INSERT INTO Cars VALUES(5,'Bentley',350000)";
execute_query($r, $query);	//error

$query = "INSERT INTO Cars VALUES(6,'Citroen',21000)";
execute_query($r, $query);	//error

$query = "INSERT INTO Cars VALUES(7,'Hummer',41400)";
execute_query($r, $query);	//error

$query = "INSERT INTO Cars VALUES(8,'Volkswagen',21600)";
execute_query($r, $query);	//error

mysqli_close($r);	//error
?>
