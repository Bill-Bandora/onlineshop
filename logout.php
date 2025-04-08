<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h1>Logout</h1>
    <p>Du wurdest erfolgreich ausgeloggt.</p>

    <nav>
        <ul>
            <li><a href="index.php">Zurück zur Startseite</a></li>
            <li><a href="produkte.php">Produkte ansehen</a></li>
            <li><a href="index.php">Erneut einloggen</a></li>
        </ul>
    </nav>

</body>
</html>
