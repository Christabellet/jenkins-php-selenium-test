<?php

// Function to calculate word length
function wordlen($input){
    $length = strlen($input);
    return $length;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST["searchTerm"];
    
    $allowRedirection = true;  // Set a flag to determine if redirection is allowed

    // Check for the presence of JavaScript code
    if (preg_match("/<script>/i", $searchTerm) || preg_match("/<script\/>/i", $searchTerm) || preg_match("/<\/script>/i", $searchTerm) || preg_match("/<\/script\/>/i", $searchTerm)) {
        $allowRedirection = false;
    }

    // Check for SQL injection (You should use prepared statements in a real application)
    if (strpos($searchTerm, "'") !== false || strpos($searchTerm, ";") !== false) {
        // Input is potentially a SQL injection, disallow redirection
        $allowRedirection = false;
    }

    // If redirection is allowed, perform the redirection
    if ($allowRedirection) {
        header("Location: results.php?searchTerm=" . urlencode($searchTerm));
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple Web Application</title>
</head>
<body>
    <h1>Home Page</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="searchTerm">Enter a search term:</label>
        <input type="text" name="searchTerm" id="searchTerm">
        <input type="submit" name="submit" value="Search">
    </form>
</body>
</html>
