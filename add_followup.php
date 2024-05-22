<?php 

include 'db.php';
  session_start();

  include "header.php";

  if(!isset($_SESSION['userid']))
   {
    header("location:index.php");
   }

  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $sql1 = "select * from `followup` where `id`=$id";
    $res = mysqli_query($con,$sql1);
    $data = mysqli_fetch_assoc($res);
  }

  if(isset($_POST['submit']))
  {
    $inq_id=$_GET['id'];
    $reason = $_POST['reason'];
    $joindate = $_POST['joindate'];
    $f_inquiryby = $_POST['f_inquiryby'];

    if (isset($_GET['id'])) 
    {
        $id = $_GET['id'];
        $sql = "UPDATE followup SET reason='$reason', joindate='$joindate',f_inquiryby='$f_inquiryby' WHERE id=$id"; 
    } else 
    {
        $sql = "INSERT INTO followup (inq_id,reason,joindate,f_inquiryby) VALUES ('$inq_id','$reason','$joindate','$f_inquiryby')";
    }
     mysqli_query($con, $sql);
  }

  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $sql2 = "select * from `inquiry` where `id`=".$id;
    $res2 = mysqli_query($con,$sql2);
    $data2 = mysqli_fetch_assoc($res2);
  } 

  $userid = $_SESSION['userid'];
  $cat="select * from `admin` WHERE id = $userid";
  $branch_data=mysqli_query($con,$cat);
  $admindata = mysqli_fetch_assoc($branch_data);

 ?>
 <style type="text/css">
   h4
   {
    display: none;
    color: red;
   }
 </style>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Follow</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Follow</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Follow</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
               
                  <div class="form-group">
                    <label for="exampleInputEmail1">Inquiry Name</label>
                    <input type="text" class="form-control" name="inquiry_name" value="<?php echo @$data2['inquiry_name']; ?>" disabled>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">contact</label>
                    <input type="text" class="form-control" name="contact" id="contact" placeholder="" value="<?php echo @$data2['contact'] ?>" disabled>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">course</label>
                     <?php 
                     
                      $inquiry="SELECT inquiry.*,course.course_name from inquiry inner join course on inquiry.course=course.id where inquiry.id=".$_GET['id'];
                      $result=mysqli_query($con,$inquiry);
                    
                      while ($inquirydata = mysqli_fetch_assoc($result)) {
                     ?>
                    <input type="text" class="form-control" name="course[]" id="course" placeholder="" value="<?php echo $inquirydata['course_name'] ?>" disabled>
                    <?php
                    } 
                     ?>
                  </div>

                   <div class="form-group">
                    <label for="exampleInputEmail1">Inquiryby</label>
                    <?php 
                      $in_id = $_GET['id'];
                      $sqll = "SELECT inquiry.*, admin.name AS inquiry_name FROM inquiry INNER JOIN admin ON inquiry.inquiryby = admin.id where inquiry.id=$in_id";

                      $result2 = mysqli_query($con,$sqll);
                      $data4 = mysqli_fetch_assoc($result2);
                     ?>
                    <input type="text" class="form-control" name="inquiryby" placeholder="Enter inquiryby" value="<?php echo @$data4['inquiry_name']; ?>" disabled>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Follow-up Reason</label>
                    <input type="text" class="form-control" name="reason" id="reason" placeholder="Enter Reason..." value="<?php echo @$data['reason'] ?>">
                    <h4>Enter reason..........!</h4>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Expected Join Date</label>
                    <input type="date" class="form-control" name="joindate" id="joindate" placeholder="" value="<?php echo @$data['joindate'] ?>">
                    <h4>Enter Expected join date........!</h4>
                  </div>  

                   <div class="form-group">
                    <label for="exampleInputEmail2">Follow-up BY</label>
                    <select name="f_inquiryby" id="f_inquiryby" class="form-control">
                    <option value="" selected> --- Select ---</option>
                      <?php
                      $cat="SELECT * FROM admin WHERE branch_id = (SELECT branch_id FROM admin WHERE id = $userid)";
                      $c_sql=mysqli_query($con,$cat);
                      
                       while ($userdata = mysqli_fetch_assoc($c_sql)) {
                       ?>
                      <option value="<?php echo $userdata['id']; ?>" <?php if(@$admindata['name']==@$userdata['name']){ echo "selected";} ?>>
                          <?php echo $userdata['name']; ?>
                      </option>
                    <?php } ?>
                    </select>
                    <span style="color:red;display: none;">select follow-up by...</span>
                  </div>

                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" name="submit" class="btn btn-primary" value="submit">
                </div>
              </form>
            </div>
            <!-- /.card -->
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>


<?php 
  include "footer.php";
 ?>

 <!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 plugin
        $('.select2').select2();
      $('#frm').submit(function() 
      {

        var name = $('#reason').val();
        var joindate = $('#joindate').val();

        if(name=='')
        {
          $('#reason').next('h4').css('display','inline')
          return false;
        }
        if(joindate=='')
        {
          $('#joindate').next('h4').css('display','inline')
          return false;
        }
        
        
    })
    });
</script>
  
