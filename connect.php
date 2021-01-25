<?php   
    session_start();

    // Server variables 
    $servername = "localhost:3306";
    $username = "root";
    $password = "nhatlinh1612";
    // Database variables cf
    $db = "myDataBase";
    // Product table variables 
    $MyProducts = "MyProducts";
    $product__id = "id";
    $product__name = "product__name";
    $product__description = "product__description";
    $product__content = "product__content";
    $product__status = "product__status";
    $product__img = "product__img";
    // User table variables 
    $MyUsers = "MyUsers";
    $user__id = "id";
    $user__username = "user__username";
    $user__email = "user__email";
    $user__password = "user__password";

    // Get Current date, time
    $current_time = time();
    $current_date = date("Y-m-d H:i:s", $current_time);
    // Set Cookie expiration for 1 month
    $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  // for 1 month


    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS $db";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating database: " . $conn->error;
    }

    // Select database
    mysqli_select_db($conn, $db);

    // sql to create table product 
    $sql = "CREATE TABLE IF NOT EXISTS $MyProducts (
        $product__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $product__name VARCHAR(100) NOT NULL,
        $product__description VARCHAR(100) NOT NULL,
        $product__content VARCHAR(100) NOT NULL,
        $product__status INT(1) UNSIGNED DEFAULT 0,
        $product__img VARCHAR(100) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table user 
    $sql = "CREATE TABLE IF NOT EXISTS $MyUsers (
        $user__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $user__username VARCHAR(30) NOT NULL,
        $user__email VARCHAR(30) NOT NULL,
        $user__password VARCHAR(50) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }
?>