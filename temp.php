<?php
$db_username = "root";
$db_password = "";
$dbname = "assignment";
$servername = "localhost";
$con = mysqli_connect($servername, $db_username, $db_password, $dbname);
// $result=mysqli_query($con,"insert into registration(username,mobile,email,password,cpassword)values('onkar','7986410930','op23singh@Gmail.com','12','12')");
$result=mysqli_query($con,"select * from registration");
$res=mysqli_fetch_array($result);
print_r($res);