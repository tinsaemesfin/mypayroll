<?php
  $page_title = 'Edit product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
$sell = find_by_id('sell',(int)$_GET['sid']);
$product = find_by_id('products',(int)$_GET['prod_id']);

if(!$sell){
  
  $session->msg("d","Missing Sell id");
  redirect('sell.php');
  
}
if(!$product)
{
$session->msg("d","Missing product id ");
redirect('sell.php');
}
?>
<?php
 if(isset($_POST['sell_edit'])){
   $req_fields = array('item_code','r_no','s_date','s_quantity');
    validate_fields($req_fields);

   if(empty($errors)){
        $r_num  = remove_junk($db->escape($_POST['r_no']));
     $p_date   = remove_junk($db->escape($_POST['s_date']));
     $s_date = date("Y-m-d", strtotime($p_date));  
     $s_quantity   = remove_junk($db->escape($_POST['s_quantity']));
    //  $p_sale  = remove_junk($db->escape($_POST['item_color']));
     $updated_qty=(($product['shop_qty']+$sell['quantity'])-$s_quantity);

$query   = "UPDATE sell SET";
       
       $query  .=" date ='{$s_date}', r_no ='{$r_num}',quantity='{$s_quantity}'";
       $query  .=" WHERE id ='{$sell['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                $query2   = "UPDATE products SET";
       
       $query2  .=" shop_qty ='{$updated_qty}'";
       $query2  .=" WHERE id ='{$product['id']}'";
       $result2 = $db->query($query2);
               if($result2 && $db->affected_rows() === 1){
                 $session->msg('s',"Product and Sell updated ");
                 redirect('sell.php', false);
               }
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('sell.php', false);
               }
         

   } else{
       $session->msg("d", $errors);
       redirect('sell.php', false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Edit Sell Information</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_sell.php?sid=<?php echo (int)$sell['id'];?>&prod_id=<?php echo (int)$product['id'];?>">
             <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                     <div class="input-group ">
                        <span class="input-group-addon">
                   Item Code
                  </span>
                  <input type="text" class="form-control" name="item_code" placeholder="Item Code" value="<?php echo remove_junk(ucfirst($product['item_code']));?>" readonly>
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="input-group ">
                        <span class="input-group-addon">
                   Reference Number
                  </span>
                  <input type="text" class="form-control" name="r_no" placeholder="Reference Number" value="<?php echo remove_junk(ucfirst($sell['r_no']));?>" >
                  </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                     <div class="input-group ">
                        <span class="input-group-addon">
                   Date
                  </span>
                  <?php
                  $date_for_value=date("d-m-Y", strtotime($sell['date']));
                  ?>
                  <input type="text" class="datepicker form-control" name="s_date" placeholder="Sold Date" autocomplete="off" value="<?php echo $date_for_value;?>">
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="input-group ">
                        <span class="input-group-addon">
                   Quantity
                  </span>
                  <?php 
                  $tot_max_sell=$sell['quantity']+$product['shop_qty']?>
                  <input type="number" class="form-control" name="s_quantity" min = "0.1" max = "<?php echo $tot_max_sell; ?>" step = "0.01" value="<?php echo ($sell['quantity']); ?>">
                  </div>
                  </div>
                </div>
              </div>
                    

             
              <button type="submit" name="sell_edit" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
