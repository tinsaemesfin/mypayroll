<?php
require_once 'includes/load.php';
if (!$session->isUserLoggedIn(true)) {redirect('index.php', false);}
?>

<?php
// Auto suggetion
$html = '';
if (isset($_POST['product_name']) && strlen($_POST['product_name'])) {
    $products = find_product_by_title($_POST['product_name']);
    if ($products) {
        foreach ($products as $product) {
            $html .= "<li class=\"list-group-item\">";
            $html .= $product['item_code'];
            $html .= "</li>";
        }
    } else {

        $html .= '<li onClick=\"fill(\'' . addslashes() . '\')\" class=\"list-group-item\">';
        $html .= 'Not found';
        $html .= "</li>";

    }

    // $html .= "<li class=\"list-group-item\">";
    // $html .= "sdsadasdadas ";
    // $html .= "</li>";
    //     if(!isset($_POST['product_name']))
    //  {

    //  }

    echo json_encode($html);
}
?>
 <?php
// find all product
if (isset($_POST['p_name']) && strlen($_POST['p_name'])) {
    $product_title = remove_junk($db->escape($_POST['p_name']));
    if ($results = find_all_product_info_by_title($product_title)) {
        foreach ($results as $result) {

            $html .= "<tr>";

            $html .= "<td id=\"s_name\">" . $result['name'] . "</td>";
            $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\">";
            $html .= "<td>";
            $html .= "<input type=\"text\" class=\"form-control\" name=\"price\" value=\"{$result['sale_price']}\">";
            $html .= "</td>";
            $html .= "<td id=\"s_qty\">";
            $html .= "<input type=\"text\" class=\"form-control\" name=\"quantity\" value=\"1\">";
            $html .= "</td>";
            $html .= "<td>";
            $html .= "<input type=\"text\" class=\"form-control\" name=\"total\" value=\"{$result['sale_price']}\">";
            $html .= "</td>";
            $html .= "<td>";
            $html .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\">";
            $html .= "</td>";
            $html .= "<td>";
            $html .= "<button type=\"submit\" name=\"add_sale\" class=\"btn btn-primary\">Add sale</button>";
            $html .= "</td>";
            $html .= "</tr>";

        }
    } else {
        $html = '<tr><td>product name not resgister in database</td></tr>';
    }

    echo json_encode($html);
}

if (isset($_POST['move_p']) && strlen($_POST['move_p'])) {
    $product_title = remove_junk($db->escape($_POST['move_p']));
    if ($results = find_all_product_info_by_title($product_title)) {
        foreach ($results as $result) {
            if ($result['store_qty'] > 0) {
                echo '<tr>
  <td id="m_code">' . $result['item_code'] . '</td>
  <input type="hidden" name="s_id" value="' . $result['id'] . '">
  <td id="shop_qty">' . $result['shop_qty'] . '</td>
  <td id="shop_qty">' . $result['store_qty'] . ' </td>
  <td id="m_qty">
  <input type="number" class="form-control" name="quantity" min = "0.1" max = "' . $result['store_qty'] . '" step = "0.01" >
  </td>
  <td>
  <input type="text" class="form-control" name="r_no" >
  </td>
  <td>
  <input type="text" class="datepicker form-control" name="date"
                                    placeholder="Date" autocomplete="off">
  </td>
  <td>
  <button type="submit" name="move_product" class="btn btn-primary">Add sale</button>
  </td>
  </tr>';

            } else {
                echo '<tr><td>There No Remaining quanity in Store For Selected Item ' . $result['item_code'] . ' </td></tr>';

            }

        }
    } else {
        echo '<tr><td>product name not resgister in database</td></tr>';

    }

}



