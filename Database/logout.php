<?php
session_start();
session_destroy();
$_SESSION = [];
echo "<script> 
alert('Logout Succesful');
location.href='../index.php'; 
</script>";
?>
