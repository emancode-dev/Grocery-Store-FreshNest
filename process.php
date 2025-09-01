<?php
$conn = mysqli_connect("localhost", "root", "", "gs");
$email=$_POST['email'];
$password=$_POST['password'];
$sql="SELECT * from store WHERE email ='$email' AND password='$password'";

$result=mysqli_query($conn, $sql);

if (mysqli_num_rows($result)==1) {
	header("location:index.html");
}
else
{
	echo "error";
}
?>