if (isset($_POST['pur_p']) && strlen($_POST['pur_p'])) {
    $product_title = remove_junk($db->escape($_POST['pur_p']));
    if ($results = find_all_product_info_by_title($product_title)) {
        $pro_id;
        $pro_item_code;
        $pro_desc;
        $pro_store;
        $x=0;
        foreach ($results as $result) {
if($x==0)
{
    $pro_id=$result['id'];
    $pro_item_code=$result['item_code'];
    $pro_desc=$result['description'];
    $pro_store=$result['store_qty'];
    $x++;
    break;
}
        }

        $purchase = find_all_purchase_by_pid($pro_id);
        if($purchase) {
            foreach ($purchase as $pur) {
                echo '<tr>
                <td class="text-center">'.count_id().'</td>
  <td id="m_code">' . $pro_item_code . '</td>
  
  <td id="shop_qty">' . $pro_desc . '</td>
  <td id="shop_qty">' . $pur['qty'] . ' </td>
  <td id="shop_qty">' . $pur['cost'] . ' </td>
  <td id="shop_qty">' . $pur['date'] . ' </td>
  <td id="shop_qty">' . $pur['r_no'] . ' </td>
  

  <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_purchase.php?sid='.(int)$pur["id"].'&srn='.$pur["r_no"].'&sdate='.$pur["date"].'&sq='.$pur["qty"].'&store_q='. $pro_store.'&prod_id='. $pro_id.'" class="btn btn-info "  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    
                  </div>
                </td>
  
  </tr>';

        }
    }

else {
        echo '<tr><td></td><td>product not Purchased</td></tr>';
        
    }
 }
    else {
        echo '<tr><td>product name not resgister in database</td></tr>';

    }

}




if (isset($_POST['sample_p']) && strlen($_POST['sample_p'])) {
    $product_title = remove_junk($db->escape($_POST['sample_p']));
    if ($results = find_all_product_info_by_title($product_title)) {
        foreach ($results as $result) {
            if ($result['shop_qty'] > 0) {
                echo '<tr>
  <td id="m_code">' . $result['item_code'] . '</td>
  <input type="hidden" name="s_id" value="' . $result['id'] . '">
  <td id="shop_qty">' . $result['shop_qty'] . '</td>
  <td id="m_qty">
  <input type="number" class="form-control" name="quantity" min = "0.1" max = "' . $result['shop_qty'] . '" step = "0.01" >
  </td>
  <td>
  <input type="text" class="form-control" name="r_no" >
  </td>
  <td>
  <input type="text" class="datepicker form-control" name="date"
                                    placeholder="Date" autocomplete="off">
  </td>
  <td>
  <button type="submit" name="sample_product_po" class="btn btn-primary">Add sale</button>
  </td>
  </tr>';

            } else {
                echo '<tr><td>There No Remaining quanity in Shop For Selected Item ' . $result['item_code'] . ' </td></tr>';

            }

        }
    } else {
        echo '<tr><td>product name not resgister in database</td></tr>';

    }

}
if (isset($_POST['found_p']) && strlen($_POST['found_p'])) {
    $product_title = remove_junk($db->escape($_POST['found_p']));
    if ($results = join_a_product_table($product_title)) {
        foreach ($results as $product) {
            
                echo '<td class="text-center">'.count_id().'</td>
               
                <td>'. remove_junk($product['item_code']).'</td>
                <td class="text-center"> '. remove_junk($product['description']).'</td>
                <td class="text-center"> '. remove_junk($product['category_name']).'</td>
                <td class="text-center"> '. remove_junk($product['store_qty'].' '.$product['category_measur']).'</td>            
                <td class="text-center">'. remove_junk($product['shop_qty'].' '.$product['category_measur']).'</td>
                <td class="text-center"> '.remove_junk($product['color']).'</td>
                <td class="text-center"> '.$product['date'] .'</td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product.php?id='.(int)$product['id'].'" class="btn btn-info "  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    
                  </div>
                </td>';

            

        }
    } else {
        echo '<tr><td>product name not resgister in database</td></tr>';

    }

}
if (isset($_POST['purchase_p']) && strlen($_POST['purchase_p'])) {
    $product_title = remove_junk($db->escape($_POST['purchase_p']));
    if ($results = find_all_product_info_by_title($product_title)) {
        foreach ($results as $result) {

            echo '<tr>
  <td id="m_code">' . $result['item_code'] . '</td>
  <input type="hidden" name="s_id" value="' . $result['id'] . '">
  <td id="item_dec">' . $result['description'] . '</td>
  <td id="store_qty">' . $result['store_qty'] . ' </td>
  <td id="m_qty">
  <input type="number" class="form-control" name="quantity" min = "0.1" max = "100000" step = "0.01" >
  </td>
  <td>
  <input type="text" class="form-control" name="r_no" >
  </td>
  <td>
  <input type="text" class="datepicker form-control" name="date"
  placeholder="Date" autocomplete="off">
  </td>
  <td id="p_cost">
  <input type="number" class="form-control" name="cost" min = "0.1" max = "100000000" step = "0.01" >
  </td>

  <td>
  <button type="submit" name="purchase_product" class="btn btn-primary">Add sale</button>
  </td>
  </tr>';

        }
    } else {
        echo '<tr><td>product name not resgister in database</td></tr>';

    }

}
if (isset($_POST['sell_p']) && strlen($_POST['sell_p'])) {
    $product_title = remove_junk($db->escape($_POST['sell_p']));
    if ($results = find_all_product_info_by_title($product_title)) {
        foreach ($results as $result) {
            if ($result['shop_qty'] > 0) {
                echo '<tr>
  <td id="m_code">' . $result['item_code'] . '</td>
  <input type="hidden" name="s_id" value="' . $result['id'] . '">
  <td id="shop_qty">' . $result['shop_qty'] . '</td>
  <td id="color">' . $result['color'] . ' </td>
  <td id="m_qty">
  <input type="number" class="form-control" name="quantity" min = "0.1" max = "' . $result['shop_qty'] . '" step = "0.01" >
  </td>
  <td>
  <input type="text" class="form-control" name="r_no" >
  </td>
  <td>
  <input type="text" class="datepicker form-control" name="date"
                                    placeholder="Date" autocomplete="off">
  </td>
  <td>
  <button type="submit" name="sell_product" class="btn btn-primary">Add sale</button>
  </td>
  </tr>';

            } 
            elseif ($result['store_qty'] > 0) {
                echo '<tr><td>There No Remaining quanity for item  ' . $result['item_code'] . ' in Shop but There are <b>'.$result['store_qty'].' </b>quantity Avelable In Store </td>
                <td>
               
                
               
                
                            <span class="input-group-btn">
                                <a href="http://localhost/aims/move_to_shop.php" class="btn btn-primary" id="pr">Proceed To Move Product </a>
 

                            </span>
                         
                        
                </td> </tr>';
               
            }
            
            else {
                echo '<tr><td>There No Remaining quanity in Shop For Selected Item ' . $result['item_code'] . ' </td></tr>';

            }

        }
    } else {
        echo '<tr><td>product name not resgister in database</td></tr>';

    }

}




