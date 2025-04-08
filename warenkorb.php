<?php
session_start();

// Produkt entfernen
if (isset($_POST['remove_item'])) {
    $remove_id = $_POST['remove_id'];
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex
            $_SESSION['message'] = "Produkt wurde entfernt.";
            break;
        }
    }
}

// Warenkorb leeren
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    $_SESSION['message'] = "Warenkorb wurde geleert.";
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Warenkorb</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>🛒 Ihr Warenkorb</h1>

<nav>
    <ul>
        <li><a href="index.php">Startseite</a></li>
        <li><a href="produkte.php">Produkte</a></li>
    </ul>
</nav>

<?php
// Feedback anzeigen
if (isset($_SESSION['message'])) {
    echo "<div class='message'>" . htmlentities($_SESSION['message']) . "</div>";
    unset($_SESSION['message']);
}
?>

<?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
    <ul>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $item):
            $line_total = $item['price'] * $item['quantity'];
            $total += $line_total;
        ?>
            <li>
                <strong><?= htmlentities($item['name']) ?></strong> – <?= $item['quantity'] ?> x <?= number_format($item['price'], 2, ',', '.') ?> €
                = <?= number_format($line_total, 2, ',', '.') ?> €

                <form method="post" style="display:inline;">
                    <input type="hidden" name="remove_id" value="<?= $item['id'] ?>">
                    <button type="submit" name="remove_item">Entfernen</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <p><strong>Gesamtsumme: <?= number_format($total, 2, ',', '.') ?> €</strong></p>

    <form method="post">
        <button type="submit" name="clear_cart">🗑️ Warenkorb leeren</button>
    </form>

<?php else: ?>
    <p>Ihr Warenkorb ist leer.</p>
<?php endif; ?>

</body>
</html>
