<?php 

include 'db.php';
  session_start();
  // include 'db.php';
  include "header.php";

  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $sql = "select * from `role` where `id`=$id";
    $res = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($res);
  }

  // if(isset($_POST['submit']))
  // {
  //   $role_name = $_POST['role_name'];

  //   if(isset($_GET['id']))
  //   {
  //      $sql = "UPDATE `role` SET `role_name`='$role_name' WHERE `id`=".$_GET['id'];
  //   }else
  //   {
  //     $sql= "INSERT INTO `role` (`role_name`) VALUES ('$role_name')";
  //   }
  //   mysqli_query($con,$sql);
  //   header("location:view_role.php");
  // }

  if(isset($_POST['submit']))
  {
        $role_name = $_POST['role_name'];
        $match = "select * from role where role_name='$role_name'";
        $select_record = mysqli_query($con,$match);
        $select_res = mysqli_num_rows($select_record);

    
      if(isset($_GET['id']))
      {
          $id = $_GET['id'];
          $sql = "update role set role_name='$role_name' where id=".$id;
      }else
      {
        if($select_res == 0)
        {
          $sql = "insert into role (role_name) values ('$role_name')";
        }else {
              $mes = "Role is already exist";
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
            <h1>Role</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Role Form</li>
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
                <h3 class="card-title">Add admin</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Role</label>
                    <input type="text" class="form-control" name="role_name" id="role" placeholder="Enter Role" value="<?php echo @$data['role_name'] ?>">
                    <span style="color: red; display: none;">Enter Role...!</span>
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
        var role= $('#role').val();

    if(role=='')
    {
      $('#role').next('span').css('display','inline')
      return false;
    }else
    {
      $('#role').next('span').css('display','none')
    }
      
    })
});
</script>