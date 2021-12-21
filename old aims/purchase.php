<?php
  $page_title = 'Purchase';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
  $products = join_purchase_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">

  <div class="col-md-12">
    <div class="alert" style="background-color:#AD2B5B">
	            <div class="container">
	            	<h1 style="color:white; text-align:center;">Manage Product Purchase Informations</h1> 
                <br>
	            </div>
	        </div>
</div>




  
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
    
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form-pur">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Search Product</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Search for Item">
            
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
 
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
        
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Product List</span>
                </strong>
            
        
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Item Code </th>
                <th class="text-center" style="width: 10%;"> Item Description </th>
                <th class="text-center" style="width: 10%;"> Quantity </th>
                <th class="text-center" style="width: 10%;"> COST </th>
                <th class="text-center" style="width: 10%;"> PURCHASED Date </th>
                <th class="text-center" style="width: 10%;"> Reference Number </th>               
                <th class="text-center" style="width: 100px;"> EDIT </th>
              </tr>
            </thead>
            <tbody id="product_info">
              <?php foreach ($products as $product):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
               
                <td> <?php echo remove_junk($product['item_code']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['description']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['quantity'].' '.$product['category_measur']); ?></td>            
                <td class="text-center"> <?php echo remove_junk($product['cost']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['date']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['r_no']); ?></td>
                
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_purchase.php?sid=<?php echo (int)$product['id'];?>&srn=<?php echo $product['r_no'];?>&sdate=<?php echo $product['date'];?>&sq=<?php echo $product['quantity'];?>&store_q=<?php echo $product['store_qty'];?>&prod_id=<?php echo $product['p_id'];?>" class="btn btn-info "  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
