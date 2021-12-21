<?php
  require_once('includes/load.php');

if (isset($_POST['download_srp'],$_POST['start_date'],$_POST['end_date'],$_POST['prod_id'])) {
  $start_date   = remove_junk($db->escape($_POST['start_date']));
  $end_date = remove_junk($db->escape($_POST['end_date']));
  $prod_id=remove_junk($db->escape($_POST['prod_id']));
  
   $history = find_product_history($prod_id, $start_date, $end_date);;
if($history)
{
  $html= "<table class=\"table\" border=\"1\">
            
             
            
            <tbody> ";
            $x=0;
            foreach ($history as $item) {
               if($x==0)
               {
                // $html= "<table class=\"table\" border=\"1\">";
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
                $html.= "<tr>
                <th class=\"text-center\"  > </th>
                <th class=\"text-center\"  > </th>
                <th class=\"text-center\"  >Item Code </th>
                <th class=\"text-center\" > Item Description </th>
                <th class=\"text-center\" > Item Category   </th>                    
                </tr> ";
                $html.= "<tr>
                <td class=\"text-center\" > </td>
                <td class=\"text-center\" > </td>
                <td class=\"text-center\" >". $p_item_code. "</td>
                <td class=\"text-center\" >". $p_item_desc ."</td>
                <td class=\"text-center\" >". $p_item_cate ."</td>                    
                </tr> ";
                $html.= "<tr>
                <th class=\"text-center\"  >  </th>
                <th class=\"text-center\" >  </th>
                <th class=\"text-center\" >     </th>                    
                </tr> ";
                $html.= "<tr>
                <th class=\"text-center\"  >  </th>
                <th class=\"text-center\" >  </th>
                <th class=\"text-center\" >     </th>                    
                </tr> ";
                $html.= "<tr>
                <th class=\"text-center\"  >  </th>
                <th class=\"text-center\" >  </th>
                <th class=\"text-center\" >     </th>                    
                </tr> ";
                $html.= "<tr>
                <th class=\"text-center\"  >Type Of Transaction </th>
                <th class=\"text-center\" > Quantity Of Transaction </th>
                <th class=\"text-center\" > Cost Of Transaction   </th>
                <th class=\"text-center\" > Reference Number  </th>  
                <th class=\"text-center\" > Shop Qty After Transaction  </th>
                <th class=\"text-center\" > Store Qty After Transaction  </th>
                <th class=\"text-center\" > Date Of Transaction  </th>         
                </tr>
              
              <tbody> ";


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
              
              }




                $html .= "<tr>";
                
                $html .= "<td >" .  $type_tran . "</td>";
                $html .= "<td >" .   ($item['qty'] . ' ' . $p_cate_mesur) . "</td>";
                $html .= "<td >" .   $item['cost'] . "</td>";
                $html .= "<td >" .   ($item['r_no']) . "</td>";

                
                $html .= "<td >" ;
                if($instore==1)
                {
                  $html .= "      ";
                }
                elseif($instore==2)
                {
                  $html .= "+"." ".$item['qty']." ".$p_cate_mesur;
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
                  $html .= $temp_sign." ".$item['qty']." ".$p_cate_mesur;
                }
                $html.="</td>";


                $html.="<td>";
                if($instore==1)
                {
                  if($temp_sign=='-')
                  {
                    $temp_store-=$item['qty'];
                  }
                  else {
                    $temp_store+=$item['qty'];      
                  }
                  $html .= $temp_sign." ".$item['qty']." ".$p_cate_mesur;
                }
                elseif($instore==2)
                {
                  $temp_store-=$item['qty'];
                  $html .= "-"." ".$item['qty']." ".$p_cate_mesur;
                }
                else {
                  $html .= "           ";
                }

                $html .= "</td >" ;
                


                $html .= "<td >" .   $item['date'] . "</td>";
                
                $html .= "</tr>";
                              
               }
               else {
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
              
              }



                            
              
                $html .= "<tr>";
                
                $html .= "<td >" .  $type_tran . "</td>";
                $html .= "<td >" .   ($item['qty'] . ' ' . $p_cate_mesur) . "</td>";
                $html .= "<td >" .   $item['cost'] . "</td>";
                $html .= "<td >" .   ($item['r_no']) . "</td>";

                
                $html .= "<td >" ;
                if($instore==1)
                {
                  $html .= "      ";
                }
                elseif($instore==2)
                {
                  $html .= "+"." ".$item['qty']." ".$p_cate_mesur;
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
                  $html .= $temp_sign." ".$item['qty']." ".$p_cate_mesur;
                }
                $html.="</td>";


                $html.="<td>";
                if($instore==1)
                {
                  if($temp_sign=='-')
                  {
                    $temp_store-=$item['qty'];
                  }
                  else {
                    $temp_store+=$item['qty'];      
                  }
                  $html .= $temp_sign." ".$item['qty']." ".$p_cate_mesur;
                }
                elseif($instore==2)
                {
                  $temp_store-=$item['qty'];
                  $html .= "-"." ".$item['qty']." ".$p_cate_mesur;
                }
                else {
                  $html .= "           ";
                }

                $html .= "</td >" ;
                


                $html .= "<td >" .   $item['date'] . "</td>";
                
                $html .= "</tr>";
                
              
              }
  
  
  $x+=1;
            }
            $html .= "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=item_history.xls");
            echo $html;
}
}
?>