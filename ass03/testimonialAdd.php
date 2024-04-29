<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Testimonial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "styles.css">
</head>

<body>
<?php
require_once('myProPerty_session.php');
require_once('myProPerty_header_user.php');
require_once('adverts.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $serviceName = $_POST['serviceName'];
    $date = $_POST['date'];
    $parentFirstName = $_POST['parentFirstName'];
    $comment = $_POST['comment'];

    // Prepare the SQL statement
    $sql = "INSERT INTO testimonial (serviceName, date, parentFirstName, comment) VALUES (?, ?, ?, ?)";
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
?>
    <div class="container mt-4">
        <h3 class="text-center">Add Testimonial</h3>
        <form class="mt-4 card p-3 mb-3" action="" method="post">
            <div class="form-group ">
                <label for="serviceName">Service Name:</label>
                <input type="text" class="form-control" id="serviceName" name="serviceName" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="parentFirstName">Parent's First Name:</label>
                <input type="text" class="form-control" id="parentFirstName" name="parentFirstName" required>
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php require_once('footer.php');?>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
