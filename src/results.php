<?php
$searchTerm = $_GET["searchTerm"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results</h1>
    <p>Search Term: <?php echo $searchTerm; ?></p>
    <a href="index.php">Return to Home</a>
</body>
</html>