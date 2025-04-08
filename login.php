<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'John' && $password == '1234') {
        $_SESSION['eingeloggt'] = true;
        $_SESSION['username'] = $username;
        echo "<p>Erfolgreich angemeldet als <strong>$username</strong>.</p>";
        header("Location: index.php"); // Weiterleitung NUR wenn Login OK
        exit();
    } else {
        echo "<p style='color:red;'>Falsche Anmeldedaten.</p>";
        header("Location: index.php"); // zurück zum Login
    }
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    echo "<p>Erfolgreich ausgeloggt.</p>";
}

if (!isset($_SESSION['eingeloggt'])) {
    ?>
    <h2>Bitte Einloggen</h2>
    <form action="index.php" method="POST">
        <label for="username">Benutzername:</label>
        <input type="text" id="username" name="username">
        <br>
        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password">
        <br>
        <input type="submit" name="login" value="Anmelden">
    </form>

    <form action="index.php" method="POST">
        <input type="submit" name="logout" value="Logout">
    </form>
    <?php
    if (isset($_POST['logout'])) {
        session_start();
        session_unset();
        session_destroy();
        echo "<p>Erfolgreich ausgeloggt.</p>";
    }
    ?>
    <form action="index.php" method="POST">
        <input type="submit" name="logout" value="Logout">
    </form>
    <?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

else if (!isset($_SESSION['username'])) {
    echo "<p>Bitte melden Sie sich an, um fortzufahren.</p>";
    echo '<form action="index.php" method="POST">';
    echo '<input type="submit" name="login" value="Login">';
    echo '</form>';
}
else if (!isset($_SESSION['eingeloggt'])) {
    echo "<p>Bitte melden Sie sich an, um fortzufahren.</p>";
    echo '<form action="index.php" method="POST">';
    echo '<input type="submit" name="login" value="Login">';
    echo '</form>';
}
else if (isset($_SESSION['eingeloggt']) && !isset($_SESSION['username'])) {
    echo "<p>Bitte melden Sie sich an, um fortzufahren.</p>";
    echo '<form action="index.php" method="POST">';
    echo '<input type="submit" name="login" value="Login">';
    echo '</form>';
}
    else {
    echo "<p>Willkommen zurück, <strong>" . htmlentities($_SESSION['username']) . "</strong>!</p>";
    echo '<form action="index.php" method="POST">';
    echo '<input type="submit" name="logout" value="Logout">';
    echo '</form>';
}
?>
