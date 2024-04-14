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
    <header class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="../MyProPerty.png" alt="MyProPerty Logo" height="100" width = "100">
        </a>

        <!-- Navbar toggler (for responsive design) -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar items -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <!-- Links centered -->
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="search.php">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="testimonial.php">Testimonial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.php">Contact Us</a>
                </li>
            </ul>
        </div>
    </header>

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

    <!-- Link to Bootstrap JS (required for dropdowns, toggles, etc.) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
