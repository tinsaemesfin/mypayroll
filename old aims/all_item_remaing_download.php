<?php
require_once('includes/load.php');
// Checkin What level user has permission to view this page
 page_require_level(1);
if (isset($_POST['download_all_remaning'])) {
  $products = join_product_table();
if($products)
{
  $html= "<table class=\"table\" border=\"1\">
            
              <tr>
                <th class=\"text-center\" style=\"width: 50px;\">#</th>
                <th> Item Code </th>
                <th> Item Description </th>
                <th> Category </th>
                <th> Store Quantity </th>
                <th> Shop Quantity </th>
                <th> Color  </th>
                <th> Added Date  </th>
                
              </tr>
            
            <tbody> ";
            foreach ($products as $product) {
               
  $html .= "<tr>";
  $html .= "<td >" .  count_id() . "</td>";
  $html .= "<td >" .   $product['item_code'] . "</td>";
  $html .= "<td >" .   $product['description'] . "</td>";
  $html .= "<td >" .   $product['category_name'] . "</td>";
  $html .= "<td >" .   ($product['store_qty'].' '.$product['category_measur']) . "</td>";
  $html .= "<td >" .   ($product['shop_qty'].' '.$product['category_measur']) . "</td>";
  $html .= "<td >" .   $product['color'] . "</td>";
  $html .= "<td >" .   $product['date'] . "</td>";
  $html .= "</tr>";
  
            }
            $html .= "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=do.xls");
            echo $html;
}
}
?>