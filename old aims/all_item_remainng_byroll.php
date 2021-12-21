<?php
  $page_title = 'Items Remaining Report';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
  

$only_one_hypen=with_only_one_hyphen();


$products_new = join_product_table();
$tot_prods=[];
foreach($products_new as $prod)
{
  $ic=$prod['item_code'];
if( substr_count($ic,"-")==1)
{
  if(!in_array($ic, $tot_prods))
  {
    array_push($tot_prods,$ic);
  }
}
elseif( substr_count($ic,"-")>1)
{
  $last_index=strripos($ic, "R");
  if($last_index>0)
  {

    $x=substr($ic,0,$last_index);
    if(!in_array($x, $tot_prods))
    {
      array_push($tot_prods,$x);
    }
  }
  else
  {
    if(!in_array($ic, $tot_prods))
  {
    array_push($tot_prods,$ic);
  }
  }
 
}
}


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
         <form method="post" action="all_item_remaing_download_roll.php">
        
            <input type="submit"  class="btn btn-primary" name="download_all_remaning"  value="Download Excel">
        
    </form>
           
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead class="mysticky">
              <tr class="mysticky">
                <!-- <th class="text-center" style="width: 50px;">#</th> -->

                <th style="width: 100px;"> PARENT ITEM CODE </th>
                <th style="width: 50px;"> ROLL ITEM CODE </th>
                <th class="text-center" style="width: 10%;"> Item Description </th>
                <th class="text-center" style="width: 10%;"> Category </th>
                <th class="text-center" style="width: 10%;"> Store Quantity </th>
                <th class="text-center" style="width: 10%;"> Shop Quantity </th>
                <th class="text-center" style="width: 10%;"> Color  </th>
                <th class="text-center" style="width: 10%;"> Added Date  </th>
               
              </tr>
            </thead>
            <tbody id="product_finds">
              <?php
              $color_bool=false;
               foreach ($tot_prods as $p):?>
               <?php
              $total_shop=0;
              $total_store=0; 
              $products = join_a_product_table_like($p);
              ?>
              
                <?php if($color_bool)
                {
                  $colo="#d8e6eb";
                }
                else{
                  $colo="#ffffff";
                }
                ?>
                 <?php 
                 $pro_panrent;
                 if(substr($p, -1)=="-")
                    {
                      $vv=strlen($p);
                      $pro_panrent=substr($p,0,$vv-1);
                    } 
                    else
                    {
                      $pro_panrent=$p;
                    }
                    $xx=0;
                    ?>
                <?php foreach ($products as $product):
                  $xx=$xx+1;
                  ?>
                   
                
              <tr bgcolor=<?php echo $colo?>>
              <?php
              if($xx==1)
              {
                ?>
                <td style="vertical-align : middle;text-align:center;  font-weight: bold; font-size:2rem;" rowspan="<?php echo sizeof($products);?>"><?php echo $pro_panrent; ?></td>

                <?php
              }
              ?>
                <td> <?php echo remove_junk($product['item_code']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['description']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['category_name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['store_qty'].' '.$product['category_measur']); ?></td>            
                <td class="text-center"> <?php echo remove_junk($product['shop_qty'].' '.$product['category_measur']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['color']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['date']); ?></td>
                
              </tr>
<?php
    $total_shop+=$product['shop_qty'];
    $total_store+=$product['store_qty'];
?>
             <?php endforeach; ?>

             <tr bgcolor=<?php echo $colo?>>
                
                
                
                <td colspan="4" class="text-center" style=" font-weight: bold;"> TOTAL </td>
                <td class="text-center" style=" font-weight: bold;"> <?php echo remove_junk($total_store.' '.$product['category_measur']); ?></td>
                <td class="text-center" style=" font-weight: bold;"> <?php echo remove_junk($total_shop.' '.$product['category_measur']); ?></td>            
                
                <td colspan="2"></td>
              </tr>
    
             <?php $color_bool=!$color_bool;?>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
