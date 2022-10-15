<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/main.css">

    <title>Online Store</title>
</head>

<body>
    <?php
    include("inc/function.php");
    include("inc/header.php");
    include("inc/navbar.php");
    echo "<div id='body_left'><ul>";
    cat_detail();
    sub_cat_detail();
    bd_men();
    bd_women();
    bd_kids();
    about_men();
    about_women();
    about_kids();
    echo "</ul></div>";
    if (isset($_GET['cat_id']) or isset($_GET['sub_cat_id'])) {
        echo "<div id='body_right'>
                <ul>";
        viewall_sub_cat();
        viewall_cat();
        echo "</ul>
            </div><br clear='all'>";
    } else {
        include("inc/bodyright.php");
    }
    include("inc/footer.php");
    ?>
</body>

</html>