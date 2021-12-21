<?php
require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) {
    // $cuser=current_user();
    // if($cuser['privilege']==1)
    // {
    //  redirect('admin.php', false);

    // }
    // else{
     redirect('home.php', false);
    // }
    }
?>
<?php include_once('layouts/header.php'); ?>

<div class="login-page">
    <div class="text-center">
       <h1>Login Panel</h1>
       <h4>Payroll Management System</h4>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="auth.php" class="clearfix">
        <div class="form-group">
              <label for="username" class="control-label">Username</label>
              <input type="name" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Password</label>
            <input type="password" name= "password" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-danger" style="border-radius:0%">Login</button>
        </div>
    </form>
</div>
<?php include_once('./layouts/footer.php'); ?>
