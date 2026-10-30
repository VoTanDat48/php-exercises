<?php
$severname = "localhost";
$username = "root";
$password = ""; 
$dbname = "quanly_ban_sua";
$conn = mysqli_connect($severname, $username, $password, $dbname);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

$query = "SELECT * FROM khach_hang";

$result = mysqli_query($conn, $query);
if(!$result) die ('<br> <b>Query failed</b>');

$numfields = mysqli_num_fields($result);


?>