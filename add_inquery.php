<?php 

  include 'db.php';
  session_start();
  
  if(!isset($_SESSION['userid']))
   {
    header("location:index.php");
   }


  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $sql1 = "select * from `inquiry` where `id`=$id";
    $res = mysqli_query($con,$sql1);
    $data = mysqli_fetch_assoc($res);
  }


 
  if(isset($_POST['submit']))
  {
    $branch_id = $_POST['branch_id'];
    $inquiry_name = $_POST['inquiry_name'];
    $contact = $_POST['contact'];
    $course = $_POST['course'];
    $course_str = implode(",", $_POST['course']); 
    
    $detail = $_POST['detail'];
    $join_date = $_POST['join_date'];
    $ref_id = $_POST['ref_id'];
    $ref_reason = $_POST['ref_reason'];
    $inquiryby = $_POST['inquiryby'];
    $status = $_POST['status'];

    if(isset($_GET['id']))
    {
        $sql = "UPDATE `inquiry` SET `branch_id`='$branch_id',`inquiry_name`='$inquiry_name',`contact`='$contact',`course`='$course_str',`detail`='$detail',`join_date`='$join_date',`ref_id`='$ref_id',`ref_reason`='$ref_reason',`inquiryby`='$inquiryby',`status`='$status' WHERE `id`=".$_GET['id'];
    }else
    {
      $sql= "INSERT INTO `inquiry` (`branch_id`,`inquiry_name`,`contact`,`course`,`detail`,`join_date`,`ref_id`,`ref_reason`,`inquiryby`,`status`) VALUES ('$branch_id','$inquiry_name','$contact','$course_str','$detail','$join_date','$ref_id','$ref_reason','$inquiryby','$status')";

    mysqli_query($con,$sql);
    }
    header("location:view_inquery.php");
  }

 $sql_select_ref = "select * from `refernce`";
  $ref_data = mysqli_query($con,$sql_select_ref);

  $sql_select_status = "select * from `status`";
  $status_data = mysqli_query($con,$sql_select_status);

  $sql_select_course = "select * from `course`";
  $course_data = mysqli_query($con,$sql_select_course);

  $userid = $_SESSION['userid'];
  $cat="select * from `admin` WHERE id = $userid";
  $branch_data=mysqli_query($con,$cat);
  $admindata = mysqli_fetch_assoc($branch_data);

  include "header.php";

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
            <h1>Inquiry</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Inquiry </li>
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
                <h3 class="card-title">Quick Example</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
               
                  <div class="form-group">
                    <label for="exampleInputPassword1">Branch Name</label>
                    <select class="form-control" name="branch_id" value="<?php echo @$data['branch_id'] ?>">
                      <?php 
                        $sql_select_branch = "select * from branch";
                        $admin_data = mysqli_query($con,$sql_select_branch);
                       ?>
                      <option selected="" disabled="">Branch Name</option>
                      <?php while($row = mysqli_fetch_assoc($admin_data)) { ?>
                        <option value="<?php echo $row['id'];?>"<?php if(@$admindata['branch_id']==@$row['id']) {echo "selected";} ?>>
                          <?php echo $row['branch_name']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="inquiry_name" id="tit" placeholder="Enter Name" value="<?php echo @$data['inquiry_name'] ?>">
                    <h4>Enter name........!</h4>
                  </div>

                   <div class="form-group">
                    <label for="exampleInputEmail1">Contact</label>
                    <input type="text" class="form-control" name="contact" id="contact" placeholder="Enter contact" value="<?php echo @$data['contact'] ?>">
                    <h4>Enter valid Contact...........!</h4>
                    <span style="color: red; display: none;">Enter valid contact...!</span>
                  </div>

                <div class="form-group">
                  <label>Course</label>
                  <select class="select2" id="cat" multiple="multiple" data-placeholder="Select course" style="width: 100%;" name="course[]">
                      <?php while($row = mysqli_fetch_assoc($course_data)) { ?>
                          <?php $courseIds = explode(',', $data['course']); ?>
                          <option value="<?php echo $row['id']; ?>" <?php if(in_array($row['id'], $courseIds)) echo 'selected'; ?>>
                              <?php echo $row['course_name']; ?>
                          </option>
                      <?php } ?>
                  </select>
                      <h4>Enter branch....!</h4>

              </div>
                  
                   <div class="form-group">
                    <label for="exampleInputEmail1">Detail</label>
                    <input type="text" class="form-control" name="detail" id="detail" placeholder="Enter Detail" value="<?php echo @$data['detail'] ?>">
                    <h4>Enter Details.........!</h4>
                  </div>
                   <div class="form-group">
                    <label for="exampleInputEmail1">Join Date</label>
                    <input type="date" class="form-control" name="join_date" id="join" placeholder="Enter Join Date" value="<?php echo @$data['join_date'] ?>">
                    <h4>Enter join date.........!</h4>
                  </div>

                   <div class="form-group">
                    <label for="exampleInputPassword1">Refernce Name</label>
                    <select class="form-control" name="ref_id" id="ref"> value="<?php echo @$data['ref_name'] ?>">
                      <option selected=""value="" disabled>Select</option>
                      <?php while($row = mysqli_fetch_assoc($ref_data)) { 
                        $selected = (@$data['ref_id']==$row['id']) ? 'selected' : '' ; ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $selected ; ?>><?php echo $row['ref_name']; ?></option>
                      <?php } ?>
                    </select>
                    <h4>Enter reference..........!</h4>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Refernce Reason</label>
                    <input type="text" class="form-control" name="ref_reason" id="refrea" placeholder="Enter Reason" value="<?php echo @$data['ref_reason'] ?>">
                    <h4>Enter reason...............!</h4>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Inquiry BY</label>
                    <select class="form-control" name="inquiryby">
                      <?php  $sql_select_admin = "select * from admin";
                        $admin_data1 = mysqli_query($con,$sql_select_admin); ?>
                      <option selected="" disabled>--Select Inquiryby--</option>
                      <?php while($row = mysqli_fetch_assoc($admin_data1)) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $userid) echo "selected"; ?>><?php echo $row['name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Status Name</label>
                    

                   <select class="form-control" name="status" value="<?php echo @$data['status_name'] ?>">
                      <option selected="" disabled="">Select Status Name</option>
                      <?php while($row = mysqli_fetch_assoc($status_data)) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php if($row['status_name']=='pending') {?> selected <?php } ?>><?php echo $row['status_name']; ?></option>                   
                      <?php } ?>
                    </select>
                  </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" name="submit" class="btn btn-primary" value="submit">
                </div>
              </form>
            </div>
            <!-- /.card -->
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
    });
