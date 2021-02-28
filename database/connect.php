<?php   
    session_start();

    // Server variables 
    $servername = "sql12.freemysqlhosting.net:3306";
    $username = "sql12395715";
    $password = "6Zh3zkSQ3p";
    // Database variables cf
    $db = "myDataBase";
    // Product table variables 
    $MyProducts = "MyProducts";
    $product__id = "product__id";
    $product__name = "product__name";
    $product__description = "product__description";
    $product__content = "product__content";
    $product__status = "product__status";
    $product__category = "product__category";
    $product__tags = "product__tags";
    $product__img = "product__img";
    // Product category table variables
    $MyProductsCategory = "MyProductsCategory";
    $category__id = "category__id";
    $category_parent__id = "parent__id";
    $category__name = "category__name";
    // Product tag table variables
    $MyProductsTags = "MyProductsTags";
    $tag__id = "tag__id";
    $tag__name = "tag__name";
    // Product tag link table variables
    $MyProductsTagsLink = "MyProductsTagsLink";
    $link__id = "link__id";
    $link__product = "link__product";
    $link__tag = "link__tag";
    // News table variables 
    $MyNews = "MyNews";
    $news__id = "news__id";
    $news__name = "news__name";
    $news__description = "news__description";
    $news__content = "news__content";
    $news__status = "news__status";
    $news__category = "news__category";
    $news__tags = "news__tags";
    $news__img = "news__img";
    // News category table variables
    $MyNewsCategory = "MyNewsCategory";
    $category__id = "category__id";
    $category_parent__id = "parent__id";
    $category__name = "category__name";
    // News tag table variables
    $MyNewsTags = "MyNewsTags";
    $tag__id = "tag__id";
    $tag__name = "tag__name";
    // News tag link table variables
    $MyNewsTagsLink = "MyNewsTagsLink";
    $link__id = "link__id";
    $link__news = "link__news";
    $link__tag = "link__tag";
    // User table variables 
    $MyUsers = "MyUsers";
    $user__id = "id";
    $user__username = "user__username";
    $user__email = "user__email";
    $user__password = "user__password";
    $user__status = "user__status";
    $user__role = "user__role";
    $user__img = "user__img";
    // User Role table variables 
    $MyUsersRoles = "MyUsersRoles";
    $role__id = "id";
    $role__name = "role__name";
    $role__description = "role__description";
    // User Role table variables 
    $MyUsersRolesLink = "MyUsersRolesLink";
    $link__id = "id";
    $link__role = "link__role";
    $link__permission = "link__permission";
    // User Role table variables 
    $MyRssNews = "MyRssNews";
    $rss__id = "rss__id";
    $rss__link = "rss__link";
    $rss__status = "rss__status";
    $rss__rank = "rss__rank";

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
        $product__category VARCHAR(100) NOT NULL,
        $product__img VARCHAR(100) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table product category
    $sql = "CREATE TABLE IF NOT EXISTS $MyProductsCategory (
        $category__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $category__name VARCHAR(100) NOT NULL,
        $category_parent__id INT(6) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table product tag
    $sql = "CREATE TABLE IF NOT EXISTS $MyProductsTags (
        $tag__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $tag__name VARCHAR(100) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table product tag link
    $sql = "CREATE TABLE IF NOT EXISTS $MyProductsTagsLink (
        $link__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $link__product VARCHAR(100) NOT NULL,
        $link__tag VARCHAR(100) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table news 
    $sql = "CREATE TABLE IF NOT EXISTS $MyNews (
        $news__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $news__name VARCHAR(100) NOT NULL,
        $news__description VARCHAR(100) NOT NULL,
        $news__content VARCHAR(100) NOT NULL,
        $news__status INT(1) UNSIGNED DEFAULT 0,
        $news__category VARCHAR(100) NOT NULL,
        $news__img VARCHAR(100) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table news category
    $sql = "CREATE TABLE IF NOT EXISTS $MyNewsCategory (
        $category__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $category__name VARCHAR(100) NOT NULL,
        $category_parent__id INT(6) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table news tag
    $sql = "CREATE TABLE IF NOT EXISTS $MyNewsTags (
        $tag__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $tag__name VARCHAR(100) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table news tag link
    $sql = "CREATE TABLE IF NOT EXISTS $MyNewsTagsLink (
        $link__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $link__news VARCHAR(100) NOT NULL,
        $link__tag VARCHAR(100) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table user 
    $sql = "CREATE TABLE IF NOT EXISTS $MyUsers (
        $user__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $user__username VARCHAR(30) NOT NULL,
        $user__email VARCHAR(30) NOT NULL,
        $user__password VARCHAR(50) NOT NULL,
        $user__status INT(1) UNSIGNED DEFAULT 0,
        $user__role VARCHAR(30) NOT NULL,
        $user__img VARCHAR(100) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table user role
    $sql = "CREATE TABLE IF NOT EXISTS $MyUsersRoles (
        $role__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $role__name VARCHAR(100) NOT NULL,
        $role__description VARCHAR(100) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    } 

    // sql to create table user role link 
    $sql = "CREATE TABLE IF NOT EXISTS $MyUsersRolesLink (
        $link__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $link__role VARCHAR(100) NOT NULL,
        $link__permission VARCHAR(100) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // sql to create table user 
    $sql = "CREATE TABLE IF NOT EXISTS $MyRssNews (
        $rss__id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        $rss__link VARCHAR(300) NOT NULL,
        $rss__status INT(1) UNSIGNED DEFAULT 0,
        $rss__rank int(50) NOT NULL
        )";
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }
?>