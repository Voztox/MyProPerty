<?php
require("../../../connection.php");
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASSWORD', '');
define('DB_DATABASE', 's3108491');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Property Inventory</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
</head>

<body>
    <div class="container dashboard-container">
        <h1 class="text-center">Property Inventory</h1>
        <div class="list-group">
            <a class="list-group-item list-group-item-action">Search</a>
        </div>
        <!-- Property Form -->
        <div class="container container-sm">
            <div class="row justify-content-center">
                <form class="container  col-sm-5 col-lg-4 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                    <div class="mb-3">
                        <label for="propertyID" class="form-label">PropertyId</label>
                        <input type="tel" name="propertyID" id="propertyID" class="form-control" value="<?php stickyValue('') ?>" placeholder="Property ID">
                    </div>
                    <button type="submit" name="inventoryForm" class="btn btn-primary">Search Property</button>
                    <a href="InventoryAdd.php" class="btn btn-primary">Add</a>
                    <a href="InventoryEdit.php" class="btn btn-primary">Update</a>
                    <a href="index.php" class="btn btn-secondary">Back</a>

                </form>
            </div>
        </div>
        <?php
        // require("./connection.php");
        function validate($value)
        {
            $value = htmlspecialchars($value);
            return $value;
        }

        function stickyValue($value)
        //sticky form value 
        {
            echo (isset($_POST[strval($value)]) ? $_POST[strval($value)] : "");
        }

        //setting variables
        $propertyID = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inventoryForm'])) {
            // getting inputs and validating
            $propertyID = validate($_POST['propertyID']);
            //validations 
            if (empty($propertyID) || !isset($propertyID)) {
                $errors[] = "Please fill the property id field";
            }
            if (empty($errors)) {
                //checking if same data exist
                $stmt = $conn->prepare("SELECT * FROM property WHERE propertyID=?");
                $stmt->bind_param("i", $propertyID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    echo "<section class='container col-lg-6 card p-3 mb-3'>";
                    echo " <table id='example' class='table table-striped ' style='width:100%'>
                <tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><th scope='col' >PropertyId</th><td scope='row'>" . $row['propertyID'] . "</td></tr>";
                        echo "<tr><th scope='col' >Bed Amount</th><td scope='row'>" . $row['bedAmount'] . "</td></tr>";
                        echo "<tr><th scope='col' >Price</th><td scope='row'>" . $row['price'] . "</td></tr>";
                        echo "<tr><th scope='col' >Area</th><td scope='row'>" . $row['area'] . "</td></tr>";
                        echo "<tr><th scope='col' >Length Tenancy</th><td scope='row'>" . $row['lengthOfTenancy'] . "</td></tr>";
                        echo "<tr><th scope='col' >Contract Start</th><td scope='row'>" . $row['contractStart'] . "</td></tr>";
                        echo "<tr><th scope='col' >Contarct End</th><td scope='row'>" . $row['contractEnd'] . "</td></tr>";
                        echo "<tr><th scope='col' >CustomerId</th><td scope='row'>" . $row['customerID'] . "</td></tr>";
                        echo "<tr><th scope='col' >Desc</th><td scope='row'>" . $row['desc'] . "</td></tr>";
                        echo "<tr><th scope='col' >Title</th><td scope='row'>" . $row['title'] . "</td></tr>";
                    }
                    echo " </tbody></table>";
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
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.jss"></script>
</body>

</html>