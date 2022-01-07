<?php
require 'dbcon.php';
$token = $_GET['token'];
$query = " Delete from registration where token='$token'";
$execute_delete = mysqli_query($con, $query) or die(mysqli_error($con));
if ($execute_delete) {
    echo "<h1>you have unsubcribed our service<h1>";
} else {
    echo "<h1> unsuccessfull <h1>";
}