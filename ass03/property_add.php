<?php
require_once('myProPerty_session.php');
require_once('myProPerty_header_user.php');
require_once('adverts.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inventoryForm'])) {
    // Validate form inputs
    $customerID = validate($_POST['customerID']);
    $bedAmount = validate($_POST['bedAmount']);
    $price = validate($_POST['price']);
    $area = validate($_POST['area']);
    $lengthOfTenancy = validate($_POST['lengthOfTenancy']);
    $contractStart = validate($_POST['contractStart']);
    $contractEnd = validate($_POST['contractEnd']);
    $description = validate($_POST['description']);
    $title = validate($_POST['title']);

    // Perform additional validation as needed...

    // Image upload
    $targetDir = "../images/"; // Path to the images folder
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $errors[] = "File is not an image.";
    } else {
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // File uploaded successfully, insert property data into database
                $imagePath = $targetFile;

                // Establish database connection
                $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
                // Check connection
                if ($conn->connect_error) {
                    die("Database connection failed: " . $conn->connect_error);
                }

                // Insert property data into database
                $stmt = $conn->prepare("INSERT INTO property (customerID, bedAmount, price, area, lengthOfTenancy, contractStart, contractEnd, `description`, title, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("isssssssss", $customerID, $bedAmount, $price, $area, $lengthOfTenancy, $contractStart, $contractEnd, $description, $title, $imagePath);

                if ($stmt->execute()) {
                    echo "<div class='alert alert-success' role='alert'>Property added to inventory</div>";
                } else {
                    $errors[] = "Error: " . $stmt->error;
                }
                $stmt->close();
                $conn->close();
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        }
    }
}

function validate($value)
{
    return htmlspecialchars(trim($value));
}
?>

<h1 class="text-center text-primary">Add Property</h1>
<div class="container container-sm">
    <div class="row justify-content-center">
        <form class="container col-sm-5 col-lg-4 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" novalidate>
            <?php
            foreach ($errors as $error) {
                echo "<div class='alert alert-warning' role='alert'>$error</div>";
            }
            ?>
            <div class="card p-3">
                <div class="mb-3">
                    <label for="customerID" class="form-label">Customer ID</label>
                    <input type="number" name="customerID" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="bedAmount" class="form-label">Bed Amount</label>
                    <input type="number" name="bedAmount" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="area" class="form-label">Area</label>
                    <input type="number" name="area" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="lengthOfTenancy" class="form-label">Length Tenancy</label>
                    <input type="number" name="lengthOfTenancy" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contractStart" class="form-label">Contract Start Date</label>
                    <input type="date" name="contractStart" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contractEnd" class="form-label">Contract End Date</label>
                    <input type="date" name="contractEnd" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <button type="submit" name="inventoryForm" class="btn btn-primary mb-3">Add Property</button>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
<?php require_once('footer.php'); ?>
