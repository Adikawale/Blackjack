<?php

$name=$_POST['nm'];# 
// $i=$_POST['userid'];
$Password=$_POST['userpassword'];
$Email=$_POST['address'];

//echo "YOUR ID: $i";
// echo "Password: $p";
// echo "<br>";
// echo "Address: $a"; # cheking the input getting in php or not 
// echo " <br>";
// echo "<br>";

 $connect = mysqli_connect("localhost","root","","blackjackUD");
// if($connect) 
// {
//  echo " connection established";
// }
// else
// {    
//     echo " ERROR NOT CONNECTED";
// } # just  to check the connection between php and data  base to verify the connectionp;

 $query = "INSERT INTO `user_details`( `user_name`, `user_address`, `user_password`) VALUES ('$name','$Email','$Password')";
 $execute = mysqli_query($connect,$query); # to execute the query its function with 2 parameter 1 database,queryname

 # checking the execution of the query

 if($query == true)
 {
     echo "RECORD INSERTED SUCESSFULLY";
 }
 else
 {
     echo "! ERROR RECORD INSERTED UNSUCESSFULLY ! ";
 }

 # to retrieve the data database
 

?>