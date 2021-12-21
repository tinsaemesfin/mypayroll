<?php
$page_title = 'Sales Report';

  require_once('includes/load.php');
  
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php include_once('layouts/header.php'); ?>





<?php
  if(isset($_POST['submit_d'])){
    $req_dates = array('start-date','end-date');
    validate_fields($req_dates);

    if(empty($errors)){
      $start_date   = remove_junk($db->escape($_POST['start-date']));
      $end_date     = remove_junk($db->escape($_POST['end-date']));
      $sells      = find_sale_by_dates($start_date,$end_date);

    }

  } else {
    $session->msg("d", "Select dates");
    redirect('sales_report.php', false);
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
         <form method="post" action="sale_report_process_download.php">
            <input type="hidden" name="start_date" value="<?php echo $start_date?>">
            <input type="hidden" name="end_date" value="<?php echo $end_date?>">
            <input type="submit"  class="btn btn-primary" name="download_srp"  value="Download Excel">
        
    </form>
           
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-left" style="width: 5%;">#</th>
                <th style="width: 20%;"> Item Code </th>
                <th class="text-center" style="width: 10%;"> Item Description </th>
                <th class="text-center" style="width: 10%;"> Category </th>
                <th class="text-center" style="width: 10%;"> Sold Quantity </th>
                <th class="text-center" style="width: 10%;"> Reference Number  </th>
                <th class="text-center" style="width: 10%;"> Sold Date  </th>
               
              </tr>
            </thead>
            <tbody id="product_finds">
              <?php foreach ($sells as $sell):?>
              <tr>
                <td class="text-left"><?php echo count_id();?></td>
               
                <td> <?php echo remove_junk($sell['item_code']); ?></td>
                <td class="text-center"> <?php echo remove_junk($sell['description']); ?></td>
                <td class="text-center"> <?php echo remove_junk($sell['name']); ?></td>
                <td class="text-center"> <?php echo remove_junk($sell['quantity'].' '.$sell['measuring_unit']); ?></td>            
                <td class="text-center"> <?php echo remove_junk($sell['r_no']); ?></td>
                <td class="text-center"> <?php echo remove_junk($sell['date']); ?></td>
                
                
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>

<?php if(isset($db)) { $db->db_disconnect(); } ?>
