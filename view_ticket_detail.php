<?php
require_once("db_connect.php");
session_start();

// Check to see if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit;
}

// Check if the ticket ID is provided
if (!isset($_GET['ticketID'])) {
    header("Location: view_ticket_detail.php");
    exit;
}

$ticketID = $_GET['ticketID'];
$userID = $_SESSION['UserID'];

// get the ticket details from the Tickets table
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE TicketID = ?");
$stmt->execute([$ticketID]);
$ticket = $stmt->fetch();

// Check if the ticket exists or if the user is not the author
if (!$ticket || $ticket['Author'] != $userID) {
    header("Location: view_ticket_detail.php");
    exit;
}

// Retrieve the comments associated with the ticket
$stmt = $pdo->prepare("SELECT * FROM comments WHERE TicketID = ? ORDER BY Date");
$stmt->execute([$ticketID]);
$comments = $stmt->fetchAll();

// Add a new comment
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newComment = $_POST['comment'];

    // Validate comment
    if (empty($newComment)) {
        $error = "Please enter a comment.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO comments (TicketID, Author, Date, Comment) VALUES (?, ?, ?, ?)");
        $stmt->execute([$ticketID, $userID, date('Y-m-d H:i:s'), $newComment]);

        // Redirect to refresh the page
        header("Location: view_ticket.php?ticketID=$ticketID");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ticket Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="banner">
    <img src="https://upload.wikimedia.org/wikipedia/commons/7/79/Pace_University_Logo_2021.png" alt="Pace University Logo">
    <h1>Ticket Details</h1>
    </header> 
    <br>

    
    <!--<h2><?php echo $ticket['Subject']; ?></h2>-->
    <p><strong>Subject:</strong> <?php echo $ticket['Subject']; ?></p>
    <br>
    <p><strong>Status:</strong> <?php echo $ticket['Status']; ?></p>
    <br>
    <p><strong>Creation Date:</strong> <?php echo $ticket['CreationDate']; ?></p>
    <br>
    <p><strong>Completion Date:</strong> <?php echo $ticket['CompletionDate']; ?></p>

    <br>
    <h3>Comments</h3>
    <?php
    if (count($comments) > 0) {
        foreach ($comments as $comment) {
            echo '<p>';
            echo '<strong>Author:</strong> ' . $comment['Author'] . '<br>';
            echo '<strong>Date:</strong> ' . $comment['Date'] . '<br>';
            echo '<strong>Comment:</strong> ' . $comment['Comment'];
            echo '</p>';
        }
    } else {
        echo '<p>No comments found.</p>';
    }
    ?>

    <br>
    <h3>Add Comment</h3>
    <?php
    if (isset($error)) {
        echo '<p class="error">' . $error . '</p>';
    }
    ?>
    <form action="view_ticket_detail.php?ticketID=<?php echo $ticketID; ?>" method="POST">
    <textarea name="comment" rows="5" required></textarea><br>
    <br>
    <input class="button" type="submit" value="Add Comment">
</form>


    <br><br><br<br><a class="button" href="welcome.php">Home</a>
    <br><br><a class="button" href="create_ticket.php">Create Ticket</a>
    <br><br><a class="button" href="view_ticket.php">View Tickets</a>
    <br><br><a class="button" href="logout.php">Logout</a>
</body>
</html
