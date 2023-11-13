<?php 
session_start();

if (isset($_POST['submit'])) {
    if (isset($_POST['password']) && $_POST['password'] != '') {
        $password = trim($_POST['password']);

        if ($password == "password1234") {
            // You might want to perform additional checks for the password
            // before setting the session. This example only checks for a specific password.
            
            $_SESSION['user_id'] = "user@example.com";

            header('location:dashboard.php');
            exit;
        }

        $errorMsg = "Login failed";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page | PHP Login and logout example with session</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h1>PHP Login and Logout with Session</h1>
        <?php 
        if (isset($errorMsg)) {
            echo "<div class='error-msg'>";
            echo $errorMsg;
            echo "</div>";
            unset($errorMsg);
        }

        if (isset($_GET['logout'])) {
            echo "<div class='success-msg'>";
            echo "You have successfully logout";
            echo "</div>";
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <!-- Removed the email input field -->
            <div class="field-container">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Enter Your Password">
            </div>
            <div class="field-container">
                <button type="submit" name="submit">Login</button>
            </div>
        </form>
    </div>
</body>

</html>
