<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
require("../../mysql_connect.php");

// Function to sanitize user input
function validate($value)
{
    return htmlspecialchars($value);
}

// Price Filtering
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['price'])) {
    // Get and validate filter values
    $price = validate($_GET['price']);

    // Prepare and execute SQL query with price filtering condition
    $sql = "SELECT * FROM property WHERE price <= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $price);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Store filtered property information
        $properties = [];
        while ($row = $result->fetch_assoc()) {
            $properties[] = $row;
        }
    } else {
        $noPropertyFound = true;
    }
    $stmt->close();
}

// Date Filtering
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['from_date']) && isset($_GET['to_date'])) {
    // Get and validate filter values
    $from_date = validate($_GET['from_date']);
    $to_date = validate($_GET['to_date']);

    // Prepare and execute SQL query with date filtering condition
    $sql = "SELECT * FROM property WHERE contractStart BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $from_date, $to_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Store filtered property information
        $properties = [];
        while ($row = $result->fetch_assoc()) {
            $properties[] = $row;
        }
    } else {
        $noPropertyFound = true;
    }
    $stmt->close();
}
?>


<div class="container dashboard-container">
    <h1 class="text-center">Filter Properties</h1>
    <div class="list-group">
        <a class="list-group-item list-group-item-action">Search by Filters</a>
    </div>
    <!-- Filtering Form -->
    <div class="container container-sm">
        <div class="row justify-content-center">
            <form class="container col-sm-8 col-lg-8 my-5" method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                <!-- Price Filtering -->
                <div class="mb-3">
                    <label for="price" class="form-label">Price (€)</label>
                    <input type="number" name="price" id="price" class="form-control" placeholder="Price">
                </div>
                <!-- Date Filtering -->
                <div class="mb-3">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo isset($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo isset($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </form>
        </div>
    </div>
</div>

<?php if (isset($properties) && !empty($properties)) : ?>
    <div class='container col-lg-8 card p-3 mb-3'>
        <div class="row row-cols-2">
            <?php foreach ($properties as $key => $property) : ?>
                <?php if ($key % 2 == 0) : ?>
                    </div>
                    <div class="row row-cols-2">
                <?php endif; ?>
                <div class="col">
                    <div class="property-entry">
                        <table class='table table-striped' style='width:100%'>
                            <tbody>
                                <tr>
                                    <th scope='col'>PropertyId</th>
                                    <td scope='row'><?php echo $property['propertyID']; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Bed Amount</th>
                                    <td scope='row'><?php echo $property['bedAmount']; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Price</th>
                                    <td scope='row'><?php echo $property['price']; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Area</th>
                                    <td scope='row'><?php echo $property['area']; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Length Tenancy</th>
                                    <td scope='row'><?php echo $property['lengthOfTenancy']; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Contract Start</th>
                                    <td scope='row'><?php echo $property['contractStart']; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Contract End</th>
                                    <td scope='row'><?php echo $property['contractEnd']; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Description</th>
                                    <td scope='row'><?php echo $property['desc']; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Title</th>
                                    <td scope='row'><?php echo $property['title']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php elseif (isset($noPropertyFound) && $noPropertyFound) : ?>
    <div class='alert alert-warning' role='alert'>
        No property found
    </div>
<?php endif; ?>

</body>
</html>
