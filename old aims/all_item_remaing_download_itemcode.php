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
                <th style=\"width: 100px;\">Item Code</th>
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
                      
              
              $proo_des=$product['description'];
              $proo_cat=$product['category_name'];
              $proo_cat_measure=$product['category_measur'];
              $proo_color=$product['color'];
              $proo_date=$product['date'];
              $total_shop+=$product['shop_qty'];
              $total_store+=$product['store_qty'];
            endforeach;
            $html .="<tr bgcolor=".$colo.">";
                $html .= "<td >" .   $pro_panrent . "</td>";
                $html .= "<td >" .   $proo_des . "</td>";
                $html .= "<td >" .   $proo_cat . "</td>";
                $html .= "<td >" .   ($total_store.' '.$proo_cat_measure) . "</td>";
                $html .= "<td >" .   ($total_shop.' '.$proo_cat_measure) . "</td>";
                $html .= "<td >" .   $proo_color . "</td>";
                $html .= "<td >" .   $proo_date . "</td>";
                $html .= "</tr>";
                
              // this ware fore each
              
            $color_bool=!$color_bool;
             endforeach;

 
            $html .= "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=do.xls");
            echo $html;
}
}
?>