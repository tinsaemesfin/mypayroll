<?php
  $page_title = 'SAMPLE PRODUCT';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<!-- <?php

  if(isset($_POST['sample_product_po'])){
    $req_fields = array('s_id','quantity', 'date','r_no' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$_POST['s_id']);
          $s_qty     = $db->escape((double)$_POST['quantity']);
        
          $date      = $db->escape($_POST['date']);
           $newDate = date("Y-m-d", strtotime($date));  
          $s_date    = make_date();
          $r_no=$db->escape($_POST['r_no']);

          $sql  = "INSERT INTO sample (";
          $sql .= " item_id,date,qty,r_no";
          $sql .= ") VALUES (";
          $sql .= "'{$p_id}','{$newDate}','{$s_qty}','{$r_no}'";
          $sql .= ")";

                if($db->query($sql)){                                        
                    sell_update_product_qty_store($s_qty,$p_id);
                  $session->msg('s',"Sample Quantity Decrease Succesfully . ");
                  redirect('sample_product.php', false);
                } else {
                  $session->msg('d',' Sorry failed to take Samples!');
                  redirect('sample_product.php', false);
                }
        } else {
           $session->msg("d", $errors);
           redirect('sample_product.php',false);
        }
  }

?> -->
<?php include_once('layouts/header.php'); ?>
<div class="row">


<div class="col-md-12">
    <div class="alert" style="background-color:#0008FF">
	            <div class="container">
	            	<h1 style="color:white; text-align:center;"> Sample Quantities of Products From Store  </h1> 
                <br>
	            </div>
	        </div>
</div>




    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
        <form method="post" action="ajax.php" autocomplete="off" id="sug-form-sample">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Find Item</button>
                    </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Search for product name">

                </div>
                <div id="result" class="list-group"></div>
            </div>
        </form>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Sample Product</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="sample_product.php">
                    <table class="table table-bordered">
                        <thead>
                            <th> Item Code</th>
                            <th> Shop Qty</th>
                            <th> Quantity </th>
                            <th> Reference Number </th>
                            <th> Date</th>
                            <th> Action</th>
                        </thead>
                        <tbody id="product_info"> </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include_once('layouts/footer.php'); ?>