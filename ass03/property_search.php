<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <style>
        div.container.dashboard-container { margin-top: 20%; }
        a.btn-primary.btn-search { font-size: 24px; height: auto;}
    </style>
</head>
<body>
<?php
require_once('myProPerty_session.php');
require_once('myProPerty_header.php');
require_once('adverts.php');
?>
<div class="container-fluid">
    <div class="row">
        <!-- Button for Search with ID -->
        <div class="col-md-6 text-center">
            <div class="container dashboard-container">
                <a href="property_searchID.php" class="btn btn-primary btn-search">Search With ID</a>
            </div>
        </div>

        <!-- Button for Search with Filters -->
        <div class="col-md-6 text-center">
            <div class="container dashboard-container">
                <a href="property_searchFilters.php" class="btn btn-primary btn-search">Search With Filters</a>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>
</body>
</html>
