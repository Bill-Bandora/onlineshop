<?php
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Keine Artikel im Warenkorb.</p>";
} else {
    echo "<ul>";
    foreach ($_SESSION['cart'] as $item) {
        echo "<li>{$item['name']} ({$item['quantity']})</li>";
    }
    echo "</ul>";
    echo '<a href="warenkorb.php">Zum Warenkorb</a>';
}
?>
