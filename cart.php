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
    ?>

    <div class="cart" enctype="multipart/form-data">
        <form method="POST">

            <?php echo cart_display(); ?>
            </table>
        </form>
    </div>

    <?php
    include("inc/footer.php");
    ?>
</body>

</html>