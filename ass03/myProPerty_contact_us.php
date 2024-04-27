<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
         <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once('myProPerty_session.php');
    require_once('myProPerty_header.php');
    require_once('adverts.php');

//vairables:
$error = '';
$success ='';
 $tenant_email = $landlord_email = $message = '';
 //check for submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
    $tenant_email = $_POST['tenant_email'];
    $landlord_email = $_POST['landlord_email'];
    $message = $_POST['message'];
    //if empty within submission 
    if(empty($tenant_email) && empty($landlord_email) && empty($message)){
        display_contact_error($error);
        echo "Please enter all the fileds!";
    }
    
    else {

        //queires
    $sql = "SELECT * FROM tenants WHERE email='$tenant_email'";
    $tenant_result = mysqli_query($db_connection, $sql);
    $sql_2 = "SELECT * FROM landlords WHERE email='$landlord_email'";
    $landlord_result = mysqli_query($db_connection, $sql_2);
    $sql_3 = "SELECT * FROM queries WHERE message ='$message'";
    $message_result = mysqli_query($db_connection, $sql_3);
    

    //check that the email is valid in the database. cant send email to none user.
    if (mysqli_num_rows($tenant_result) == 0 && mysqli_num_rows($landlord_result) == 0) {
        // no record found, display error message
        echo "Error: Looks like your email or your landlord email is incorrect!";
    } 
    else {
        //inset into database if required field is not empty
        if(!empty($tenant_email) && !empty($landlord_email) && !empty($message)){
            $sql = $db_connection->prepare("INSERT INTO queries (tenant_email, landlord_email, message) VALUES (?, ?, ?);");
            $sql->bind_param("sss",$tenant_email, $landlord_email, $message);
             //execute the bind query in result variable:
            $result = $sql->execute();
            var_dump($result); // for debugging
        
        if ($result) {
            $success .= '<p class="alert alert-success" "style="text-align: center !important;">Sent!!</p>';
        } 
        else {
            $error .= '<p class="error">Something went wrong: '.$sql->error.'</p>';
        }

    }//else if not empty

    }//if there's user name 
    }

    // if (!empty($error)) {
    //     //code for the string message
    //     $error_msg = explode('',$error); //split string into array.
    //     foreach($error_msg as $msg){
    //         echo '- $msg <br/>';
    //     }
    // }
    // Display error and success messages
if (!empty($error)) {
    display_contact_error($error);
}

if (!empty($success)) {
    echo $success;
}
    
 // Close database connection everytime we finish.
 mysqli_close($db_connection);
}
function display_contact_error($error){
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
 


    ?>
    
    <div class="container">

        <h2 class="mt-5 text-center"> Send Your Email</h2>
         <div class="row">
             <div class="col-md-4 offset-md-4">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" novalidate class="mt-3">

                <div class="form-group">
                    <label for="tenant_email" class="tenant_email">Your Email</label>
                    <input type="email" class="form-control" id="tenant_email" name="tenant_email" placeholder="name@example.com" required>
                </div>

                <div class="form-group">
                    <label for="landlord_email" class="landlord_email">Your Landlord Email</label>
                    <input type="email" class="form-control" id="landlord_email" name="landlord_email" placeholder="name@example.com" required>
                </div>

                <div class="form-group"> 
                      <label for="message" class="form-label">Your Queries</label>
                     <textarea class="form-control" id="message"  name="message" rows="10" required></textarea>
                </div>

                <div class="form-control-lg mb-3">
                <button type="submit" name ="submit" class=" btn btn-primary form-control-sm offset-md-11">Send</button>
                </div>
                 <!-- <a class="btn btn-primary mt-3 offset-md-11" href="#" role="button">Send</a> --> 
                </form>
               

            </div>
        </div>
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