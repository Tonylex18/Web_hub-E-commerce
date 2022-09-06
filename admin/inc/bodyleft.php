<div id="bodyleft">
    <h3>Content Management</h3>

    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php?viewall_cat">View all Categories</a></li>
        <li><a href="index.php?viewall_sub_cat">View all Sub Categories</a></li>
        <li><a href="index.php?add_product">Add New Product</a></li>
        <li><a href="index.php?view_product">View all Products</a></li>
    </ul>
 </div>

 <?php 
    if (isset($_GET['viewall_cat'])) {
        include("cat.php");
    }

    if (isset($_GET['viewall_sub_cat'])) {
        include("sub_cat.php");
    }

    if (isset($_GET['add_product'])) {
        include("add_product.php");
    }

    if (isset($_GET['view_product'])) {
        include("view_product.php");
    }
 ?>