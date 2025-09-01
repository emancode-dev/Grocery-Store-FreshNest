<?php
session_start();

$prices = [
    "Apple" => 2.00, "Banana" => 1.20, "Pineapple" => 3.00,
    "Guava" => 2.50, "Mango" => 4.00, "Orange" => 2.80,"Papaya"=>5.00,
    "Watermelon"=>90,
"Blueberries"=>65,
"Strawberries"=>100,

    "Pumpkin" => 5.50, "Bringel" => 5.50, "Potato" => 1.50,
    "Tomato" => 3.50, "Cabbage" => 2.50, "LadyFinger" => 4.50,
    "Carrot"=> 75,
    "GreenBeans"=> 90,
    "Cauliflower"=> 40,
    "Broccoli"=> 85,

    "Milk" => 1.50, "Eggs" => 3.00, "Butter" => 4.50,
    "Cheese" => 5.00, "Yogurt" => 2.50, "Cream" => 3.50,
    "Bread" => 1.50, "Cake" => 5.00, "Muffins" => 2.00,
    "Cookies" => 1.50, "Buns" => 1.20, "Donuts" => 2.00,
    "Red Chili Powder" => 2.50, "Garlic Powder" => 3.00,
    "Ginger Powder" => 3.50, "Turmeric Powder" => 3.50,
    "Saunf Powder" => 2.80, "Fennel Powder" => 2.80,
    "Onion Powder" => 3.20, "Cumin Powder" => 3.20
];

// Init cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add-to-cart
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['product'], $_POST['qty']) &&
    is_array($_POST['product']) && is_array($_POST['qty'])
) {
    foreach ($_POST['product'] as $i => $product) {
        $product = trim($product);
        $qty = isset($_POST['qty'][$i]) ? (int)$_POST['qty'][$i] : 0;

        if ($qty > 0 && isset($prices[$product])) {
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['name'] === $product) {
                    $item['qty'] += $qty;
                    $found = true;
                    break;
                }
            }
            unset($item);
            if (!$found) {
                $_SESSION['cart'][] = [
                    'name' => $product,
                    'qty' => $qty,
                    'price' => $prices[$product]
                ];
            }
        }
    }
}

$cart = $_SESSION['cart'];
$grandTotal = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - Mini Grocery Store</title>
    <link rel="stylesheet" href="style.css">
    <div class="top-banner">
        <img src="images/main/log.png" alt="Grocery Banner">
    </div>

 <style>
.cart {
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    border: 2px solid #ddd;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);

    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;

    /* auto-grow with content */
    width: fit-content;
    min-width: 400px;
}

/* Cart heading */
.cart h2 {
    font-size: 1.8rem;
    margin-bottom: 1rem;
    color: #333;
}

/* Table styling */
.cart table {
    width: 100%;
    border-collapse: collapse;
    font-size: clamp(0.9rem, 1vw + 0.8rem, 1.2rem); /* scale with width */
}

.cart th, 
.cart td {
    border: 1px solid #ddd;
    padding: 12px 16px;
    text-align: center;
}

.cart th {
    background: #f8f8f8;
    font-weight: bold;
}

/* Grand total row */
.cart tbody tr:last-child {
    font-size: 1.2em;
    font-weight: bold;
    background: #fafafa;
}

/* Checkout button */
.shop-bt {
    display: inline-block;
    padding: clamp(0.6rem, 1vw + 0.4rem, 1rem) clamp(1.2rem, 2vw + 0.6rem, 2rem);
    font-size: clamp(1rem, 1vw + 0.8rem, 1.4rem);
    font-weight: bold;
    text-align: center;
    color: #fff;
    background: #28a745;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.3s ease;
    margin-top: 1.2rem;
}

.shop-bt:hover {
    background: #218838;
}
/* Cart action buttons */
.btn-edit, .btn-delete {
    display: inline-block;
    padding: 6px 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border-radius: 6px;
    transition: background 0.3s, transform 0.2s;
}

/* Edit button */
.btn-edit {
    background: darkgreen;   /* Blue */
    color: #fff;
    margin-right: 6px;
}
.btn-edit:hover {
    background: greenyellow;
    transform: scale(1.05);
}

/* Delete button */
.btn-delete {
    background: darkgreen;   /* Red */
    color: #fff;
}
.btn-delete:hover {
    background: greenyellow;
    transform: scale(1.05);
}
.top-banner img {
    width: 100%;
    height: 200px;
    display: block;
}
.sent {
  display: flex;               /* make it a flex container */
  flex-direction: column;      /* stack children vertically */
  justify-content: center;     /* center vertically */
  align-items: center;         /* center horizontally */
  text-align: center;          /* center text inside elements */
  
  width: 380px;
  height: 280px;
  margin: 30px auto;
  padding: 10px 20px;
  border-radius: 15px;
  
  background: rgba(255, 255, 255, 0.1); /* glass effect */
  backdrop-filter: blur(10px);
  box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
}

