<?php
require_once("db_connect.php");
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Welcome to Ticketing System</title>
</head>
<body>
    <header class="banner">
    <img src="https://upload.wikimedia.org/wikipedia/commons/7/79/Pace_University_Logo_2021.png" alt="Pace University Logo">
        <h1>Welcome to Pace Ticketing System</h1>
    </header>
    <br><br>
    <p>Welcome to the Home page! Create or view your tickets.</p>
    <br>
    <?php
    if (!isset($_SESSION['UserID'])) {
        echo '<a class="button" href="login.php">Login</a>';
    } else {
        //If the Tech is not equal to 1, then the user will be Student or Faculty and will get the options to click on the links
        if ($_SESSION['Tech'] != 1) {
            echo '
            <a class="button" href="create_ticket.php">Create Ticket</a>
            <a class="button" href="view_ticket.php">View My Tickets</a>
            <a class="button" href="contact_page.php">Contact Us</a>

            ';
        } else {
            //If Tech, then provide links to pages for Admin
            echo '
            <a class="button" href="view_all_tickets.php">View All Tickets</a>
            <a class="button" href="update_ticket_status.php">Update Ticket Status</a>
            ';
        }
        echo '<a class="button" href="logout.php">Logout</a>';
    }
    ?>
</body>
</html>
