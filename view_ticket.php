<?php
require_once("db_connect.php");
session_start();

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit;
}

// get the user's ID from the session
$userID = $_SESSION['UserID'];

// get the user's active tickets from the database
$stmt = $pdo->prepare("SELECT TicketID, CreationDate, Subject, Body, Status, CompletionDate FROM Tickets WHERE Author = ? AND Status IN ('New', 'In Progress','Completed')");
$stmt->execute([$userID]);
$tickets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Tickets</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="banner">
    <img src="https://upload.wikimedia.org/wikipedia/commons/7/79/Pace_University_Logo_2021.png" alt="Pace University Logo">
        <h1>My Tickets</h1>
    </header>
    
    <br>
    <br>
    <?php
    if (count($tickets) > 0) {
        echo '<div>';
        echo '<center><table >';
        echo '<tr><th>Ticket ID</th><th>Creation Date</th><th>Subject</th><th>Body</th><th>Status</th><th>Action</th></tr>';

        foreach ($tickets as $ticket) {
            echo '<tr>';
            echo '<td>' . $ticket['TicketID'] . '</td>';
            echo '<td>' . $ticket['CreationDate'] . '</td>';
            echo '<td style="width:10%">' . $ticket['Subject'] . '</td>';
            echo '<td>' . $ticket['Body'] . '</td>';
            echo '<td>' . $ticket['Status'] . '</td>';
            echo '<td><a href="view_ticket_detail.php?ticketID=' . $ticket['TicketID'] . '">View Details</a></td>';
            echo '</tr>';
        }

        echo '</table><center/>';
        echo '</div>';
    } else {
        echo '<p>No tickets found.</p>';
    }
    echo '<br><br><br<br><a class="button" href="welcome.php">Home</a>';
    echo '<br><br><a class="button" href="create_ticket.php">Create Ticket</a>';
    echo '<br><br><a class="button" href="logout.php">Logout</a>';
    
    
    ?>
    
</body>
</html>