/* Optional: add spacing between elements inside .sent */
.sent h2,
.sent p,
.sent a {
  margin: 10px 0; 
}
.footer {
  background: darkgreen;
  padding: 50px 20px;
  font-family: Arial, sans-serif;
  color: white;
}

.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  max-width: 1200px;
  margin: auto;
}

.footer-col {
  flex: 1 1 200px;
  margin: 20px;
}

.footer-col h4 {
  font-size: 16px;
  margin-bottom: 15px;
  color: #111;
  font-weight: bold;
  font-family: Arial Black;
}

.footer-col ul {
  list-style: none;
  padding: 0;
}

.footer-col ul li {
  margin-bottom: 10px;
}

.footer-col ul li a {
  text-decoration: none;
  color: white;
  transition: 0.3s;
}

.footer-col ul li a:hover {
  color: #27ae60;
}


.footer-logo h3{
  margin-bottom: 10px;
  border-radius: 60px;
  align-items: left;

}
.footer-bottom {
  text-align: center;
  padding: 15px;
  margin-top: 30px;
  border-top: 1px solid #ddd;
  font-size: 14px;
}
  </style>
</head>
<body>
<header>
    <nav>
            <a href="index.html">Home</a>
            <a href="about.html">About</a>
            <a href="shop.html">Shop</a>
            <a href="#">Vendor</a>
            <a href="#">Pages</a>
            <a href="blog.html">Blog</a>
            <a href="cart.php">Cart</a>
        </nav>

</header>

<main>
    <div class="cart">
    <h2>Your Cart</h2>
    <?php if (count($cart) === 0): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($cart as $item): 
                $total = $item['qty'] * $item['price'];
                $grandTotal += $total;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td>$<?= number_format($total, 2) ?></td>
                    <td>
                        <a href="edit.php?name=<?= urlencode($item['name']) ?>" class="btn-edit">Edit</a>
                        <a href="delete.php?name=<?= urlencode($item['name']) ?>" class="btn-delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th colspan="4">Grand Total</th>
                <th>$<?= number_format($grandTotal, 2) ?></th>
            </tr>
            </tbody>
        </table>
        <br>
        <a href="checkout.php" class="shop-bt">Checkout</a>
    <?php endif; ?>
</div>
</main>
<!-- Different Footer -->
   <footer class="footer">
  <div class="footer-container">
    <!-- Logo & Info -->
    <div class="footer-col">
        <h4>FreshNest</h4>
      <p>Healthy Choices, Happy Nest!!</p>
      <p><strong>Address:</strong>Islamabad</p>
      <p><strong>Call Us:</strong> +1 540-025-124553</p>
      <p><strong>Email:</strong> support@freshnest.com</p>
      <p><strong>Hours:</strong> 10:00 - 18:00, Mon - Sat</p>
    </div>

     <!-- Company -->
    <div class="footer-col">
      <h4>Company</h4>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html">About Us</a></li>
        <li><a href="doc/Delivery Information.pdf" download="Delivery Information">Delivery Information</a></li>
        <li><a href="doc/PrivacyPolicy.pdf" download="PrivacyPolicy">Privacy Policy</a></li>
        <li><a href="doc/Terms & Conditions.pdf" download="Terms & Conditions">Terms & Conditions</a></li>
        <li><a href="doc/index.html#contact">Contact Us</a></li>
      </ul>
    </div>



    <!-- Popular -->
    <div class="footer-col">
      <h4>Popular</h4>
      <ul>
        <li><a href="#">Milk & Flavoured Milk</a></li>
        <li><a href="#">Butter & Margarine</a></li>
        <li><a href="#">Egg Substitutes</a></li>
        <li><a href="#">Marmalades</a></li>
        <li><a href="#">Tea & Kombucha</a></li>
        <li><a href="">Cheeze</a></li>
      </ul>
    </div>

    <!-- Install App -->
    <div class="footer-col">
      <h4>Install App</h4>
      <p>From App Store or Google Play</p>
      <a href="#"><img src="images/pay/appstore.png" alt="App Store" width="120"></a>
      <a href="#"><img src="images/pay/googleplay.png" alt="Google Play" width="120"></a>
      <p>Secured Payment Gateways</p>
      <img src="images/pay/visa.jpeg" alt="Visa" width="40">
      <img src="images/pay/mastercard.png" alt="Mastercard" width="40">
      <img src="images/pay/paypal.png" alt="PayPal" width="40">
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2025 FreshNest. All Rights Reserved.</p>
  </div>
</footer>
</body>
</html>
