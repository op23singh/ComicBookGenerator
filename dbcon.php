<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "assignment";
$con = mysqli_connect($servername, $username, $password, $dbname);
// print_r($con);
if ($con) {
    echo '<script type="text/javascript"> alert("connection successfully established"); </script>';
} else {
    echo '<script type="text/javascript">alert("connection failed");</script>';
}