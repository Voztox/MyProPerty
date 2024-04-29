<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myProPerty Password reset.</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body>

    <?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 's3105875');

// Establish a new database connection
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// Check connection
if ($db_connection->connect_error) {
    die("Database connection failed: " . $db_connection->connect_error);
}
    require_once ("myProPerty_session.php");
    require_once ('myProPerty_header.php');

    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
        $user_id = $user_type = $password = $result ='';
        // //GET USER_id from session
        // $user_id = $_SESSION['user_ID']

        //determin uder_type frompOST  
        $user_type = $_POST['user_type'];
          //retrieving user form input
          $old_pass = trim($_POST['old_password']);
          $new_pass = trim($_POST['new_password']);
       //hashing pass
        $password_hash = password_hash($new_pass, PASSWORD_BCRYPT);

      

        if (empty($email)) {
            $error = '<p class="error">Please enter your old password.</p>';
            } 
        
        if (empty($password)) {
            $error = '<p class="error">Please enter your new password.</p>';
            } 

        if (!isset($user_type)) {
            $error = '<p class="error">Please enter the fileds below. </p>';
        }

        else if (empty($error)){

         if(empty($error) && $user_type == 'tenants'){
            //searching by the email to compare password of customer of myProPerty
                $query = $db_connection->prepare("SELECT * FROM tenants WHERE password = ?");
                // Bind parameters (s = string, i = int),  string so use "s"
                $query->bind_param("i", $password_hash );
                $query->execute();
                // Store the result to check if account exists in the database.
                $result = $query->get_result();
                // $result = $conn->query($sql); (ignore).


                //check for user in database::::
                if ($result->num_rows > 0) { //check for data row
                    //fetching the data from myProPerty database
                    $row = $result->fetch_assoc();

                    //Verify the given input with data from database::::::
                        // verify the password
                        if ($result == $old_pass) {
                            //if the password macthes we update the table to the database:
                                $update_sql = "UPDATE $tenants SET $password = '$new_pass' WHERE password = '$password'";
                                $update_result = mysqli_query($db_connection, $update_sql);
                               
                                if ($update_result) {
                                    echo "Password updated successfully.";
                                } 
                                else {
                                    echo "Error updating password: " . mysqli_error($db_connection);
                                   }  
                                 }//if
                            
                            else {
                                echo "Incorrect old password.";
                            }
                        } 
                        else {
                            echo "User not found.";
                        }

                }//tenants

                if(empty($error) && $user_type == 'landlords'){
                    //searching by the email to compare password of customer of myProPerty
                        $query = $db_connection->prepare("SELECT * FROM landlords WHERE password = ?");
                        // Bind parameters (s = string, i = int),  string so use "s"
                        $query->bind_param("i", $password_hash );
                        $query->execute();
                        // Store the result to check if account exists in the database.
                        $result = $query->get_result();
                        // $result = $conn->query($sql); (ignore).
        
        
                        //check for user in database::::
                        if ($result->num_rows > 0) { //check for data row
                            //fetching the data from myProPerty database
                            $row = $result->fetch_assoc();
        
                            //Verify the given input with data from database::::::
                                // verify the password
                                if ($result == $old_pass) {
                                    //if the password macthes we update the table to the database:
                                        $update_sql = "UPDATE $landlords SET $password = '$new_pass' WHERE password = '$password'";
                                        $update_result = mysqli_query($db_connection, $update_sql);
                                       
                                        if ($update_result) {
                                            echo "Password updated successfully.";
                                        } 
                                        else {
                                            echo "Error updating password: " . mysqli_error($db_connection);
                                           }  
                                         }//if
                                    
                                    else {
                                        echo "Incorrect old password.";
                                    }
                                } 
                                else {
                                    echo "User not found.";
                                }
        
                        }//landlords

                        if(empty($error) && $user_type == 'admin'){
                            //searching by the email to compare password of customer of myProPerty
                                $query = $db_connection->prepare("SELECT * FROM admin WHERE password = ?");
                                // Bind parameters (s = string, i = int),  string so use "s"
                                $query->bind_param("i", $password_hash );
                                $query->execute();
                                // Store the result to check if account exists in the database.
                                $result = $query->get_result();
                                // $result = $conn->query($sql); (ignore).
                
                
                                //check for user in database::::
                                if ($result->num_rows > 0) { //check for data row
                                    //fetching the data from myProPerty database
                                    $row = $result->fetch_assoc();
                
                                    //Verify the given input with data from database::::::
                                        // verify the password
                                        if ($result == $old_pass) {
                                            //if the password macthes we update the table to the database:
                                                $update_sql = "UPDATE $admin SET $password = '$new_pass' WHERE password = '$password'";
                                                $update_result = mysqli_query($db_connection, $update_sql);
                                               
                                                if ($update_result) {
                                                    echo "Password updated successfully.";
                                                } 
                                                else {
                                                    echo "Error updating password: " . mysqli_error($db_connection);
                                                   }  
                                                 }//if
                                            
                                            else {
                                                echo "Incorrect old password.";
                                            }
                                        } 
                                        else {
                                            echo "User not found.";
                                        }
                
                                }//admin
             }//else if no error
                                 // Close connection
                        mysqli_close($db_connection);
  
        }
    

        
    
    ?>

    <!-- HTML -->
    <div class="container">
        <h2 class="mt-5 text-center"> Reset Password </h2>
        <!-- Start of row -->
        <div class="row">
            <!-- Form starts within a column of size 4 centered -->
            <div class="col-md-4 offset-md-4">
                <!-- variable names in this page: email, password -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" novalidate class="mt-3">
                   
                    <!-- password-->
                    <div class="form-group">
                        <label for="old_password">Enter Your Old Password</label>
                        <input type="text" id="old_password" name="old_password" value="<?php echo isset($_POST['old_password']) ? $_POST['old_password'] : ''; ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="new_password">Enter Your New Password</label>
                        <input type="text" id="new_password" name="new_password" value="<?php echo isset($_POST['new_password']) ? $_POST['new_password'] : ''; ?>" class="form-control" required>
                    </div>
                    <!-- form check for tenants -->
                    <div class="form-check mt-3">
                            <input class="form-check-input" type="radio" name="user_type" id="tenants"
                            value = "tenants">
                            <label class="form-check-label" for="tenants">
                                I am a tenant
                            </label>
                        </div>
                        <!-- form check for landlords-->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="user_type" id="landlords"
                            value = "landlords">
                            <label class="form-check-label" for="landlords">
                                I am a landlord
                            </label>
                        </div>

                         <!-- form check for admin-->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="user_type" id="admin"
                            value = "admin">
                            <label class="form-check-label" for="admin">
                                I'm an admiin
                            </label>
                        </div>
                    
                    <button type="submit" class="mt-3 btn btn-primary" name="reset">Reset Password</button>
                    
                </form>
            </div>
        </div>
        <!-- End of row -->
    </div>
    
<!-- closing tags -->
<!-- Link to external JavaScript file -->
<script src="script.js"></script>

<!-- Link to Bootstrap JS (required for dropdowns, toggles, etc.) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>