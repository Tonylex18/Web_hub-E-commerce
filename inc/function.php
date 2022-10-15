<?php
function getIp()
{
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARED_FOR'];
    }

    return $ip;
}

function add_cart()
{
    include("inc/db.php");

    if (isset($_POST['cart_btn'])) {
        $pro_id = $_POST['pro_id'];
        $ip = getIp();

        $check_cart = $con->prepare("select * from cart where pro_id='$pro_id' AND ip_add = '$ip'");
        $check_cart->execute();

        $row_check = $check_cart->rowCount();
        if ($row_check == 1) {
            echo "<script>alert('Cart Already Added To Your List !!!');</script>";
        } else {
            $add_cart = $con->prepare("insert into cart(pro_id,qty,ip_add) values('$pro_id','1','$ip')");
            if ($add_cart->execute()) {
                echo "<script>alert('Cart Added Successfully !!!');</script>";
                echo "<script>window.open('index.php','_self');</script>";
            } else {
                echo "<script>alert('Try Again !!!');</script>";
            }
        }
    }
}

function cart_count()
{
    include("inc/db.php");
    $ip = getIp();

    $get_cart_item = $con->prepare("select * from cart where ip_add = '$ip'");
    $get_cart_item->execute();

    $count_cart = $get_cart_item->rowCount();

    echo $count_cart;
}

function cart_display()
{
    include("inc/db.php");
    $ip = getIp();

    $get_cart_item = $con->prepare("select * from cart where ip_add = '$ip'");
    $get_cart_item->setFetchMode(PDO::FETCH_ASSOC);
    $get_cart_item->execute();
    $cart_empty = $get_cart_item->rowCount();
    $net_total = 0;

    if ($cart_empty == 0) {
        echo "<center><h2>No Product Found In Cart <a href='index.php' id='buy_now'>Continue Shopping</a></h2></center>";
    } else {

        if (isset($_POST['up_qty'])) {
            $quantity = $_POST['qty'];

            foreach ($quantity as $key => $value) {
                $update_qty = $con->prepare("update cart set qty = '$value' where cart_id = '$key'");

                if ($update_qty->execute()) {
                    echo "<script>window.open('cart.php','_self');</script>";
                }
            }
        }

        echo " <table cellspacing='0' cellpadding='0'>
                       <tr>
                           <th>Image</th>
                           <th>Product Name</th>
                           <th>Quantity</th>
                           <th>Price</th>
                           <th>Sub Total</th>
                           <th>Remove</th>
                       </tr>";
        while ($row = $get_cart_item->fetch()) :
            $pro_id = $row['pro_id'];

            $get_pro = $con->prepare("select * from product where pro_id = '$pro_id'");
            $get_pro->setFetchMode(PDO::FETCH_ASSOC);
            $get_pro->execute();
            $row_pro = $get_pro->fetch();
            echo "<tr>
                    <td><img src='img/pro_imgs/" . $row_pro['pro_img1'] . "' style='width: 50px; height: 50px;'></td>
                    <td>" . $row_pro['pro_name'] . "</td>
                    <td>
                    <input type='text' name='qty[" . $row['cart_id'] . "]' value='" . $row['qty'] . "'>
                    <input type='submit' name='up_qty' value='Save'></td>
                    <td>" . $row_pro['pro_price'] . "</td>
                    <td>";
            $qty = $row['qty'];
            $pro_price = $row_pro['pro_price'];
            $sub_total = (int) $pro_price * (int) $qty;
            echo $sub_total;
            $net_total = $net_total + $sub_total;
            echo " </td>
                    <td><a href='delete_cart.php?delete_id=" . $row_pro['pro_id'] . "'>Delete</a></td>
                </tr>";
        endwhile;

        echo "<tr>
                    <td><button id='buy_now'>Continue Shopping</button></td>
                    <td></td>
                    <td><button id='buy_now'>Listing</button></td>
                    <td><b>Net Total =</b></td>
                    <td><b>$net_total</b></td>
                </tr>";
    }
}

