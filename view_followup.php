<?php 
  include 'db.php';

  session_start();

  if(isset($_GET['id']))
  {
    $id= $_GET['id'];

    $dlt = "delete from `followup` where `id`=$id";
    mysqli_query($con,$dlt);
    
    header("location:view_followup.php");
  }

  $limit = 1;

  if (isset($_GET['srch'])) {
      $srch = $_GET['srch'];
  }else{
    $srch="";
  }

  // for pagination

  //  $count_page ="select followup.*,admin.name from `followup` join admin on followup.f_inquiryby=admin.id where followup.name like '%$srch%'";

  //   $count_record = mysqli_query($con,$count_page);
  //   $total_record = mysqli_num_rows($count_record);
  //   $total_page = ceil($total_record/$limit);

  //   if (isset($_GET['page_no'])) {
  //     $page_no = $_GET['page_no'];
  //   }else{
  //     $page_no=1;
  //   }
  //   $start = ($page_no-1)*$limit;


  // $sql = "select followup.*,admin.name from `followup` join admin on followup.f_inquiryby=admin.id where followup.name like '%$srch%' limit $start,$limit ";
  // $inq_data = mysqli_query($con,$sql);

   $sql = "select followup.*,admin.name from `followup` join admin on followup.f_inquiryby=admin.id";
  $followup_data = mysqli_query($con,$sql);

  // $sql = "select * from `followup`";
  // $followup_data= mysqli_query($con,$sql);  
  include "header.php";

 ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>FollowUp Table</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Followup Table</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->


     <form method="get">
        <input type="text" name="srch" value="<?php echo @$search; ?>">
        <input type="submit" name="submit" value="Search">
    </form> 

    </section>

    <style type="text/css">
      img{
        height: 100px;
        width: 100px;
      }
    </style>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Reason</th>
                    <th>Joindate</th>
                    <th>Inquiry By</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php while ($data = mysqli_fetch_assoc($followup_data)) { ?>
                      <tr>
                          <td><?php echo $data['id']; ?></td>
                          <td><?php echo $data['reason']; ?></td>
                          <td><?php echo $data['joindate']; ?></td>
                          <td><?php echo $data['name']; ?></td>
                          <td>
                            <a href="add_followup.php?id=<?php echo $data['id']; ?>">Edit</a>
                          </td>
                          <td> 
                             <a href="view_followup.php?id=<?php echo $data['id']; ?>">Delete</a>
                        </td>
                      </tr>
                    <?php  } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
<!--     
    <?php for($i = 1; $i <= $total_page; $i++) { 
          echo "<a href='view_inquery.php?page_no=$i&name=$srch'>$i</a>";
       } ?>
   -->
  </div>

  <?php 
    include "footer.php";
   ?>