<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        <h1 class="text-center">Landlord Account</h1>
        <div class="list-group">
            <a class="list-group-item list-group-item-action">Search Landlord</a>
        </div>
        <!-- Property Form -->
        <div class="container container-sm">
            <div class="row justify-content-center">
                <form class="container  col-sm-5 col-lg-4 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                    <div class="mb-3">
                        <label for="landlordID" class="form-label">Landlord ID</label>
                        <input type="tel" name="landlordID" id="landlordID" class="form-control" value="<?php stickyValue('') ?>" placeholder="Landlord ID ">
                    </div>
                    <button type="submit" name="landlordForm" class="btn btn-primary">Landlord Account</button>
                    <a href="landlordEdit.php" class="btn btn-primary">Update</a>
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
        $landlordID = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['landlordForm'])) {
            // getting inputs and validating
            $landlordID = validate($_POST['landlordID']);
            //validations 
            if (empty($landlordID) || !isset($landlordID)) {
                $errors[] = "Please fill the landlord id field";
            }
            if (empty($errors)) {
                //checking if same data exist
                $stmt = $conn->prepare("SELECT * FROM landlord WHERE landlordID=?");
                $stmt->bind_param("i", $landlordID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    echo "<section class='container col-lg-6 card p-3 mb-3'>";
                    echo " <table id='example' class='table table-striped ' style='width:100%'>
                <tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><th scope='col' >Landlord ID</th><td scope='row'>" . $row['landlordID'] . "</td></tr>";
                        echo "<tr><th scope='col' >Property ID</th><td scope='row'>" . $row['propertyID'] . "</td></tr>";
                        echo "<tr><th scope='col' >Rental Income</th><td scope='row'>" . $row['rentalIncome'] . "</td></tr>";
                        echo "<tr><th scope='col' >Commission Fee</th><td scope='row'>" . $row['commissionFee'] . "</td></tr>";
                        echo "<tr><th scope='col' >Management Fee</th><td scope='row'>" . $row['managementFee'] . "</td></tr>";
                    }
                    echo " </tbody></table></section>";
                } else {
                    echo "<div class='alert alert-warning' role='alert'>
           No landlords account found
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
        <?php require_once('footer.php'); ?>
</body>

</html>