<?php
require_once("db_connect.php");
session_start();

// Check if the user is logged in and is a tech
if (!isset($_SESSION['UserID']) || $_SESSION['Tech'] != 1) {
    header("Location: login.php");
    exit;
}

// Check to see if form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the ticket ID and new status from the form
    $ticketID = $_POST['TicketID'];
    $newStatus = $_POST['Status'];

    // If Status is Completed then, put Complete Date
    if ($newStatus === 'Completed') {
        $stmt = $pdo->prepare("UPDATE tickets SET Status = ?, CompletionDate = NOW() WHERE TicketID = ?");
    } else {
        //If Status is In Progress then dont put Completion Date
        $stmt = $pdo->prepare("UPDATE tickets SET Status = ? WHERE TicketID = ?");
    }

    
    $stmt->execute([$newStatus, $ticketID]);

    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Ticket Status</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="banner">
    <img src="https://upload.wikimedia.org/wikipedia/commons/7/79/Pace_University_Logo_2021.png" alt="Pace University Logo">
    <h1>Update Ticket Status</h1>    
</header>
<br><br>

<form action="update_ticket_status.php" method="POST">
    <label for="ticketID">Ticket ID:</label>
    <input type="text" name="TicketID" required>
    <br><br>
    <label for="status">Status:</label>
    <select name="Status">
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
    </select>

    <input class="button" type="submit" value="Update Status">
</form>

<br><br><br>
<br><a class="button" href="welcome.php">Home</a>
<br><br><a class="button" href="view_all_tickets.php">View All Tickets</a>
<br><br><a class="button" href="logout.php">Logout</a>
</body>
</html>
