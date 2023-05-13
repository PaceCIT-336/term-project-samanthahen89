<?php
require_once("db_connect.php");
session_start();

// Check to see if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit;
}

// Check to see if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    // Validate data
    if (empty($subject) || empty($body)) {
        $error = "Please fill in all fields.";
    } else {
        $author = $_SESSION['UserID'];
        $status = 'New';
        $creationDate = date('Y-m-d H:i:s');
        $completionDate = null;

        // Insert ticket details into database
        $stmt = $pdo->prepare("INSERT INTO tickets (Author, Subject, Body, Status, CreationDate, CompletionDate)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$author, $subject, $body, $status, $creationDate, $completionDate]);

        // Redirect to view the created ticket
        $ticketID = $pdo->lastInsertId();
        header("Location: view_ticket.php?ticketID=$ticketID");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Ticket</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="banner">
    <img src="https://upload.wikimedia.org/wikipedia/commons/7/79/Pace_University_Logo_2021.png" alt="Pace University Logo">
    
    </header> 
    <?php
    if (isset($error)) {
        echo '<p class="error">' . $error . '</p>';
    }
    ?>
    <div class="container">
    <form action="create_ticket.php" method="POST">
    <h1>Create Ticket</h1>
    <br>
        <label for="subject">Subject:</label>
        <input type="text" name="subject" required><br><br>
        
        <label for="body">Body:</label>
        <textarea name="body" rows="5" required></textarea><br>
        <br>
        <input class="button" type="submit" value="Create Ticket">
    </form>
</div>

<br><br><br<br><a class="button" href="welcome.php">Home</a>
    <br><br><a class="button" href="view_ticket.php">View Ticket</a>
    <br><br><a class="button" href="logout.php">Logout</a>

</body>
</html>
