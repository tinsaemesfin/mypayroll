<?php
  $page_title = 'Edit product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
$sell = find_by_id('purchase',(int)$_GET['sid']);
$product = find_by_id('products',(int)$_GET['prod_id']);

if(!$sell){
  
  $session->msg("d","Missing Purchase id");
  redirect('purchase.php');
  
}
if(!$product)
{
$session->msg("d","Missing product id ");
redirect('product.php');
}
?>
<?php
 if(isset($_POST['sell_editt'])){
   $req_fields = array('item_code','r_no','s_date','s_quantity','cost');
    validate_fields($req_fields);

   if(empty($errors)){
        $r_num  = remove_junk($db->escape($_POST['r_no']));
     $p_date   = remove_junk($db->escape($_POST['s_date']));
     $s_date = date("Y-m-d", strtotime($p_date));  
     $s_quantity   = remove_junk($db->escape($_POST['s_quantity']));
     $s_cost   = remove_junk($db->escape($_POST['cost']));
    //  $p_sale  = remove_junk($db->escape($_POST['item_color']));
     $updated_qty=(($s_quantity+$product['store_qty'])-$sell['qty']);

$query   = "UPDATE purchase SET";
       
       $query  .=" date ='{$s_date}', r_no ='{$r_num}',qty='{$s_quantity}',cost='{$s_cost}'";
       $query  .=" WHERE id ='{$sell['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                $query2   = "UPDATE products SET";
       
       $query2  .=" store_qty ='{$updated_qty}'";
       $query2  .=" WHERE id ='{$product['id']}'";
       $result2 = $db->query($query2);
               if($result2 && $db->affected_rows() === 1){
                 $session->msg('s',"Product and Purchase updated ");
                 redirect('purchase.php', false);
               }
               else{
                $session->msg('s',"Purchase updated");
                redirect('purchase.php', false);
               }
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('purchase.php', false);
               }
         

   } else{
       $session->msg("d", $errors);
       redirect('purchase.php', false);
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
            <span>Edit Purchase Information</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_purchase.php?sid=<?php echo (int)$sell['id'];?>&prod_id=<?php echo (int)$product['id'];?>">
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
                  $tot_max_sell=$sell['qty']+$product['shop_qty']?>
                  <input type="number" class="form-control" name="s_quantity" min = "0.0"  step = "0.01" value="<?php echo ($sell['qty']); ?>">
                  </div>
                  </div>
                </div>
              </div>



              <div class="form-group">
                <div class="row">
                <div class="col-md-6">
                  <div class="input-group ">
                        <span class="input-group-addon">
                   Cost
                  </span>
                  <input type="text" class="form-control" name="cost" placeholder="Cost" value="<?php echo remove_junk(ucfirst($sell['cost']));?>" >
                  <input type="hidden" class="form-control" name="sid"  value="<?php echo (int)$sell['id'];?>" >
                  <input type="hidden" class="form-control" name="prod_id"  value="<?php echo (int)$product['id'];?>" >

                  </div>
                  
                  </div>
                  
                </div>
              </div>
                    

             
              <button type="submit" name="sell_editt" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
