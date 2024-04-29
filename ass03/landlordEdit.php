<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
</head>

<body>
<?php
    require_once('myProPerty_session.php');
    require_once('myProPerty_header_user.php');
    require_once('adverts.php');
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
    $propertyID = $rentalIncome  = $commissionFee  = $managementFee = "";
    $errors = [];

    //click search
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
        $landlordID = validate($_POST['landlordID']);
        $propertyID = validate($_POST['propertyID']);

        // getting information
        $stmt = $conn->prepare("SELECT * FROM landlord WHERE propertyID=? AND landlordID=?");
        $stmt->bind_param("ii", $propertyID, $landlordID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $info = $result->fetch_assoc();
            // passing information
            $rentalIncome = $info['rentalIncome'];
            $commissionFee = $info['commissionFee'];
            $managementFee = $info['managementFee'];
        } else {
            echo "<div class='alert alert-warning' role='alert'>
           No landlords account found
          </div>";
        }
        $stmt->close();
    }
    // click update 
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['landlordEdit'])) {
        // getting inputs and validating
        $landlordID = validate($_POST['landlordID']);
        $propertyID = validate($_POST['propertyID']);
        $rentalIncome = validate($_POST['rentalIncome']);
        $commissionFee = validate($_POST['commissionFee']);
        $managementFee = validate($_POST['managementFee']);


        //validations 
        if (empty($landlordID) || !isset($landlordID)) {
            $errors[] = "Please fill the landlord ID field";
        } else if (!(preg_match('/^\d+$/', $landlordID))) {
            $errors[] = "Landlord id should be a number";
        }
        if (empty($propertyID) || !isset($propertyID)) {
            $errors[] = "Please fill the property id field";
        } else if (!(preg_match('/^\d+$/', $propertyID))) {
            $errors[] = "Property id should be number";
        }
        if (empty($rentalIncome) || !isset($rentalIncome)) {
            $errors[] = "Please fill the rentalIncome field";
        } else if (!(preg_match('/^\$?\d+(\.\d{1,2})?$/', $rentalIncome))) {
            $errors[] = "Rental Income should be a number";
        }
        if (empty($commissionFee) || !isset($commissionFee)) {
            $errors[] = "Please fill the commissionFee field";
        } else if (!(preg_match('/^\$?\d+(\.\d{1,2})?$/', $commissionFee))) {
            $errors[] = "Commission Fee should be a number";
        }
        if (empty($managementFee) || !isset($managementFee)) {
            $errors[] = "Please fill the managementFee field";
        } else if (!(preg_match('/^\$?\d+(\.\d{1,2})?$/', $managementFee))) {
            $errors[] = "Management Fee should be a number";
        }

        if (empty($errors)) {
            $stmt = $conn->prepare("UPDATE landlord SET rentalIncome=?, commissionFee=?, managementFee=? WHERE landlordID=?");
            $stmt->bind_param("sssi", $rentalIncome, $commissionFee, $managementFee, $landlordID);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success' role='alert'>
                Landlords account Updated.
               </div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>
               Unable to update.
               </div>";
            }
        }
    }
    ?>
    <!-- Property Form -->
    <h1 class="text-center text-primary">Update Landlords Details</h1>
    <div class="container container-sm">
        <div class="row justify-content-center">

            <!-- form to search
            <form class="col-lg-2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" novalidate>
                
            </form> -->

            <!-- form to edit  -->

            <form class="container  col-sm-5 col-lg-4 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                <div class="card p-3">
                    <div class="mb-3">
                        <label for="landlordID" class="form-label">LandlordID</label>
                        <input type="text" name="landlordID" class="form-control col-2 bg-light" value="<?php stickyValue('landlordID') ?>"><br>

                        <label for="propertyID" class="form-label">Property ID </label>
                        <input type="text" name="propertyID" class="form-control col-2 bg-light" value="<?php stickyValue('propertyID') ?>">
                    </div>
                    <button class="btn btn-primary mb-5" type="submit" name="search">Search Landlords account</button>
                    <p class="text-center text-danger">You can Update the information</p>
                    <div class="mb-3">
                        <label for="rentalIncome" class="form-label">Rental Income</label>
                        <input type="number" name="rentalIncome" class="form-control" value="<?php echo $rentalIncome; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="commissionFee" class="form-label">Commission Fee</label>
                        <input type="number" name="commissionFee" class="form-control" value="<?php echo $commissionFee; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="managementFee" class="form-label">Management Fee</label>
                        <input type="number" name="managementFee" class="form-control" value="<?php echo $managementFee; ?>">
                    </div>
                    
                    <button type="submit" name="landlordEdit" class="btn btn-primary mb-3">Update Landlords Account</button>
                    <a href="index.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.jss"></script>
    <?php require_once('footer.php'); ?>
</body>

</html>