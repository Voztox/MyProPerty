<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myProPerty Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body>

<?php

require_once('myProPerty_session.php');
require_once('myProPerty_header.php');
require_once('adverts.php');


    //vairables:
    $error ='';

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
             //check for selected user type that's been submited. 
            $user_type = $_POST['user_type'];
            //initialize and trim variables
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);


            //validating if input is empty::::::::::
                
                if (empty($email)) {
                    $error = '<p class="error">Please enter email.</p>';
                    } 
                
                if (empty($password)) {
                    $error = '<p class="error">Please enter password.</p>';
                    } 

                if (!isset($user_type)) {
                    $error = '<p class="error">Please check one of the option</p>';
                 } 


            //validaing input::::::::

                if(empty($error) && $user_type == 'tenants'){
                    //searching by the email to compare password of customer of myProPerty
                        $query = $db_connection->prepare("SELECT * FROM tenants WHERE email = ?");
                        // Bind parameters (s = string, i = int),  string so use "s"
                        $query->bind_param("s", $email);
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
                                if (password_verify($password, $row['password'])) {
                                    $_SESSION["userID"] = $row['userID'];
                                    $_SESSION["tenants"] = $row;//customer table
                                    $_SESSION["first_name"] = $row['first_name']; 
                               
                                    // Redirect the user to welcome page
                                    header("location:myProPerty_welcome.php");
                                    exit;
                                }
                                else {
                                    $error = '<p class="error">The password you have enter is invalid.</p>';
                                }
                        }//checking num rows
                            else{ 
                                $error = '<p class="error">No User exist with that email address.</p>';
                            }//else
                            //close query statement.
                            $query->close();
                        }//if error is empty


                        else if (empty($error) && $user_type == 'landlords'){
                            //searching by the email to compare password of customer of myProPerty
                        $query = $db_connection->prepare("SELECT * FROM landlords WHERE email = ?");
                        // Bind parameters (s = string, i = int),  string so use "s"
                        $query->bind_param("s", $email);
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
                                if (password_verify($password, $row['password'])) {
                                    $_SESSION["userID"] = $row['userID'];
                                    $_SESSION["landlord"] = $row;//customer table
                                    $_SESSION["first_name"] = $row['first_name']; 
                               
                                    // Redirect the user to welcome page
                                    header("location:myProPerty_welcome.php");
                                    exit;
                                }
                                else {
                                    $error = '<p class="error">The password you have enter is invalid.</p>';
                                }
                         }//checking num rows
                            else{ 
                                $error = '<p class="error">No User exist with that email address.</p>';
                            }//else
                            //close query statement.
                            $query->close();

                        }
                        // Close connection
                        mysqli_close($db_connection);

                        // display errors (if any)
                        if (!empty($error)) {
                            display_login_error($error);
                        }
            }//submit

            function display_login_error($error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            
    ?>
    <!-- HTML FORM -->

    <div class="container">
        <h2 class="mt-5 text-center"> Login </h2>
        <!-- Start of row -->
        <div class="row">
            <!-- Form starts within a column of size 4 centered -->
            <div class="col-md-4 offset-md-4">
                <!-- variable names in this page: email, password -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" novalidate class="mt-3">
                    <!-- email -->
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" class="form-control" required><br>
                    </div>
                    <!-- password-->
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="text" id="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" class="form-control" required>
                    </div>
                    <!-- form check for tenants -->
                    <div class="form-check mt-3">
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
                    <button type="submit" class="mt-3 btn btn-primary" name="login">Login</button>
                    <!-- Link to registeration page -->
                    <p>Don't have an account? <a href="myProPerty_registration_form.php">Register here</a>.</p>
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