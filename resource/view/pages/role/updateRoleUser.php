<?php   
    include '../../../../database/connect.php'; 

    $name = $_POST["updateName"];
    $updateId = $_POST["updateID"];
    $oldName = $_POST["oldName"];
    $permission = $_POST["permission"];

    if ($name !== $oldName) {
        $sql = "SELECT * FROM $MyProductsTags WHERE $tag__name LIKE '$name'";
        $result = ($conn->query($sql));
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../main-view/manage-user_roles.php?updateFail=2");
            exit();
        } else {
            if(empty($_POST['updateName']) || empty($_POST['updateDescription'])) {
                header("Location: ../main-view/manage-user_roles.php?updateFail=1");
                exit();
            } else {
                $sql = "UPDATE $MyUsersRoles 
                        SET $role__name='$name'
                        WHERE $role__id='$updateId'";
                if ($conn->query($sql) == TRUE) {
                    $sql = "UPDATE $MyUsersRolesLink 
                            SET $link__role = '$name' 
                            WHERE $link__role = '$oldName'";
                    if ($conn->query($sql) == TRUE) {
                        $sql = "UPDATE $MyUsers 
                            SET $user__role = '$name' 
                            WHERE $user__role = '$oldName'";
                        if ($conn->query($sql) == TRUE) {
                            header("Location: ../main-view/manage-user_roles.php?updateSuccess=1");
                            exit();
                        }
                    }
                }
            }
        }
    }
?>