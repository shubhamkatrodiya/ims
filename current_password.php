<?php 
  session_start();
  include 'db.php';

  if(isset($_POST['submit'])) {
    $password = md5($_POST['password']);
    $user_id = $_SESSION['username']['id'];
  
    $pass_select = "select * from `admin` where `id`='$user_id' and `password`='$password'";
    $pass_res = mysqli_query($con , $pass_select);
    $pass_rec = mysqli_num_rows($pass_res);

    if($pass_rec==1){
      header("location:change_password.php");
    }
    else
    {
      $msg = "Your current password is wrong";
    }

  }


  include 'header.php';
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Chang password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="Dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">change password</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<style type="text/css">    
    h6
    {
      color: red;
      display: none;
    }  
</style>    
<!-- Main content -->
    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Change password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Current password</label>
                    <input type="password" name="password"  value="<?php echo @$data['password']; ?>" class="form-control" id="password" placeholder="Enter password">
                    <h6>enter your current password</h6>
                    <h5 style="color: red;"><?php echo @$msg; ?></h5>
                  </div>                 
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit"  class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>            
          </div>      
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    
    $('#frm').submit(function(){      
      var pass = $('#password').val();
      // var p_pat = /^[a-zA-Z0-9!@#\$%\^\&*_=+-]{8,12}/

      if(pass == '') {
        $('#password').next('h6').css('display','inline');
        return false;
      }

     


    })

</script>


<?php 
  include 'footer.php';
?>
