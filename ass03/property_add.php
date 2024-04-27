<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Add</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
require_once('myProPerty_session.php');
require_once('myProPerty_header.php');
require_once('adverts.php');
function validate($value)
{
    return htmlspecialchars($value);
}

function stickyValue($value)
{
    echo (isset($_POST[strval($value)]) ? $_POST[strval($value)] : "");
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] && isset($_POST['inventoryForm'])) {
    $bedAmount = validate($_POST['bedAmount']);
    $price = validate($_POST['price']);
    $area = validate($_POST['area']);
    $lengthOfTenancy = validate($_POST['lengthOfTenancy']);
    $contractStart = validate($_POST['contractStart']);
    $contractEnd = validate($_POST['contractEnd']);
    $customerID = validate($_POST['customerID']);
    $desc = validate($_POST['desc']);
    $title = validate($_POST['title']);

    // Image upload
    $targetDir = "../images/"; // Path to the images folder
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    // File uploaded successfully, insert property data into database
                    $imagePath = $targetFile;

                    // Insert property data into database
                    $stmt = $conn->prepare("INSERT INTO property (bedAmount, price, area, lengthOfTenancy, contractStart, contractEnd, customerID, `desc`, title, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("isssssisss", $bedAmount, $price, $area, $lengthOfTenancy, $contractStart, $contractEnd, $customerID, $desc, $title, $imagePath);
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success' role='alert'>
                                Property added to inventory
                            </div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>
                                Unable to add property to inventory
                            </div>";
                    }
                    $stmt->close();
                } else {
                    $errors[] = "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            $errors[] = "File is not an image.";
        }
    }
}

foreach ($errors as $error) {
    echo "<div class='alert alert-warning' role='alert'>
        <li>$error</li>
    </div>";
}
?>
<h1 class="text-center text-primary">Add Property</h1>
<div class="container container-sm">
    <div class="row justify-content-center">
        <form class="container col-sm-5 col-lg-4 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" novalidate>

            <div class="card p-3">
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
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control">
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