if (isset($_POST['sell_p_m']) && strlen($_POST['sell_p_m'])) {
    $product_title = remove_junk($db->escape($_POST['sell_p_m']));
    if ($results = find_all_product_info_by_title($product_title)) {
        $pro_id;
        $pro_item_code;
        $pro_desc;
        $pro_shop;
        $x=0;
        foreach ($results as $result) {
if($x==0)
{
    $pro_id=$result['id'];
    $pro_item_code=$result['item_code'];
    $pro_desc=$result['description'];
    $pro_shop=$result['shop_qty'];
    $x++;
    break;
}
        }

        $purchase = find_all_sell_by_pid($pro_id);
        if($purchase) {
            foreach ($purchase as $pur) {
                echo '<tr>
                <td class="text-center">'.count_id().'</td>
  <td id="m_code">' . $pro_item_code . '</td>
  
  <td id="shop_qty">' . $pro_desc . '</td>
  <td id="shop_qty">' . $pur['quantity'] . ' </td>
  <td id="shop_qty">' . $pur['date'] . ' </td>
  <td id="shop_qty">' . $pur['r_no'] . ' </td>
  
  

  <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_sell.php?sid='.(int)$pur["id"].'&prod_id='.$pro_id.'" class="btn btn-info "  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    
                  </div>
                </td>
  
  </tr>';

        }
    }

else {
        echo '<tr><td></td><td>product not Sold</td></tr>';
        
    }
 }
    else {
        echo '<tr><td></td><td>product name not resgister in database</td></tr>';

    }

}



?>


