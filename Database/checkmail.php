<?php
# databse connection 
$connect = mysqli_connect("localhost","root","","blackjackUD");

if(isset($_POST['resetbtn']))
{
    $email = $_POST['email'];
    $query = "SELECT * from user_details where user_address = '$email'";
    $chk_email =mysqli_query($connect,$query);
    if(mysqli_num_rows($chk_email)==1)
    {
        echo "Email Verified";
        header('location:resetpass.html?email='.$email);
    }
    else
    {
        echo "<script> 
        alert('Invalid Email');
        location.href='checkmail.html'; 
        </script>";
    }
}
?>