</script>
  
  <script type="text/javascript">
  
  $(document).ready(function()
  {
      $('#frm').submit(function() 
      {

        var name = $('#tit').val();

        var contact= $('#contact').val();
        var c_contact =  /((\d{12}|\d{10}))|\d{5}([- ])\d{6}/;
        var cat = $('#cat').val();
        var detail = $('#detail').val();
        var join = $('#join').val();
        var ref = $('#ref').val();
        var refrea = $('#refrea').val();

        if(name=='')
        {
          $('#tit').next('h4').css('display','inline')
          return false;
        }
        if(contact=='')
        {
          $('#contact').next('h4').css('display','inline')
          return false;
        }
        if(!c_contact.test(contact))
        {
            $('#contact').next('span').css('display','inline')
            return false;
        }
        else
        {
            $('#contact').next('span').css('display','none')
        }
        if(cat==null)
        {
          $('#cat').next('h4').css('display','inline')
          return false;
        }
          if(detail=='')
        {
          $('#detail').next('h4').css('display','inline')
          return false;
        }
        if(join=='')
        {
          $('#join').next('h4').css('display','inline')
          return false;
        }
        if(ref==null)
        {
          $('#ref').next('h4').css('display','inline')
          return false;
        }
        if(refrea=='')
        {
          $('#refrea').next('h4').css('display','inline')
          return false;
        }
    })
});
</script>