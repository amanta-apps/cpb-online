<?php
session_start();
error_reporting(0);
if (isset($_SESSION['userid'])) {
    // header('Location: /page/mainpage.php?p=dashboard');
    // echo '<script>alert("OKE")</script>';
} else {
    // header('Location: http://localhost/sga/');
    // echo '<script>alert("TIDAK OKE")</script>';
}
