<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel = "stylesheet" href = "styles.css">
</head>

<body>
    <?php
require_once('myProPerty_session.php');
require_once('myProPerty_header_user.php');
require_once('adverts.php');
    ?>
    <div class="container">
        <h1 class="my-4">Add Inventory</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="mb-3">
                <label for="propertyID" class="form-label">Property ID</label>
                <input type="text" name="propertyID" class="form-control" id="propertyID" required>
            </div>
            <div class="mb-3">
                <label class="form-check-label">Inventory Items:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="electricity" id="electricity">
                    <label class="form-check-label" for="electricity">Electricity</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="internet" id="internet">
                    <label class="form-check-label" for="internet">Internet</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="oven" id="oven">
                    <label class="form-check-label" for="oven">Oven</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="TV" id="TV">
                    <label class="form-check-label" for="TV">TV</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="heater" id="heater">
                    <label class="form-check-label" for="heater">Heater</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="bills" id="bills">
                    <label class="form-check-label" for="bills">Bills</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="washingMachine" id="washingMachine">
                    <label class="form-check-label" for="washingMachine">Washing Machine</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="dryingMachine" id="dryingMachine">
                    <label class="form-check-label" for="dryingMachine">Drying Machine</label>
                </div>
                <!-- Add more checkboxes for other inventory items -->
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add Inventory</button>
        </form>
    </div>

    <?php
    

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Get input data
        $propertyID = $_POST['propertyID'];
        $electricity = isset($_POST['electricity']) ? 1 : 0;
        $internet = isset($_POST['internet']) ? 1 : 0;
        $oven = isset($_POST['oven']) ? 1 : 0;
        $TV = isset($_POST['TV']) ? 1 : 0;
        $heater = isset($_POST['heater']) ? 1 : 0;
        $bills = isset($_POST['bills']) ? 1 : 0;
        $washingMachine = isset($_POST['washingMachine']) ? 1 : 0;
        $dryingMachine = isset($_POST['dryingMachine']) ? 1 : 0;
        // Add more variables for other inventory items

        // Prepare and execute the SQL query
        $stmt = $conn->prepare("INSERT INTO inventory (propertyID, electricity, internet, oven, TV, heater, bills, washingMachine, dryingMachine) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiiiiiii", $propertyID, $electricity, $internet, $oven, $TV, $heater, $bills, $washingMachine, $dryingMachine);
        if ($stmt->execute()) {
            echo '<div class="container mt-3"><div class="alert alert-success" role="alert">Inventory added successfully.</div></div>';
        } else {
            echo '<div class="container mt-3"><div class="alert alert-danger" role="alert">Error adding inventory.</div></div>';
        }
        $stmt->close();
    }
    require_once('footer.php');
    ?>
</body>

</html>
