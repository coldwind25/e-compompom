<?php
include_once"assets/config.php";
session_start();
if(isset($_GET['cart_id'])){

    $del = $_GET['cart_id'];
    $delete=mysqli_query($conn, "DELETE FROM
      cart
    where cart_id='$del'");?>

    <?PHP

      header("location: myCart.php");

}
?>