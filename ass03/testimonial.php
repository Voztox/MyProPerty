<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel = "stylesheet" href = "styles.css">
</head>

<body>
<?php
require_once('myProPerty_session.php');
require_once('myProPerty_header.php');
require_once('adverts.php');
?>
    <div class="container mt-4">
        <h3 class="text-center">Testimonials</h3 >

        <?php 
        $sql = "SELECT * FROM testimonial WHERE approved = 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) : ?>
            <ul class="list-group mt-3">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center ">
                            <div>
                                <strong><?php echo $row['parentFirstName']; ?></strong> - <?php echo $row['serviceName']; ?> - <?php echo $row['date']; ?>
                            </div>
                            <div>
                                <span><?php echo $row['comment']; ?></span>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <p class="text-center mt-3">No testimonials available.</p>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php require_once('footer.php'); ?>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
