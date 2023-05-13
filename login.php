<?php
require_once("db_connect.php");
session_start();

// Check if the user is already logged in, redirect to welcome page
if (isset($_SESSION['UserID'])) {
    header("Location: welcome.php");
    exit;
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query to authenticate the user
    $stmt = $pdo->prepare("SELECT UserID, Tech FROM Users WHERE Username = ? AND Password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['Tech'] = $user['Tech'];
        header("Location: welcome.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<header class="banner">
    <img src="https://upload.wikimedia.org/wikipedia/commons/7/79/Pace_University_Logo_2021.png" alt="Pace University Logo">
    
    </header>
    <title>Login</title>
    
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <?php
    if (isset($error)) {
        echo '<p class="error">' . $error . '</p>';
    }
    ?>
    <div class="container">
    <form action="login.php" method="POST">
   
    <h1>Login</h1>
    <br><br>
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        
        <input class="button" type="submit" value="Login">
    </form>
</div>
</body>
</html>
