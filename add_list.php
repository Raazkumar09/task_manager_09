<?php
    include('config/constants.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo SITEURL;?>CSS/style.css">
</head>
<body>
    <div class="wrapper">
    <h1>Task Manager</h1>
    <a class="btn-secondary" href= <?php echo SITEURL; ?>index.php>Home</a>
    <a class="btn-secondary" href= <?php echo SITEURL; ?>manage_list.php>Manage Lists</a>

    <h3>Add List</h3>
    <p>
        <?php
            if(isset($_SESSION['add_fail'])){
                echo $_SESSION['add_fail'];
                unset($_SESSION['add_fail']);
            }
        ?>
    </p>

    <!-- Form to add list -->
    <form method="POST" action="">
        <table class="tbl-half">
            <tr>
                <td>List Name : </td>
                <td><input type="text" name= "list_name" placeholder = "Enter List name here" required="required"></td>
            </tr>
            <tr>
                <td>List Description : </td>
                <td><textarea name="list_description" id="list_desc" cols="30" rows="5" placeholder = "Enter List desc here"></textarea></td>
            </tr>
            <tr>
                <td><input class="btn-primary" type="submit" name = "submit" value="SAVE"></td> <br>
            </tr>
        </table>
    </form> <br>
    </div>
</body>
</html>

<?php
    if(isset($_POST['submit'])){
        // echo "Form submitted";
        $list_name = $_POST['list_name'];
        $list_description = $_POST['list_description'];

        //connect to DB
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
        // if($conn == true){
        //     echo "Database connected";
        // }
        $db_select = mysqli_select_db($conn, DB_NAME);
        // if($conn == true){
        //     echo "Database selected";
        // }
        
        //Query to insert data into database
        $sql = "INSERT INTO tbl_list SET
                list_name = '$list_name',
                list_description = '$list_description'
            ";
        //Execute query and insert into db
        $res = mysqli_query($conn, $sql);
        if($res == true){
            $_SESSION['add'] = 'List Added Successfully';
            header('location: ' . SITEURL . 'manage_list.php');
            
        } else {
            $_SESSION['add_fail'] = 'Added to fail list';
            header('location: ' . SITEURL . 'add_list.php');
        }
    }
?>