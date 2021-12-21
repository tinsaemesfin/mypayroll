<?php
  require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,privilege FROM user WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Login with the data provided in $_POST,
  /* coming from the login_v2.php form.
  /* If you used this method then remove authenticate function.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
         return $user;
       }
     }
    return false;
   }


  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['aims_user_id'])):
             $user_id = intval($_SESSION['aims_user_id']);
             $current_user = find_by_id('user',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Find all Group name
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  function item_code_duplicated($code)
  {
    global $db;
    $sql = "SELECT item_code FROM products WHERE item_code = '{$db->escape($code)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }

  
  function find_by_groupLevel_detail($level)
  {

    global $db;
    
    $sql = "SELECT * FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);

    if($db->num_rows($result)):
   $userGroup_data = $db->fetch_assoc($result);
   return $userGroup_data;
    endif;
    return null;
  }
  /*--------------------------------------------------------------*/
  /* Function for cheaking which user level has access to page
  /*--------------------------------------------------------------*/
   function page_require_level($require_level)
   {
     global $session;
     $current_user = current_user();
    //  $login_level = find_by_userprivilege($current_user['privilege']);
    // $grup_detail=null;

if (!$session->isUserLoggedIn(true)){
            $session->msg('d','Please login...');
            redirect('index.php', false);
}

    

if($require_level==$current_user['privilege'])
{
  //     $grup_detail=find_by_groupLevel_detail($require_level);   
  // if($grup_detail!==null){
  //   if($grup_detail['group_status']!=0)
  //       {
  //         if($current_user['status']==1)
  //         {
              return true;
  //         }
  //         else{
  //            $session->msg('d',"YOUR ACCOUNT HAS BEEN BAND '{$current_user['status']}'");
  //           redirect('show_error.php', false);
  //         }
  //       }
  //   else {
  //         $session->msg('d','YOUR GROUP HAS BEEN BAND');
  //           redirect('show_error.php', false);
  //       }
  //     }
  // else {
        
  //       $session->msg('d','YOUR GROUP HAS NOT BEEN FOUND');
  //           redirect('show_error.php', false);
  //     }
}
else {
 $session->msg('d',"ACCESS DENIED'{$require_level}' hdhdhdh   '{$current_user['user_level']}'");
            redirect('show_error.php', false);

}
    
    
     }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/

   function join_sell_table(){
    global $db;
   $sql  =" SELECT s.id,s.date,s.r_no,s.quantity,p.item_code,p.description,p.store_qty,p.shop_qty,c.name";
   $sql  .=" AS category_name,c.measuring_unit AS category_measur, p.id AS p_id, p.shop_qty AS p_shop_q";
   $sql  .=" FROM sell s";
   $sql  .=" LEFT JOIN products p ON p.id = s.item_id";
   $sql  .=" LEFT JOIN category c ON c.id = p.category";
   $sql  .=" ORDER BY s.id ASC";
  
   return find_by_sql($sql);


  }
  function join_purchase_table(){
    global $db;
   $sql  =" SELECT s.id,s.date,s.r_no,s.qty AS quantity ,s.cost,pr.item_code,pr.description,pr.store_qty,pr.shop_qty,c.name";
   $sql  .=" AS category_name,c.measuring_unit AS category_measur, pr.id AS p_id, pr.shop_qty AS p_shop_q";
   $sql  .=" FROM purchase s";
   $sql  .=" LEFT JOIN products pr ON pr.id = s.item_id";
   $sql  .=" LEFT JOIN category c ON c.id = pr.category";
   $sql  .=" ORDER BY s.id DESC";
  
   return find_by_sql($sql);


  }



  function join_product_table(){
     global $db;
    //  $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
    // $sql  .=" AS categorie,m.file_name AS image";
    // $sql  .=" FROM products p";
    // $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    // $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
    // $sql  .=" ORDER BY p.id ASC";
    // return find_by_sql($sql);
$sql  =" SELECT p.id,p.item_code,p.description,p.color,p.store_qty,p.shop_qty,p.date,c.name";
    $sql  .=" AS category_name,c.measuring_unit AS category_measur";
    $sql  .=" FROM products p";
    $sql  .=" LEFT JOIN category c ON c.id = p.category";
    $sql  .=" ORDER BY p.id ASC";
   
    return find_by_sql($sql);


   } 

   function join_product_table_l_100(){
    global $db;
   //  $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
   // $sql  .=" AS categorie,m.file_name AS image";
   // $sql  .=" FROM products p";
   // $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
   // $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
   // $sql  .=" ORDER BY p.id ASC";
   // return find_by_sql($sql);
$sql  =" SELECT p.id,p.item_code,p.description,p.color,p.store_qty,p.shop_qty,p.date,c.name";
   $sql  .=" AS category_name,c.measuring_unit AS category_measur";
   $sql  .=" FROM products p";
   $sql  .=" LEFT JOIN category c ON c.id = p.category";
   $sql  .=" ORDER BY p.id DESC LIMIT 100";
  
   return find_by_sql($sql);


  }
   function join_a_product_table($p_code){
     global $db;
    //  $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
    // $sql  .=" AS categorie,m.file_name AS image";
    // $sql  .=" FROM products p";
    // $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    // $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
    // $sql  .=" ORDER BY p.id ASC";
    // return find_by_sql($sql);
$sql  =" SELECT p.id,p.item_code,p.description,p.color,p.store_qty,p.shop_qty,p.date,c.name";
    $sql  .=" AS category_name,c.measuring_unit AS category_measur";
    $sql  .=" FROM products p";
    $sql  .=" LEFT JOIN category c ON c.id = p.category";
    $sql  .=" WHERE p.item_code ='{$p_code}'";
    $sql  .=" ORDER BY p.id ASC";
   
    return find_by_sql($sql);


   }
   function join_a_product_table_like($p_code){
    global $db;
   //  $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
   // $sql  .=" AS categorie,m.file_name AS image";
   // $sql  .=" FROM products p";
   // $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
   // $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
   // $sql  .=" ORDER BY p.id ASC";
   // return find_by_sql($sql);
$sql  =" SELECT p.id,p.item_code,p.description,p.color,p.store_qty,p.shop_qty,p.date,c.name";
   $sql  .=" AS category_name,c.measuring_unit AS category_measur";
   $sql  .=" FROM products p";
   $sql  .=" LEFT JOIN category c ON c.id = p.category";
   $sql  .=" WHERE p.item_code LIKE '{$p_code}%'";
   $sql  .=" ORDER BY p.item_code ASC";
  
   return find_by_sql($sql);


  }

   function with_only_one_hyphen(){
    global $db;
   //  $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
   // $sql  .=" AS categorie,m.file_name AS image";
   // $sql  .=" FROM products p";
   // $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
   // $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
   // $sql  .=" ORDER BY p.id ASC";
   // return find_by_sql($sql);
$sql  =" SELECT item_code";
   $sql  .=" FROM products";
   $sql  .=" WHERE item_code NOT LIKE '%-%-%'";
   $sql  .=" ORDER BY item_code ASC";
  
   return find_by_sql($sql);


  }

