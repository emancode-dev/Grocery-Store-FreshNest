<?php
session_start();

if (!isset($_GET['name'])) {
    header("Location: cart.php");
    exit;
}

$name = $_GET['name'];

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qty'])) {
    $newQty = (int)$_POST['qty'];
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $name) {
            if ($newQty > 0) {
                $item['qty'] = $newQty;
            } else {
                // remove if qty <= 0
                $item = null;
            }
            break;
        }
    }
    $_SESSION['cart'] = array_values(array_filter($_SESSION['cart']));
    unset($item);
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Mini Grocery Store</title>
    <link rel="stylesheet" href="style.css">
     <div class="top-banner">
        <img src="images/main/log.png" alt="Grocery Banner">
    </div>

<style>
.top-banner img
{
    width: 100%;
    height: 200px;
    display: block;
}

}
.registration-form {
    max-width: 400px;
    margin: 40px auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.registration-form h2 {
    text-align: center;
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
    color: darkgreen;
}

.registration-form form {
    display: flex;
    flex-direction: column;
}

.registration-form label {
    margin: 10px 0 5px;
    font-size: 14px;
    font-weight: bold;
    color: #333;
}

.registration-form input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
}

.registration-form button {
    margin-top: 20px;
    padding: 12px;
    background: darkgreen;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: 0.3s ease;
}

.registration-form button:hover {
    background: #27ae60;
}

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
    <section class="registration-form">
        <h2>Edit Quantity: <?= htmlspecialchars($name) ?></h2>

        <form method="POST">

            <label>New Quantity</label>
            <input type="number" name="qty" min="0" required>
            <button type="submit" class="shop-bt">Update</button>

        </form>
    </section>
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
