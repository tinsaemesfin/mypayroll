<?php
  require_once('includes/load.php');

if (isset($_POST['download_srp'],$_POST['start_date'],$_POST['end_date'])) {
  $start_date   = remove_junk($db->escape($_POST['start_date']));
  $end_date = remove_junk($db->escape($_POST['end_date']));
  $products =find_sale_by_dates($start_date,$end_date);
if($products)
{
  $html= "<table class=\"table\" border=\"1\">
            
              <tr>
                <th class=\"text-center\" style=\"width: 50px;\">#</th>
                <th> Item Code </th>
                <th> Item Description </th>
                <th> Category </th>
                <th> Sold Quantity </th>
                <th> Reference Number </th>                
                <th> Sold Date  </th>                
              </tr>
            
            <tbody> ";
            foreach ($products as $product) {
               
  $html .= "<tr>";
  $html .= "<td >" .  count_id() . "</td>";
  $html .= "<td >" .   $product['item_code'] . "</td>";
  $html .= "<td >" .   $product['description'] . "</td>";
  $html .= "<td >" .   $product['name'] . "</td>";
  $html .= "<td >" .   ($product['quantity'].' '.$product['measuring_unit']) . "</td>";
  $html .= "<td >" .   $product['r_no'] . "</td>";
  $html .= "<td >" .   $product['date'] . "</td>";
  $html .= "</tr>";
  
            }
            $html .= "</table>";
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=sale.xls");
            echo $html;
}
}
?>