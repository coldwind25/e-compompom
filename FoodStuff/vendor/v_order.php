
<?php include_once "../assets/config.php";
session_start();
if(!isset($_SESSION['vendor'])):
  header("location: ../vendor_login.php");
endif;
?><!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>FoodStuff | online Dairy products available Here</title>
    <link rel="stylesheet" href="..\bootstrap\bootstrap.min.css">
    <link rel = "icon" href = "..\image\ico.gif" type = "image/x-icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">
  </head>

  <body>
    <?php include"header.php"?>

    <div class="container-fluid mt-3">
      <div class="row">
        <div class="col-lg-3">
        <?php include"include/side.php"?>
        </div>

        <div class="col-lg-9">

              <?php

            $log =   $_SESSION['vendor'];

              $calling=mysqli_query($conn, "SELECT * from orders
                INNER JOIN vendor ON  orders.v_email = vendor.v_email where orders.v_email='$log'");

                $count=mysqli_num_rows($calling);
                if($count>0):
                  // $c=0;
                  while($row=mysqli_fetch_array($calling)):

                      // $calling_pro = mysqli_query($conn, "select * from product where p_id='".$row['p_id']."'");
                      $calling_pro = mysqli_query($conn, "SELECT * from orders
                      INNER JOIN product ON  orders.p_id = product.p_id where orders.o_id=".$row['o_id']);
                      $pro_row = mysqli_fetch_array($calling_pro);

                      // echo '<pre>';
                      // print_r($pro_row['o_id']);
                      // echo '<pre>';
                    // $c++;
              ?>

              <table class="table table-bordered text-center">
                <tr>
                  <th>Serial No.</th>
                  <th>Name</th>
                  <th>Action</th>
                  <th>Status</th>
                </tr>

                <tr>

              <td><?= $row['o_id']?></td>
              <td><?= $pro_row["p_name"]?></td>
              <td>
                <a type="button"  href="#vendorProduct<?= $row['o_id'];?>" class="btn btn-success" data-toggle="modal"><i class="fas fa-eye" name="view"></i></a>

                <!--  View Modal -->
                <div class="modal fade" id="vendorProduct<?= $pro_row['o_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable " role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                          <strong >PRODUCTS</strong>
                      </div>
                      <div class="modal-body">
                        <table class="table table-bordered mt-5">
                              <tr>
                                <th>product Id</th>
                                <td><?= $pro_row['o_id']?></td>
                              </tr>
                              <tr>
                                <th>product name</th>
                                <td><?= $pro_row['p_name'];?></td>
                              </tr>
                              <tr>
                                <th>Price</th>
                                  <td>₹<?= $pro_row['p_price'];?>/-</td>
                              </tr>
                              <tr>
                                <th>Manufacturing date</th>
                                  <td><?= $pro_row['p_mfg'];?></td>
                              </tr>

                              <tr>
                                <th>product Category</th>
                                  <td><?= $pro_row['cat_title'];?></td>
                              </tr>
                              <tr>
                                <th>Quantity</th>
                                  <td><?= $pro_row['each_qty'];?></td>
                              </tr>
                              <th>Inserted By</th>
                                <td><?= $row['v_f_name'];?></td>
                              </tr>
                              <tr>

                              <tr>
                                <th>Brand</th>
                                  <td><?= $pro_row['p_brand'];?></td>
                              </tr>
                              <tr>
                                <th>Status</th>
                                  <td> 
                                    <form class="" action="v_order.php?<?=$row['o_id'];?>" method="get">
                                    <input type="hidden" name="o_id" value="<?=$row['o_id'];?>">
                                      <?php
                                      if($row['order_status'] == 'warning'){
                                        $color = '#FF0000';
                                      } elseif($row['order_status'] == 'success') {
                                        $color = '#000000';
                                      }
                                      ?>
                                      <button name="order" type="submit" class="btn btn-link" style="color:<?=$color;?>"><?= $row['order_status'];?></button>
                                      <!-- <a href="#" style="color:#21c416"><?= $row['order_status'];?></a> -->
                                    </form>
                                    </td>
                              </tr>
                              <tr>

                            <u><h5 class="text-center mt-3 mb-4 text-uppercase"><?= $pro_row['p_name']?><span class="text-lowercase">'s complete details here</span></h5></u>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                      </div>
                    </div>
                  </div>
                </div>



              </td>
              <td><?= $row['order_status']?></td>
            </tr>
          <?php
                  
                endwhile;
              else:?>
              <h1>No Order yet</h1>
              <?php
               endif;
              ?>
          </table>
        </div>
      </div>
    </div>
    <?php 
			if(isset($_GET['order'])){
        $update = mysqli_query($conn, "UPDATE orders SET order_status = 'success' WHERE o_id =".$_GET['o_id']);
        echo "<script>window.open('v_order.php','_self')</script>";
        // echo "<script>alert('".$_GET['o_id']."');</script>";

			}
		?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  </body>
</html>
