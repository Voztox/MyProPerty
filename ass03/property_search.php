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

<div class="container-fluid">
    <div class="row">
        <!-- Button for Search with ID -->
        <div class="col-md-6 text-center">
            <div class="container dashboard-container">
                <button type="button" class="btn btn-primary btn-search" onclick="window.location.href='property_searchID.php'">Search With ID</button>
            </div>
        </div>

        <!-- Button for Search with Filters -->
        <div class="col-md-6 text-center">
            <div class="container dashboard-container">
                <button type="button" class="btn btn-primary btn-search" onclick="window.location.href='property_searchFilters.php'">Search With Filters</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
