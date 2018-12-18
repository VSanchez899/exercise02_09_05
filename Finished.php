<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Complete</h1>
    <p>you are done, Have a nice day</p>
    <?php
    echo "<p style='text-align: center;'><a href='home.php'>Log Out</a></p>\n";
    ?>
</body>
</html>