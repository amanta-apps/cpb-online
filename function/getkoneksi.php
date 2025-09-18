<?php
session_start();
if (isset($_POST['prosesgetkoneksi'])) {
    $database = $_POST['prosesgetkoneksi'];
    $_SESSION["client"] = $_POST['prosesgetkoneksi'];
    $servername = "localhost";
    // $servername = "19.0.2.244";
    $username = "root";
    $password = 'P@ssw0rd';
    $conn = mysqli_connect($servername, $username, $password, $database);
    global $conn;
    echo $_SESSION["client"];
}
