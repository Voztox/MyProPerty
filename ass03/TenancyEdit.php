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
    $propertyID = $customerID  = $tenancyAgreement  = $amountPaid = $amountOwed = "";
    $errors = [];

    //click search
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
        $tenancyID = validate($_POST['tenancyID']);
        $propertyID = validate($_POST['propertyID']);

        // getting information
        $stmt = $conn->prepare("SELECT * FROM tenancy WHERE propertyID=? AND tenancyID=?");
        $stmt->bind_param("ii", $propertyID, $tenancyID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $info = $result->fetch_assoc();
            // passing information
            $tenancyAgreement = $info['tenancyAgreement'];
            $amountPaid = $info['amountPaid'];
            $amountOwed = $info['amountOwed'];
        } else {
            echo "<div class='alert alert-warning' role='alert'>
           No property found
          </div>";
        }
        $stmt->close();
    }
    // click update 
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['tenancyEdit'])) {
        // echo $propertyID;
        // getting inputs and validating
        $tenancyID = validate($_POST['tenancyID']);
        $propertyID = validate($_POST['propertyID']);
        // $customerID = validate($_POST['customerID']);
        $tenancyAgreement = validate($_POST['tenancyAgreement']);
        $amountPaid = validate($_POST['amountPaid']);
        $amountOwed = validate($_POST['amountOwed']);

        //validations 
        if (empty($tenancyID) || !isset($tenancyID)) {
            $errors[] = "Please fill the tenancy id field";
        } else if (!(preg_match('/^\d+$/', $propertyID))) {
            $errors[] = "Tenancy id should be number";
        }
        if (empty($propertyID) || !isset($propertyID)) {
            $errors[] = "Please fill the property id field";
        } else if (!(preg_match('/^\d+$/', $propertyID))) {
            $errors[] = "Property id should be number";
        }
        // if (empty($customerID) || !isset($customerID)) {
        //     $errors[] = "Please fill the customer ID field";
        // } else if (!(preg_match('/^\d+$/', $customerID))) {
        //     $errors[] = "Customer id should be a number";
        // }
        if (empty($tenancyAgreement) || !isset($tenancyAgreement)) {
            $errors[] = "Please fill the Tenancy Agreement field";
        }

        if (empty($amountPaid) || !isset($amountPaid)) {
            $errors[] = "Please fill the Amount Paid field";
        }

        if (empty($amountOwed) || !isset($amountOwed)) {
            $errors[] = "Please fill the Amount Owed field";
        }

        if (empty($errors)) {
            $stmt = $conn->prepare("UPDATE tenancy SET tenancyAgreement=?, amountPaid=?, amountOwed=? WHERE tenancyID=?");
            $stmt->bind_param("sssi", $tenancyAgreement, $amountPaid, $amountOwed, $tenancyID);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success' role='alert'>
                Tenancy Updated.
               </div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>
               Unable to update.
               </div>";
            }
        }
    }?>
    <?php
    //setting variables
    $price  = $lengthOfTenancy = $contractStart = $contractEnd  = "";
    $errors = [];

    //click search
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
        $propertyID = validate($_POST['propertyID']);
        // $customerID = validate($_POST['customerID']);

        // getting information
        $stmt = $conn->prepare("SELECT * FROM property WHERE propertyID=?");
        $stmt->bind_param("i", $propertyID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $info = $result->fetch_assoc();
            // passing information
            $price = $info['price'];
            $lengthOfTenancy = $info['lengthOfTenancy'];
            $contractStart = $info['contractStart'];
            $contractEnd = $info['contractEnd'];
        } else {
            echo "<div class='alert alert-warning' role='alert'>
           No property found
          </div>";
        }
        $stmt->close();
    }
    // click update 
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['tenancyEdit'])) {
        // echo $propertyID;
        // getting inputs and validating
        $price = validate($_POST['price']);
        $lengthOfTenancy = validate($_POST['lengthOfTenancy']);
        $contractStart = validate($_POST['contractStart']);
        $contractEnd = validate($_POST['contractEnd']);

        //validations 
        if (empty($price) || !isset($price)) {
            $errors[] = "Please fill the price field";
        } else if (!(preg_match('/^\$?\d+(\.\d{1,2})?$/', $price))) {
            $errors[] = "price should be a number";
        }

        if (empty($lengthOfTenancy) || !isset($lengthOfTenancy)) {
            $errors[] = "Please fill the length Of Tenancy field";
        }

        if (empty($contractStart) || !isset($contractStart)) {
            $errors[] = "Please fill the contract Start date field";
        }

        if (empty($contractEnd) || !isset($contractEnd)) {
            $errors[] = "Please fill the contract End date field";
        }

        if (empty($errors)) {
            $stmt = $conn->prepare("UPDATE property SET price=?, lengthOfTenancy=?, contractStart=?, contractEnd=? WHERE propertyID=?");
            $stmt->bind_param("ssssi", $price, $lengthOfTenancy, $contractStart, $contractEnd, $propertyID);
            if ($stmt->execute()) {
            } else {
                echo "<div class='alert alert-danger' role='alert'>
               Unable to update.
               </div>";
            }
        }
    }
    ?>
    <!-- Tenancy Form -->
    <h1 class="text-center text-primary">Update Tenancy Details</h1>
    <div class="container container-sm">
        <div class="row justify-content-center">

            <!-- form to search
            <form class="col-lg-2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" novalidate>
                
            </form> -->

            <!-- form to edit  -->

            <form class="container  col-sm-5 col-lg-4 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                <div class="card p-3">
                    <div class="mb-3">
                        <label for="tenancyID" class="form-label">Tenancy ID</label>
                        <input type="text" name="tenancyID" class="form-control col-2 bg-light" value="<?php stickyValue('tenancyID') ?>"><br>

                        <label for="propertyID" class="form-label">Property ID </label>
                        <input type="text" name="propertyID" class="form-control col-2 bg-light" value="<?php stickyValue('propertyID') ?>">
                    </div>
                    <button class="btn btn-primary mb-5" type="submit" name="search">Search Tenancy</button>
                    <p class="text-center text-danger">You can Update the information</p>
                    <div class="mb-3">

                        <label for="tenancyAgreement" class="form-label">Tenancy Agreement</label>
                        <input type="tel" name="tenancyAgreement" class="form-control" value="<?php echo $tenancyAgreement; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="amountPaid" class="form-label">Amount Paid</label>
                        <input type="text" name="amountPaid" class="form-control" value="<?php echo $amountPaid; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="amountOwed" class="form-label">Amount Owed</label>
                        <input type="text" name="amountOwed" class="form-control" value="<?php echo $amountOwed; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" value="<?php echo $price; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="lengthOfTenancy" class="form-label">Length Tenancy</label>
                        <input type="tel" name="lengthOfTenancy" class="form-control" value="<?php echo $lengthOfTenancy; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="contractStart" class="form-label">Contract Start Date</label>
                        <input type="date" name="contractStart" class="form-control" value="<?php echo $contractStart; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="contractEnd" class="form-label">Contract End Date</label>
                        <input type="date" name="contractEnd" class="form-control" value="<?php echo $contractEnd; ?>">
                    </div>


                    <button type="submit" name="tenancyEdit" class="btn btn-primary mb-3">Update Tenancy</button>
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



