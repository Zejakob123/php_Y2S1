<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle.css">
    <style>
        form div input[type="text"]{
            width: 200px;
            outline: none;
            border-radius: 5px;
            background-color: beige;
        }

        form div.go_back_class a{
            text-decoration: none;
            color: white;
            padding: 16px 50px;
            border-radius: 10px;
            background-color: #293241;
            text-align: center;
            float: right;
            display:inline-block;
        }
    </style>

    
</head>
<body>
    <?php
        session_start();
        date_default_timezone_set('Asia/Kuching');
        //used for later redirect user back to registration html
        if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
            $uri = 'https://';
        } else {
            $uri = 'http://';
        }
        $uri .= $_SERVER['HTTP_HOST'];
        $dirname = dirname($_SERVER['PHP_SELF']);
        if(strlen($dirname) === 1) {
            $dirname = '';
        }
        
        include_once 'dbConnection.php';
        //check available function
        function isEmptyOrTrimEmpty($elementId){
            return ((isset($_POST[$elementId]))?(empty($_POST[$elementId]) || empty(trim($_POST[$elementId]))):true);
        }
        //declare variable
        $login_email_alert_string = $login_password_alert_string = "";
        $login_email = $login_psd = "";

        $user_fname = $user_lname = $user_email = $user_mobile = "";
        $user_psd = $user_cpsd = $user_gender = $user_state = "";

        $user_fname_alert_string = $user_lname_alert_string = $user_email_alert_string = $user_mobile_alert_string = '';
        $user_password_alert_string = $user_cpassword_alert_string = $user_gender_alert_string = $user_state_alert_string = '';
        $user_provision_alert_string = '';

        $user_provision_checked = '';
        $isValidate = false;
        $validateNumber = 0;

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            //form validation
            //validation for fname
            
            if(isset($_POST['Submit'])){
                
                if(isEmptyOrTrimEmpty('user_fname')){
                    $user_fname_alert_string = "Your input cannot be empty or contain space character !";
                }else{
                    $user_fname = $_POST['user_fname'];
                    if(!preg_match("/^[A-Z][a-z]{0}/", $user_fname)  ||  preg_match("/\s/", $user_fname)){
                        $user_fname_alert_string = "Your name input must be the first character uppercase and followed by lowercase without any space character!";
                    }else{
                        $validateNumber++;
                    }
                }
                
                //validation for lname
                if(isEmptyOrTrimEmpty('user_lname')){
                    $user_lname_alert_string = "Your input cannot be empty or contain space character !";
                }else{
                    $user_lname = $_POST['user_lname'];
                    if(!preg_match("/^[A-Z][a-z]{0}/", $user_fname)  ||  preg_match("/\s/", $user_lname)){
                        $user_lname_alert_string = "Your name input must be the first character uppercase and followed by lowercase without any space character!";
                    }else{
                        $validateNumber++;
                    }
                }
                
                //validation for email
                if(isEmptyOrTrimEmpty('user_email')){
                    $user_email_alert_string = "Your input cannot be empty or contain space character !";
                }else{
                    $user_email = $_POST['user_email'];
                    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                        $user_email_alert_string = "Invalid email format !";
                    }else{
                        $validateNumber++;
                    }
                }
                //validation for mobile
                if(isEmptyOrTrimEmpty('user_mobile')){
                    $user_mobile_alert_string = "Your input cannot be empty or contain space character !";
                }else{
                    $user_mobile = $_POST['user_mobile'];
                    if(!preg_match('/^[1-9][0-9]{7,9}+$/', $user_mobile)  ||  strlen($user_mobile) < 8  ||  strlen($user_mobile) > 10){
                        $user_mobile_alert_string = "Your input must have at least 8 digits and not more than 10 digits character !";
                    }else{
                        $validateNumber++;
                    }
                }
                //validation for password
                if(isEmptyOrTrimEmpty('user_password')){
                    $user_password_alert_string = "Your input cannot be empty or contain space character !";
                }else{
                    $user_psd = $_POST['user_password'];
                    if(!preg_match("#.*^(?=.{6})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\S).*$#", $user_psd)){
                        $user_password_alert_string = "Your 6 alphanumeric password must have at least 1 uppercase, 1 lowercase, 1 special character and no space character";
                    }else{
                        $validateNumber++;
                    }
                }
                //validation for cpassword
                if(isEmptyOrTrimEmpty('user_cpassword')){
                    $user_cpassword_alert_string = "Your input cannot be empty or contain space character !";
                }else{
                    $user_cpsd = $_POST['user_cpassword'];
                    if($user_cpsd != $user_psd){
                        $user_cpassword_alert_string = "Your confirm password is not correct !";
                    }else{
                        $validateNumber++;
                    }
                }
                //validation for gender
                if(isEmptyOrTrimEmpty('user_gender')){
                    $user_gender_alert_string = "Please choose your gender !";
                }else{
                    $user_gender = $_POST['user_gender'];
                    $validateNumber++;
                }
                //validation for state
                if(isEmptyOrTrimEmpty('user_state')){
                    $user_state_alert_string = "Please choose your staying state !";
                }else{
                    $user_state = $_POST['user_state'];
                    $validateNumber++;
                }
                //validation for provision
                if(isEmptyOrTrimEmpty('user_provision')){
                    $user_provision_alert_string = "You must accept the provision before registration !";
                }else{
                    $user_provision_checked = "checked";
                    $validateNumber++;
                }
                
                $isValidate = ($validateNumber == 9)?true:false;
                
            
            }else if(isset($_POST['Login']) && !isset($_SESSION["loggedIn"])){
                //if form submit with the submit button (name = "Login")
                //detect 
                //check sql database user
                //validation for email
                $validateLogin = 0;
                if(isEmptyOrTrimEmpty('loginEmail')){
                    $login_email_alert_string = "Your input cannot be empty or contain space character !";
                }else{
                    $login_email = $_POST['loginEmail'];
                    if (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
                        $login_email_alert_string = "Invalid email format !";
                    }else{
                        $validateLogin++;
                    }
                }

                if(isEmptyOrTrimEmpty('loginPassword')){
                    $login_password_alert_string = "Your input cannot be empty or contain space character !";
                }else{
                    $login_psd = $_POST['loginPassword'];
                    if(!preg_match("#.*^(?=.{6})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\S).*$#", $login_psd)){
                        $login_password_alert_string = "Your 6 alphanumeric password must have at least 1 uppercase, 1 lowercase, 1 special character and no space character";
                    }else{
                        $validateLogin++;
                    }
                }

                if($validateLogin == 2){
                    $user_t = new User_t();
                    if($user_t->login($login_email, $login_psd)){
                        
                    }
                }
                
                
            }else if(isset($_POST['Logout']) && isset($_SESSION['loggedIn'])){
                //logout handling
                $temp_user_t = new User_t();
                $temp_user_t->updateLogoutDT();
                //destroy the session variable
                unset($_SESSION['loggedIn']);
                unset($_SESSION['userID']);
                unset($_SESSION['loggedInTime']);
                
            }
        }
        
        
    ?>  
    <!-- display data -->
    <main>

    <?php 
       
        if($_SERVER["REQUEST_METHOD"] === "GET"){
            if($_GET['login'] === "login"){
                echo '<div>
                <h1><?php if($_GET[\'login\'] === "login") {echo \'Login Form\';}else {echo \'Display Input in Server Side\';} ?></h1>
                </div>
                <form class="login-form" method="post" action ="'.htmlspecialchars($_SERVER["PHP_SELF"]).'"> 
                    <fieldset>
                        <!-- login email -->
                        
                        <label for="loginEmail">User Account</label>
                        <input type="email" name="loginEmail" id="user_account" placeholder="Email">
                        <p>'.$user_email_alert_string.'</p>
                    </fieldset>
                    <fieldset>
                        <!-- password -->
                        <label for="loginPassword">Password</label>
                        <!-- <span><a href="">Forgot password?</a></span> -->
                        <input type="password" name="loginPassword" id="user_password" placeholder="password">
                        <p>'.$user_password_alert_string.'</p>
                        
                    </fieldset>
                    <fieldset>
                        <!-- submit -->
                        <input type="submit" name="Login" value="Log in" class="button-login">
                        <a href="registration.html" class="back-login">Register Account</a>
                    </fieldset>
                </form>';
            }
        }else if(isset($_POST['Submit']) && !$isValidate){
            echo'
                <section>
                    <form action="#">
                        <div>   
                            <label for="user_fname"><p>First Name</p><img src="source/icon/Normal/id-card.png" alt="icon" id="fname_img"></label>
                            <!--  <label for="user_fname" id="user_fname_icon"></label> -->
                            <input type="text" name="user_fname"  disabled value="'.htmlspecialchars($user_fname).'">
                            <p>$user_fname_alert_string</p>
                        </div>
                        <div>
                            <label for="user_lname"><p>Last Name</p><img src="source/icon/Normal/id-card.png" alt="icon" id="lname_img"></label>
                            <input type="text" name="user_lname" disabled value="'.htmlspecialchars($user_lname).'">
                            <p>$user_lname_alert_string</p>
                        </div>
                        <div>
                            <label for="user_email"><p>Email</p><img src="source/icon/Normal/email.png" alt="icon" id="email_img"></label>
                            <input type="text" name="user_email" disabled value="'.htmlspecialchars($user_email).'">
                            <p>$user_email_alert_string</p>
                        </div>
                        <div>
                            <label for="user_mobile"><p>Mobile</p><img src="source/icon//Normal/smartphone.png" alt="icon" id="mobile_img"></label>
                            <input type="text" id="country_code" style= "width:50px" disabled value="+60">
                            <input type="text" name="user_mobile" style="width: 140px" disabled value="'.htmlspecialchars($user_mobile).'">
                            <p>$user_mobile_alert_string</p>
                        </div>
                        <div>
                            <label for="user_password"><p>Password</p><img src="source/icon/Normal/password.png" alt="icon" id="password_img"></label>
                            <input type="text" name="user_password" disabled value="'.htmlspecialchars($user_psd).'">
                            <p>$user_password_alert_string</p>
                        </div>
                        <div>
                            <label for="user_cpassword"><p>Confirm Password</p><img src="source/icon/Normal/confirm_password.png" alt="icon" id="cpassword_img"></label>
                            <input type="text" name="user_cpassword" disabled value= "'.htmlspecialchars($user_cpsd).'">
                            <p>$user_cpassword_alert_string</p>
                        </div>
                        <div>
                            <label for="user_gender"><p>Gender</p><img src="source/icon/Normal/gender.png" alt="icon" id="gender_img"></label>
                            <input type="text" name="user_gender" disabled value= "'.htmlspecialchars($user_gender).'">
                            <p>$user_gender_alert_string</p>
                        </div>
                        <div>
                            <label for="user_state"><p>State</p><img src="source/icon/Normal/region.png" alt="icon" id="state_img"></label>
                            <input type="text" name="user_state" disabled value = "'.htmlspecialchars($user_state).'">
                            <p>$user_state_alert_string</p>
                        </div>
                        <div>
                            <div><input type="checkbox" name="user_provision" $user_provision_checked disabled/><span>I accept the above Terms and Conditions</span></div>
                            <p>$user_provision_alert_string</p>
                        </div>
                        
                        <div class="go_back_class">
                            
                            <a href="registration.html">Go back</a>
                        </div>
                    </form>
                </section>';
        }else if(isset($_POST['Submit']) && $isValidate){
            //show data written in db is completed
                //write in database
            $user_t = new User_t();
            if($user_t->registrationHandle($user_fname, $user_lname, $user_email, $user_mobile, $user_psd, $user_gender, $user_state)){
                echo 'Account Registration success<br/>';
                
            }else{
                echo 'Account Registration unsuccess<br/>';
            }
            echo '<a href="registration.html">Back To Registration page</a>';
            
        }else if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true){
            //display myUser and myUserLog table
            $user_t = new User_t();
            $user_t->setUserID($_SESSION["userID"]);
            //display table of myUser and myUserLog, and joing table
            $query1 = "SELECT * FROM myUser";
            $query2 = "SELECT * FROM myUserLog";
            $query3 = "SELECT myUserLog.userID, myUser.email, myUserLog.login_date_time, myUserLog.logout_date_time, 
                       myUserLog.duration FROM myUserLog JOIN myUser ON myUserLog.userID = myUSer.user_id";
            $query_array = Array($query1, $query2, $query3);

            $tableName = Array('myUser', 'myUserLog', 'Joining Table between myUser and myUserLog');

            for($i = 0; $i < count($query_array); $i++){
                $user_t->getTable($query_array[$i], $array_th, $array_row);

                echo '<table><legend>'.$tableName[$i].'</legend><tr>';

                for($j = 0; $j < count($array_th); $j++){
                    echo '<td>'.$array_th[$j].'</td>';
                }
                echo '</tr>';
                foreach($array_row as $temp_row){
                    echo '<tr>';
                    foreach($temp_row as $temp_el){
                        echo '<td>'.$temp_el.'</td>';
                    }
                    echo '</tr>';
                }

                echo '</table>';
                echo '<br/><br/><br/>';

            }
                
            //logout event handling
            echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post"><input type="submit" name="Logout" value="Logout"/></form>';
                
        }else{
                
            echo '<a href="formValidation.php?login=login">Back to Login page</a>';
        }
            


             
        ?>    
    </main>



</body>
</html>

