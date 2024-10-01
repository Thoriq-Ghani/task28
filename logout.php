<?php
// logout.php
session_start();
session_destroy();
header('Location: login.php');
exit();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>You have logged out</h1>
        <p class="message">Thank you for using our service.</p>
        <a href="login.php" class="btn">Login Again</a>
    </div>
</body>
</html>
