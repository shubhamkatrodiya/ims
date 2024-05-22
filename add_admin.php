<?php 

  include 'db.php';
  
  session_start();
    
  if(!isset($_SESSION['userid']))
  {
    header("location:index.php");         
  }

  $user_id = $_SESSION['userid'];
  
  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $sql = "select * from `admin` where `id`=$id";
    $res = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($res);
    // $user_id = @$_SESSION['userid']['id'];  
  }

  if(isset($_POST['submit']))
  {
    // $user_id = $_SESSION['userid']['id'];  
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = @$_POST['password'];
    
    if($_POST['submit']=='Submit')
    {
      $image = rand(10000,90000).'img.jpg';
      $path = "image/admin/".$image;
      move_uploaded_file($_FILES['image']['tmp_name'], $path);
      $image = $_FILES['image']['name'];
    }
    else
    {
        if($_FILES['image']['name']!='')
        {
          $image = rand(10000,90000).'img.jpg';
          $path = "image/admin/".$image;
          move_uploaded_file($_FILES['image']['tmp_name'], $path);
          unlink("image/admin/".@$data['image']);
        }
        else
        {
          $image=$data['image'];
        }
        print_r($_FILES['image']);
  }

    $role_id = $_POST['role_id'];
    $branch_id = $_POST['branch_id'];

    $select="select * from `admin` where email='$email'"; 
    $res1=mysqli_query($con,$select);
    $sel = mysqli_fetch_assoc($res1);

    if (isset($_GET['id'])) 
    {   
      if(mysqli_num_rows($res1)==0) 
      {
        $sql = "update `admin` set name='$name',email='$email',image='$image',role_id='$role_id',branch_id='$branch_id' WHERE id=$id"; 
        mysqli_query($con, $sql);
        // header("location:view_admin.php");
        if($id==$user_id) 
        {
          header("location:log-out.php");
        }              
      }
      else 
      {
        if($sel['id']==$id)
        {
          $sql = "UPDATE `admin` SET name='$name', email='$email', image='$image',role_id=' $role_id',branch_id='$branch_id' WHERE id=$id"; 
          mysqli_query($con, $sql);
          header("location:view_admin.php");      
        }
        else 
        {
          $mes = "this is alrady exist...!";
        }
      }
    } 
    else 
    {   
      if(mysqli_num_rows($res1)==0)
        {
            $sql = "INSERT INTO `admin` (`name`,`email`,`password`,`image`,`role_id`,`branch_id`) VALUES ('$name', '$email','$password','$image','$role_id','$branch_id')";
            mysqli_query($con, $sql);
        }
        else
        {
          $mes = "email already exist";
        }
    }
  
  }

  $sql_select_role = "select * from role";
  $role_data = mysqli_query($con,$sql_select_role);

  $sql_select_branch = "select * from branch";
  $branch_data = mysqli_query($con,$sql_select_branch);


  include "header.php";

 ?>
 <style type="text/css">
   h5 
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
        
        <h2 style="color: red"><?php echo @$mes; ?></h2>

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Admin</li>
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
                <h3 class="card-title">Add Admin</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" id="tit" id="exampleInputEmail1" placeholder="Enter Name" value="<?php echo @$data['name'] ?>">
                    <h5>Enter name...!</h5>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?php echo @$data['email'] ?>">
                    <h5>Enter Email...........!</h5>
                  </div>

                  <?php 
                    if(!isset($_GET['id']))
                    {
                  ?>
                  <!-- </div> -->
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo @$data['password'] ?>">
                    <h5>Enter Password.............!</h5>
                  </div>
                  <?php 
                    }
                    else if($id==$user_id)
                    {
                  ?>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Change Password</label><br>
                    <a href="current_password.php" class="btncha">Change password</a>
                  </div>
                  <?php 
                    } 
                  ?>

                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                        <input type="file" name="image" id="img" class="custom-file-input" >
                        <h5>enter your image</h5>                      
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                  </div>
    <?php
    if(@$_GET['id'])
    {
      ?>
                   <img style="width: 100px" id="fimg" src="image/admin/<?php echo @$data['image']; ?>" id="fimg">
      <?php
    }
    ?>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Role</label>
                    <select class="form-control" id="role" name="role_id">
                      <option selected="" disabled value="">Select</option>
                      <?php while($row = mysqli_fetch_assoc($role_data)) { 
                        $selected = (@$data['role_id']==$row['id']) ? 'selected' : '' ; ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $selected ; ?>><?php echo $row['role_name']; ?></option>
                      <?php } ?>
                    </select>
                    <h5>Select Role.......!</h5>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Branch</label>
                    <select class="form-control" id="branch" name="branch_id" value=<?php echo $data['branch_name']; ?>>
                      <option selected="" value="" disabled>--Select Branch--</option>
                      <?php while($row = mysqli_fetch_assoc($branch_data)) { 
                        $selected = (@$data['branch_id']==$row['id']) ? 'selected' : '' ; ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $selected ; ?>><?php echo $row['branch_name']; ?></option>
                      <?php } ?>
                    </select>
                    <h5>Enter Branch.....!</h5>
                  </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" name="submit" class="btn btn-primary" value="<?php if(@$_GET['id']){?>Update<?php }else{?>Submit<?php }?>">
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>



  <script type="text/javascript">
  
  $(document).ready(function()
  {
      $('#frm').submit(function() 
      {

        var name = $('#tit').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var role = $('#role').val();
        var branch = $('#branch').val();
       
        
        if(name=='')
        {
          $('#tit').next('h5').css('display','inline')
          return false;
        }
        if(email=='')
        {
          $('#email').next('h5').css('display','inline')
          return false;
        }
        if(password=='')
        {
          $('#password').next('h5').css('display','inline')
          return false;
        }
        if(role==null)
        {
          $('#role').next('h5').css('display','inline')
          return false;
        }
        if(branch==null)
        {
          $('#branch').next('h5').css('display','inline')
          return false;
        }
        // var image = $('#img').val();
        // var im = $('#fimg').attr('src');
        // if(im!="image/admin/") {
        //   $('#img').val(im);
        // }
        // if(image == '') {
        //   $('#img').next('h5').css('display','inline');
        //   return false;
        // }
      
    })
});
</script>