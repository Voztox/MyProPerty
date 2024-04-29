<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel = "stylesheet" href = "styles.css">
</head>

<body>

    <?php

    // Include necessary files
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
    $bedAmount = $price  = $area  = $lengthOfTenancy = $contractStart = $contractEnd = $customerID = $description = $title = "";
    $errors = [];

    //click search
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
        $propertyID = validate($_POST['propertyID']);

        // getting information
        $stmt = $conn->prepare("SELECT * FROM property WHERE propertyID=?");
        $stmt->bind_param("s", $propertyID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $info = $result->fetch_assoc();
            // passing information
            $bedAmount = $info['bedAmount'];
            $price = $info['price'];
            $area = $info['area'];
            $lengthOfTenancy = $info['lengthOfTenancy'];
            $contractStart = $info['contractStart'];
            $contractEnd = $info['contractEnd'];
            $description = $info['description'];
            $title = $info['title'];
        } else {
            echo "<div class='alert alert-warning' role='alert'>
           No property found
          </div>";
        }
        $stmt->close();
    }

    // click update 
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['property_edit'])) {
        // getting inputs and validating
        $propertyID = validate($_POST['propertyID']);
        $bedAmount = validate($_POST['bedAmount']);
        $price = validate($_POST['price']);
        $area = validate($_POST['area']);
        $lengthOfTenancy = validate($_POST['lengthOfTenancy']);
        $contractStart = validate($_POST['contractStart']);
        $contractEnd = validate($_POST['contractEnd']);
        $description = validate($_POST['description']);
        $title = validate($_POST['title']);

        // File upload handling
        if (!empty($_FILES["image"]["tmp_name"])) {
            $targetDir = "../images/";
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $errors[] = "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($targetFilePath)) {
                $errors[] = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["image"]["size"] > 5000000) {
                $errors[] = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
                $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $errors[] = "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    $stmt = $conn->prepare("UPDATE property SET bedAmount=?, price=?, area=?, lengthOfTenancy=?, contractStart=?, contractEnd=?, description=?, title=?, image_path=?  WHERE propertyID=?");
                    $stmt->bind_param("sssssssssi", $bedAmount, $price, $area, $lengthOfTenancy, $contractStart, $contractEnd, $description, $title, $targetFilePath, $propertyID);
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success' role='alert'>
                        Property Updated.
                       </div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>
                       Unable to update.
                       </div>";
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>
                   Sorry, there was an error uploading your file.
                   </div>";
                }
            }
        } else {
            // No file uploaded
            $stmt = $conn->prepare("UPDATE property SET bedAmount=?, price=?, area=?, lengthOfTenancy=?, contractStart=?, contractEnd=?, `description`=?, title=? WHERE propertyID=?");
            $stmt->bind_param("ssssssssi", $bedAmount, $price, $area, $lengthOfTenancy, $contractStart, $contractEnd, $description, $title, $propertyID);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success' role='alert'>
                Property Updated.
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
    <h1 class="text-center text-primary">Update Property Details</h1>
    <div class="container container-sm">
        <div class="row justify-content-center">

            <!-- form to search
            <form class="col-lg-2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" novalidate>
                
            </form> -->

            <!-- form to edit  -->

            <form class="container  col-sm-5 col-lg-4 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" novalidate>
                <div class="card p-3">
                    <div class="mb-3">
                        <label for="propertyID" class="form-label">Property ID </label>
                        <input type="text" name="propertyID" class="form-control col-2 bg-light" value="<?php stickyValue('propertyID') ?>">
                    </div>
                    <button class="btn btn-primary mb-5" type="submit" name="search">Search Property</button>
                    <p class="text-center text-danger">You can Update the information</p>
                    <div class="mb-3">
                        <label for="bedAmount" class="form-label">Bed Amount</label>
                        <input type="tel" name="bedAmount" class="form-control" value="<?php echo $bedAmount; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" value="<?php echo $price; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="area" class="form-label">Area</label>
                        <input type="text" name="area" class="form-control" value="<?php echo $area; ?>">
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
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button type="submit" name="property_edit" class="btn btn-primary mb-3">Update Property</button>
                    <a href="index.php" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php require_once('footer.php'); ?>
</body>

</html>
