<?php
$page_title = 'All categories';
require_once 'includes/load.php';
// Checkin What level user has permission to view this page
page_require_level(1);

$all_categories = find_all('category');
?>
<?php
if (isset($_POST['add_cat'])) {
    $req_field = array('categorie-name', 'categorie-measuring_unit');
    validate_fields($req_field);
    $cat_name = remove_junk($db->escape($_POST['categorie-name']));
    $cat_measuring_unit = remove_junk($db->escape($_POST['categorie-measuring_unit']));
    if (empty($errors)) {
        $sql = "INSERT INTO category (name,measuring_unit)";
        $sql .= " VALUES ('{$cat_name}','{$cat_measuring_unit}')";
        if ($db->query($sql)) {
            $session->msg("s", "Successfully Added New Category");
            redirect('categorie.php', false);
        } else {
            $session->msg("d", "Sorry Failed to insert.");
            redirect('categorie.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('categorie.php', false);
    }
}
?>
<?php include_once 'layouts/header.php';?>

  <div class="row">





<div class="col-md-12">
    <div class="alert" style="background-color:#7fc78b">
	            <div class="container">
	            	<h1 style="color:white; text-align:center;">CATEGORIES</h1>
                <br>
	            </div>
	        </div>
</div>








     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>

  </div>
   <div class="row">
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Category</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="categorie.php">
            <div class="form-group">
                <input type="text" class="form-control" name="categorie-name" placeholder="Category Name">
                <!-- <input type="text" class="form-control" name="categorie-measuring_unit" placeholder="Measuring Unit" style="margin-top:10px;width:50%;"> -->
            <select style="margin-top:10px;width:50%;" class="form-control" name="categorie-measuring_unit">
                      <option value="">Select Measuring Unit</option>
                    <?php
$unit_items = array(
    'M2',
    'M',
    'Pcs',

);foreach ($unit_items as $unit): ?>
                      <option value="<?php echo $unit ?>">
                        <!-- <?php echo $cat['name'] ?></option> -->
                        <?php echo $unit; ?></option>

                    <?php endforeach;?>
                    </select>
              </div>
            <button type="submit" name="add_cat" class="btn btn-primary">Add Category</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>All Categories</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Categories</th>
                    <th class="text-center" style="width: 100px;">Measuring Unit</th>
                    <th class="text-center" style="width: 100px;">Number Of Sells</th>
                    <th class="text-center" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_categories as $cat): ?>
                <tr>
                    <td class="text-center"><?php echo count_id(); ?></td>
                    <td><?php echo remove_junk(ucfirst($cat['name'])); ?></td>
                    <td class="text-center"><?php echo remove_junk(ucfirst($cat['measuring_unit'])); ?></td>
                    <td class="text-center"><?php echo remove_junk(ucfirst($cat['no_sell'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="edit_categorie.php?id=<?php echo (int) $cat['id']; ?>"  class="btn  btn-warning" data-toggle="tooltip" title="Edit">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <!-- <a href="delete_categorie.php?id=<?php echo (int) $cat['id']; ?>"  class="btn  btn-danger" data-toggle="tooltip" title="Remove">
                          <span class="glyphicon glyphicon-trash"></span>
                        </a> -->
                      </div>
                    </td>

                </tr>
              <?php endforeach;?>
            </tbody>
          </table>
       </div>
    </div>
    </div>
   </div>
  </div>
  <?php include_once 'layouts/footer.php';?>
