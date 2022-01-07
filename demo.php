<?php
    $con=mysqli_connect("localhost","root","","ecommerce1") or die(mysqli_error($con));
    $query="select * from users";
   $result=mysqli_query($con,$query)or die(mysqli_error($con));
   $result_array=mysqli_fetch_array($result);
   echo "<pre>";
   print_r($result_array);
   echo "</pre>";