<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <p>asass</p>
       <?php 
           /*  $servername =“localhost”;
            $username = “myUSR”;
            $password = “myPWD”;
    
            $connection1 = mysqli_connect(“localhost”, “myUSR”, “myPWD”, “myDB”);
            $connection2 = new mysqli(“localhost”, “myUSR”, “myPWD”, “myDB”);
            $connection3 = new PDO("mysql:host=$servername;dbname=myDB", $username, $password); */
            

           

            echo 'abc';

            $host = "localhost"; 
            $user = "root"; //give your own username & pwd
            $pass = "";
            $dbname = "myDB11"; 
            // Create connection
            $conn = mysqli_connect($host, $user, $pass);
            if (!$conn) {
                echo "Could not connect to server\n<p>";
                trigger_error(mysqli_error(), E_USER_ERROR);
            } else {
                echo "Connection established\n<p>"; 
                $sql_command = "CREATE DATABASE ".$dbname;
                if(mysqli_query($conn, $sql_command)){
                    echo 'database '.$dbname.' is created successfully \n';
                }else{
                     echo 'database '.$dbname.' is created successfully';
                }
            }
            echo mysqli_get_server_info($conn). "\n<p>"; 
            mysqli_close($conn);

            $servername = "localhost";
            $username = "root";
            $password = "";
            
            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
                
            }
            // sql to create table

            if(mysqli_query($conn,"DROP TABLE IF EXIST drivers")){
                echo 'drop table '.$dbname.' success\n';
            }else{
                echo 'do not drop table drivers !!';
            }

            $sql = "CREATE TABLE drivers (d_name VARCHAR(100), 
                    emp_no SMALLINT, hire_date DATE, 
                    stop_date DATE)";
            $sql = mysqli_query($conn, $sql);
            if ($sql===FALSE)
                echo "<p>Unable to execute the query.</p>"
                        . "<p>Error code " . mysqli_errno($conn)
                        . ": " . mysqli_error($conn) . "</p>";
            else{
                echo "<p>Successfully created the table.</p>";
                $sql_insert_command = "INSERT INTO drivers  
                    (d_name, emp_no, hire_date, 
                    stop_date) VALUES 
                    ('Yugene', 1, '2017-03-03', '2017-03-04'),
                    ('Jia Hoe', 2, '2017-04-04', '2017-04-05'),
                    ('Arene', 3, '2017-05-07', '2018-09-01')";
                if(mysqli_query($conn, $sql_insert_command)){
                    echo 'insert data to '.$dbname.' successfully!';
                }
            }
                
            mysqli_close($conn);
    
        ?> 
    </body>
</html>