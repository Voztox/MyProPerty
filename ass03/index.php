<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyProPerty</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel = "stylesheet" href = "index_styles.css">
    
</head>

<body>
<?php

require_once('myProPerty_session.php');
require_once('myProPerty_header.php');
require_once('adverts.php');

// Retrieve highlighted properties from cookies
$highlightedProperties = isset($_COOKIE['highlighted_properties']) ? unserialize($_COOKIE['highlighted_properties']) : [];



if (!empty($highlightedProperties)) {
    // Construct a comma-separated string of property IDs for the SQL query
    $propertyIDs = implode(',', $highlightedProperties);

    // SQL query to fetch title, description, and image path for selected properties
    $sql = "SELECT propertyID, title, description, image_path FROM property WHERE propertyID IN ($propertyIDs)";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Output data of each row
        echo '<div class="container">';
        echo '<div class="row">';
        while ($row = $result->fetch_assoc()) {
            $propertyID = $row["propertyID"];
            $title = $row["title"];
            $description = $row["description"];
            $imagePath = $row["image_path"];

            // Display the feature box for each property
            echo '<div class="col-md-4">';
            echo '<div class="feature-box">';
            // Display the image
            if (!empty($imagePath)) {
                echo '<img src="' . $imagePath . '" alt="' . $title . '">';
            }
            echo '<h3>' . $title . '</h3>';
            // Set max height for the box
            echo '<div class="box-content">';
            echo '<p>' . $description . '</p>';
            echo '</div>';
            // Add button to expand the box (only if content exceeds max height)
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo "No properties found";
    }
} else {
    echo "No properties selected";
}

// Close connection
$conn->close();
?>

    <!-- Your existing HTML content -->

    <!-- Link to external JavaScript file -->
    <script src="script.js"></script>

    <!-- Link to Bootstrap JS (required for dropdowns, toggles, etc.) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php require_once('footer.php'); ?>
</body>

</html>
