<?php
$conn = mysqli_connect("localhost","root","","gs");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $sql = "INSERT INTO store (name, email, password, cpassword) 
            VALUES ('$name', '$email', '$password', '$cpassword')";

    mysqli_query($conn, $sql);
    header("location:login.html");
}
?>
