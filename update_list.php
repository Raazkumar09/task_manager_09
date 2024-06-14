<?php
    include('config/constants.php');
    if(isset($_GET['list_id'])){
        $list_id = $_GET['list_id'];
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
        $sql = "SELECT * FROM tbl_list WHERE list_id=$list_id";
        $res = mysqli_query($conn, $sql);

        if($res == true){
            $row = mysqli_fetch_assoc($res); //value is in array
            // print_r($row);
            $list_name = $row['list_name'];
            $list_description = $row['list_description'];
        } else {
            header('location: ' . SITEURL . 'manage_list.php');
        }
    }
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
    <h1>Task Manager</h1>
    <div class="menu">
        <a class="btn-secondary" href="<?php echo SITEURL;?>">Home</a>
        <a class="btn-secondary" href="<?php echo SITEURL;?>manage_list.php">Manage list</a>
    </div>
    <h3>Update List Page</h3>
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
                <td>List Name :</td>
                <td><input type="text" name='list_name' value="<?php echo $list_name;?>" required = "required"></td>
            </tr>
            <tr>
                <td>List Description : </td>
                <td><textarea name="list_description" id="list_desc" cols="30" rows="5">
                        <?php echo $list_description;?>
                </textarea></td>
            </tr>
            <tr>
                <td><input class="btn-primary" type="submit" name="submit" value="update"></td>
            </tr>
        </table>
    </form>
    </div>
</body>
</html>

<?php
    if(isset($_POST['submit'])){
        $list_name = $_POST['list_name'];
        $list_description = $_POST['list_description'];

        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
        $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());
        $sql2 = "UPDATE tbl_list SET
                list_name = '$list_name',
                list_description = '$list_description'
                WHERE list_id = $list_id";
        $res2 = mysqli_query($conn2, $sql2);
        if($res2 == true){
            $_SESSION['update'] = 'List updated successfully';
            header('location: ' . SITEURL . 'manage_list.php');
        } else {
            $_SESSION['update_fail'] = 'Failed to update list';
            header('location: ' . SITEURL . 'manage_list.php?list_id='.$list_id);
        }
    }
?>