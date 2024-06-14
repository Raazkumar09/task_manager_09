<?php
    include('config/constants.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task manager with php and mysql</title>
    <link rel="stylesheet" href="<?php echo SITEURL;?>CSS/style.css">
</head>
<body>
    <div class="wrapper">
    <h1>TASK MANAGER</h1>
    
    <a class="btn-secondary" href="<?php SITEURL; ?>index.php">Home</a>
    <h3>ADD TASKS</h3>

    <p>
        <?php
            if(isset($_SESSION['add_fail'])){
                echo $_SESSION['add_fail'];
                unset($_SESSION['add_fail']);
            }
        ?>
    </p>

    <form action="" method="post">
        <table class="tbl-half">
            <tr>
                <td>Task Name : </td>
                <td> <input type="text" name="task_name" placeholder="Type your task name" required = "required"></td>
            </tr>
            <tr>
                <td>Task Description : </td>
                <td><textarea name="task_description" id="desc" cols="30" rows="5" placeholder="Type your description"></textarea></td>
            </tr>
            <tr>
                <td>Select List</td>
                <td>
                    <select name="list_id" id="list_id">
                        <?php 
                            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
                            $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
                            $sql = "SELECT * FROM tbl_list";
                            $res = mysqli_query($conn, $sql);

                            if($res == true){
                                    $count_rows = mysqli_num_rows($res); // return the number of rows present in the result set
                                    if($count_rows > 0){
                                        while($row=mysqli_fetch_assoc($res)){ //return an associative array representing the next row in the result set
                                            $list_id = $row['list_id'];
                                            $list_name = $row['list_name'];
                                            ?>
                                                <option value="<?php echo $list_id;?>"><?php echo $list_name; ?></option>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="none">None</option>
                                        <?php
                                    }
                            } 
                        ?>
                        
                    </select>
                </td>
            </tr>
            <tr>
                <td>Priority</td>
                <td>
                    <select name="priority" id="priority">
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Deadline : </td>
                <td><input type="date" name="deadline"></td>
            </tr>
            <tr>
                <td><input class="btn-primary" type="submit" name="submit" value="SAVE"></td>
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

        //connect to db
        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
        $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());
        $sql2 = "INSERT INTO tbl_tasks SET
                task_name = '$task_name',
                task_description = '$task_description',
                list_id = '$list_id',
                priority = '$priority',
                deadline = '$deadline'
            ";
        $res2 = mysqli_query($conn2, $sql2);

        if($res2 == true){
            $_SESSION['add'] = 'TASK ADDED SUCCESSFULLY';
            header('location: ' . SITEURL . 'index.php');
        } else{
            $_SESSION['add_fail'] = 'FAILED TO ADD TASK';
            header('location: ' . SITEURL . 'add_task.php');
        }
    }
?>