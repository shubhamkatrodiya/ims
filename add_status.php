<?php 

include 'db.php';
  session_start();
  include "header.php";

  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $sql = "select * from `status` where `id`=$id";
    $res = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($res);
  }

  if(isset($_POST['submit']))
  {
        $status_name = $_POST['status_name'];
        $match = "select * from status where status_name='$status_name'";
        $select_record = mysqli_query($con,$match);
        $select_res = mysqli_num_rows($select_record);
    
      if(isset($_GET['id']))
      {
          $id = $_GET['id'];
          $sql = "update status set status_name='$status_name' where id=".$id;
      }else
      {
        if($select_res == 0)
        {
          $sql = "insert into status (status_name) values ('$status_name')";
        }else {
              $mes = "Status is already exist";
        }
      }
      if(isset($sql)) {
      mysqli_query($con, $sql);
      header("location:view_status.php");   
    }
  }

 ?>
 <style type="text/css">
   span
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
            <h1>Status</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Status </li>
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
                <h3 class="card-title">Add Status</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="frm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <input type="text" class="form-control" name="status_name" id="status" placeholder="Enter Status" value="<?php echo @$data['status_name'] ?>">
                    <span style="color: red; display: none;">Enter Status...!</span>
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
        var status= $('#status').val();

    if(status=='')
    {
      $('#status').next('span').css('display','inline')
      return false;
    }else
    {
      $('#status').next('span').css('display','none')
    }
      
    })
});
</script>