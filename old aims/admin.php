<?php
  $page_title = 'Admin Home Page';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
 $c_categorie     = count_by_id('category');
 $c_product       = count_by_id('products');
 $c_sale          = count_by_id('sell');
 $c_user          = count_by_id('user');
//  $products_sold   = find_higest_saleing_product('10');
//  $recent_products = find_recent_product_added('5');
//  $recent_sales    = find_recent_sale_added('5');
 $products_sold   = 10;
 $recent_products = 10;
 $recent_sales    = 10;
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
</div>
  <div class="row">
    <a href="add_sale.php" style="color:black;">
		<div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left" style="background-color: #868686;">
          <i class="glyphicon glyphicon-list-alt"></i>
        </div>
        <div >
          <h2 style="margin-top: 45px;"> Daily Sales </h2>
        </div>
       </div>
    </div>
	</a>
	
	<a href="product.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
        <div >
          <h2 style="margin-top: 45px;">Stock</h2>
        </div>
        </div>
       </div>
    </div>
	</a>
	
	<a href="move_to_shop.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-blue2">
          <i class="glyphicon glyphicon-share"></i>
        </div>
        <div class="panel-value pull-right">
        <div >
          <h2 style="margin-top: 45px;"> Transfer Product </h2>

        </div>
        </div>
       </div>
    </div>
	</a>
	
	<a href="add_product.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-green">
          <i class="glyphicon glyphicon-folder-open"></i>
        </div>
        <div class="panel-value pull-right">
         
          <div  class="margin-top">
          <h2 style="margin-top: 45px;"> New Product </h2>
        </div>
        </div>
       </div>
    </div>
	</a>
</div>
  
<div class="row">
    <a href="purchase_product.php" style="color:black;">
		<div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left" style="background-color: #655880;">
          <i class="glyphicon glyphicon-object-align-left"></i>
        </div>
        <div >
          <h2 style="margin-top: 45px;"> New Purchase </h2>
        </div>
       </div>
    </div>
	</a>
	
	<a href="purchase.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left" style="background-color: #ad2b5b;"> 
          <i class="glyphicon glyphicon-cog"></i>
        </div>
        <div class="panel-value pull-right">
        <div >
          <h2 style="margin-top: 45px;"> Manage Purchase </h2>
        </div>
        </div>
       </div>
    </div>
	</a>
	
	<a href="sell.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left" style="background-color: #86a769;">
          <i class="glyphicon glyphicon-shopping-cart"></i>
        </div>
        <div class="panel-value pull-right">
        <div >
          <h2 style="margin-top: 45px;"> Manage Sales </h2>
        </div>
        </div>
       </div>
    </div>
	</a>
	
	<a href="sample_product.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left" style="background-color: #0008ff;">
          <i class="glyphicon  glyphicon-screenshot"></i>
        </div>
        <div class="panel-value pull-right">
         
          <div  class="margin-top">
          <h2 style="margin-top: 45px;">Sample Allocated </h2>
        </div>
        </div>
       </div>
    </div>
	</a>
</div>


<div class="row">
    <a href="categorie.php" style="color:black;">
		<div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left " style="background-color: #7fc78b;">
          <i class="glyphicon glyphicon-tags"></i>
        </div>
        <div >
          <h2 style="margin-top: 45px;"> Categories </h2>
        </div>
       </div>
    </div>
	</a>
	
	
<?php include_once('layouts/footer.php'); ?>
