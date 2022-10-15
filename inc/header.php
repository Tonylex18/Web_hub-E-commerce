<div id="header">
<div id="logo">
    <a href="index.php"><img src="img/images (4).jpeg"></a>
</div>
<div id="link">
    <ul>
        <li><a href="#">Download App</a></li>
        <li><a href="#">Sign_up</a></li>
        <li><a href="#">Login</a></li>
    </ul>
</div>
<div id="search">
    <form method="get" action="search.php" enctype="multipart/form-data">
        <input type="text" name='user_query' placeholder="search from here...">
        <button name='search' id="search_btn">search</button>
        <button id="cart_btn"><a href='cart.php'>cart <?php echo cart_count(); ?></a></button>
    </form>
</div>
</div>