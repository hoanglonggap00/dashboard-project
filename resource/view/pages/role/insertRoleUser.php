<?php 
    include '../../../../database/connect.php'; 

    $name = $_POST['role-name'];
    $description = $_POST['role-description'];
    $permission = $_POST['permission']; 

    $sql = "SELECT * FROM $MyUsersRoles WHERE $role__name = '$name'";
    $result = ($conn->query($sql));
    if (mysqli_num_rows($result) > 0) {
        header("Location: ../main-view/manage-user_roles.php?insertFail=2");
        exit();
    } else {
        $sql = "INSERT INTO $MyUsersRoles ($role__name, $role__description) VALUES ('$name', '$description')";
        if ($conn->query($sql) == TRUE) {
            $addPermission = true;
            foreach ($permission as $per) {
                $sql = "INSERT INTO $MyUsersRolesLink ($link__role,$link__permission) VALUES ('$name','$per')";
                if ($conn->query($sql) == TRUE) {
                    $addPermission = true;
                } else  {
                    $addPermission = false;
                }
            }
            if ($addPermission) {
                header("Location: ../main-view/manage-user_roles.php?insertSuccess=1");
                exit();
            }
        }
    }
?>