function join_a_product_table_move($p_code){
     global $db;

$sql  =" SELECT p.id,p.item_code,p.description,p.store_qty,p.shop_qty,p.date,c.name";
    $sql  .=" AS category_name,c.measuring_unit AS category_measur";
    $sql  .=" FROM products p";
    $sql  .=" LEFT JOIN category c ON c.id = p.category";
    $sql  .=" WHERE p.item_code ='{$p_code}'";
    $sql  .=" ORDER BY p.id ASC";
   
    return find_by_sql($sql);


   }
   function join_a_product_table_with_id($p_code){
    global $db;

$sql  =" SELECT p.id,p.item_code,p.description,p.store_qty,p.shop_qty,p.date,c.name";
   $sql  .=" AS category_name,c.measuring_unit AS category_measur";
   $sql  .=" FROM products p";
   $sql  .=" LEFT JOIN category c ON c.id = p.category";
   $sql  .=" WHERE p.id ='{$p_code}'";
   $sql  .=" ORDER BY p.id ASC";
  
   return find_by_sql($sql);


  }
   function find_product_history($prod_id,$start_date,$end_date){
    $startdate  = date("Y-m-d", strtotime($start_date));
    $enddate    = date("Y-m-d", strtotime($end_date));
    $sql  ="SELECT id, item_id, r_no, qty, cost, date FROM purchase WHERE item_id ='{$prod_id}' AND date BETWEEN '{$startdate}' AND '{$enddate}' UNION ALL";
    $sql  .=" SELECT id, item_id, r_no, quantity AS qty, cost, date FROM sell WHERE item_id ='{$prod_id}' AND date BETWEEN '{$startdate}' AND '{$enddate}' UNION ALL";
    $sql  .=" SELECT id, item_id, r_no, qty, cost, date FROM sample WHERE item_id ='{$prod_id}' AND date BETWEEN '{$startdate}' AND '{$enddate}' UNION ALL ";
    $sql  .=" SELECT id, item_id, r_no, qty, cost, date FROM move ";
    $sql  .=" WHERE item_id ='{$prod_id}' AND date BETWEEN '{$startdate}' AND '{$enddate}'";
    $sql  .=" ORDER BY date ASC";
   
    return find_by_sql($sql);
  }
  function find_product_history_all($start_date,$end_date){
    $startdate  = date("Y-m-d", strtotime($start_date));
    $enddate    = date("Y-m-d", strtotime($end_date));
    $sql  ="SELECT products.item_code, item_id, r_no, qty, cost, purchase.date FROM purchase LEFT JOIN products ON products.id = purchase.item_id WHERE purchase.date BETWEEN '{$startdate}' AND '{$enddate}' UNION ALL";
    $sql  .=" SELECT products.item_code, item_id, r_no, quantity AS qty, cost, sell.date FROM sell LEFT JOIN products ON products.id = sell.item_id WHERE sell.date BETWEEN '{$startdate}' AND '{$enddate}' UNION ALL";
    $sql  .=" SELECT products.item_code, item_id, r_no, qty, cost, sample.date FROM sample LEFT JOIN products ON products.id = sample.item_id WHERE sample.date BETWEEN '{$startdate}' AND '{$enddate}' UNION ALL ";
    $sql  .=" SELECT products.item_code, item_id, r_no, qty, cost, move.date FROM move LEFT JOIN products ON products.id = move.item_id";
    $sql  .=" WHERE move.date BETWEEN '{$startdate}' AND '{$enddate}'";
    $sql  .=" ORDER BY item_id DESC, date ASC";
    return find_by_sql($sql);
  }
  function find_product_history_all_like($start_date,$end_date,$p){
    $startdate  = date("Y-m-d", strtotime($start_date));
    $enddate    = date("Y-m-d", strtotime($end_date));
    $sql  ="SELECT products.item_code, item_id, r_no, qty, cost, purchase.date,category.measuring_unit FROM purchase LEFT JOIN products ON products.id = purchase.item_id  LEFT JOIN category on products.category=category.id WHERE purchase.date BETWEEN '{$startdate}' AND '{$enddate}' AND products.item_code LIKE '{$p}%' UNION ALL";
    $sql  .=" SELECT products.item_code, item_id, r_no, quantity AS qty, cost, sell.date,category.measuring_unit FROM sell LEFT JOIN products ON products.id = sell.item_id  LEFT JOIN category on products.category=category.id WHERE sell.date BETWEEN '{$startdate}' AND '{$enddate}' AND products.item_code LIKE '{$p}%' UNION ALL";
    $sql  .=" SELECT products.item_code, item_id, r_no, qty, cost, sample.date,category.measuring_unit FROM sample LEFT JOIN products ON products.id = sample.item_id  LEFT JOIN category on products.category=category.id WHERE sample.date BETWEEN '{$startdate}' AND '{$enddate}' AND products.item_code LIKE '{$p}%' UNION ALL ";
    $sql  .=" SELECT products.item_code, item_id, r_no, qty, cost, move.date,category.measuring_unit FROM move LEFT JOIN products ON products.id = move.item_id  LEFT JOIN category on products.category=category.id";
    $sql  .=" WHERE move.date BETWEEN '{$startdate}' AND '{$enddate}' AND products.item_code LIKE '{$p}%'";
    $sql  .=" ORDER BY item_id DESC, date ASC";
    return find_by_sql($sql);
  }
   
   
  /*--------------------------------------------------------------*/
  /* Function for Finding all product name
  /* Request coming from ajax.php for auto suggest
  /*--------------------------------------------------------------*/

   function find_product_by_title($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT item_code FROM products WHERE item_code like '%$p_name%' LIMIT 5";
     $result = find_by_sql($sql);
     return $result;
   }
   function find_all_purchase_by_pid($pid){
    global $db;
     $p_name = remove_junk($db->escape($pid));
     $sql  = "SELECT * FROM purchase";
    $sql .= " WHERE item_id ='{$p_name}'";
     $result = find_by_sql($sql);
     return $result;
  }
  function find_all_sell_by_pid($pid){
    global $db;
     $p_name = remove_junk($db->escape($pid));
     $sql  = "SELECT * FROM sell";
    $sql .= " WHERE item_id ='{$p_name}'";
     $result = find_by_sql($sql);
     return $result;
  }

  /*--------------------------------------------------------------*/
  /* Function for Finding all product info by product title
  /* Request coming from ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE item_code ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty_store($qty,$p_id){
    global $db;
    $qty = (double) $qty;
    $qty = round($qty,3);
    $id  = (int)$p_id;

    $sql = "UPDATE products SET store_qty= Round(store_qty -'{$qty}',3),shop_qty= Round(shop_qty +'{$qty}',3) WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  function purchase_update_product_qty_store($qty,$p_id){
    global $db;
    $qty = (double) $qty;
    $qty = round($qty,3);
    $id  = (int)$p_id;

    $sql = "UPDATE products SET store_qty= Round(store_qty +'{$qty}',3) WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  function sell_update_product_qty_store($qty,$p_id){
    global $db;
    $qty = (double) $qty;
    $qty = round($qty,3);
    $id  = (int)$p_id;

    $sql = "UPDATE products SET shop_qty= Round(shop_qty -'{$qty}',3) WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }



  function update_product_qty($qty,$p_id){
    global $db;
    $qty = (double) $qty;
    $qty = round($qty,3);
    $id  = (int)$p_id;

    $sql = "UPDATE products SET remaining= Round(remaining -'{$qty}',3) WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  /*--------------------------------------------------------------*/
  /* Function for Display Recent product Added
  /*--------------------------------------------------------------*/
 function find_recent_product_added($limit){
   global $db;
   $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
   $sql  .= "m.file_name AS image FROM products p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Find Highest saleing Product
 /*--------------------------------------------------------------*/
 function find_higest_saleing_product($limit){
   global $db;
   $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
   $sql .= " GROUP BY s.product_id";
   $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ".$db->escape((int)$limit);
   return $db->query($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for find all sales
 /*--------------------------------------------------------------*/
 function find_all_sale(){
   global $db;
   $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON s.product_id = p.id";
   $sql .= " ORDER BY s.date DESC";
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Display Recent sale
 /*--------------------------------------------------------------*/
function find_recent_sale_added($limit){
  global $db;
  $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " ORDER BY s.date DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_sale_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date,s.r_no,s.quantity, p.item_code,p.description,p.color,c.name,c.measuring_unit ";
  // $sql .= "COUNT(s.product_id) AS total_records,";
  // $sql .= "SUM(s.qty) AS total_sales,";
  // $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  // $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sell s ";
  $sql .= "LEFT JOIN products p ON s.item_id = p.id ";
  $sql .= "LEFT JOIN category c ON p.category = c.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  // $sql .= " GROUP BY DATE(s.date),p.name";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Daily sales report
/*--------------------------------------------------------------*/
function  dailySales($year,$month){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$year}-{$month}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Monthly sales report
/*--------------------------------------------------------------*/
function  monthlySales($year){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$year}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
  $sql .= " ORDER BY date_format(s.date, '%c' ) ASC";
  return find_by_sql($sql);
}



// own customizations


?>