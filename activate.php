<?php
session_start();
include 'dbcon.php';
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $updateQuery = "update registration set status='active' where token='$token'";
    $query = mysqli_query($con, $updateQuery);
    if ($query) {
        echo $_SESSION['message'];
        if (isset($_SESSION['message'])) {
            $_SESSION['message'] = 'account verified successfully';
            header('location:login.php');
        }
    } else {
        echo "not activated";
    }
}