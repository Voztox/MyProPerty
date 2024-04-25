<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <?php
            require("../../mysql_connect.php");

            // Function to sanitize user input
            function validate($value)
            {
                return htmlspecialchars($value);
            }

            // Function to echo sticky form value
            function stickyValue($value)
            {
                echo (isset($_POST[$value]) ? $_POST[$value] : "");
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
                // Get and validate property ID
                $propertyID = validate($_POST['propertyID']);

                if (empty($propertyID) || !isset($propertyID)) {
                    $errors[] = "Please fill the property id field";
                }

                if (empty($errors)) {
                    // Prepare and execute SQL query
                    $stmt = $conn->prepare("SELECT * FROM property WHERE propertyID=?");
                    $stmt->bind_param("i", $propertyID);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Display property information
                        echo "<section class='container col-lg-6 card p-3 mb-3'>";
                        echo "<table id='example' class='table table-striped' style='width:100%'>
                <tbody>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><th scope='col'>PropertyId</th><td scope='row'>" . $row['propertyID'] . "</td></tr>";
                            echo "<tr><th scope='col'>Bed Amount</th><td scope='row'>" . $row['bedAmount'] . "</td></tr>";
                            echo "<tr><th scope='col'>Price</th><td scope='row'>" . $row['price'] . "</td></tr>";
                            echo "<tr><th scope='col'>Area</th><td scope='row'>" . $row['area'] . "</td></tr>";
                            echo "<tr><th scope='col'>Length Tenancy</th><td scope='row'>" . $row['lengthOfTenancy'] . "</td></tr>";
                            echo "<tr><th scope='col'>Contract Start</th><td scope='row'>" . $row['contractStart'] . "</td></tr>";
                            echo "<tr><th scope='col'>Contarct End</th><td scope='row'>" . $row['contractEnd'] . "</td></tr>";
                            echo "<tr><th scope='col'>CustomerId</th><td scope='row'>" . $row['customerID'] . "</td></tr>";
                            echo "<tr><th scope='col'>Desc</th><td scope='row'>" . $row['desc'] . "</td></tr>";
                            echo "<tr><th scope='col'>Title</th><td scope='row'>" . $row['title'] . "</td></tr>";
                        }
                        echo "</tbody></table>";
                    } else {
                        echo "<div class='alert alert-warning' role='alert'>
                        No property found
                      </div>";
                    }
                    $stmt->close();
                } else {
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-warning' role='alert'>
                        <li>$error</li>
                      </div>";
                    }
                }
            }
            ?>
            <div class="container dashboard-container">
                <h1 class="text-center">Property Inventory</h1>
                <div class="list-group">
                    <a class="list-group-item list-group-item-action">Search by PropertyID</a>
                </div>
                <!-- PropertyID Form -->
                <div class="container container-sm">
                    <div class="row justify-content-center">
                        <form class="container col-sm-8 col-lg-8 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                            <div class="mb-3">
                                <label for="propertyID" class="form-label">PropertyId</label>
                                <input type="tel" name="propertyID" id="propertyID" class="form-control" value="<?php stickyValue('propertyID') ?>" placeholder="Property ID">
                            </div>
                            <button type="submit" name="search" class="btn btn-primary">Search Property</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="container dashboard-container">
                <h1 class="text-center">Filter Properties</h1>
                <div class="list-group">
                    <a class="list-group-item list-group-item-action">Search by Filters</a>
                </div>
                <!-- Filtering Form -->
                <div class="container container-sm">
                    <div class="row justify-content-center">
                        <form class="container col-sm-8 col-lg-8 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price (€)</label>
                                <input type="number" name="price" id="price" class="form-control" placeholder="Price">
                            </div>
                            <div class="mb-3">
                                <label for="area" class="form-label">Area (m<sup>2</sup>)</label>
                                <input type="number" name="area" id="area" class="form-control" placeholder="Area">
                            </div>
                            <div class="mb-3">
                                <label for="contractStart" class="form-label">Contract Start Date</label>
                                <input type="date" name="contractStart" id="contractStart" class="form-control">
                            </div>
                            <button type="submit" name="search" class="btn btn-primary">Apply Filters</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery UI library for draggable functionality -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="script.js"></script>
</body>
</html>
