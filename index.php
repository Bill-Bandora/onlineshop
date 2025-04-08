<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
    <title>Startseite</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Onlineshop</h1>

<?php if (isset($_SESSION['username'])): ?>
<div class="welcome">
    <p>Willkommen, <?= $_SESSION['username'] ?></p>
    <p><a href="produkte.php">🛒 Produkte ansehen</a></p>
    <p><a href="warenkorb.php">🧺 Zum Warenkorb</a></p>
    <li><a href="überuns.php">Über uns</a></li>

    <form action="logout.php" method="post">
        <button name="logout">🚪 Abmelden</button>
    </form>
</div>
<?php else: ?>
    <h2>Login</h2>
    <?php if (isset($_SESSION['login_error'])): ?>
        <p style="color:red"><?= $_SESSION['login_error'] ?></p>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>
    <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Benutzername"><br>
        <input type="password" name="password" placeholder="Passwort"><br>
        <input type="submit" name="login" value="Anmelden">
    </form>
<?php endif; ?>

<div class="welcome fade-in">
    <h1 class="pop-in">🍓 Über Uns</h1>

    <p class="slide-in">Willkommen bei <strong>FruchtShop</strong> – deinem bunten Onlineparadies für alles, was süß, sauer und lecker ist!</p>

    <p class="slide-in">Unsere Reise begann 2024 mit einer einfachen Idee...</p>

    <p class="slide-in">Ob du nach einem fruchtigen Snack suchst oder...</p>

    <p class="highlight">Danke, dass du Teil unserer fruchtigen Community bist!</p>

    <p><strong>– Dein FruchtShop-Team 🍭</strong></p>
</div>
<div class="footer">
    <p>&copy; 2024 FruchtShop. Alle Rechte vorbehalten.</p>
    <p><a href="impressum.php">Impressum</a> | <a href="datenschutz.php">Datenschutz</a></p>

</body>
</html>
