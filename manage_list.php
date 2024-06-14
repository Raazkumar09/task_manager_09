<?php
    include('config/constants.php');
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
    <h1>TASK MANAGER</h1>
    <a class="btn-secondary" href= <?php echo SITEURL; ?>index.php>Home</a>

    <h3>Manage lists page</h3>
    <p>
        <?php
            //This is session for add_list
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            //This is session for delete_list
            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if(isset($_SESSION['delete_fail'])){
                echo $_SESSION['delete_fail'];
                unset($_SESSION['delete_fail']);
            }
            //This is session for update_list
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
    </p>

    <!-- task to display list -->
    <div class="all-list">
        <a class="btn-primary" href = <?php echo SITEURL; ?>add_list.php>ADD LIST</a>
        <table class="tbl-half">
            <tr>
                <th>S.No</th>
                <th>List Name</th>
                <th>Actions</th>
            </tr>
            
            <?php
                //connect the db
                $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
                $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

                $sql = "SELECT * FROM tbl_list";
                $res = mysqli_query($conn, $sql);

                if($res == true){
                    // echo "executed";
                    $count_rows = mysqli_num_rows($res);
                    //serial number var
                    $sn = 1;
                    if($count_rows > 0){
                        while($row = mysqli_fetch_assoc($res)){
                            $list_id = $row['list_id'];
                            $list_name = $row['list_name'];
                            ?>

                            <tr>
                                <td><?php echo $sn++; ?>.</td>
                                <td><?php echo $list_name; ?>.</td>
                                <td>
                                    <a class="link" href="<?php echo SITEURL;?>update_list.php?list_id=<?php echo $list_id;?>">Update</a>
                                    <a class="link" href="<?php echo SITEURL;?>delete_list.php ?list_id=<?php echo $list_id;?>">Delete</a>
                                </td>
                            </tr>

                            <?php
                        }
                    } else {
                        ?>

                        <tr>
                            <td colspan="3">No list added yet</td>
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