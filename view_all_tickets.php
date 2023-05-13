<?php
require_once("db_connect.php");
session_start();

// Check if the user is logged in and is a tech
if (!isset($_SESSION['UserID']) || $_SESSION['Tech'] != 1) {
    header("Location: login.php");
    exit;
}

// Retrieve New, In progress, and Completed tickets
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE Status IN ('New', 'In Progress', 'Completed')");
$stmt->execute();
$tickets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Tickets</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="banner">
    <img src="https://upload.wikimedia.org/wikipedia/commons/7/79/Pace_University_Logo_2021.png" alt="Pace University Logo">
    <h1>All Tickets</h1>
    </header>
    <br><br>
    
    <center><table>
        <tr>
            <th>Ticket ID</th>
            <th>Creation Date</th>
            <th>Subject</th>
            <th>Body</th>
            <th>Status</th>
            <th>Completion Date</th>
            
        </tr>
        <?php
        foreach ($tickets as $ticket) {
            echo '<tr>';
            echo '<td>' . $ticket['TicketID'] . '</td>';
            echo '<td style="width:10%">' . $ticket['CreationDate'] . '</td>';
            echo '<td >' . $ticket['Subject'] . '</td>';
            echo '<td>' . $ticket['Body'] . '</td>';
            echo '<td>' . $ticket['Status'] . '</td>';
            echo '<td>' . $ticket['CompletionDate'] . '</td>';
            
            echo '</tr>';
        }
        ?>
    </table></center>
    <br><br><br<br><a class="button" href="welcome.php">Home</a>
    <br><br><a class="button" href="update_ticket_status.php">Update Ticket Status</a>
    <br><br><a class="button" href="logout.php">Logout</a>
</body>
</html>
