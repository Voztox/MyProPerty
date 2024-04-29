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

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to the login page if not logged in
    header("Location: myProPerty_login.php");
    exit(); // Stop further execution
}



// Get the user's ID from the session
$login_ID = $_SESSION['userID'];

// Check if the user is an admin
$sql = "SELECT * FROM admin WHERE userID = '$login_ID'";
$result = mysqli_query($db_connection, $sql);

// Check if the user is an admin
if (mysqli_num_rows($result) === 0) {
    // Redirect user if they are not an admin
    header('Location: index.php');
    exit(); // Stop further execution
}



// Fetch the admin's email
$admin_row = mysqli_fetch_assoc($result);
$admin_email = $admin_row['email'];

// Fetch queries associated with this admin's email
$sql_3 = "SELECT * FROM queries WHERE admin_email = '$admin_email'";
$result = mysqli_query($db_connection, $sql_3);
?>

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

    <div class="container">
        <h2 class="mt-5 text-center">Emails</h2>
        <div class="table-responsive">
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Querie_ID</th>
                        <th>Admin Email</th>
                        <th>Sender Email</th>
                        <th>Message</th>
                        <th>Reply</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any queries for this admin
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["querie_ID"] . "</td>";
                            echo "<td>" . $row["admin_email"] . "</td>";
                            echo "<td>" . $row["sender_email"] . "</td>";
                            echo "<td>" . $row["message"] . "</td>";
                            echo "<td><a href='myProPerty_contect_us.php" . $row["querie_ID"] . "' class='btn btn-primary'>Reply</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No email found for this Admin user.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Link to external JavaScript file -->
    <script src="script.js"></script>

    <!-- Link to Bootstrap JS (required for dropdowns, toggles, etc.) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
