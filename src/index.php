<?php 
session_start();

function isCommonPassword($password) {
    // Define an array of common passwords from your txt file
    $commonPasswords = file('10-million-password-list-top-1000.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    //echo "Pw: $commonPasswords";
    // Check if the provided password is in the common passwords list
    return in_array($password, $commonPasswords);
}

function isStrongPassword($password) {

	// Check if the password is a common password
	if (isCommonPassword($password)) {
		return false;
	}
    // Minimum length requirement
    $minLength = 10;

    // Check if the password meets the minimum length requirement
    if (strlen($password) < $minLength) {
        return false;
    }

    // Check for a mix of character types (uppercase, lowercase, numbers, symbols)
    if (!preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) ||
        !preg_match('/[0-9]/', $password) ||
        !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        return false;
    }

    return true;
}


if (isset($_POST['submit'])) {
    if (isset($_POST['password']) && $_POST['password'] != '') {
        $password = trim($_POST['password']);

		$cost = 15;
        if (isStrongPassword($password)) {
            //echo "Password: $password";
            // You might want to perform additional checks for the password
            // before setting the session. This example only checks for a specific password.
			$password_hash = password_hash($password, PASSWORD_DEFAULT, ["cost" => $cost]);
			//echo "Password hash: $password_hash";
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
