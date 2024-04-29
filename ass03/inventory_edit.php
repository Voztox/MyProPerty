<?php
require_once('myProPerty_session.php');
require_once('myProPerty_header_user.php');
require_once('adverts.php');

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['searchForm'])) {
    $propertyID = validate($_POST['propertyID']);

    // Perform database query to retrieve inventory details based on property ID
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM inventory WHERE inventoryID = ?");
    $stmt->bind_param("i", $propertyID);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Inventory found, display edit form
            $inventory = $result->fetch_assoc();
        } else {
            $errors[] = "Inventory not found for property ID: $propertyID";
        }
    } else {
        $errors[] = "Error executing the query: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateForm'])) {
    // Perform form validation and update inventory in the database
    $propertyID = validate($_POST['propertyID']);
    $electricity = isset($_POST['electricity']) ? 1 : 0;
    $internet = isset($_POST['internet']) ? 1 : 0;
    $oven = isset($_POST['oven']) ? 1 : 0;
    $tv = isset($_POST['tv']) ? 1 : 0;
    $heater = isset($_POST['heater']) ? 1 : 0;
    $bills = isset($_POST['bills']) ? 1 : 0;
    $washingMachine = isset($_POST['washingMachine']) ? 1 : 0;
    $dryingMachine = isset($_POST['dryingMachine']) ? 1 : 0;

    // Update inventory in the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE inventory SET electricity=?, internet=?, oven=?, tv=?, heater=?, bills=?, washingMachine=?, dryingMachine=? WHERE propertyID=?");
    $stmt->bind_param("iiiiiiiii", $electricity, $internet, $oven, $tv, $heater, $bills, $washingMachine, $dryingMachine, $propertyID);

    if ($stmt->execute()) {
        $success = "Inventory updated successfully.";
    } else {
        $errors[] = "Error updating inventory: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

function validate($value)
{
    return htmlspecialchars(trim($value));
}
?>

<h1 class="text-center text-primary">Edit Inventory</h1>
<div class="container container-sm">
    <div class="row justify-content-center">
        <form class="container col-sm-5 col-lg-4 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
            <?php
            foreach ($errors as $error) {
                echo "<div class='alert alert-warning' role='alert'>$error</div>";
            }

            if (!empty($inventory)) {
                ?>
                <div class="card p-3">
                    <input type="hidden" name="propertyID" value="<?php echo $inventory['propertyID']; ?>">
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="electricity" class="form-check-input" <?php echo $inventory['electricity'] ? 'checked' : ''; ?>>
                        <label class="form-check-label">Electricity</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="internet" class="form-check-input" <?php echo $inventory['internet'] ? 'checked' : ''; ?>>
                        <label class="form-check-label">Internet</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="oven" class="form-check-input" <?php echo $inventory['oven'] ? 'checked' : ''; ?>>
                        <label class="form-check-label">Oven</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="TV" class="form-check-input" <?php echo $inventory['TV'] ? 'checked' : ''; ?>>
                        <label class="form-check-label">TV</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="heater" class="form-check-input" <?php echo $inventory['heater'] ? 'checked' : ''; ?>>
                        <label class="form-check-label">Heater</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="bills" class="form-check-input" <?php echo $inventory['bills'] ? 'checked' : ''; ?>>
                        <label class="form-check-label">Bills</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="washingMachine" class="form-check-input" <?php echo $inventory['washingMachine'] ? 'checked' : ''; ?>>
                        <label class="form-check-label">Washing Machine</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="dryingMachine" class="form-check-input" <?php echo $inventory['dryingMachine'] ? 'checked' : ''; ?>>
                        <label class="form-check-label">Drying Machine</label>
                    </div>
                    <button type="submit" name="updateForm" class="btn btn-primary mb-3">Update Inventory</button>
                </div>
            <?php } else { ?>
                <div class="card p-3">
                    <div class="mb-3">
                        <label for="propertyID" class="form-label">Enter Property ID to Edit Inventory</label>
                        <input type="number" name="propertyID" class="form-control" required>
                    </div>
                    <button type="submit" name="searchForm" class="btn btn-primary mb-3">Search Inventory</button>
                </div>
            <?php } ?>
        </form>
    </div>
</div>
<?php
if (!empty($success)) {
    echo "<div class='alert alert-success' role='alert'>$success</div>";
}
?>
<?php require_once('footer.php'); ?>