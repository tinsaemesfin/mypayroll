<?php
require_once('includes/load.php');
// Checkin What level user has permission to view this page
 page_require_level(1);
if (isset($_POST['download_all_remaning'])) {



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
  







  $products = join_product_table();
if($products)
{
  $html= "<table class=\"table\" border=\"1\">
            
              <tr>
                <th style=\"width: 100px;\">Parent Item Code</th>
                <th style=\"width: 50px;\">Roll Item Code </th>
                <th> Item Description </th>
                <th> Category </th>
                <th> Store Quantity </th>
                <th> Shop Quantity </th>
                <th> Color  </th>
                <th> Added Date  </th>
                
              </tr>
            
            <tbody> ";

            $color_bool=false;
               foreach ($tot_prods as $p):
                $total_shop=0;
              $total_store=0; 
              $products = join_a_product_table_like($p);
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
                      $html .="<tr bgcolor=".$colo.">";
                      if($xx==1)
              {
               
                $html .= "<td style='vertical-align : middle;text-align:center;  font-weight: bold; font-size:2rem;' rowspan=". sizeof($products) .">". $pro_panrent ."</td>";
              } 
                $html .= "<td >" .   $product['item_code'] . "</td>";
                $html .= "<td >" .   $product['description'] . "</td>";
                $html .= "<td >" .   $product['category_name'] . "</td>";
                $html .= "<td >" .   ($product['store_qty'].' '.$product['category_measur']) . "</td>";
                $html .= "<td >" .   ($product['shop_qty'].' '.$product['category_measur']) . "</td>";
                $html .= "<td >" .   $product['color'] . "</td>";
                $html .= "<td >" .   $product['date'] . "</td>";
                $html .= "</tr>";
                $total_shop+=$product['shop_qty'];
                $total_store+=$product['store_qty'];
              endforeach;
              $html .= "<tr bgcolor=". $colo .">";                            
             $html .="<td colspan='4' class='text-center' style=' font-weight: bold;'> TOTAL </td>";
             $html .="<td class='text-center' style=' font-weight: bold;'>". remove_junk($total_store.' '.$product['category_measur']) ."</td>";
              $html .="<td class='text-center' style=' font-weight: bold;'>". remove_junk($total_shop.' '.$product['category_measur']) ."</td>";            
              $html .="<td colspan='2'></td>";
            $html .="</tr>";
            $color_bool=!$color_bool;
             endforeach;

  //           foreach ($products as $product) {
               
  // $html .= "<tr>";
  // $html .= "<td >" .  count_id() . "</td>";
  // $html .= "<td >" .   $product['item_code'] . "</td>";
  // $html .= "<td >" .   $product['description'] . "</td>";
  // $html .= "<td >" .   $product['category_name'] . "</td>";
  // $html .= "<td >" .   ($product['store_qty'].' '.$product['category_measur']) . "</td>";
  // $html .= "<td >" .   ($product['shop_qty'].' '.$product['category_measur']) . "</td>";
  // $html .= "<td >" .   $product['color'] . "</td>";
  // $html .= "<td >" .   $product['date'] . "</td>";
  // $html .= "</tr>";
  
  //           }
            $html .= "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=do.xls");
            echo $html;
}
}
?>