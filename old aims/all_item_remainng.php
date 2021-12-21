<?php
  $page_title = 'Items Remaining Report';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
  $products = join_product_table();

$only_one_hypen=with_only_one_hyphen();

?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">

  <div class="col-md-12">
    <div class="alert" style="background-color:#7A83EE">
	            <div class="container">
	            	<h1 style="color:white; text-align:center;">Report for all product Remaining quantities </h1> 
                <br>
	            </div>
	        </div>
</div>



     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
    
    <?php echo display_msg($msg); ?>
    
 
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
        
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Product List</span>
                </strong>
            
         <div class="pull-right">
         <form method="post" action="all_item_remaing_download.php">
        
            <input type="submit"  class="btn btn-primary" name="download_all_remaning"  value="Download Excel">
        
    </form>
           
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Item Code </th>
                <th class="text-center" style="width: 10%;"> Item Description </th>
                <th class="text-center" style="width: 10%;"> Category </th>
                <th class="text-center" style="width: 10%;"> Store Quantity </th>
                <th class="text-center" style="width: 10%;"> Shop Quantity </th>
                <th class="text-center" style="width: 10%;"> Color  </th>
                <th class="text-center" style="width: 10%;"> Added Date  </th>
               
              </tr>
            </thead>
            <tbody id="product_finds">
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
               
                <td> <?php echo remove_junk($product['item_code']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['description']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['category_name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['store_qty'].' '.$product['category_measur']); ?></td>            
                <td class="text-center"> <?php echo remove_junk($product['shop_qty'].' '.$product['category_measur']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['color']); ?></td>
                <td class="text-center"> <?php echo $product['date'] ?></td>
                
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
