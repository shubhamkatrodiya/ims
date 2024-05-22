<?php 

  include 'db.php';
  session_start();

  $sql = "select * from `refernce`";
  $res = mysqli_query($con,$sql);

  if(isset($_GET['id']))
  {
    $id= $_GET['id'];

    $dlt = "delete from `refernce` where `id`=$id";
    mysqli_query($con,$dlt);
    
    header("location:view_refernce.php");
  }

    $search = ''; 

    $limit = 2; 
    
    if (isset($_GET['page']))   
    {
        $page = $_GET['page'];
    }else
    {
        $page = 1;
    }
    $start = ($page - 1) * $limit;  

    if (isset($_GET['ref_name'])) 
    {
      $search = $_GET['ref_name'];
      $sql_page = "select * from `refernce` WHERE ref_name LIKE '%$search%' LIMIT $start, $limit";
      $sql1 = "select * from `refernce` WHERE ref_name LIKE '%$search%'";
    } else 
    {
      $sql_page = "select * from refernce limit $start, $limit";
      $sql1 = "select * from refernce";
    }

    $total_rec = mysqli_query($con, $sql1);
    $total_r = mysqli_num_rows($total_rec);
    $total_page = ceil($total_r/$limit);
    $res_page = mysqli_query($con, $sql_page); 


  include "header.php";

 ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Refernce Table</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Refernce Table</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->


     <form method="get">
        <input type="text" name="ref_name" value="<?php echo $search; ?>">
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
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php while ($data = mysqli_fetch_assoc($res_page)) { ?>
                      <tr>
                          <td><?php echo $data['id']; ?></td>
                          <td><?php echo $data['ref_name']; ?></td>
                        <th>
                            <a href="add_refernce.php?id=<?php echo $data['id']; ?>">Edit</a>
                            </th>
                            <th> 
                            <a href="view_refernce.php?id=<?php echo $data['id']; ?>">Delete</a>
                        </th>
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
    <div class="btn">
      <a href="view_refernce.php">All</a>
      <a <?php if ($page == 1) { echo 'style="pointer-events: none; opacity: 0.5;"'; } ?> 
      href='view_refernce.php?page=<?php echo ($page-1); ?>&ref_name=<?php echo $search; ?>' 
      >Previous</a>

      <?php for($i = 1; $i <= $total_page; $i++) {
          echo "<a href='view_refernce.php?page=$i&ref_name=$search'>$i</a> ";
      } ?>
      <a <?php if ($page == $total_page) { echo 'style="pointer-events: none; opacity: 0.5;"'; } ?> href='view_refernce.php?page=<?php echo ($page+1); ?>&ref_name=<?php echo $search; ?>' 
      >Next</a>
    </div>
    </section>
    <!-- /.content -->
  </div>

  <?php 
    include "footer.php";
   ?>
    <style type="text/css">
     .btn a
     {
      border: 1px solid black;
      padding: 6px;
      background-color: darkblue;
      color: white;
     }
   </style>