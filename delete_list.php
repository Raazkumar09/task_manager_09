<?php
    include('config/constants.php');
    // "Delete List page";
    //check wether the list_id is assigned or not
    if(isset($_GET['list_id'])){
        $list_id = $_GET['list_id'];
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
        //query to delete 
        $sql = "DELETE FROM tbl_list WHERE list_id = $list_id";
        $res = mysqli_query($conn, $sql);
        //check wether the query is executed successfully.
        if($res == true){
            $_SESSION['delete'] = "List deleted successfully";
            header('location: ' . SITEURL . 'manage_list.php');
        } else {
            $_SESSION['delete_fail'] = "Failed to delete list";
            header('location: ' . SITEURL . 'manage_list.php');
        }
    } else{
        header('location: ' . SITEURL . 'manage_list.php');
    }
  
?>