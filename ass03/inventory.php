<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Inventory ID</th>
                <th>Electricity</th>
                <th>Internet</th>
                <th>Oven</th>
                <th>TV</th>
                <th>Heater</th>
                <th>Bills</th>
                <th>Washing Machine</th>
                <th>Drying Machine</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Define database connection constants
            define('DB_HOST', 'localhost');
            define('DB_USER', 'root');
            define('DB_PASSWORD', '');
            define('DB_DATABASE', 's3105875');
            
            // Establish a new database connection
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
            
            // Check connection
            if ($conn->connect_error) {
                die("Database connection failed: " . $conn->connect_error);
            }
            
            // Include necessary files
            require_once('myProPerty_session.php');
            require_once('myProPerty_header.php');
            $sql = "SELECT * FROM inventory";
            $result = $conn->query($sql);

            if (!$result) {
                die("Error executing the query: " . mysqli_error($conn));
            }
            if ($result && mysqli_num_rows($result) > 0) {
                // Fetch data from $result and display
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['inventoryID'] . "</td>";
                    echo "<td>" . ($row['electricity'] ? 'Yes' : 'No') . "</td>";
                    echo "<td>" . ($row['internet'] ? 'Yes' : 'No') . "</td>";
                    echo "<td>" . ($row['oven'] ? 'Yes' : 'No') . "</td>";
                    echo "<td>" . ($row['TV'] ? 'Yes' : 'No') . "</td>";
                    echo "<td>" . ($row['heater'] ? 'Yes' : 'No') . "</td>";
                    echo "<td>" . ($row['bills'] ? 'Yes' : 'No') . "</td>";
                    echo "<td>" . ($row['washingMachine'] ? 'Yes' : 'No') . "</td>";
                    echo "<td>" . ($row['dryingMachine'] ? 'Yes' : 'No') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No records found.</td></tr>";
            }
            ?>

        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.jss"></script>

</body>

</html>
