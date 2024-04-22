<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Edit</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Set cookies for highlighted properties
    setcookie("highlighted_properties", serialize($_POST['highlighted_properties']), time() + (86400 * 30), "/"); // 86400 = 1 day
    // Redirect to index.php
    header("Location: index.php");
    exit;
}
?>


    <div class="container mt-5">
        <h2>Enter the PropertyID to Highlight</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="highlight1">Highlight 1:</label>
                <input type="number" class="form-control" id="highlight1" name="highlighted_properties[]" required>
            </div>
            <div class="form-group">
                <label for="highlight2">Highlight 2:</label>
                <input type="number" class="form-control" id="highlight2" name="highlighted_properties[]" required>
            </div>
            <div class="form-group">
                <label for="highlight3">Highlight 3:</label>
                <input type="number" class="form-control" id="highlight3" name="highlighted_properties[]" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</body>

</html>
