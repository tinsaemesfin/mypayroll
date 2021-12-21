<?php
  $page_title = 'Edit product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
$product = find_by_id('products',(int)$_GET['id']);
$all_categories = find_all('category');

if(!$product){
  $session->msg("d","Missing product id.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
   $req_fields = array('item_code','item_category','item_desc');
    validate_fields($req_fields);

   if(empty($errors)){
        $p_code  = remove_junk($db->escape($_POST['item_code']));
     $p_cat   = remove_junk($db->escape($_POST['item_category']));
     $p_dec   = remove_junk($db->escape($_POST['item_desc']));
    //  $p_sale  = remove_junk($db->escape($_POST['item_color']));
     if (is_null($_POST['item_color']) || $_POST['item_color'] === "") {
       $p_color = '';
     } else {
       $p_color = remove_junk($db->escape($_POST['item_color']));
     }
    $item_code_passed= item_code_duplicated($p_code);
    if($item_code_passed)
    {
$query   = "UPDATE products SET";
       $query  .=" item_code ='{$p_code}',";
       $query  .=" description ='{$p_dec}', category ='{$p_cat}',color='{$p_color}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query_add_product($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Product updated ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('edit_product.php?id='.$product['id'], false);
               }
    }
    else{
        $session->msg('d',' ERROR !!! You try to give another Items Item code');
                 redirect('edit_product.php?id='.$product['id'], false);
    }

       

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
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
            <span>Edit Product</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
             <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                     <div class="input-group ">
                        <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="item_code" placeholder="Item Code" value="<?php echo remove_junk(ucfirst($product['item_code']));?>">
               </div>
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="item_category">
                      <option value="">Select Item Category</option>
                    <?php  foreach ($all_categories as $photo): ?>
                      <option value="<?php echo (int)$photo['id'] ?>" <?php if($photo['id']==$product['category']) { echo 'selected';}?>>
                        <?php echo $photo['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
                    



              <div class="form-group">
                <div class="input-group ">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="item_desc" placeholder="Item Descripion " value= "<?php echo remove_junk(ucfirst($product['description']))?> ">
               </div>
              </div>
              

              <div class="form-group">
               <div class="row">
              
                 <div class="col-md-4">
                   <div class="input-group">
                     <span class="input-group-addon">
                       <i class="glyphicon glyphicon-usd"></i>
                     </span>
                     <input type="text" class="form-control" name="item_color" placeholder="Color" value= "<?php echo $product['color'];?>">
                     
                  </div>
                 </div>
                  
               </div>
              </div>
              <button type="submit" name="product" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
