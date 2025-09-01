<?php
$conn = mysqli_connect("localhost","root","","gs");
if(!$conn)
{
	echo "not connected";
}
else
{
	echo "connected";
}
?>