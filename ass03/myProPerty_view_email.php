<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Email</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body>

    <?php
    require_once('mySql_databaseConnection.php');
    require_once('myProPerty_session.php');
    require_once('myProPerty_header.php');

    //always check if user is logged in
    if (!isset($_SESSION['userID'])) {
    // Redirect to login page or display an error message
    header("Location: myProPerty_login.php"); // Redirect to the login page
    exit(); // Stop further execution
    
}


     //check if user is not a lanlord:::::::::
                    //request login email.
                    $login_landlord = $_SESSION['userID'];
                    //select from  database  landlords table.
                    $sql = "SELECT * FROM landlords WHERE userID = '$login_landlord'";
                    $result = mysqli_query($db_connection, $sql);
    
                    //check if the email is in the landlord database.
                    if (mysqli_num_rows($result) === 0) { //if no email found/matched.
                        //redired user
                        header('Location: index.php');
                    }

    ?>

<div class="container">
        <h2 class="mt-5 text-center">Emails</h2>
        <div class="table-responsive">
        <table class="table table-striped mt-3">
            <thead>
                <tr>          
                    <th>Querie_ID</th>
                    <th>Email</th>
                    <th>Message</th>  
                    <th>Reply</th>
                </tr>
            </thead>
            <tbody>

                <?php


                  // //request the email so we can view the data that was sent to that email only.

                
                $login_email =  $email = '';        
                // $sql_2 = "SELECT * FROM landlords where email = '$login_email'";
                // $result = mysqli_query($db_connection, $sql_2);
                // Fetch all landlord's email from the database
                $sql = "SELECT * FROM queries where landlord_email = '$login_email'";
                $result = mysqli_query($db_connection, $sql);
            
                // Check if there are any customers
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<td>". $row["querie_ID"] ."</td>";
                        echo "<td>". $row["tenant_email"] ."</td>";
                        echo "<td>". $row["message"] ."</td>"; 
                        echo "<td><a href='myProPerty_reply.php" . $row["querie_ID"] . "' class='btn btn-primary'>Reply</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No email found for this landlord.</td></tr>";
                }

                // Close database connection
                mysqli_close($db_connection);
                ?>
            </tbody>
        </table>
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