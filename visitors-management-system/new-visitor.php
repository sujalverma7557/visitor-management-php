<?php
session_start();
include ('connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id))
{
    header("Location: index.php"); 
}
if(isset($_REQUEST['sbt-vstr']))
{
  $fullname = $_POST['fullname'];
  $emailid = $_POST['emailid'];
  $mobile = $_POST['mobile'];
  $address = $_POST['address'];
  $meet = $_POST['meet'];
  $department = $_POST['department'];
  $reason = $_POST['reason'];

  $insert_visitor = mysqli_query($conn,"insert into tbl_visitors set name='$fullname', emailid='$emailid', mobile='$mobile', address='$address', to_meet='$meet', department='$department', reason='$reason', in_time=now()");

if($insert_visitor > 0)
{
  ?>
<script type="text/javascript">
    alert("Visitor added successfully.")
</script>
<?php
}
}
?>
<?php include('include/header.php'); ?>
<div id="wrapper">
<?php include('include/side-bar.php'); ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Add Visitors</a>
          </li>
        </ol>

  <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-info-circle"></i>
            Submit Details</div>
             
      <form method="post" class="form-valide">
      <div class="card-body">
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="name">Name <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter Name" required>
       </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="email">EmailId <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="email" name="emailid" id="emailid" class="form-control" placeholder="Enter EmailId" required>
       </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="mobile">Mobile No. <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile No." required>
       </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="address">Address <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <textarea name="address" id="address" class="form-control" placeholder="Enter Address" required></textarea>
       </div>
      </div>                        
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="meet">Whom to Meet <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="meet" id="meet" class="form-control" placeholder="Enter Whom to Meet" required>
       </div>
      </div>                                
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="department">Department <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <select name="department" id="department" class="form-control" required>
       <option value="">Select Department</option>
       <?php
       $select_department = mysqli_query($conn,"select * from tbl_department where status=1");
       while($dept = mysqli_fetch_array($select_department)){
       ?>
       <option><?php echo $dept['department']; ?></option>
       <?php } ?>
      </select>
      </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="reason">Reason <span class="text-danger">*</span></label>
       <div class="col-lg-6">
      <input type="text" name="reason" id="reason" class="form-control" placeholder="Enter Reason" required>
       </div>
      </div>                                                   
      <div class="form-group row">
      <div class="col-lg-8 ml-auto">
      <button type="submit" name="sbt-vstr" class="btn btn-primary">Submit</button>
      </div>
      </div>
      </div>
      </form>
      </div>                  
    </div>
  </div>  
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
 <?php include('include/footer.php'); ?>