<?php 
  
include 'db.php';
  session_start();
  
  include "header.php";

  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $sql = "select * from `course` where `id`=$id";
    $res = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($res);
  }

  if(isset($_POST['submit']))
  {
        $course_name = $_POST['course_name'];
        $match = "select * from course where course_name='$course_name'";
        $select_record = mysqli_query($con,$match);
        $select_res = mysqli_num_rows($select_record);

    
      if(isset($_GET['id']))
      {
          $id = $_GET['id'];
          $sql = "update course set course_name='$course_name' where id=".$id;
      }else
      {
        if($select_res == 0)
        {
          $sql = "insert into course (course_name) values ('$course_name')";
        }else {
              $mes = "Course is already exist";
        }
      }
      if(isset($sql)) {
      mysqli_query($con, $sql);
      header("location:view_course.php");   
    }
  }


 ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Course</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Course Form</li>
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
                    <label for="exampleInputEmail1">Course</label>
                    <input type="text" class="form-control" name="course_name" id="course" placeholder="Enter Course" value="<?php echo @$data['course_name'] ?>">
                    <span style="color: red; display: none;">Enter Course...!</span>
                    <h4 style="color: red;"><?php echo @$mes; ?></h4>
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

 <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script type="text/javascript">

  $(document).ready(function()
  {
      $('#frm').submit(function() 
      {
        var course= $('#course').val();

    if(course=='')
    {
      $('#course').next('span').css('display','inline')
      return false;
    }else
    {
      $('#course').next('span').css('display','none')
    }
      
    })
});
</script>