<?php
session_start();

if (isset($_GET['name'])) {
    $name = $_GET['name'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['name'] === $name) {
                unset($_SESSION['cart'][$index]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex
                break;
            }
        }
    }
}
header("Location: cart.php");
exit;
