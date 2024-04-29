<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<?php
require_once('myProPerty_session.php');
require_once('myProPerty_header.php');
require_once('adverts.php');

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    // Get and validate filter value for propertyID
    $propertyID = isset($_POST['propertyID']) ? validate($_POST['propertyID']) : null;

    // Prepare and execute SQL query with filtering condition for propertyID
    $sql = "SELECT * FROM property WHERE propertyID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $propertyID);
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
    } else {
        echo "Error executing query: " . $conn->error;
    }
}
?>
<div class="container dashboard-container">
    <h1 class="text-center">Search by ID</h1>
    <div class="list-group">
        <a class="list-group-item list-group-item-action">Search by ID</a>
    </div>
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
                                    <td scope='row'><?php echo $property['description']; ?></td>
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
