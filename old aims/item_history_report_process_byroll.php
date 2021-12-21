<?php
$page_title = 'Sales Report';

require_once 'includes/load.php';

// Checkin What level user has permission to view this page
page_require_level(1);
?>
<?php include_once 'layouts/header.php';?>





<?php
if (isset($_POST['submit_ih'])) {
    $req_dates = array('start-date', 'end-date');
    validate_fields($req_dates);

    if (empty($errors)) {
        $start_date = remove_junk($db->escape($_POST['start-date']));
        $end_date = remove_junk($db->escape($_POST['end-date']));
        // $prod = find_all_product_info_by_title($prod_item_code);
        // $prod_id;
        // if ($prod) {
        //     foreach ($prod as $pro) {
        //         $prod_id = $pro['id'];
        //     }
        // } else {
        //     $session->msg("d", "Ther Is NO Product With Item Code You Provide");
        //     redirect('http://localhost/aims/sell.php', false);
           
        // }

        // $history = find_product_history($prod_id, $start_date, $end_date);
        $history = find_product_history_all($start_date, $end_date);
        

        $tot_prods=[];
foreach($history as $prod)
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
            <!-- <input type="hidden" name="prod_id" value="<?php echo $prod_id ?>"> -->
            <input type="submit"  class="btn btn-primary" name="download_srp"  value="Download Excel">

    </form>

         </div>
        </div>
        <div class="mm">
        <div class="panel-body scrol-table-tinsae">
          <table class="table table-bordered table-striped mb-0">
            <thead>
              <tr>
                
                <th class="text-center"  >Item Code </th>
                <th class="text-center"  >Roll Number</th>
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
              
            <?php
              $color_bool=false;
               foreach ($tot_prods as $p):?>
               <?php
               $products = find_product_history_all_like($start_date, $end_date,$p);
              ?>
              
              <?php 
                
                if($color_bool)
                {
                  $colo="#d8e6eb";
                }
                else{
                  $colo="#ffffff";
                }
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
                foreach ($products as $product):
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
            <?php
                $type_tran;
                $temp_sign;
                $temp_shop=0;$temp_store=0;
                $instore;
                switch ($product['cost']) {
                    case 100000001:
                        $type_tran = "Sell";
                        $product['cost'] = "-";
                        $temp_sign="-";
                        $instore=0;
                        break;
                    case 100000002:
                        $type_tran = "Sample";
                        $product['cost'] = "-";
                        $temp_sign="-";
                        $instore=0;
                        break;
                    case 100000003:
                        $type_tran = "Moved To Shop";
                        $product['cost'] = "-";
                        $temp_sign="-";
                        $instore=2;
                        break;
                    default:
                        $type_tran = "Purchased";
                        $temp_sign="+";
                        $instore=1;
                        break;
                }
            ?>

                <td class="text-center"> <?php echo remove_junk($type_tran); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['qty'].' '.$product['measuring_unit']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['cost']); ?></td>            
                <td class="text-center"> <?php echo remove_junk($product['r_no']); ?></td>
                <td class="text-center"> 
            <?php 
                if($instore==1)
                  {
                    echo "      ";
                  }
                elseif($instore==2)
                  {
                    echo "+"." ".$product['qty']." ".$product['measuring_unit'];
                    $temp_shop+=$product['qty'];
                  }
                else 
                  {
                    if($temp_sign=='-')
                    {
                      $temp_shop-=$product['qty'];
                    }
                    else {
                      $temp_shop+=$product['qty'];      
                    }
                    echo $temp_sign." ".$product['qty']." ".$product['measuring_unit'];
                  }
            ?>
                </td>

                <td class="text-center"> 
            <?php 
                  if($instore==1)
                  {
                    if($temp_sign=='-')
                    {
                      $temp_store-=$product['qty'];
                    }
                    else 
                    {
                      $temp_store+=$product['qty'];      
                    }
                    echo $temp_sign." ".$product['qty']." ".$product['measuring_unit'];
                  }
                  elseif($instore==2)
                  {
                    $temp_store-=$product['qty'];
                    echo "-"." ".$product['qty']." ".$product['measuring_unit'];
                  }
                  else 
                  {
                    echo "           ";
                  }
            ?>
                </td>
                <td class="text-center"> <?php echo remove_junk($product['date']); ?></td>
                
              </tr>
              <?php endforeach; ?>


              <?php $color_bool=!$color_bool;?>
             <?php endforeach; ?>






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




