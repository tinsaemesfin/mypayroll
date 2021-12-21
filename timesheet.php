<?php
$page_title = 'Time Sheet';
require_once 'includes/load.php';
page_require_level(1);
include_once 'layouts/header.php';
?>

<?php if(isset($_POST["submit_csv"])){ 
    echo $filename=$_FILES["file"]["tmp_name"];
        if($_FILES["file"]["size"] > 0)
		    {
		    	$file = fopen($filename, "r");
                while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	                {	    
                    //It wiil insert a row to our subject table from our csv file`
                    $sql = "INSERT into attendance (`SUBJ_CODE`, `SUBJ_DESCRIPTION`, `UNIT`, `PRE_REQUISITE`,COURSE_ID, `AY`, `SEMESTER`) 
                            values('$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]')";
                    //we are using mysql_query function. it returns a resource on true else False on error
                    $result = mysqli_query( $conn, $sql );
                        if(! $result )
                        {
                            echo "<script type=\"text/javascript\">
                                    alert(\"Invalid File:Please Upload CSV File.\");
                                    window.location = \"index.php\"
                                </script>";
                        
                        }

	                }
	         fclose($file);
            }
    
?>




<?php } ?>



<div class="row">
    <div class="col-md-12">
        <div class="alert" style="background-color:#7fc78b">
            <div class="container">
                <h1 style="color:white; text-align:center;">TimeSheet Data's</h1>
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
                    <span>Import TimeSheet</span>
                </strong>
            </div>
            <div class="panel-body">
                <form class="clearfix" method="post" action="timesheet.php">
                    <div class="form-group">                   
                        <div class="custom-file">
                            <input type="file" class="custom-file-input form-control" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>                          
                    </div>                    
                    <div class="form-group">
                        <button type="submit" name="submit_csv" class="btn btn-primary">Upload TimeSheet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<?php include_once 'layouts/footer.php'; ?>