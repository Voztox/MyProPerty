<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisement</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link to your external CSS file -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Advertisement -->
<div class="advertisement">
    <?php
    // Array of available ad images with their corresponding URLs
    $adLinks = [
        'ad1' => 'https://aib.ie/',
        'ad2' => 'https://www.bankofireland.com/',
        'ad3' => 'https://www.griffith.ie/'
    ];

    // Randomly select one image
    $adImages = array_keys($adLinks);
    $randomIndex = array_rand($adImages);
    $selectedImage = $adImages[$randomIndex];

    // Path to the ads folder
    $adsFolder = '../ads/';

    // Check if the selected image exists
    if (isset($adLinks[$selectedImage]) && file_exists($adsFolder . $selectedImage . '.png')) {
        // Output the image wrapped in an anchor tag with the corresponding URL
        echo "<a href='{$adLinks[$selectedImage]}' target='_blank'>";
        echo "<img src='{$adsFolder}{$selectedImage}.png' alt='Advertisement' width='200' height='300'>";
        echo "</a>";
    } else {
        echo 'No ad available.';
    }
    ?>
</div>

<?php
// Define database connection constants
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

// Include necessary files
require_once('myProPerty_session.php');
?>

<!-- Link to external JavaScript file -->
<script src="script.js"></script>

<!-- Link to Bootstrap JS (required for dropdowns, toggles, etc.) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
