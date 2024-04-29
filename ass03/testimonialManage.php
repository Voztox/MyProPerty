<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Testimonials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "styles.css">
</head>
<body>
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 's3105875');

// Establish a new database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


require_once('myProPerty_session.php');
require_once('myProPerty_header_user.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $serviceName = $_POST['serviceName'];
    $date = $_POST['date'];
    $parentFirstName = $_POST['parentFirstName'];
    $comment = $_POST['comment'];

    // Prepare the SQL statement
    $sql = "INSERT INTO testimonial  (serviceName, date, parentFirstName, comment) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the statement
    $stmt->bind_param("ssss", $serviceName, $date, $parentFirstName, $comment);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<div class='alert alert-success' role='alert'>Testimonial added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $conn->error . "</div>";
    }

    // Close the statement
    $stmt->close();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission to approve or disapprove testimonials
    if (isset($_POST['approve'])) {
        $testimonialID = $_POST['approve'];
        $sql = "UPDATE testimonial SET approved = 1 WHERE testimonialID = $testimonialID";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Testimonial approved successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error updating record: </div>" . $conn->error;
        }
    } elseif (isset($_POST['disapprove'])) {
        $testimonialID = $_POST['disapprove'];
        $sql = "DELETE FROM testimonial WHERE testimonialID = $testimonialID";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Testimonial disapproved successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error deleting record: </div>" . $conn->error;
        }
    }
}

// Retrieve testimonials from the database
$sql = "SELECT testimonialID, parentFirstName, serviceName, date, comment FROM testimonial";
$result = $conn->query($sql);
?>
    <h3 class="text-center">Manage Testimonials</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Service Name</th>
                <th>Date</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['parentFirstName']; ?></td>
                        <td><?php echo $row['serviceName']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['comment']; ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="approve" value="<?php echo $row['testimonialID']; ?>">
                                <button type="submit" class="btn btn-primary">Approve</button>
                            </form>
                            <form action="" method="post" style="display: inline;">
                                <input type="hidden" name="disapprove" value="<?php echo $row['testimonialID']; ?>">
                                <button type="submit" class="btn btn-danger">Disapprove</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No testimonials available.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php require_once('footer.php'); ?>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
