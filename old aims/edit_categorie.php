<?php
  $page_title = 'Edit categorie';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $categorie = find_by_id('category',(int)$_GET['id']);
  if(!$categorie){
    $session->msg("d","Missing categorie id.");
    redirect('categorie.php');
  }
?>

<?php
if(isset($_POST['edit_cat'])){
  $req_field = array('categorie-name','categorie-measuring_unit');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['categorie-name']));
  $cat_measuring_unit= remove_junk($db->escape($_POST['categorie-measuring_unit']));
  if(empty($errors)){
        $sql = "UPDATE category SET name='{$cat_name}',measuring_unit='{$cat_measuring_unit}'";
       $sql .= " WHERE id='{$categorie['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $session->msg("s", "Successfully updated Categorie");
       redirect('categorie.php',false);
     } else {
       $session->msg("d", "Sorry! Failed to Update");
       redirect('categorie.php',false);
     }
  } else {
    $session->msg("d", $errors);
    redirect('categorie.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Editing <?php echo remove_junk(ucfirst($categorie['name']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="edit_categorie.php?id=<?php echo (int)$categorie['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="categorie-name" value="<?php echo remove_junk(ucfirst($categorie['name']));?>">
                  <select style="margin-top:10px;width:50%;" class="form-control" name="categorie-measuring_unit">
                      <option value="">Select Measuring Unit</option>
                    <?php   
                    $unit_items=array(
'M2',
'M',
'Pcs'


 );foreach ($unit_items as $unit): ?>
                      <option  value="<?php echo $unit;?>" <?php if ($unit==$categorie['measuring_unit']){echo 'selected';}?> >
                        
                        <?php echo $unit;?></option>
                        
                    <?php endforeach; ?>
                    </select>
               
               
              
           </div>
           <button type="submit" name="edit_cat" class="btn btn-primary">Update categorie</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once('layouts/footer.php'); ?>
