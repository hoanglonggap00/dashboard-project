<?php

include '../../../../database/connect.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../../vendor/PHPMailer/src/Exception.php';
require '../../../../vendor/PHPMailer/src/PHPMailer.php';
require '../../../../vendor/PHPMailer/src/SMTP.php';

function sentEmail($to,$subject,$body) :int {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        // $mail->Username   = ;                     // SMTP username
        // $mail->Password   = ;                               // SMTP password
        $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('admin@gmail.com', 'admin');
        $mail->addAddress($to);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        return 0;
    }

    return 1;
}


function categoryTree($table,$parent_id = 0, $sub_mark = '') {
    global $conn,$category_parent__id,$category__id,$category__name;
    $query = "SELECT * 
              FROM $table 
              WHERE $category_parent__id = '$parent_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row["$category__id"].'" id="'.$row["$category__name"].'">'
                                .$sub_mark.$row["$category__name"]
                            .'</option>';
            categoryTree($table,$row["$category__id"], $sub_mark.'---');
        }
    }
}

function tagsInputRender($targetTable) {
    global $conn,$tag__id,$tag__name;
    $sql = "SELECT * FROM $targetTable";
    $result = mysqli_query($conn, $sql);
    $returnString = '';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $returnString .= '<div class="form-group"><input type="checkbox" value="'.$row["$tag__id"].'" id="'.$row["$tag__name"].'" class="mr-2" name="tag[]"/>'
                .'<label for="'.$row["$tag__name"].'">'.$row["$tag__name"].'</label></div>';
        }
    }
    return $returnString;
}

function tagsOutputRender($typeTable,$typeLink,$targetDB,$targetTable,$targetName,$tagDB) {
    global $conn,$link__tag,$tag__id,$tag__name;
    $sql = "SELECT * FROM $typeTable
            LEFT JOIN $targetDB 
            ON $typeTable.$typeLink = $targetDB.$targetTable
            INNER JOIN $tagDB 
            ON $typeTable.$link__tag = $tagDB.$tag__id
            WHERE $targetDB.$targetTable LIKE '$targetName'";
    $result = mysqli_query($conn, $sql);
    $returnString="";
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $returnString .= $row["$tag__name"]." ";
        }
    }
    return $returnString;
}

function permissionOutputRender($typeTable,$typeLink,$targetDB,$targetTable,$targetName) {
    global $conn,$link__permission;
    $sql = "SELECT * FROM $typeTable
            LEFT JOIN $targetDB 
            ON $typeTable.$typeLink = $targetDB.$targetTable
            WHERE $targetDB.$targetTable LIKE '$targetName'";
    $result = mysqli_query($conn, $sql);
    $returnString="";
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $returnString .= $row["$link__permission"]." ";
        }
    }
    return $returnString;
}


function getPermission($role,$permission) : bool {
    global $conn,$MyUsersRolesLink,$link__role,$link__permission;
    $sql = "SELECT * FROM $MyUsersRolesLink
            WHERE $link__role = '$role' AND $link__permission = '$permission'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

?>