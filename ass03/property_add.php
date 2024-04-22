<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Property</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    require("../../mysql_connect.php");
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
    $bedAmount = $price  = $area  = $lengthOfTenancy = $contractStart = $contractEnd = $customerID = $desc = $title = "";
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] && isset($_POST['inventoryForm'])) {
        // getting inputs and validating
        // $propertyID = validate($_POST['propertyID']);
        $bedAmount = validate($_POST['bedAmount']);
        $price = validate($_POST['price']);
        $area = validate($_POST['area']);
        $lengthOfTenancy = validate($_POST['lengthOfTenancy']);
        $contractStart = validate($_POST['contractStart']);
        $contractEnd = validate($_POST['contractEnd']);
        $customerID = validate($_POST['customerID']);
        $desc = validate($_POST['desc']);
        $title = validate($_POST['title']);


        //validations 
        // if (empty($propertyID) || !isset($propertyID)) {
        //     $errors[] = "Please fill the property id field";
        // } else if (!(preg_match('/^\d+$/', $propertyID))) {
        //     $errors[] = "Property id should be number";
        // }

        if (empty($bedAmount) || !isset($bedAmount)) {
            $errors[] = "Please fill the bed amount field";
        } else if (!(preg_match('/^\d+$/', $bedAmount))) {
            $errors[] = "bed count should be number";
        }

        if (empty($price) || !isset($price)) {
            $errors[] = "Please fill the price field";
        } else if (!(preg_match('/^\$?\d+(\.\d{1,2})?$/', $price))) {
            $errors[] = "price should be a number";
        }

        if (empty($area) || !isset($area)) {
            $errors[] = "Please fill the area field";
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

        if (empty($customerID) || !isset($customerID)) {
            $errors[] = "Please fill the customer ID field";
        } else if (!(preg_match('/^\d+$/', $customerID))) {
            $errors[] = "Customer id should be a number";
        }
        if (empty($desc) || !isset($desc)) {
            $errors[] = "Please fill the desc(description) field";
        }
        if (empty($title) || !isset($title)) {
            $errors[] = "Please fill the title field";
        }
        //checking if same data exist
        $stmt = $conn->prepare("SELECT * FROM property WHERE price=? AND area=?");
        $stmt->bind_param("ss", $price, $area);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows <= 0) {
            //checking if same data exist
            // inserting to data 
            $add = $conn->prepare("INSERT INTO property (bedAmount, price, area, lengthOfTenancy, contractStart, contractEnd, customerID, `desc`, title) VALUES (?,?,?,?,?,?,?,?,?)");
            $add->bind_param("issssssss", $bedAmount, $price, $area, $lengthOfTenancy, $contractStart, $contractEnd, $customerID, $desc, $title);
            if ($add->execute()) {
                echo "<div class='alert alert-success' role='alert'>
                    Property added to inventory
                  </div>";
            } else {
                //error
                echo "<div class='alert alert-danger' role='alert'>
                    Unable to add to inventory
                  </div>";
            }
        } else {
            echo "<div class='alert alert-warning' role='alert'>
             Property already exist in Inventory
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
    ?>
    <!-- Property Form -->
    <h1 class="text-center text-primary">Property Inventory</h1>
    <div class="container container-sm">
        <div class="row justify-content-center">
            <form class="container  col-sm-5 col-lg-4 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>

                <div class="card p-3">
                    <!-- <div class="mb-3">
                    <label for="propertyID" class="form-label">Property ID</label>
                    <input type="tel" name="propertyID" class="form-control" value="">
                    <?php // stickyValue('propertyID') 
                    ?> 
                </div> -->
                    <div class="mb-3">
                        <label for="customerID" class="form-label">Customer ID</label>
                        <input type="tel" name="customerID" class="form-control" value="<?php stickyValue('customerID') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="bedAmount" class="form-label">Bed Amount</label>
                        <input type="tel" name="bedAmount" class="form-control" value="<?php stickyValue('bedAmount') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" value="<?php stickyValue('price') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="area" class="form-label">Area</label>
                        <input type="text" name="area" class="form-control" value="<?php stickyValue('area') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lengthOfTenancy" class="form-label">Length Tenancy</label>
                        <input type="text" name="lengthOfTenancy" class="form-control" value="<?php stickyValue('lengthOfTenancy') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="contractStart" class="form-label">Contract Start Date</label>
                        <input type="date" name="contractStart" class="form-control" value="<?php stickyValue('contractStart') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="contractEnd" class="form-label">Contract End Date</label>
                        <input type="date" name="contractEnd" class="form-control" value="<?php stickyValue('contractEnd') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description</label>
                        <input type="text" name="desc" class="form-control" value="<?php stickyValue('desc') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?php stickyValue('title') ?>">
                    </div>

                    <button type="submit" name="inventoryForm" class="btn btn-primary mb-3">Add Property</button>
                    <a href="index.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>