<?php
$servername = "localhost";
// $servername = "19.0.2.244";
$database = $_SESSION['client'];
$username = "root";
$password = "P@ssw0rd";
$conn = mysqli_connect($servername, $username, $password, $database);
