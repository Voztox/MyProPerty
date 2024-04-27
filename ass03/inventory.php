<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
require_once('myProPerty_session.php');
require_once('myProPerty_header.php');
require_once('adverts.php');

// Simulated inventory data (replace this with our actual database query)
$fakeInventoryData = array(
    array('inventoryID' => 1, 'propertyID' => 1, 'electricity' => 1, 'internet' => 0, 'oven' => 1, 'TV' => 0, 'heater' => 1, 'bills' => 1, 'washingMachine' => 0, 'dryingMachine' => 1),
    array('inventoryID' => 2, 'propertyID' => 2, 'electricity' => 0, 'internet' => 1, 'oven' => 1, 'TV' => 1, 'heater' => 0, 'bills' => 0, 'washingMachine' => 1, 'dryingMachine' => 1),
    // Add more simulated inventory data as needed
);

// Function to simulate database query for inventory search
function searchInventory($propertyID)
{
    global $fakeInventoryData;
    $inventoryItems = array();
    foreach ($fakeInventoryData as $item) {
        if ($item['propertyID'] == $propertyID) {
            $inventoryItems[] = $item;
        }
    }
    return $inventoryItems;
}

// Function to sanitize user input
function validate($value)
{
    return htmlspecialchars($value);
}

// Function to echo sticky form value
function stickyValue($value)
{
    echo (isset($_POST[$value]) ? $_POST[$value] : "");
}

$inventoryItems = []; // Initialize the $inventoryItems variable

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    // Get and validate filter value for propertyID
    $propertyID = isset($_POST['propertyID']) ? validate($_POST['propertyID']) : null;

    // Perform inventory search (simulate database query)
    $inventoryItems = searchInventory($propertyID);
}
?>

<div class="container dashboard-container">
    <h1 class="text-center">Search Inventory by Property ID</h1>
    <!-- Filtering Form -->
    <div class="container container-sm">
        <div class="row justify-content-center">
            <form class="container col-sm-8 col-lg-8 my-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                <div class="mb-3">
                    <label for="propertyID" class="form-label">Property ID</label>
                    <input type="text" name="propertyID" id="propertyID" class="form-control" placeholder="Property ID" value="<?php stickyValue('propertyID'); ?>">
                </div>
                <button type="submit" name="search" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</div>

<?php if (!empty($inventoryItems)) : ?>
    <div class='container col-lg-8 card p-3 mb-3'>
        <div class="row row-cols-2">
            <?php foreach ($inventoryItems as $key => $item) : ?>
                <?php if ($key % 2 == 0) : ?>
                    </div>
                    <div class="row row-cols-2">
                <?php endif; ?>
                <div class="col">
                    <div class="property-entry">
                        <table class='table table-striped' style='width:100%'>
                            <tbody>
                                <tr>
                                    <th scope='col'>Inventory ID</th>
                                    <td scope='row'><?php echo $item['inventoryID']; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Electricity</th>
                                    <td scope='row'><?php echo $item['electricity'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Internet</th>
                                    <td scope='row'><?php echo $item['internet'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Oven</th>
                                    <td scope='row'><?php echo $item['oven'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>TV</th>
                                    <td scope='row'><?php echo $item['TV'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Heater</th>
                                    <td scope='row'><?php echo $item['heater'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Bills</th>
                                    <td scope='row'><?php echo $item['bills'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Washing Machine</th>
                                    <td scope='row'><?php echo $item['washingMachine'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                                <tr>
                                    <th scope='col'>Drying Machine</th>
                                    <td scope='row'><?php echo $item['dryingMachine'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
    <div class='alert alert-warning' role='alert'>
        No inventory found for the given property ID
    </div>
<?php endif; ?>

</body>
</html>
