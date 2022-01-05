<?php

class User_t{
    const DB_HOST = "localhost";
    const DB_USERNAME = "p1-admin";
    const DB_PSD = "dummy123";
    const DB = "db75405";
    private $userID;
    private $db_connector;

    function __construct(){

        $this->db_connector = mysqli_connect(self::DB_HOST, self::DB_USERNAME, self::DB_PSD, self::DB);
        //connect to server AND database
        if(!$this->db_connector){
            echo 'Could not connect to server<br/>';
            trigger_error(mysqli_error(), E_USER_ERROR);
        }else{
           /* echo 'connection established<br/>'; */
        }
        
    }

    function setUserID($userID){
        $this->userID = $userID; 
    }

    function execQuery($query, &$rs){
        $rs = mysqli_query($this->db_connector, $query);
       /*  echo '<br/>halo<br/>'; */
        if (!$rs) {
            echo "Could not execute query: $query";
            trigger_error(mysqli_error(), E_USER_ERROR); 
            return false;
        }else{
            /* echo "Query: $query executed<br/>"; */
            return true;
        }
    }

    function getTable($query, &$array1, &$array2){
        if(self::execQuery($query, $rs)){
            $array1 = [];
            //echo '<br/>special:'.mysqli_num_fields($rs).'<br/>';
            for($i=0;$i<mysqli_num_fields($rs);$i++){
                $array1[] = mysqli_fetch_field($rs)->name;
                /* print_r($array1);
                echo '<br/>'; */
            }
            
            $array2 = [];
            while ($row = mysqli_fetch_row($rs)) {
                $array_temp = [];
                foreach($row as $x){
                    array_push($array_temp, $x);
                }
                array_push($array2, $array_temp);
            
            }
            return true;
        }
        return false;
    }

    function getTable1($query, &$array1){

    }

    function registrationHandle($post_fname, $post_lname, $post_email, $post_mobile, $post_password, $post_gender, $post_state){
        $f_name_escape = mysqli_real_escape_string($this->db_connector, $post_fname);
        $l_name_escape = mysqli_real_escape_string($this->db_connector, $post_lname);
        $email_escape = mysqli_real_escape_string($this->db_connector, $post_email);
        $mobile_escape = mysqli_real_escape_string($this->db_connector, $post_mobile);
        $password_escape = mysqli_real_escape_string($this->db_connector, $post_password);
        $gender_escape = mysqli_real_escape_string($this->db_connector, $post_gender);
        $state_escape = mysqli_real_escape_string($this->db_connector, $post_state);

        //generate hash password
        $hash_password_generated = password_hash($password_escape, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO myUser (f_name, l_name, email, mobile, password, gender, state) VALUES (
                    '$f_name_escape', '$l_name_escape', '$email_escape', '$mobile_escape', 
                    '$hash_password_generated', '$gender_escape', '$state_escape')";

        if (mysqli_query($this->db_connector, $query)) {
            
            return true;
        }
        else {
            
            // Query fails because the apostrophe in
            // the string interferes with the query
            printf("An error occurred!");
            return false;
        }    
    }
    //return true, if login success
    //else return false
    function login($post_email, $post_password){
        $query = "SELECT * FROM myUser";
        $email_login= $password_login = "";
        
        $email_login = mysqli_real_escape_string($this->db_connector, $post_email);
        $password_login = mysqli_real_escape_string($this->db_connector ,$post_password);

        $password_extracted = $userID_extracted = $email_extracted = "";

        // Prepare a select statement
        $sql = "SELECT user_id, email, password FROM myUser WHERE email = ?";
        
        if($stmt = mysqli_prepare($this->db_connector, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email_login;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $userID_extracted, $email_extracted, $password_extracted);
                    if(mysqli_stmt_fetch($stmt)){
                        /* echo '<br/>'.password_hash($password_login, PASSWORD_DEFAULT).'<br/>'.strlen(password_hash($password_login, PASSWORD_DEFAULT)).'<br/>';
                        echo $password_login; */
                        if(password_verify($password_login, $password_extracted)){
                            // Password is correct, so start a new session
                            
                            // Store data in session variables
                            $_SESSION["loggedIn"] = true;
                            $_SESSION["userID"] = $userID_extracted;
                            $_SESSION["loggedInTime"] = date('Y-m-d H:i:s');
                            //pre-set logout datetime, if user directly close the window,
                            //php perform operation to myql would not be handled
                            $temp_login_time = $_SESSION["loggedInTime"];
                            $minutes_to_add = 5;

                            $time = new DateTime();
                            $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

                            $temp_logout_time = $time->format('Y-m-d H:i:s');

                            $temp_duration = $time->format('U') - strtotime( $_SESSION["loggedInTime"]);
                            $query3 = "INSERT INTO myUserLog (login_date_time, logout_date_time, duration, userID) VALUE ('$temp_login_time', '$temp_logout_time','$temp_duration','$userID_extracted')";
                            if(self::execQuery($query3, $rs)){
                                /* echo 'insert into myUserLog login date time success<br/>'; */
                                return true;
                            }
                            
                            
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid password.";
                            echo '<br/>'.$login_err;
                            return false;
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username.";
                    echo '<br/>'.$login_err;
                    return false;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
                return false;
            }
        }
        echo '<br/>Fail to login';

        return false;
    }

    function updateLogoutDT(){
        $user_id_login = $_SESSION['userID'];
        $login_dateTime_save = $_SESSION['loggedInTime'];
        $logout_dateTime_save = date("Y-m-d H:i:s");
        /*echo $logout_dateTime_save.'<br/>'; */
        $duration_save = strtotime($logout_dateTime_save) - strtotime($login_dateTime_save);
        /* echo $duration_save; */
        $t_sql = "UPDATE myUserLog SET logout_date_time='$logout_dateTime_save' , duration = '$duration_save' WHERE userID = '$user_id_login' AND login_date_time = '$login_dateTime_save'";
        mysqli_query($this->db_connector,$t_sql);
    }

    function __destruct(){
        mysqli_close($this->db_connector);
    }
}