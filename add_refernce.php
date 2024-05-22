<?php 

include 'db.php';
  session_start();
  include "header.php";

  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $sql = "select * from `refernce` where `id`=$id";
    $res = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($res);
  }

 if(isset($_POST['submit']))
  {
        $ref_name = $_POST['ref_name'];
        $match = "select * from refernce where ref_name='$ref_name'";
        $select_record = mysqli_query($con,$match);
        $select_res = mysqli_num_rows($select_record);
    
      if(isset($_GET['id']))
      {
          $id = $_GET['id'];
          $sql = "update refernce set ref_name='$ref_name' where id=".$id;
      }else
      {
        if($select_res == 0)
        {
          $sql = "insert into refernce (ref_name) values ('$ref_name')";
        }else {
              $mes = "Refernce is already exist";
        }
      }
      if(isset($sql)) {
      mysqli_query($con, $sql);
      header("location:view_refernce.php");   
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
            <h1>Refernce</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Refernce Form</li>
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
                    <label for="exampleInputEmail1">Refernce</label>
                    <input type="text" class="form-control" name="ref_name" id="refernce" placeholder="Enter Refernce" value="<?php echo @$data['ref_name'] ?>">
                    <span style="color: red; display: none;">Enter Refernce...!</span>
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
        var refernce= $('#refernce').val();

    if(refernce=='')
    {
      $('#refernce').next('span').css('display','inline')
      return false;
    }else
    {
      $('#refernce').next('span').css('display','none')
    }
      
    })
});
</script>