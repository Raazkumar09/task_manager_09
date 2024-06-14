<?php
    include('config/constants.php');
    $list_id_url = $_GET['list_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task-Manager with php and mysql</title>
    <link rel="stylesheet" href="<?php echo SITEURL;?>CSS/style.css">
</head>
<body>
    <div class="wrapper">
    <h1>TASK MANAGER</h1>
    
    <!-- menu -->
    <div class="menu">
        <a href=<?php echo SITEURL; ?>>Home</a>
        <?php
            //connecting and displaying list from db
            $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
            $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());
            $sql2 = "SELECT * FROM tbl_list";
            $res2 = mysqli_query($conn2, $sql2);

            if ($res2 == true) {
                while ($row2 = mysqli_fetch_assoc($res2)) {
                    $list_id = $row2['list_id'];
                    $list_name = $row2['list_name'];
                    ?>
                    <a href="<?php echo SITEURL; ?>list_task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>
                    <?php
                }
            }
        ?>
        
        <a href=<?php echo SITEURL; ?>manage_list.php>Manage Lists</a>

    </div>

    <div class="all-task">
        <a class="btn-primary" href="<?php SITEURL;?>add_task.php">ADD TASK</a>
        <table class="tbl-full">
            <tr>
                <th>S.No</th>
                <th>Task Name</th>
                <th>Priority</th>
                <th>Deadline</th>
                <th>Actions</th>
            </tr>
            

            <?php
                $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
                $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
                $sql = "SELECT * FROM tbl_tasks WHERE list_id=$list_id_url";
                $res = mysqli_query($conn, $sql);

                if($res == true){
                    $count_rows = mysqli_num_rows($res);
                    if($count_rows > 0){
                        while($row = mysqli_fetch_assoc($res)){
                            $task_id = $row["task_id"];
                            $task_name = $row["task_name"];
                            $priority = $row["priority"];
                            $deadline = $row["deadline"];
                            ?>
                            <tr>
                                <td>1.</td>
                                <td><?php echo $task_name;?></td>
                                <td><?php echo $priority;?></td>
                                <td><?php echo $deadline;?></td>
                                <td>
                                    <a class="link" href="<?php echo SITEURL;?>update_task.php ?task_id=<?php echo $task_id;?>">Update</a>
                    
                                    <a class="link" href="<?php echo SITEURL;?>delete_task.php ?task_id=<?php echo $task_id;?>">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="5">No tasks added in this list</td>
                        </tr>
                        <?php
                    }
                }
            ?>
            
        </table>
    </div>
    </div>
</body>
</html>