function delete_cart_items()
{
    include("inc/db.php");

    if (isset($_GET['delete_id'])) {
        $pro_id = $_GET['delete_id'];

        $delete_cart = $con->prepare("delete from cart where pro_id = '$pro_id'");
        $delete_cart->execute();

        if ($delete_cart) {
            echo "<script>alert('Cart Deleted Succesfully!!!');</script>";
            echo "<script>window.open('cart.php','_self');</script>";
        }
    }
}

    function electronics() {
       include("inc/db.php");
       $fetch_cat = $con -> prepare("select * from main_cat where cat_id = '1' ");
       $fetch_cat -> setFetchMode (PDO:: FETCH_ASSOC);
       $fetch_cat -> execute();
                                                                          
       $row_cat = $fetch_cat -> fetch();
       $cat_id = $row_cat['cat_id'];
       echo"<h3>".$row_cat['cat_name']."</h3>";

       $fetch_pro = $con -> prepare("select * from product where cat_id='$cat_id'");
       $fetch_pro -> setFetchMode (PDO:: FETCH_ASSOC);
       $fetch_pro -> execute();
       
       while ($row_pro = $fetch_pro -> fetch()):
        echo "<li>
                    <form method='post' enctype='multipart/form-data'>
                        <a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>
                            <h4>" . $row_pro['pro_name'] . "</h4>
                            <img src='img/pro_imgs/" . $row_pro['pro_img1'] . "'>
                            <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_pro['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                            </center>
                        </a>
                   </form>
                </li>";
      endwhile;
  }

   function women_wears() {
       include("inc/db.php");
       $fetch_cat = $con -> prepare("select * from main_cat where cat_id = '9' ");
       $fetch_cat -> setFetchMode (PDO:: FETCH_ASSOC);
       $fetch_cat -> execute();
                                                                          
       $row_cat = $fetch_cat -> fetch();
       $cat_id = $row_cat['cat_id'];
       echo"<h3>".$row_cat['cat_name']."</h3>";

       $fetch_pro = $con -> prepare("select * from product where cat_id='$cat_id'");
       $fetch_pro -> setFetchMode (PDO:: FETCH_ASSOC);
       $fetch_pro -> execute();
       
       while ($row_pro = $fetch_pro -> fetch()):
        echo "<li>
                    <form method='post' enctype='multipart/form-data'>
                        <a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>
                            <h4>" . $row_pro['pro_name'] . "</h4>
                            <img src='img/pro_imgs/" . $row_pro['pro_img1'] . "'>
                            <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_pro['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                            </center>
                        </a>
                   </form>
                </li>";
    endwhile;
}

function local_dishes()
{
    include("inc/db.php");
    $fetch_cat = $con->prepare("select * from main_cat where cat_id = '2' ");
    $fetch_cat->setFetchMode(PDO::FETCH_ASSOC);
    $fetch_cat->execute();

    $row_cat = $fetch_cat->fetch();
    $cat_id = $row_cat['cat_id'];
    echo "<h3>" . $row_cat['cat_name'] . "</h3>";

    $fetch_pro = $con->prepare("select * from product where cat_id='$cat_id'");
    $fetch_pro->setFetchMode(PDO::FETCH_ASSOC);
    $fetch_pro->execute();

    while ($row_pro = $fetch_pro->fetch()) :
        echo "<li>
                    <form method='post' enctype='multipart/form-data'>
                        <a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>
                            <h4>" . $row_pro['pro_name'] . "</h4>
                            <img src='img/pro_imgs/" . $row_pro['pro_img1'] . "'>
                            <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_pro['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                            </center>
                        </a>
                   </form>
                </li>";
    endwhile;
}


// function wallclocks()
// {
//     include("inc/db.php");
//     $fetch_cat = $con->prepare("select * from main_cat where cat_id = '3' ");
//     $fetch_cat->setFetchMode(PDO::FETCH_ASSOC);
//     $fetch_cat->execute();

//     $row_cat = $fetch_cat->fetch();
//     $cat_id = $row_cat['cat_id'];
//     echo "<h3>" . $row_cat['cat_name'] . "</h3>";

//     $fetch_pro = $con->prepare("select * from product where cat_id='$cat_id'");
//     $fetch_pro->setFetchMode(PDO::FETCH_ASSOC);
//     $fetch_pro->execute();

//     while ($row_pro = $fetch_pro->fetch()) :
//         echo "<li>
//                     <form method='post' enctype='multipart/form-data'>
//                         <a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>
//                             <h4>" . $row_pro['pro_name'] . "</h4>
//                             <img src='img/pro_imgs/" . $row_pro['pro_img1'] . "'>
//                             <center>
//                                     <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>View</a></button>
//                                     <input type='hidden' value='" . $row_pro['pro_id'] . "' name='pro_id' />
//                                     <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
//                                     <button id='pro_btn'><a href='#'>Wishlist</a></button>
//                             </center>
//                         </a>
//                    </form>
//                 </li>";
//     endwhile;
// }

// function photo_frame()
// {
//     include("inc/db.php");
//     $fetch_cat = $con->prepare("select * from main_cat where cat_id = '5' ");
//     $fetch_cat->setFetchMode(PDO::FETCH_ASSOC);
//     $fetch_cat->execute();

//     $row_cat = $fetch_cat->fetch();
//     $cat_id = $row_cat['cat_id'];
//     echo "<h3>" . $row_cat['cat_name'] . "</h3>";

//     $fetch_pro = $con->prepare("select * from product where cat_id='$cat_id'");
//     $fetch_pro->setFetchMode(PDO::FETCH_ASSOC);
//     $fetch_pro->execute();

//     while ($row_pro = $fetch_pro->fetch()) :
//         echo "<li>
//                     <form method='post' enctype='multipart/form-data'>
//                         <a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>
//                             <h4>" . $row_pro['pro_name'] . "</h4>
//                             <img src='img/pro_imgs/" . $row_pro['pro_img1'] . "'>
//                             <center>
//                                     <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>View</a></button>
//                                     <input type='hidden' value='" . $row_pro['pro_id'] . "' name='pro_id' />
//                                     <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
//                                     <button id='pro_btn'><a href='#'>Wishlist</a></button>
//                             </center>
//                         </a>
//                    </form>
//                 </li>";
//     endwhile;
// }

// function articles()
// {
//     include("inc/db.php");
//     $fetch_cat = $con->prepare("select * from main_cat where cat_id = '6' ");
//     $fetch_cat->setFetchMode(PDO::FETCH_ASSOC);
//     $fetch_cat->execute();

//     $row_cat = $fetch_cat->fetch();
//     $cat_id = $row_cat['cat_id'];
//     echo "<h3>" . $row_cat['cat_name'] . "</h3>";

//     $fetch_pro = $con->prepare("select * from product where cat_id='$cat_id'");
//     $fetch_pro->setFetchMode(PDO::FETCH_ASSOC);
//     $fetch_pro->execute();

//     while ($row_pro = $fetch_pro->fetch()) :
//         echo "<li>
//                     <form method='post' enctype='multipart/form-data'>
//                         <a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>
//                             <h4>" . $row_pro['pro_name'] . "</h4>
//                             <img src='img/pro_imgs/" . $row_pro['pro_img1'] . "'>
//                             <center>
//                                     <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>View</a></button>
//                                     <input type='hidden' value='" . $row_pro['pro_id'] . "' name='pro_id' />
//                                     <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
//                                     <button id='pro_btn'><a href='#'>Wishlist</a></button>
//                             </center>
//                         </a>
//                    </form>
//                 </li>";
//     endwhile;
// }

// function showpiece()
// {
//     include("inc/db.php");
//     $fetch_cat = $con->prepare("select * from main_cat where cat_id = '8' ");
//     $fetch_cat->setFetchMode(PDO::FETCH_ASSOC);
//     $fetch_cat->execute();

//     $row_cat = $fetch_cat->fetch();
//     $cat_id = $row_cat['cat_id'];
//     echo "<h3>" . $row_cat['cat_name'] . "</h3>";

//     $fetch_pro = $con->prepare("select * from product where cat_id='$cat_id'");
//     $fetch_pro->setFetchMode(PDO::FETCH_ASSOC);
//     $fetch_pro->execute();

//     while ($row_pro = $fetch_pro->fetch()) :
//         echo "<li>
//                     <form method='post' enctype='multipart/form-data'>
//                         <a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>
//                             <h4>" . $row_pro['pro_name'] . "</h4>
//                             <img src='img/pro_imgs/" . $row_pro['pro_img1'] . "'>
//                             <center>
//                                     <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>View</a></button>
//                                     <input type='hidden' value='" . $row_pro['pro_id'] . "' name='pro_id' />
//                                     <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
//                                     <button id='pro_btn'><a href='#'>Wishlist</a></button>
//                             </center>
//                         </a>
//                    </form>
//                 </li>";
//     endwhile;
// }

function men_wears()
{
    include("inc/db.php");
    $fetch_cat = $con->prepare("select * from main_cat where cat_id = '10' ");
    $fetch_cat->setFetchMode(PDO::FETCH_ASSOC);
    $fetch_cat->execute();

    $row_cat = $fetch_cat->fetch();
    $cat_id = $row_cat['cat_id'];
    echo "<h3>" . $row_cat['cat_name'] . "</h3>";

    $fetch_pro = $con->prepare("select * from product where cat_id='$cat_id'");
    $fetch_pro->setFetchMode(PDO::FETCH_ASSOC);
    $fetch_pro->execute();

    while ($row_pro = $fetch_pro->fetch()) :
        echo "<li>
                    <form method='post' enctype='multipart/form-data'>
                        <a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>
                            <h4>" . $row_pro['pro_name'] . "</h4>
                            <img src='img/pro_imgs/" . $row_pro['pro_img1'] . "'>
                            <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_pro['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                            </center>
                        </a>
                   </form>
                </li>";
    endwhile;
}

function cards()
{
    include("inc/db.php");
    $fetch_cat = $con->prepare("select * from main_cat where cat_id = '12' ");
    $fetch_cat->setFetchMode(PDO::FETCH_ASSOC);
    $fetch_cat->execute();

    $row_cat = $fetch_cat->fetch();
    $cat_id = $row_cat['cat_id'];
    echo "<h3>" . $row_cat['cat_name'] . "</h3>";

    $fetch_pro = $con->prepare("select * from product where cat_id='$cat_id'");
    $fetch_pro->setFetchMode(PDO::FETCH_ASSOC);
    $fetch_pro->execute();

    while ($row_pro = $fetch_pro->fetch()) :
        echo "<li>
                    <form method='post' enctype='multipart/form-data'>
                        <a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>
                            <h4>" . $row_pro['pro_name'] . "</h4>
                            <img src='img/pro_imgs/" . $row_pro['pro_img1'] . "'>
                            <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_pro['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_pro['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                            </center>
                        </a>
                   </form>
                </li>";
    endwhile;
}

  function pro_details(){
       include("inc/db.php");
       
       if(isset($_GET['pro_id'])) {
           $pro_id = $_GET['pro_id'];

           $fetch_pro = $con -> prepare("select * from product where pro_id='$pro_id'");
           $fetch_pro -> setFetchMode(PDO:: FETCH_ASSOC);
           $fetch_pro -> execute();

           $row_pro = $fetch_pro -> fetch();
           $cat_id =  $row_pro['cat_id'];

           echo"<div id='pro_img'>
                  <img src='img/pro_imgs/".$row_pro['pro_img1']."'  />
                  <ul>
                    <li><img src='img/pro_imgs/".$row_pro['pro_img1']."'  /></li>
                    <li><img src='img/pro_imgs/".$row_pro['pro_img2']."'  /></li>
                    <li><img src='img/pro_imgs/".$row_pro['pro_img3']."'  /></li>
                    <li><img src='img/pro_imgs/".$row_pro['pro_img4']."'  /></li>
                  </ul>
                </div>
                <div id='pro_feature'>
                    <h3>".$row_pro['pro_name']."</h3>
                    <ul>
                        <li>".$row_pro['pro_feature1']."</li>
                        <li>".$row_pro['pro_feature2']."</li>
                        <li>".$row_pro['pro_feature3']."</li>
                        <li>".$row_pro['pro_feature4']."</li>
                        <li>".$row_pro['pro_feature5']."</li>
                    </ul>

                    <ul>
                        <li>Model No. : ".$row_pro['pro_model']."</li>
                        <li>Warranty : ".$row_pro['pro_warranty']."</li>
                    </ul><br clear='all'>
                    <center>
                        <h4>Selling Price : ".$row_pro['pro_price']."</h4>
                        <form>
                            <button name='Buy Now'>Buy Now</button>
                            <button name='Cart'>Add To Cart</button>
                        </form>
                    </center>
                </div><br clear='all'>
                <div id='sim_pro'>
                    <h4>Related Products</h4>
                    <ul>";
                        $sim_pro = $con -> prepare("select * from product where cat_id='$cat_id'");
                        $sim_pro -> setFetchMode (PDO:: FETCH_ASSOC);
                        $sim_pro -> execute();

                        while($row = $sim_pro -> fetch()):
                            echo"<li>
                                    <a href='pro_detail.php?pro_id=".$row['pro_id']."'>
                                        <img src='img/pro_imgs/".$row['pro_img1']."'>
                                        <p>".$row['pro_name']."</p>
                                        <p>Price : ".$row['pro_price']."</p>
                                    </a>
                                </li>";
                        endwhile;
                   echo" </ul>
                </div>";
       }
       
  }

  /* ---------display category from navbar------------  */

  function all_cat() {
        include("inc/db.php");

        $all_cat = $con -> prepare("select * from main_cat");
        $all_cat -> setFetchMode (PDO:: FETCH_ASSOC);
        $all_cat -> execute();

        while($row = $all_cat -> fetch()): 
            echo"<li><a href='cat_detail.php?cat_id=".$row['cat_id']."'>".$row['cat_name']."</a></li>";
        endwhile;

  }

  function cat_detail() {
    include("inc/db.php");

    if(isset($_GET['cat_id'])) {
        $cat_id = $_GET['cat_id'];
        $cat_pro = $con -> prepare ("select * from product where cat_id='$cat_id'");
        $cat_pro -> setFetchMode(PDO:: FETCH_ASSOC);
        $cat_pro -> execute();

        $cat_name = $con -> prepare ("select * from main_cat where cat_id='$cat_id'");
        $cat_name -> setFetchMode(PDO:: FETCH_ASSOC);
        $cat_name -> execute();

        $row = $cat_name -> fetch();
        $row_main_cat = $row['cat_name'];
        echo"<h3>$row_main_cat</h3>";

         while ($row_cat = $cat_pro -> fetch()):
            echo "<li>
                    <form method='post' enctype='multipart/form-data'>
                        <a href='pro_detail.php?pro_id=" . $row_cat['pro_id'] . "'>
                            <h4>" . $row_cat['pro_name'] . "</h4>
                            <img src='img/pro_imgs/" . $row_cat['pro_img1'] . "'>
                            <center>
                                <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_cat['pro_id'] . "'>View</a></button>
                                <input type='hidden' value='" . $row_cat['pro_id'] . "' name='pro_id' />
                                <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                <button id='pro_btn'><a href='#'>Wishlist</a></button>
                            </center>
                        </a>
                    </form>
                </li>";
         endwhile;
    }
  }

  function viewall_sub_cat() {
    include("inc/db.php");

    if(isset($_GET['cat_id'])) {
        $cat_id = $_GET['cat_id'];

        $sub_cat = $con -> prepare("select * from sub_cat where cat_id = '$cat_id'");
        $sub_cat -> setFetchMode(PDO:: FETCH_ASSOC);
        $sub_cat -> execute();
        
        echo"<h2>Sub_Categories</h2>";
        while($row = $sub_cat -> fetch()): 
            echo"<li><a href='cat_detail.php?sub_cat_id=".$row['sub_cat_id']."'>".$row['sub_cat_name']."</a></li>";
        endwhile;
    }
  }

    function sub_cat_detail() {
    include("inc/db.php");

    if(isset($_GET['sub_cat_id'])) {
        $sub_cat_id = $_GET['sub_cat_id'];
        $sub_cat_pro = $con -> prepare ("select * from product where sub_cat_id='$sub_cat_id'");
        $sub_cat_pro -> setFetchMode(PDO:: FETCH_ASSOC);
        $sub_cat_pro -> execute();

        $sub_cat_name = $con -> prepare ("select * from sub_cat where sub_cat_id='$sub_cat_id'");
        $sub_cat_name -> setFetchMode(PDO:: FETCH_ASSOC);
        $sub_cat_name -> execute();

        $row = $sub_cat_name -> fetch();
        $row_sub_cat = $row['sub_cat_name'];
        echo"<h3>$row_sub_cat</h3>";

         while ($row_sub_cat = $sub_cat_pro -> fetch()):
            echo "<li>
                    <form method='post' enctype='multipart/form-data'>
                        <a href='pro_detail.php?pro_id=" . $row_sub_cat['pro_id'] . "'>
                            <h4>" . $row_sub_cat['pro_name'] . "</h4>
                            <img src='img/pro_imgs/" . $row_sub_cat['pro_img1'] . "'>
                            <center>
                                <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_sub_cat['pro_id'] . "'>View</a></button>
                                <input type='hidden' value='" . $row_sub_cat['pro_id'] . "' name='pro_id' />
                                <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                <button id='pro_btn'><a href='#'>Wishlist</a></button>
                            </center>
                        </a>
                    </form>
                </li>";
         endwhile;
    }
  }

    function viewall_cat() {
    include("inc/db.php");

    if(isset($_GET['sub_cat_id'])) {

        $main_cat = $con -> prepare("select * from main_cat");
        $main_cat -> setFetchMode(PDO:: FETCH_ASSOC);
        $main_cat -> execute();

        echo"<h2>Categories</h2>";
        while($row = $main_cat -> fetch()): 
            echo"<li><a href='cat_detail.php?cat_id=".$row['cat_id']."'>".$row['cat_name']."</a></li>";
        endwhile;
    }
  }

function bd_men()
{
    include("inc/db.php");

    if (isset($_GET['bd_men'])) {
        $fetch_pro = $con->prepare("select * from product where for_whome='men' ");
        $fetch_pro->setFetchMode(PDO::FETCH_ASSOC);
        $fetch_pro->execute();

        echo "<h3>Birthday Gifts For Men</h3>";
        while ($row_men = $fetch_pro->fetch()) :
            echo "<li>
                    <form method='post' enctype='multipart/form-data'>
                        <a href='pro_detail.php?pro_id=" . $row_men['pro_id'] . "'>
                            <h4>" . $row_men['pro_name'] . "</h4>
                            <img src='img/pro_imgs/" . $row_men['pro_img1'] . "'>
                            <center>
                                <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_men['pro_id'] . "'>View</a></button>
                                <input type='hidden' value='" . $row_men['pro_id'] . "' name='pro_id' />
                                <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                <button id='pro_btn'><a href='#'>Wishlist</a></button>
                            </center>
                        </a>
                    </form>
                </li>";
        endwhile;
    }
}

function bd_women()
{
    include("inc/db.php");

    if (isset($_GET['bd_women'])) {
        $fetch_pro = $con->prepare("select * from product where for_whome='women' ");
        $fetch_pro->setFetchMode(PDO::FETCH_ASSOC);
        $fetch_pro->execute();

        echo "<h3>Birthday Gifts For Women</h3>";
        while ($row_women = $fetch_pro->fetch()) :
            echo "<li>
                    <form method='post' enctype='multipart/form-data'>
                        <a href='pro_detail.php?pro_id=" . $row_women['pro_id'] . "'>
                            <h4>" . $row_women['pro_name'] . "</h4>
                            <img src='img/pro_imgs/" . $row_women['pro_img1'] . "'>
                            <center>
                                <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_women['pro_id'] . "'>View</a></button>
                                <input type='hidden' value='" . $row_women['pro_id'] . "' name='pro_id' />
                                <button id='pro_btn' name='cart_btn' class='cart_btn'><Cart</button>
                                <button id='pro_btn'><a href='#'>Wishlist</a></button>
                            </center>
                        </a>
                    </form>
                </li>";
        endwhile;
    }
}

function bd_kids()
{
    include("inc/db.php");

    if (isset($_GET['bd_kids'])) {
        $fetch_pro = $con->prepare("select * from product where for_whome='kids' ");
        $fetch_pro->setFetchMode(PDO::FETCH_ASSOC);
        $fetch_pro->execute();

        echo "<h3>Birthday Gifts For Kids</h3>";
        while ($row_kids = $fetch_pro->fetch()) :
            echo "<li>
                        <form method='post' enctype='multipart/form-data'>
                            <a href='pro_detail.php?pro_id=" . $row_kids['pro_id'] . "'>
                                <h4>" . $row_kids['pro_name'] . "</h4>
                                <img src='img/pro_imgs/" . $row_kids['pro_img1'] . "'>
                                <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_kids['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_kids['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                </center>
                            </a>
                        </form>
                    </li>";
        endwhile;
    }
}

function about_men()
{
    include("inc/db.php");

    if (isset($_GET['men_watch'])) {
        $men_watch = "watch";

        $watch = $con->prepare("select * from product where for_whome='men' and pro_name like '%$men_watch%'");
        $watch->setFetchMode(PDO::FETCH_ASSOC);
        $watch->execute();

        echo "<h3>Watches For Men</h3>";
        while ($row_men = $watch->fetch()) :
            echo "<li>
                        <form method='post' enctype='multipart/form-data'>
                            <a href='pro_detail.php?pro_id=" . $row_men['pro_id'] . "'>
                                <h4>" . $row_men['pro_name'] . "</h4>
                                <img src='img/pro_imgs/" . $row_men['pro_img1'] . "'>
                                <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_men['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_men['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                </center>
                            </a>
                        </form>
                    </li>";
        endwhile;
    }

    if (isset($_GET['men_belt'])) {
        $men_belt = "belt";

        $belt = $con->prepare("select * from product where for_whome='men' and pro_name like '%$men_belt%' or pro_keyword like '%$men_belt%'");
        $belt->setFetchMode(PDO::FETCH_ASSOC);
        $belt->execute();

        echo "<h3>Belts For Men</h3>";
        while ($row_men = $belt->fetch()) :
            echo "<li>
                       <form method='post' enctype='multipart/form-data'>
                            <a href='pro_detail.php?pro_id=" . $row_men['pro_id'] . "'>
                                <h4>" . $row_men['pro_name'] . "</h4>
                                <img src='img/pro_imgs/" . $row_men['pro_img1'] . "'>
                                <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_men['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_men['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                </center>
                            </a>
                        </form>
                    </li>";
        endwhile;
    }

    if (isset($_GET['men_perfume'])) {
        $men_perfume = "belt";

        $perfume = $con->prepare("select * from product where for_whome='men' and pro_name like '%$men_perfume%' or pro_keyword like '%$men_perfume%'");
        $perfume->setFetchMode(PDO::FETCH_ASSOC);
        $perfume->execute();

        echo "<h3>Perfumes For Men</h3>";
        while ($row_men = $perfume->fetch()) :
            echo "<li>
                        <form method='post' enctype='multipart/form-data'>
                            <a href='pro_detail.php?pro_id=" . $row_men['pro_id'] . "'>
                                <h4>" . $row_men['pro_name'] . "</h4>
                                <img src='img/pro_imgs/" . $row_men['pro_img1'] . "'>
                                <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_men['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_men['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                </center>
                            </a>
                        </form>
                    </li>";
        endwhile;
    }
}

function about_women()
{
    include("inc/db.php");

    if (isset($_GET['women_watch'])) {
        $women_watch = "watch";

        $watch = $con->prepare("select * from product where for_whome='men' and pro_name like '%$women_watch%' or pro_keyword like '%$women_watch%'");
        $watch->setFetchMode(PDO::FETCH_ASSOC);
        $watch->execute();

        echo "<h3>Watches For Women</h3>";
        while ($row_women = $watch->fetch()) :
            echo "<li>
                        <form method='post' enctype='multipart/form-data'>
                            <a href='pro_detail.php?pro_id=" . $row_women['pro_id'] . "'>
                                <h4>" . $row_women['pro_name'] . "</h4>
                                <img src='img/pro_imgs/" . $row_women['pro_img1'] . "'>
                                <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_women['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_men['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                </center>
                            </a>
                        </form>
                    </li>";
        endwhile;
    }

    if (isset($_GET['women_belt'])) {
        $women_belt = "belt";

        $belt = $con->prepare("select * from product where for_whome='men' and pro_name like '%$women_belt%' or pro_keyword like '%$women_belt%'");
        $belt->setFetchMode(PDO::FETCH_ASSOC);
        $belt->execute();

        echo "<h3>Belts For Women</h3>";
        while ($row_women = $belt->fetch()) :
            echo "<li>
                         <form method='post' enctype='multipart/form-data'>
                            <a href='pro_detail.php?pro_id=" . $row_women['pro_id'] . "'>
                                <h4>" . $row_women['pro_name'] . "</h4>
                                <img src='img/pro_imgs/" . $row_women['pro_img1'] . "'>
                                <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_women['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_women['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                </center>
                            </a>
                        </form>
                    </li>";
        endwhile;
    }

    if (isset($_GET['women_perfume'])) {
        $women_perfume = "perfume";

        $perfume = $con->prepare("select * from product where for_whome='men' and pro_name like '%$women_perfume%' or pro_keyword like '%$women_perfume%'");
        $perfume->setFetchMode(PDO::FETCH_ASSOC);
        $perfume->execute();

        echo "<h3>Perfumes For Women</h3>";
        while ($row_women = $perfume->fetch()) :
            echo "<li>
                         <form method='post' enctype='multipart/form-data'>
                            <a href='pro_detail.php?pro_id=" . $row_women['pro_id'] . "'>
                                <h4>" . $row_women['pro_name'] . "</h4>
                                <img src='img/pro_imgs/" . $row_women['pro_img1'] . "'>
                                <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_women['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_women['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                </center>
                            </a>
                        </form>
                    </li>";
        endwhile;
    }
}

function about_kids()
{
    include("inc/db.php");

    if (isset($_GET['kid_toys'])) {
        $kid_toys = "toys";

        $toys = $con->prepare("select * from product where for_whome='men' and pro_name like '%$kid_toys%'");
        $toys->setFetchMode(PDO::FETCH_ASSOC);
        $toys->execute();

        echo "<h3>Toys For Kids</h3>";
        while ($row_kids = $toys->fetch()) :
            echo "<li>
                         <form method='post' enctype='multipart/form-data'>
                            <a href='pro_detail.php?pro_id=" . $row_kids['pro_id'] . "'>
                                <h4>" . $row_kids['pro_name'] . "</h4>
                                <img src='img/pro_imgs/" . $row_kids['pro_img1'] . "'>
                                <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_kids['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_kids['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                </center>
                            </a>
                        </form>
                    </li>";
        endwhile;
    }

    if (isset($_GET['kid_games'])) {
        $kid_games = "games";

        $games = $con->prepare("select * from product where for_whome='men' and pro_name like '%$kid_games%'");
        $games->setFetchMode(PDO::FETCH_ASSOC);
        $games->execute();

        echo "<h3>Games For Kids</h3>";
        while ($row_kids = $games->fetch()) :
            echo "<li>
                        <form method='post' enctype='multipart/form-data'>
                            <a href='pro_detail.php?pro_id=" . $row_kids['pro_id'] . "'>
                                <h4>" . $row_kids['pro_name'] . "</h4>
                                <img src='img/pro_imgs/" . $row_kids['pro_img1'] . "'>
                                <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_kids['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_kids['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                </center>
                            </a>
                        </form>
                    </li>";
        endwhile;
    }

    if (isset($_GET['kid_books'])) {
        $kid_books = "books";

        $books = $con->prepare("select * from product where for_whome='men' and pro_name like '%$kid_books%'");
        $books->setFetchMode(PDO::FETCH_ASSOC);
        $books->execute();

        echo "<h3>Books For Kids</h3>";
        while ($row_kids = $books->fetch()) :
            echo "<li>
                         <form method='post' enctype='multipart/form-data'>
                            <a href='pro_detail.php?pro_id=" . $row_kids['pro_id'] . "'>
                                <h4>" . $row_kids['pro_name'] . "</h4>
                                <img src='img/pro_imgs/" . $row_kids['pro_img1'] . "'>
                                <center>
                                    <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row_kids['pro_id'] . "'>View</a></button>
                                    <input type='hidden' value='" . $row_kids['pro_id'] . "' name='pro_id' />
                                    <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                    <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                </center>
                            </a>
                        </form>
                    </li>";
        endwhile;
    }
}

function search()
{
    include("inc/db.php");

    if (isset($_GET['search'])) {
        $user_query = $_GET['user_query'];

        $search = $con->prepare("select * from product where pro_name like '%$user_query%' or pro_keyword like '%$user_query%'");
        $search->setFetchMode(PDO::FETCH_ASSOC);
        $search->execute();

        echo "<div id='body_left'><ul>";
        if ($search->rowCount() == 0) {
            echo "<h3>Product Not Found With The Related Keyword</h3>";
        } else {
            echo "<h3>Related Search</h3>";
            while ($row = $search->fetch()) :
                echo "<li>
                            <form method='post' enctype='multipart/form-data'>
                                <a href='pro_detail.php?pro_id=" . $row['pro_id'] . "'>
                                    <h4>" . $row['pro_name'] . "</h4>
                                    <img src='img/pro_imgs/" . $row['pro_img1'] . "'>
                                    <center>
                                        <button id='pro_btn'><a href='pro_detail.php?pro_id=" . $row['pro_id'] . "'>View</a></button>
                                        <input type='hidden' value='" . $row['pro_id'] . "' name='pro_id' />
                                        <button id='pro_btn' name='cart_btn' class='cart_btn'>Cart</button>
                                        <button id='pro_btn'><a href='#'>Wishlist</a></button>
                                    </center>
                                </a>
                            </form>
                        </li>";
            endwhile;
        }
        echo "</ul></div>";
    }
}                                                                                                           
?>
