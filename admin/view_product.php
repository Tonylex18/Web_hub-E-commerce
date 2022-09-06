<div class="scroll" id="bodyright">
    <h3>View products From Here</h3>
    <form method="post" enctype="multipart/form-data">
        <table cellspacing="10";>
             <tr>
                <th>Sr No.</th>
                <th>Edit </th>
                <th>Delete </th>
                <th>Product Name</th>
                <th>Products Imgs</th>
                <th>Feature 1</th>
                <th>Feature 2</th>
                <th>Feature 3</th>
                <th>Feature 4</th>
                <th>Feature 5</th>
                <th>Price</th>
                <th>Model No</th>
                <th>Warranty</th>
                <th>Keywords</th>
                <th>Added Date</th>
            </tr>
            <?php include("inc/function.php"); echo view_product (); ?>
        </table>
    </form>
</div>