<?php
$page_title = 'Add Product';
require_once 'includes/load.php';
// Checkin What level user has permission to view this page
page_require_level(1);
$all_categories = find_all('category');

?>
<?php
if (isset($_POST['add_product'])) {

    $req_fields = array('item_code', 'item_category', 'item_desc', 'date');
    validate_fields($req_fields);
    if (empty($errors)) {
        $p_code = remove_junk($db->escape($_POST['item_code']));
        $p_cat = remove_junk($db->escape($_POST['item_category']));
        $p_dec = remove_junk($db->escape($_POST['item_desc']));

        //  $p_sale  = remove_junk($db->escape($_POST['item_color']));
        if (is_null($_POST['item_color']) || $_POST['item_color'] === "") {
            $p_color = '';
        } else {
            $p_color = remove_junk($db->escape($_POST['item_color']));
        }
        $stored = 0;
        $shop = 0;
        $date_temp = remove_junk($db->escape($_POST['date']));
        $date = date("Y-m-d", strtotime($date_temp));
        $query = "INSERT INTO products (";
        $query .= " item_code, description, category,color, date, store_qty,shop_qty";
        $query .= " ) VALUES (";
        $query .= " '{$p_code}', '{$p_dec}', '{$p_cat}', '{$p_color}', '{$date}', '{$stored}', '{$shop}' ";
        $query .= ")";
        //  $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
        if ($db->query_add_product($query)) {
            $session->msg('s', "Product added ");
            redirect('add_product.php', false);
        } else {
            $session->msg('d', ' Sorry failed to add . same item code exist!');

            redirect('add_product.php', false);
        }

    } else {
        $session->msg("d", $errors);
        redirect('add_product.php', false);
    }

}

?>
<?php include_once 'layouts/header.php';?>
<div class="row">

<div class="col-md-12">
    <div class="alert" style="background-color:#FF7857">
	            <div class="container">
	            	<h1 style="color:white; text-align:center;">Create New Product</h1> 
                <br>
	            </div>
	        </div>
</div>


    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Add New Product</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="post" action="add_product.php" class="clearfix">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group ">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-th-large"></i>
                                        </span>
                                        <input type="text" class="form-control" name="item_code"
                                            placeholder="Item Code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="item_category">
                                        <option value="">Select Item Category</option>
                                        <?php foreach ($all_categories as $photo): ?>
                                        <option value="<?php echo (int) $photo['id'] ?>">
                                            <?php echo $photo['name'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>




                        <div class="form-group">
                            <div class="input-group ">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-list-alt"></i>
                                </span>
                                <input type="text" class="form-control" name="item_desc" placeholder="Item Descripion ">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-asterisk"></i>
                                        </span>
                                        <input type="text" class="form-control" name="item_color" placeholder="Color">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                        </span>
                                        <input type="text" class="datepicker form-control" name="date"
                                            placeholder="Date" autocomplete="off">

                                    </div>
                                </div>

                            </div>
                        </div>

                        <button type="submit" name="add_product" class="btn btn-danger">Add product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'layouts/footer.php';?>