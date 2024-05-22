<?php 

  session_start();
  include 'db.php';

  $user_id=$_SESSION['userid'];

  if(isset($_GET['id']))
  {
    $id= $_GET['id'];
    if($id!=$user_id)
    {
      $rec = "select `image` from `admin` where `id`=$id";
      $res_image = mysqli_query($con, $rec);
      $image_data = mysqli_fetch_assoc($res_image);
      $image_name = $image_data['image'];

      $dlt = "delete from `admin` where `id`=$id";
      mysqli_query($con,$dlt);
    
      unlink("image/admin/$image_name");
      // header("location:view_admin.php");
    }
    else
    {
      $error = "admin cannot delete...!";
    }
    
  }

  $limit = 2;
  if(isset($_GET['page'])) {
    $page = $_GET['page'];
  }
  else
  {
    $page = 1;
  }
  $start = ($page - 1) * $limit;

  if(isset($_GET['search'])) {
    $search = $_GET['search'];
    $search_sql = "select admin.* ,role.role_name, branch.branch_name from `admin` join role on admin.role_id = role.id join branch on admin.branch_id = branch.id where admin.name like '%$search%' limit $start , $limit";
    $total_rec = "select admin.* ,role.role_name, branch.branch_name from `admin` join role on admin.role_id = role.id join branch on admin.branch_id = branch.id where admin.name like '%$search%'";
  } 
  else
  {
    $search_sql = "select admin.* ,role.role_name, branch.branch_name from `admin` join role on admin.role_id = role.id join branch on admin.branch_id = branch.id limit $start, $limit";
    $total_rec = "select admin.* ,role.role_name, branch.branch_name from `admin` join role on admin.role_id = role.id join branch on admin.branch_id = branch.id";
  }

  $res_page = mysqli_query($con, $total_rec);
  $total_r = mysqli_num_rows($res_page);
  $total_page = ceil($total_r/$limit);


  $res = mysqli_query($con, $search_sql); 

  include "header.php";

 ?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin Table</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Table</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->


     

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
                <form method="get">
                  <label for="exampleInputPassword1">search Name</label>
                  <input type="text" name="search" value="<?php echo @$search; ?>">
                  <input type="submit" name="submit" value="Search" class=" btn btn-primary btn-sm">
                </form> 
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role Name</th>
                    <th>Branch Name</th>
                    <th>Image</th>
                    <th>Delete</th>
                    <th>update</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php while ($data = mysqli_fetch_assoc($res)) { ?>
                      <tr>
                          <td><?php echo $data['id']; ?></td>
                          <td><?php echo $data['name']; ?></td>
                          <td><?php echo $data['email']; ?></td>
                          <td><?php echo $data['role_name']; ?></td>
                          <td><?php echo $data['branch_name']; ?></td>
                          <td><img src="image/admin/<?php echo $data['image']; ?>"></td>
                          <td> <a href="view_admin.php?id=<?php echo $data['id']; ?>">Delete</a>
                            <?php if($data['id']==$id) { ?>
                              <p style="color: red"><?php echo @$error;  ?></p>
                            <?php } ?>
                          </td>
                          <td><a href="add_admin.php?id=<?php echo $data['id']; ?>">Edit</a></td>
                      </tr>
                    <?php  } ?>
                  </tbody>
                </table>
                <div class="mt-3">
                  <a class="btn btn-primary btn-sm" href="view_admin.php">All</a>    
<?php
                  if($page>1)
                  {
                        echo "<a href='view_admin.php?page=".$page - 1 ."' class='btn btn-primary btn-sm' >pre</a>";
                  }
                  for ($i=1; $i<=$total_page; $i++)
                  {  
?>
                    <a class="btn btn-primary btn-sm" href="view_admin.php?page=<?php echo $i; if(isset($_GET['search'])) {?> &search=<?php echo $_GET['search']; } ?>"><?php echo $i; ?></a>    
<?php     
                  } 
                  if($page<=$total_page-1)
                  {
                        echo "<a href='view_admin.php?page=".$page +1 ."' class='btn btn-primary btn-sm' >next</a>";

                  }  
?>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </section>

    <!-- /.content -->
  </div>



  <?php 
    include "footer.php";
   ?>