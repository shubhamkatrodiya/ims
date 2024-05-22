<?php 

  include 'db.php';
session_start();
  include "header.php";

  $sql = "select * from `course`";
  $res = mysqli_query($con,$sql);

  if(isset($_GET['id']))
  {
    $id= $_GET['id'];

    $dlt = "delete from `course` where `id`=$id";
    mysqli_query($con,$dlt);
    
    header("location:view_course.php");
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

    if (isset($_GET['course_name'])) 
    {
      $search = $_GET['course_name'];
      $sql_page = "select * from `course` WHERE course_name LIKE '%$search%' LIMIT $start, $limit";
      $sql1 = "select * from `course` WHERE course_name LIKE '%$search%'";
    } else 
    {
      $sql_page = "select * from course limit $start, $limit";
      $sql1 = "select * from course";
    }

    $total_rec = mysqli_query($con, $sql1);
    $total_r = mysqli_num_rows($total_rec);
    $total_page = ceil($total_r/$limit);
    $res_page = mysqli_query($con, $sql_page); 

 ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View Course</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">View Course </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->


     <form method="get">
        <input type="text" name="course_name" value="<?php echo $search; ?>">
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
                          <td><?php echo $data['course_name']; ?></td>
                         <th>
                            <a href="add_course.php?id=<?php echo $data['id']; ?>">Edit</a> 
                          </th>
                          <th>
                            <a href="view_course.php?id=<?php echo $data['id']; ?>">Delete</a>
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
        <a href="view_course.php">All</a>
        <a <?php if ($page == 1) { echo 'style="pointer-events: none; opacity: 0.5;"'; } ?> 
        href='view_course.php?page=<?php echo ($page-1); ?>&course_name=<?php echo $search; ?>' 
        >Previous</a>

        <?php for($i = 1; $i <= $total_page; $i++) {
            echo "<a href='view_course.php?page=$i&course_name=$search'>$i</a> ";
        } ?>
        <a <?php if ($page == $total_page) { echo 'style="pointer-events: none; opacity: 0.5;"'; } ?> href='view_course.php?page=<?php echo ($page+1); ?>&course_name=<?php echo $search; ?>' 
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