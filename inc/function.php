<?php 
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
           echo"<li>
                   <a href='pro_detail.php?pro_id=".$row_pro['pro_id']."'>
                       <h4>".$row_pro['pro_name']."</h4>
                       <img src='img/pro_imgs/".$row_pro['pro_img1']."'>
                       <center>
                              <button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_pro['pro_id']."'>View</a></button>
                              <button id='pro_btn'><a href='#'>Cart</a></button>
                              <button id='pro_btn'><a href='#'>Wishlist</a></button>
                       </center>
                   </a>
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
           echo"<li>
                   <a href='pro_detail.php?pro_id=".$row_pro['pro_id']."'>
                       <h4>".$row_pro['pro_name']."</h4>
                       <img src='img/pro_imgs/".$row_pro['pro_img1']."'>
                       <center>
                              <button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_pro['pro_id']."'>View</a></button>
                              <button id='pro_btn'><a href='#'>Cart</a></button>
                              <button id='pro_btn'><a href='#'>Wishlist</a></button>
                       </center>
                   </a>
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
           echo"<li>
                    <a href='pro_detail.php?pro_id=".$row_cat['pro_id']."'>
                        <h4>".$row_cat['pro_name']."</h4>
                        <img src='img/pro_imgs/".$row_cat['pro_img1']."'>
                        <center>
                            <button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_cat['pro_id']."'>View</a></button>
                            <button id='pro_btn'><a href='#'>Cart</a></button>
                            <button id='pro_btn'><a href='#'>Wishlist</a></button>
                        </center>
                    </a>
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
           echo"<li>
                    <a href='pro_detail.php?pro_id=".$row_sub_cat['pro_id']."'>
                        <h4>".$row_sub_cat['pro_name']."</h4>
                        <img src='img/pro_imgs/".$row_sub_cat['pro_img1']."'>
                        <center>
                            <button id='pro_btn'><a href='pro_detail.php?pro_id=".$row_sub_cat['pro_id']."'>View</a></button>
                            <button id='pro_btn'><a href='#'>Cart</a></button>
                            <button id='pro_btn'><a href='#'>Wishlist</a></button>
                        </center>
                    </a>
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

                                                                 
?>
