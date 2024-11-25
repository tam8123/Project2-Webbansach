<?php require_once "./public/check_admin_login.php"; ?>

<?php
include_once 'public/bk_connect.php';


echo $_GET['prdid'];
$sql = "DELETE FROM products WHERE id = " . $_GET['prdid'];
$result = mysqli_query($prconn, $sql);

header("Location: ./manager_product.php");