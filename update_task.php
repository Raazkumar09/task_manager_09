<?php
    include('config/constants.php');
    if(isset($_GET['task_id'])){
        $task_id = $_GET['task_id'];
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
        $sql = "SELECT * FROM tbl_tasks WHERE task_id=$task_id";
        $res = mysqli_query($conn, $sql);

        if ($res == true){
            $row = mysqli_fetch_assoc($res);
            $task_name = $row['task_name'];
            $task_description = $row['task_description'];
            $list_id = $row['list_id'];
            $priority = $row['priority'];
            $deadline = $row['deadline'];
        } else {
            header('location: ' . SITEURL . 'index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task-manager with php and mysql</title>
    <link rel="stylesheet" href="<?php echo SITEURL;?>CSS/style.css">
</head>
<body>
    <div class="wrapper">
    <h1>Task Manager</h1>
    <a class="btn-secondary" href= <?php echo SITEURL; ?>index.php>Home</a>

    <h3>Update Task</h3>
    <p>
    <?php
        if(isset($_SESSION['update_fail'])){
            echo $_SESSION['update_fail'];
            unset($_SESSION['update_fail']);
        }
    ?>
    </p>


    <form action="" method="post">
        <table class="tbl-half">
            <tr>
                <td>Task Name : </td>
                <td><input type="text" name="task_name" value="<?php echo $task_name;?>" required="required"></td>
            </tr>
            <tr>
                <td>Task Description : </td>
                <td><textarea name="task_description" id="task_desc" cols="30" rows="5">
                    <?php echo $task_description;?>
                </textarea></td>
            </tr>
            <tr>
                <td>Select List :</td>
                <td>
                <select name="list_id" id="list">
                    <?php
                        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
                        $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());
                        $sql2 = "SELECT * FROM tbl_list";
                        $res2 = mysqli_query($conn2, $sql2);

                        if($res2 == true){
                            $count_rows2 = mysqli_num_rows($res2);
                            if($count_rows2 > 0){
                                while($row2 = mysqli_fetch_assoc($res2)){
                                    $list_id_db = $row2['list_id'];
                                    $list_name = $row2['list_name'];
                                    ?>
                                    <option <?php if($list_id_db == $list_id){echo "selected = 'selected'";}?> value="<?php echo $list_id_db;?>"><?php echo $list_name;?></option>
                                    <?php
                            }
                        } else {
                            ?>
                            <option <?php if($list_id == 0){echo "selected = 'selected'";}?> value="0">none</option>
                            <?php
                        }
                    }
                    ?>
                </select>
                </td>
            </tr>
            <tr>
                <td>Priority :</td>
                <td>
                    <select name="priority" id="priority">
                        <option <?php if($priority=='High'){echo "selected='selected'";}?> value="High">High</option>
                        <option <?php if($priority=='Medium'){echo "selected='selected'";}?> value="Medium">Medium</option>
                        <option <?php if($priority=='Low'){echo "selected='selected'";}?> value="Low">Low</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Deadline : </td>
                <td><input type="date" name="deadline" value="<?php echo $deadline;?>"></td>
            </tr>
            <tr>
                <td><input class="btn-primary" type="submit" name="submit" value="UPDATE"></td>
            </tr>
        </table>
    </form>
    </div>
</body>
</html>

<?php
    if(isset($_POST['submit'])){
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $list_id = $_POST['list_id'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];

        $conn3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
        $db_select3 = mysqli_select_db($conn3, DB_NAME) or die(mysqli_error());
        $sql3 = "UPDATE tbl_tasks SET
                task_name = '$task_name',
                task_description = '$task_description',
                list_id = '$list_id',
                priority = '$priority',
                deadline = '$deadline'
                WHERE task_id=$task_id";
        $res3 = mysqli_query($conn3, $sql3);

        if($res3 == true){
            $_SESSION['update'] = "TASK UPDATED SUCCESSFULLY";
            header('location: ' . SITEURL . 'index.php');
        } else {
            $_SESSION['update_fail'] = "FAILED TO DELETE TASK";
            header('location: ' . SITEURL . 'update_task.php?task_id'.$task_id);
        }
    }
?>