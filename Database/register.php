<?php

session_start();

$connect = mysqli_connect("localhost","root","","blackjackUD"); # connection to db
// if($connect) 
// {
//  echo " connection established";
// }
// else
// {    
//     echo " ERROR NOT CONNECTED";
// } # just  to check the connection between php and data  base to verify the connectionp;
$n=$_POST['nm'];# name of the user using for the login 
$p=$_POST['userpassword']; # PASSWORD user for the login
$a=$_POST['address'];

$n= mysqli_real_escape_string($connect,$n);# to prevent from sql injection secured form
$p= mysqli_real_escape_string($connect,$p);# to prevent from sql injection secured form
$a= mysqli_real_escape_string($connect,$a);# to prevent from sql injection secured form

 $p = password_hash($p,PASSWORD_BCRYPT);

 $check_email = "SELECT * from user_details WHERE user_address = '$a'";
 $checkusername="SELECT * from user_details WHERE user_name = '$n'";
 $username = mysqli_query($connect,$checkusername);
 $email = mysqli_query($connect,$check_email);

 $nuser = mysqli_num_rows($username);

 $emailcount = mysqli_num_rows($email);
  
$insert = "SELECT * from user_details where user_name = '$n' && user_password = '$p' && user_address = '$a' "; # query to chek the record exist or not in the databse
$result = mysqli_query($connect,$insert) ; 
$check_rows = mysqli_num_rows($result); # check the no of rows in the database

if($emailcount > 0 )
{
    echo "<script> 
    alert('E-mail already exists! Please enter a new E-mail. ')
    location.href='../index.php' 
    </script>"; 
// echo " test if mail exists";
}

elseif ($nuser > 0) 
{ 
    // echo " user name exist";
    echo "<script> 
            alert('Username alredy exist! Please enter a unique Username!);
            location.href='../index.php'; 
            </script>";
    //   //header('location:login.html');
 }

 else

 {

    $insert = " INSERT into user_details(user_name , user_password , user_address) values ('$n' , '$p' , '$a')";
     mysqli_query($connect,$insert); #  
     //echo "Your ID ".$connect-> insert_id;# to show Last inserted ID 
    echo "<script> 
            alert('REGISTERED')
            location.href='../index.php';
            </script>";
        // echo "registerd";    
        //header('location:login.html');
}
?>