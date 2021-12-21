<?php
$page_title = 'Sales Report';

require_once 'includes/load.php';

// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php include_once 'layouts/header.php';?>





<?php
if (isset($_POST['submit_ih'])) {
    $req_dates = array('start-date', 'end-date', 'title');
    validate_fields($req_dates);

    if (empty($errors)) {
        $start_date = remove_junk($db->escape($_POST['start-date']));
        $end_date = remove_junk($db->escape($_POST['end-date']));
        $prod_item_code = remove_junk($db->escape($_POST['title']));
        $prod = find_all_product_info_by_title($prod_item_code);
        $prod_id;
        if ($prod) {
            foreach ($prod as $pro) {
                $prod_id = $pro['id'];
            }
        } else {
            $session->msg("d", "Ther Is NO Product With Item Code You Provide");
            redirect('http://localhost/aims/sell.php', false);
           
        }

        $history = find_product_history($prod_id, $start_date, $end_date);
        $aproduct;
        // if()

    }

} else {
    $session->msg("d", $errors);
    redirect('item_history_report.php', false);
}
?>
 <div class="row">

    <div class="col-md-12">

    <?php echo display_msg($msg); ?>


      <div class="panel panel-default">
        <div class="panel-heading clearfix">

                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Sells Report</span>
                </strong>

         <div class="pull-right">
         <form method="post" action="item_history_report_process_download.php">
            <input type="hidden" name="start_date" value="<?php echo $start_date ?>">
            <input type="hidden" name="end_date" value="<?php echo $end_date ?>">
            <input type="hidden" name="prod_id" value="<?php echo $prod_id ?>">
            <input type="submit"  class="btn btn-primary" name="download_srp"  value="Download Excel">

    </form>

         </div>
        </div>
        <div class="mm">
        <div class="panel-body scrol-table-tinsae">
          <table class="table table-bordered table-striped mb-0">
            <thead>
              <tr>
                
                <th class="text-center"  >Type Of Transaction </th>
                <th class="text-center" > Quantity Of Transaction </th>
                <th class="text-center" > Cost Of Transaction   </th>
                <th class="text-center" > Reference Number  </th>  
                <th class="text-center" > Shop Qty After Transaction  </th>
                <th class="text-center" > Store Qty After Transaction  </th>
                <th class="text-center" > Date Of Transaction  </th>

              </tr>
            </thead>
            <tbody id="product_finds">
              <?php foreach ($history as $item): ?>
              <tr>
                
               <?php
$aproduct = join_a_product_table_with_id($item['item_id']);
$p_item_code;$p_item_desc;$p_item_cate;$p_store_qty;$p_shop_qyt;$p_cate_mesur;
 foreach($aproduct as $prod )
                {
                  
                $p_item_code=$prod['item_code'];
                $p_item_desc=$prod['description'];
                $p_item_cate=$prod['category_name'];
                $p_cate_mesur=$prod['category_measur'];
                $p_store_qty=$prod['store_qty'];
                $p_shop_qty=$prod['shop_qty'];
                }
                
?>
               <?php
$type_tran;
$temp_sign;
$temp_shop=0;$temp_store=0;
$instore;
switch ($item['cost']) {
    case 100000001:
        $type_tran = "Sell";
        $item['cost'] = "-";
        $temp_sign="-";
        $instore=0;
        break;
    case 100000002:
        $type_tran = "Sample";
        $item['cost'] = "-";
        $temp_sign="-";
        $instore=0;
        break;
    case 100000003:
        $type_tran = "Moved To Shop";
        $item['cost'] = "-";
        $temp_sign="-";
        $instore=2;
        break;
    default:
        $type_tran = "Purchased";
        $temp_sign="+";
        $instore=1;
        break;

}?>
                <td class="text-center"> <?php echo remove_junk($type_tran); ?></td>
                <td class="text-center"> <?php echo remove_junk($item['qty'] . ' ' . $p_cate_mesur); ?></td>
                <td class="text-center"> <?php echo remove_junk($item['cost']); ?></td>
                <td class="text-center"> <?php echo remove_junk($item['r_no']); ?></td>
                <td class="text-center"> <?php 
                if($instore==1)
                {
                  echo "      ";
                }
                elseif($instore==2)
                {
                  echo "+"." ".$item['qty']." ".$p_cate_mesur;
                  $temp_shop+=$item['qty'];
                }
                else {
                  if($temp_sign=='-')
                  {
                    $temp_shop-=$item['qty'];
                  }
                  else {
                    $temp_shop+=$item['qty'];      
                  }
                  echo $temp_sign." ".$item['qty']." ".$p_cate_mesur;
                }
                ?></td>

<td class="text-center"> <?php 
                if($instore==1)
                {
                  if($temp_sign=='-')
                  {
                    $temp_store-=$item['qty'];
                  }
                  else {
                    $temp_store+=$item['qty'];      
                  }
                  echo $temp_sign." ".$item['qty']." ".$p_cate_mesur;
                }
                elseif($instore==2)
                {
                  $temp_store-=$item['qty'];
                  echo "-"." ".$item['qty']." ".$p_cate_mesur;
                }
                else {
                  echo "           ";
                }
                ?></td>
              
                <td class="text-center"> <?php echo remove_junk($item['date']); ?></td>


              </tr>
             <?php endforeach;?>
            </tbody>
          </tabel>
        </div>
         <div class ="me-upper">
<!--
        <div class="col-md-6 " style="background-color:#EFEFEF;">
							<div class="panel panel-body border-top-info" style="background-color:#EFEFEF;">
								
                
								<ul class="dropdown-menu" style="display: block; position: static; width: 100%; margin-top: 0; float: none; margin-bottom:10px;">
								<!-- $p_item_code
$p_item_desc
$p_item_cate
$p_cate_mesur
$p_store_qty
$p_shop_qty	 -->
<ul class="dropdown-menu" style="display: block; position: static; width: 100%; margin-top: 0; float: none; margin-bottom:10px;">
                 <li>    Item Code   =>   <?php echo $p_item_code; ?> </li>
									<li class="divider"></li>
                  <li>    Item Description   =>   <?php echo $p_item_desc; ?> </li>
									<li class="divider"></li>
                  <li>    Item Category   =>   <?php echo $p_item_cate; ?> </li>
									<li class="divider"></li>
                  <!-- <li>    Item Store Quantity Bignning   =>   <?php echo $temp_store; ?> </li>
                  <li class="divider"></li>
                  <li>    Item Shop Quantity Bignning   =>   <?php echo $temp_shop; ?> </li> -->
								</ul>
                <!--
							</div>
						</div>

-->

          </div> 

              </div>
      </div>
    </div>
  </div>
  <?php include_once 'layouts/footer.php';?>

<?php if (isset($db)) {$db->db_disconnect();}?>




