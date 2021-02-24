<?php 
    include '../../../../database/connect.php'; 

    $id = $_GET['id'];

    $sql = "UPDATE $MyUsers SET $user__status = '1' WHERE $user__id ='$id'";
    if ($conn->query($sql) === TRUE) {
        header("location:login.php?activeAccount='1'");
    }
?>