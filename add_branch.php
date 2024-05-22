<?php 

include 'db.php';
  session_start();
  include "header.php";

  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $sql = "select * from `branch` where `id`=$id";
    $res = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($res);
  }

  if(isset($_POST['submit']))
  {
        $branch_name = $_POST['branch_name'];
        $match = "select * from branch where branch_name='$branch_name'";
        $select_record = mysqli_query($con,$match);
        $select_res = mysqli_num_rows($select_record);

      if(isset($_GET['id']))
      {
          $id = $_GET['id'];
          $sql = "update branch set branch_name='$branch_name' where id=".$id;
      }else
      {
        if($select_res == 0)
        {
          $sql = "insert into branch (branch_name) values ('$branch_name')";
        }else {
              $mes = "Branch is already exist";
        }
      }
      if(isset($sql)) {
      mysqli_query($con, $sql);
      header("location:view_branch.php");   
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
            <h1>Branch</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Branch Form</li>
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
                    <label for="exampleInputEmail1">Branch</label>
                    <input type="text" class="form-control" name="branch_name" id="branch" placeholder="Enter Branch" value="<?php echo @$data['branch_name'] ?>">
                    <span style="color: red; display: none;">Enter Branch...!</span>
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
        var branch= $('#branch').val();

    if(branch=='')
    {
      $('#branch').next('span').css('display','inline')
      return false;
    }else
    {
      $('#branch').next('span').css('display','none')
    }
      
    })
});
</script>