<?php 

  include 'db.php';
  
  session_start();

  if(isset($_GET['id']))
  {
    $id= $_GET['id'];

    $dlt = "delete from `inquiry` where `id`=$id";
    mysqli_query($con,$dlt);
    
    header("location:view_inquery.php");
  }

  $limit = 10;

  if (isset($_GET['srch'])) 
  {
      $srch = $_GET['srch'];
  }
  else
  {
    $srch="";
  }

   $count_page ="select inquiry.* , branch.branch_name , course.course_name , status.status_name , refernce.ref_name ,admin.name from `inquiry` join branch on inquiry.branch_id = branch.id JOIN course on inquiry.course = course.id JOIN status on status.id = inquiry.status JOIN refernce on refernce.id = inquiry.ref_id join admin on inquiry.inquiryby=admin.id where inquiry.inquiry_name like '%$srch%'";

    $count_record = mysqli_query($con,$count_page);
    $total_record = mysqli_num_rows($count_record);
    $total_page = ceil($total_record/$limit);

    if (isset($_GET['page_no'])) 
    {
      $page_no = $_GET['page_no'];
    }
    else
    {
      $page_no=1;
    }
    $start = ($page_no-1)*$limit;

  $sql = "select inquiry.* , branch.branch_name , course.course_name , status.status_name , refernce.ref_name ,admin.name from `inquiry` join branch on inquiry.branch_id = branch.id JOIN course on inquiry.course = course.id JOIN status on status.id = inquiry.status JOIN refernce on refernce.id = inquiry.ref_id join admin on inquiry.inquiryby=admin.id where inquiry.inquiry_name like '%$srch%' limit $start,$limit ";
  $inq_data = mysqli_query($con,$sql);


  include 'header.php';

 ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View Inquiry</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">View Inquiry</li>
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
                    <th>Branch name</th>
                    <th>Name</th>
                    <th>Conatct</th>
                    <th>Course</th>
                    <th>Detail</th>
                    <th>Join Date</th>
                    <th>Refrence name</th>
                    <th>Reason</th>
                    <th>Inquiry By</th>
                    <th>Status </th>
                    <th>FollowUp </th>
                    <th>View FollowUp</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php while ($data = mysqli_fetch_assoc($inq_data)) { ?>
                      <tr>
                          <td><?php echo $data['branch_name']; ?></td>
                          <td><?php echo $data['inquiry_name']; ?></td>
                          <td>
                          <?php echo $data['contact']; ?></td>
                          <td>
                        <?php  
                          $courses = explode(',', $data['course']);
                          
                          foreach ($courses as $course) 
                          {
                            $sql = "select course_name from course where id = '$course'";
                            $res_data = mysqli_query($con,$sql);
                            $date = mysqli_fetch_assoc($res_data);
                            echo $date['course_name'].",<br>";
                        
                        }
                      ?>

                      </td>
                          <td><?php echo $data['detail']; ?></td>
                          <td><?php echo $data['join_date']; ?></td>
                          <td><?php echo $data['ref_name']; ?></td>
                          <td><?php echo $data['ref_reason']; ?></td>
                          <td><?php echo $data['name']; ?></td>
                          <td><?php echo $data['status_name']; ?></td>
                          <td>
                            <a href="add_followup.php?id=<?php echo $data['id'] ?>" style="margin-right:20px; "><i class="fa fa-plus follow"></i></a> </td>
                            <td>
                            <a href="view_followup.php?id=<?php echo $data['id'] ?>" style="margin-left:20px; "><i class="fa fa-eye follow"></i></a>
                          </td>
                           <th>
                            <a href="add_inquery.php?id=<?php echo $data['id']; ?>">Edit</a> 
                            </th><th><a href="view_inquery.php?id=<?php echo $data['id']; ?>">Delete</a>
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
        <a href="view_inquery.php">All</a>
         <?php for($i = 1; $i <= $total_page; $i++) { 
            echo "<a href='view_inquery.php?page_no=$i&name=$srch'>$i</a>";
         } ?> 
      </div>
    </section>
  </div>
    
  
  </div>

  <?php 
    include "footer.php";
   ?>
   <style type="text/css">
     .btn a 
     {
      border: 1px solid black;
      padding: 6px;
      margin-right: 10px;
      background-color: darkblue;
      color: white;
     }
   </style>