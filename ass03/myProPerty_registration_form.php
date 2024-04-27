<!DOCTYPE html>
<html>
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myProPerty Registration form</title>

  </head>



  <body>

  <?php
   //basic cnnection for now: 
    // require 'mySql_databaseConnection.php';
    require_once('myProPerty_session.php');
    require_once('myProPerty_header.php');
    require_once('adverts.php');

   
   
 // REGISTRATION PHP HANDLER::::
    
    //create vairable 
    $success = ''; 
    $error = ''; //this is string*
    //$error = []; //this is declaring empty array.

   $user_type = $first_name = $last_name = $email = $mobile = $tenants = $landlords = $password = $confirm_pass = '';
    //check for submit form
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        //check for selected user type that's been submited. 
        $user_type = $_POST['user_type'];

        //validating and sanitize the given user input. 
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $mobile = trim($_POST['mobile']);
        $password = trim($_POST['password']);
        $confirm_pass = trim($_POST["confirm_pass"]);
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $insertQuery = null;

            // Check if first_name is submitted
            if (!isset($_POST['first_name']) || empty($_POST['first_name'])) {
                 $error .= '<p class="error">Please enter a first name</p>';
            }
            
            // Check if last_name is submitted
            if (!isset($_POST['last_name']) || empty($_POST['last_name'])) {
                $error .= '<p class="error"> Please enter a last name</p>';
            }
                        // Check if email is submitted
            if (!isset($_POST['email']) || empty($_POST['email'])) {
                $error .= '<p class="error">Please enter your email address</p>';
            }

                        // Check if mobile is submitted
            if (!isset($_POST['mobile']) || empty($_POST['mobile'])) {
                $error .= '<p class="error">Please enter a mobile number</p>';
            }
                        // Check if password is submitted

            if (!isset($_POST['password']) || empty($_POST['password'])) {
                $error .= '<p class="error">Please enter a password</p>';
            }
            // radio buttons
            if (!isset($user_type)) {
                $error .= '<p class="error">Please check one of the option</p>';
            }
    
    }


    // <!--vairables on this page:
    // first_name, last_name, email, mobile, password, confirm_pass-->

    if (!empty($error)) {
        // foreach ($error as $msg) { //does not work as it takes in array not string.
        //     echo '- $msg <br/>';
        // }

        //code for the string message
        $error_msg = explode('',$error); //split string into array.
        foreach($error_msg as $msg){
            echo '- $msg <br/>';
        }
    }
    else{
 
        //if the use_type is a tenants 
        if ($user_type == 'tenants'){
        //mysql prepare statement
            $query = $db_connection->prepare("SELECT * FROM tenants WHERE email = ?");
            // Bind parameters (s = string, i = int), username is a string so use "s"
            $query->bind_param('s', $email);
            $query->execute();
            // Store the result to check if account exists in the database.
            $query->store_result();

            if ($query->num_rows > 0) { //if data of row is >0 (data exists in database)
                $error .= '<p class="error">The email address is already registered!</p>';
            }
            else{

                // we validate password: MOVE THESE STATEMENT UP to isset 

                if (strlen($password ) < 6) {
                    $error .= '<p class="error">Please enter a password that is atleast 6 characters.</p>';
                }

                // Validate confirm password
                if (empty($confirm_pass)) {
                    $error .= '<p class="error">Please enter confirm password.</p>';
                } 
                else {
                    if (($password != $confirm_pass)) {
                        $error .= '<p class="error">Password did not match.</p>';
                    }
                }

                 
                //if there'sno errors::
                if (empty($error) ) {

                    if($user_type == 'tenants'){

                     //we insert new input data in the database:
                    $insertQuery = $db_connection->prepare("INSERT INTO tenants (first_name, last_name, email, mobile, password) VALUES (?, ?, ?, ?, ?);");
                    $insertQuery->bind_param("sssis", $first_name, $last_name, $email, $mobile, $password_hash);
                    //execute the bind query in result variable:
                    $result = $insertQuery->execute();
                    var_dump($result); // for debugging
                    }

                    if ($result) {
                        $success .= '<p class="success">Your registration was successful, please login to continue!</p>';
                    } 
                    else {
                        $error .= '<p class="error">Something went wrong: '.$insertQuery->error.'</p>';
                    }
                }//if no error
         
           
       
            }//else
            $query->close();
        }//if user_type = tenents
        
        //if the user_type is a landlords.
        else if ($user_type == 'landlords'){

            //mysql prepare statement
            $query = $db_connection->prepare("SELECT * FROM landlords WHERE email = ?");
            // Bind parameters (s = string, i = int), username is a string so use "s"
            $query->bind_param('s', $email);
            $query->execute();
            // Store the result to check if account exists in the database.
            $query->store_result();



            if ($query->num_rows > 0) { //if data of row is >0 (data exists in database)
                $error .= '<p class="error">The email address is already registered!</p>';
            }
            else{

                // we validate password: MOVE THESE STATEMENT UP to isset 


                if (strlen($password ) < 6) {
                    $error .= '<p class="error">Please enter a password that is atleast 6 characters.</p>';
                }

                // Validate confirm password
                if (empty($confirm_pass)) {
                    $error .= '<p class="error">Please enter confirm password.</p>';
                } 
                else {
                    if (($password != $confirm_pass)) {
                        $error .= '<p class="error">Password did not match.</p>';
                    }
                }

                 
                //if there'sno errors::
                if (empty($error) ) {

                    if($user_type == 'landlords'){

                     //we insert new input data in the database:
                    $insertQuery = $db_connection->prepare("INSERT INTO landlords (first_name, last_name, email, mobile, password) VALUES (?, ?, ?, ?, ?);");
                    $insertQuery->bind_param("sssis", $first_name, $last_name, $email, $mobile, $password_hash);
                    //execute the bind query in result variable:
                    $result = $insertQuery->execute();
                    var_dump($result); // for debugging
                    }
                    if ($result) {
                        $success .= '<p class="success">Your registration was successful, please login to continue!</p>';
                    } 
                    else {
                        $error .= '<p class="error">Something went wrong: '.$insertQuery->error.'</p>';
                    }
                }//if no error
         
             $query->close();
       
            }

        }//if user_type = landlord.
        
    }
  ?>


  <!-- HTML  -->
  <div class="container">
 
  <h2 class="mt-5 text-center"> Register </h2>
         <div class="row">
             <div class="col-md-4 offset-md-4">
                    <!-- <p>Please fill this form to create an account.</p> -->
                    <?php echo $error; ?>
                    <?php echo $success; ?>
                    <!-- validation -->
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                       <!--vairables on this page:
                    first_name, last_name, email, mobile, password, confirm_pass-->

                        <!-- first name -->
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>"class="form-control" required><br>
                        </div>    
                        
                        <!-- last name -->
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>"class="form-control" required><br>
                        </div>                        

                        <!-- Emial ADDRESS -->
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" class="form-control" required><br>
                        </div>    

                        <!-- mobile -->
                        <div class="form-group">
                            <label for="mobile">Mobile:</label>
                            <input type="tel" id="mobile" name="mobile" value="<?php if(isset($_POST['moible']))echo $mobile; ?>" class="form-control" required><br>
                        </div>    

                        <!-- PASSWORD -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>" class="form-control" required><br>
                        </div>
                        <!-- CONFIRM pass  -->
                        <div class="form-group">
                            <label for="confirm_pass">Confirm Password</label>
                            <input type="password" id="confirm_pass" name="confirm_pass" value="<?php if(isset($_POST['confirm_pass'])) echo $_POST['confirm_pass']; ?>" class="form-control" required><br>
                        </div>
                       <!-- form check for tenants -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="user_type" id="tenants"
                            value = "tenants">
                            <label class="form-check-label" for="tenants">
                                I am a tenants
                            </label>
                        </div>
                        <!-- form check for landlords-->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="user_type" id="landlords"
                            value = "landlords">
                            <label class="form-check-label" for="landlords">
                                I am a landlords
                            </label>
                        </div>

                        <!-- submiy BUTTON -->
                        <div class="form-group">
                            <input type="submit" name="submit" class="mt-3 btn btn-primary" value="Submit">
                        </div>
                        <!-- Link to LOGIN.php page -->
                        <p>Already have an account? <a href="myProPerty_login.php">Login here</a>.</p>
                    </form>
                </div>
            </div>
        </div>

        
  </body>
</html>