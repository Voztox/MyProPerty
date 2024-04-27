<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>PropertyId</th>
                <th>Bed Amount</th>
                <th>Price</th>
                <th>Area</th>
                <th>Length Tenancy</th>
                <th>Contract Start</th>
                <th>Contarct End</th>
                <th>CustomerId</th>
                <th>Desc</th>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once('myProPerty_session.php');
            require_once('myProPerty_header.php');
            require_once('adverts.php');
            $sql = "SELECT * FROM property";
            $result = $conn->query($sql);

            if (!$result) {
                die("Error executing the query: " . mysqli_error($conn));
            }
            if ($result && mysqli_num_rows($result) > 0) {
                // Fetch data from $result and display
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['propertyID'] . "</td>";
                    echo "<td>" . $row['bedAmount'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['area'] . "</td>";
                    echo "<td>" . $row['lengthOfTenancy'] . "</td>";
                    echo "<td>" . $row['contractStart'] . "</td>";
                    echo "<td>" . $row['contractEnd'] . "</td>";
                    echo "<td>" . $row['customerID'] . "</td>";
                    echo "<td>" . $row['desc'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No records found.</td></tr>";
            }
            ?>

        </tbody>
    </table>
    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.jss"></script>

</body>

</html>