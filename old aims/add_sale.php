<?php

  $page_title = 'Add Sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
 <?php

  if(isset($_POST['sell_product'])){
    $req_fields = array('s_id','quantity', 'date','r_no' );
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$_POST['s_id']);
          $s_qty     = $db->escape((double)$_POST['quantity']);
          $r_no     = $db->escape($_POST['r_no']);
          $date      = $db->escape($_POST['date']);
          $newDate = date("Y-m-d", strtotime($date));  
         

          $sql  = "INSERT INTO sell (";
          $sql .= " item_id,date,r_no,quantity";
          $sql .= ") VALUES (";
          $sql .= "'{$p_id}','{$newDate}','{$r_no}','{$s_qty}'";
          $sql .= ")";

                if($db->query($sql)){                                        
                  sell_update_product_qty_store($s_qty,$p_id);
                  $session->msg('s',"Sale added. ");
                  redirect('add_sale.php', false);
                } else {
                  $session->msg('d',' Sorry failed to add!');
                  redirect('add_sale.php', false);
                }
        } else {
           $session->msg("d", $errors);
           redirect('add_sale.php',false);
        }
  }

?> 
<?php include_once('layouts/header.php'); ?>
<div class="row">

<div class="col-md-12">
    <div class="alert" style="background-color:#868686">
	            <div class="container">
	            	<h1 style="color:white; text-align:center;"> Add New Sale Information </h1> 
                <br>
	            </div>
	        </div>
</div>




  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form-sell">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Find Item Code</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Search for Item">
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
          <span>Add Sell</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php">
         <table class="table table-bordered">
           <thead>
            <th> Item Code</th>
            <th> Available Qty In Shop </th>
            <th> Color </th>
            <th> Qty </th>
            <th> Reference Number </th>
            <th> Date</th>
            <th> Add Sale</th>
           </thead>
             <tbody  id="product_info"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
