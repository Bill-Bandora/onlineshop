<?php session_start(); ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkte</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php require_once("login.php"); ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
        $id = $_POST['product_id'];
        $name = $_POST['product_name'];
        $price = floatval($_POST['product_price']);
        $quantity = intval($_POST['product_quantity']);

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity
            ];
        }

        echo "<p><strong>Produkt erfolgreich zum Warenkorb hinzugefügt.</strong></p>";
    }
    ?>

    <h1>Produkte</h1>
    <nav>
        <ul>
            <li><a href="index.php">Startseite</a></li>
            <li><a href="produkte.php">Produkte</a></li>
            <?php if (isset($_SESSION['eingeloggt'])): ?>
                <li><a href="warenkorb.php">Warenkorb</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <?php
    $produkte = [
        ['id' => 1, 'name' => 'Fruchtgummis', 'beschreibung' => 'Fruchtige Vielfalt!', 'preis' => 4.99],
        ['id' => 2, 'name' => 'Fruchtbonbons', 'beschreibung' => 'Suess und lecker!', 'preis' => 3.99],
        ['id' => 3, 'name' => 'Fruchtkaugummis', 'beschreibung' => 'Langanhaltender Geschmack!', 'preis' => 2.99],
        ['id' => 4, 'name' => 'Fruchtige Lutscher', 'beschreibung' => 'Fuer die suessen Momente!', 'preis' => 1.99],
        ['id' => 5, 'name' => 'Fruchtige Schokolade', 'beschreibung' => 'Schokolade mit Fruchtgeschmack!', 'preis' => 5.49],
        ['id' => 6, 'name' => 'Fruchtige Kekse', 'beschreibung' => 'Kekse mit fruchtiger Fuellung!', 'preis' => 3.49],
        ['id' => 7, 'name' => 'Fruchtige Muesliriegel', 'beschreibung' => 'Gesunde Snacks für unterwegs!', 'preis' => 2.49],
        ['id' => 8, 'name' => 'Fruchtige Joghurt', 'beschreibung' => 'Erfrischend und lecker!', 'preis' => 1.49],
        ['id' => 9, 'name' => 'Fruchtige Smoothies', 'beschreibung' => 'Gesunde Erfrischung!', 'preis' => 3.99],
        ['id' => 10, 'name' => 'Fruchtige Eiscreme', 'beschreibung' => 'Kuehle Erfrischung für heisse Tage!', 'preis' => 4.49]
    ];

    $produkte = array_map(function($produkt) {
        $produkt['beschreibung'] = htmlentities($produkt['beschreibung']);
        $produkt['name'] = htmlentities($produkt['name']);
        $produkt['preis'] = number_format($produkt['preis'], 2, '.', '.');
        return $produkt;
    }, $produkte);
    ?>

    <form method="get" style="text-align: center; margin-bottom: 2rem;">
    <label>Sortieren nach:
        <select name="sort">
            <option value="">-- Auswahl --</option>
            <option value="preis_auf">Preis aufsteigend</option>
            <option value="preis_ab">Preis absteigend</option>
            <option value="name_az">Name A–Z</option>
            <option value="name_za">Name Z–A</option>
        </select>
    </label>

    <label>Filter Buchstabe:
        <input type="text" name="start" maxlength="1" style="width: 20px;">
    </label>

    <button type="submit">Anwenden</button>
    </form>
    
    <?php
    if (isset($_GET['sort'])) {
        switch ($_GET['sort']) {
            case 'preis_auf':
                usort($produkte, function($a, $b) {
                    return $a['preis'] <=> $b['preis'];
                });
                break;
            case 'preis_ab':
                usort($produkte, function($a, $b) {
                    return $b['preis'] <=> $a['preis'];
                });
                break;
            case 'name_az':
                usort($produkte, function($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
                break;
            case 'name_za':
                usort($produkte, function($a, $b) {
                    return strcmp($b['name'], $a['name']);
                });
                break;
        }
    }
    if (isset($_GET['start']) && strlen($_GET['start']) === 1) {
        $start = strtoupper($_GET['start']);
        $produkte = array_filter($produkte, function($produkt) use ($start) {
            return strtoupper(substr($produkt['name'], 0, 1)) === $start;
        });
    }
    ?>

    <?php 
    foreach ($produkte as $produkt): 
    ?>
        
        
        <div class="product">
            <img src="img/produkt<?= $produkt['id'] ?>.jpg" alt="<?= $produkt['name'] ?>">
            <h3><?= $produkt['name'] ?></h3>
            <p><?= $produkt['beschreibung'] ?></p>
            <p>Preis: <?= number_format($produkt['preis'], 2, ',', '.') ?> €</p>
    
            <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <input type="hidden" name="product_id" value="<?= $produkt['id'] ?>">
                <input type="hidden" name="product_name" value="<?= $produkt['name'] ?>">
                <input type="hidden" name="product_price" value="<?= $produkt['preis'] ?>"> <!-- float -->
                Menge: <input type="number" name="product_quantity" value="1" min="1">
                <button type="submit" name="add_product">In den Warenkorb</button>
            </form>
        </div>
            
        
    <?php endforeach; ?>
    
    <?php if (isset($_SESSION['eingeloggt'])): ?>
        <h2>Warenkorb-Vorschau</h2>
        <?php require_once("cartwidget.php"); ?>
    <?php endif; ?>
    
    <?php
    // Floating Cart Button
    $cart_count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $cart_count += $item['quantity'];
        }
    }
    ?>
    
    <!-- Muss im <body> stehen, vor </body> -->
    <a href="warenkorb.php" class="floating-cart">
        🛒
        <?php if ($cart_count > 0): ?>
            <span class="cart-count"><?= $cart_count ?></span>
        <?php endif; ?>
    </a>
    
    


</body>
</html>
