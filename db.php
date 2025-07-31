<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "blog_db";

$conn = mysqli_connect("$host", "$user", "$pass", "$db");

if(!$conn){
    echo ("connection failed: " . $conn->connect_error);
}
?>