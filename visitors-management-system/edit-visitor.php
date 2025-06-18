<?php
session_start();
include ('connection.php');
$name = $_SESSION['name'];
$id = $_SESSION['id'];
if(empty($id))
{
    header("Location: index.php"); 
}
$id = $_GET['id'];
$fetch_query = mysqli_query($conn, "select * from tbl_visitors where id='$id'");
$row = mysqli_fetch_array($fetch_query);
if(isset($_REQUEST['sv-vstr']))
{
  $fullname = $_POST['fullname'];
  $emailid = $_POST['emailid'];
  $mobile = $_POST['mobile'];
  $address = $_POST['address'];
  $meet = $_POST['meet'];
  $department = $_POST['department'];
  $reason = $_POST['reason'];
  $status = $_POST['status'];

  if($status == 0)
{
  $update_visitor = mysqli_query($conn,"update tbl_visitors set name='$fullname', emailid='$emailid', mobile='$mobile', address='$address', to_meet='$meet', department='$department', reason='$reason', status='$status', out_time=now() where id='$id'");
}
else
{
  $update_visitor = mysqli_query($conn,"update tbl_visitors set name='$fullname', emailid='$emailid', mobile='$mobile', address='$address', to_meet='$meet', department='$department', reason='$reason', status='$status' where id='$id'");
}

if($update_visitor > 0)
{
?>
<script type="text/javascript">
    alert("Visitor Updated successfully.");
    window.location.href='manage-visitors.php';
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
            <a href="#">Edit Visitor</a>
          </li>
          
        </ol>
      <div class="card mb-3">
          <div class="card-header">
            <i class="fa fa-info-circle"></i>
            Edit Details</div> 
            <form method="post" class="form-valide">
          <div class="card-body">
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="name">Name</label>
       <div class="col-lg-6">
      <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter Name" required value="<?php echo $row['name']; ?>" readonly>
       </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="email">EmailId</label>
       <div class="col-lg-6">
      <input type="email" name="emailid" id="emailid" class="form-control" placeholder="Enter EmailId" required value="<?php echo $row['emailid']; ?>" readonly>
       </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="mobile">Mobile No.</label>
       <div class="col-lg-6">
      <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile No." required value="<?php echo $row['mobile']; ?>" readonly>
       </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="address">Address</label>
       <div class="col-lg-6">
      <textarea name="address" id="address" class="form-control" placeholder="Enter Address" required readonly><?php echo $row['address']; ?></textarea>
       </div>
      </div>                        
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="meet">Whom to Meet</label>
       <div class="col-lg-6">
      <input type="text" name="meet" id="meet" class="form-control" placeholder="Enter Whom to Meet" required value="<?php echo $row['to_meet']; ?>" readonly>
       </div>
      </div>                                
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="department">Department</label>
       <div class="col-lg-6">
      <input type="text" name="department" id="department" class="form-control" placeholder="Enter Department" required value="<?php echo $row['department']; ?>" readonly>
       </div>
      </div>
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="reason">Reason</label>
       <div class="col-lg-6">
      <input type="text" name="reason" id="reason" class="form-control" placeholder="Enter Reason" required value="<?php echo $row['reason']; ?>" readonly>
       </div>
      </div> 
      <div class="form-group row">
      <label class="col-lg-4 col-form-label" for="intime">In Time</label>
       <div class="col-lg-6">
      <input type="text" name="intime" id="intime" class="form-control" placeholder="In Time" required value="<?php echo $row['in_time']; ?>" readonly>
       </div>
      </div>  
    <div class="form-group row">
    <?php
    if($row['status']==1){
    ?>
    <label class="col-lg-4 col-form-label" for="status">Status <span class="text-danger">*</span>
    </label>
    <div class="col-lg-6">
    <select class="form-control" id="status" name="status" required>
    <option value="">Select Status</option>
    <option value="1" <?php if($row['status'] == 1) { ?> selected="selected"; <?php } ?>>In</option>
    <option value="0" <?php if($row['status'] == 0) { ?> selected="selected"; <?php } ?>>Out</option>
    </select>
    </div>
  <?php } else{ ?>
    <label class="col-lg-4 col-form-label" for="outtime">Out Time
    </label>
    <div class="col-lg-6">
    <input type="text" name="outtime" id="outtime" class="form-control" placeholder="Out Time" required value="<?php echo $row['out_time']; ?>" readonly>
    </div>
  <?php } ?>
    </div>
    <?php
    if($row['status']==1){
    ?>                                                
    <div class="form-group row">
    <div class="col-lg-8 ml-auto">
    <button type="submit" name="sv-vstr" class="btn btn-primary">Save</button>
    </div>
    </div>
  <?php } ?>
    </div>
    </form>
  </div>
</div>
</div>   
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
 <?php include('include/footer.php'); ?>