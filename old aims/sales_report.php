<?php
$page_title = 'Sale Report';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">

<div class="col-md-12">
    <div class="alert" style="background-color:#7A83EE">
	            <div class="container">
	            	<h1 style="color:white; text-align:center;">Report for Sales Information</h1> 
                <br>
	            </div>
	        </div>
</div>




  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="panel">
      <div class="panel-heading">

      </div>
      <div class="panel-body">
          <form class="clearfix" method="post" action="sale_report_process.php">
            <div class="form-group">
              <label class="form-label">Date Range</label>
                <div class="input-group">
                  <input type="text" class="datepicker form-control" name="start-date" placeholder="From" autocomplete="off">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                  <input type="text" class="datepicker form-control" name="end-date" placeholder="To" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                 <button type="submit" name="submit_d" class="btn btn-primary">Generate Report</button>
            </div>
          </form>
      </div>

    </div>
  </div>

</div>
<?php include_once('layouts/footer.php'); ?>
