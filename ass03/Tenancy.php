<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tenancy Account</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <link rel = "stylesheet" href = "styles.css">
</head>

<body>
    <?php
require_once('myProPerty_session.php');
require_once('myProPerty_header.php');
require_once('adverts.php');
    ?>
    <div class="container dashboard-container">
        <h1 class="text-center">Tenancy Account</h1>
        <div class="list-group">
            <a class="list-group-item list-group-item-action">Search Tenancy</a>
        </div>
        <!-- Property Form -->
        <div class="container container-sm">
            <div class="row justify-content-center">
                <form class="container  col-sm-5 col-lg-4 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                    <div class="mb-3">
                        <label for="tenancyID" class="form-label">TenancyID</label>
                        <input type="tel" name="tenancyID" id="tenancyID" class="form-control" value="<?php stickyValue('') ?>" placeholder="Tenancy ID">
                    </div>
                    <div class="mb-3">
                        <label for="propertyID" class="form-label">Property ID</label>
                        <input type="tel" name="propertyID" id="propertyID" class="form-control" value="<?php stickyValue('') ?>" placeholder="Property ID">
                    </div>
                    <button type="submit" name="tenancyForm" class="btn btn-primary">Tenancy Account</button>
                    <a href="TenancyEdit.php" class="btn btn-primary">Update</a>
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
        $tenancyID = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tenancyForm'])) {
            // getting inputs and validating
            $tenancyID = validate($_POST['tenancyID']);
            //validations 
            if (empty($tenancyID) || !isset($tenancyID)) {
                $errors[] = "Please fill the tenancy id field";
            }
            if (empty($errors)) {
                //checking if same data exist
                $stmt = $conn->prepare("SELECT * FROM tenancy WHERE tenancyID=?");
                $stmt->bind_param("i", $tenancyID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    echo "<section class='container col-lg-6 card p-3 mb-3'>";
                    echo " <table id='example' class='table table-striped ' style='width:100%'>
                <tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><th scope='col' >Tenancy ID</th><td scope='row'>" . $row['tenancyID'] . "</td></tr>";
                        echo "<tr><th scope='col' >Property ID</th><td scope='row'>" . $row['propertyID'] . "</td></tr>";
                        echo "<tr><th scope='col' >Customer ID</th><td scope='row'>" . $row['customerID'] . "</td></tr>";
                        echo "<tr><th scope='col' >Tenancy Agreement</th><td scope='row'>" . $row['tenancyAgreement'] . "</td></tr>";
                        echo "<tr><th scope='col' >Amount Paid</th><td scope='row'>" . $row['amountPaid'] . "</td></tr>";
                        echo "<tr><th scope='col' >Amount Owed</th><td scope='row'>" . $row['amountOwed'] . "</td></tr>";
                    }
                    echo " </tbody></table></section>";
                } else {
                    echo "<div class='alert alert-warning' role='alert'>
           No tenancy found
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
        <?php
        //setting variables
        $propertyID = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tenancyForm'])) {
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
                        echo "<tr><th scope='col' >Price</th><td scope='row'>" . $row['price'] . "</td></tr>";
                        echo "<tr><th scope='col' >Length Tenancy</th><td scope='row'>" . $row['lengthOfTenancy'] . "</td></tr>";
                        echo "<tr><th scope='col' >Contract Start</th><td scope='row'>" . $row['contractStart'] . "</td></tr>";
                        echo "<tr><th scope='col' >Contarct End</th><td scope='row'>" . $row['contractEnd'] . "</td></tr>";
                    }
                    echo " </tbody></table></section>";
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
        <script src="script.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.jss"></script>
        <?php require_once('footer.php'); ?>
</body>

</html>