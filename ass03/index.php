<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyProPerty</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link to external CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    // Include the database connection script
    require("../../mysql_connect.php");

    // SQL query to fetch title, description, and image path for all properties
    $sql = "SELECT propertyID, title, `desc`, image_path FROM property ";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        echo '<div class="container">';
        echo '<div class="row">';
        while ($row = mysqli_fetch_assoc($result)) {
            $propertyID = $row["propertyID"];
            $title = $row["title"];
            $description = $row["desc"];
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

    mysqli_close($conn);
    ?>
    <!-- Link to external JavaScript file -->
    <script src="script.js"></script>
</body>

</html>
