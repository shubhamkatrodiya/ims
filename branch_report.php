<?php
  include 'db.php';
  session_start();

if (!isset($_SESSION['userid'])) {
    header("location:index.php");
}

include "header.php";
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Branch Inquiry Status</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Branch Inquiry Status</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Branch</th>
                                        <th>Total Inquiries</th>
                                        <th>Admissions</th>
                                        <th>Pending</th>
                                        <th>Declined</th>
                                        <th>Ratio</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    if(isset($_SESSION['userid']))
                                    {
                                        $userid = $_SESSION['userid'];
                                        $sql_data = "select * from `admin` where `id`=".$userid;
                                        $admin_sql = mysqli_query($con,$sql_data);
                                        $admin_data = mysqli_fetch_assoc($admin_sql);

                                        $userrole =$admin_data['role_id'];
                                        $userbranch =$admin_data['branch_id'];

                                        if($userrole == 9)
                                        {
                                           $sql = "SELECT branch.branch_name AS branch_name,
                                                    COUNT(inquiry.id) AS total_inquiries,
                                                    SUM(CASE WHEN status.status_name = 'admission' THEN 1 ELSE 0 END) AS admission,
                                                    SUM(CASE WHEN status.status_name = 'Pending' THEN 1 ELSE 0 END) AS Pending,
                                                    SUM(CASE WHEN status.status_name = 'Decline' THEN 1 ELSE 0 END) AS Decline
                                                FROM branch 
                                                LEFT JOIN inquiry ON inquiry.branch_id = branch.id 
                                                LEFT JOIN status ON inquiry.status = status.id GROUP BY branch.branch_name";
                                        } else {
                                            $sql = "SELECT branch.branch_name AS branch_name,
                                                    COUNT(inquiry.id) AS total_inquiries,
                                                    SUM(CASE WHEN status.status_name = 'admission' THEN 1 ELSE 0 END) AS admission,
                                                    SUM(CASE WHEN status.status_name = 'Pending' THEN 1 ELSE 0 END) AS Pending,
                                                    SUM(CASE WHEN status.status_name = 'Decline' THEN 1 ELSE 0 END) AS Decline
                                                FROM branch 
                                                LEFT JOIN inquiry ON inquiry.branch_id = branch.id 
                                                LEFT JOIN status ON inquiry.status = status.id WHERE branch.id=$userbranch GROUP BY branch.branch_name";
                                        }
                                    }
                                        $result = mysqli_query($con, $sql);
            
                                    ?>

                                    <?php  while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?php echo $row['branch_name']; ?></td>
                                                <td><?php echo $row['total_inquiries']; ?></td>
                                                <td><?php echo $row['admission']; ?></td>
                                                <td><?php echo $row['Pending']; ?></td>
                                                <td><?php echo $row['Decline']; ?></td>
                                                <td>
                                                    <?php 
                                                        $total_inquiries = $row['total_inquiries'];
                                                        $admission = $row['admission'];
                                                        if ($total_inquiries != 0) {
                                                            $ratio = ($admission / $total_inquiries) * 100;
                                                            echo round($ratio, 2) . "%";
                                                        } else {
                                                            echo "N/A";
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include "footer.php"; ?>
