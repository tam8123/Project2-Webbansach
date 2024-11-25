<?php require_once "./public/check_admin_login.php"; ?>

<?php
require_once 'public/bk_connect.php';
if (isset($_GET["invoiceId"])) {	
	$id = $_GET["invoiceId"];	
	
	// Cập nhật trạng thái đơn hàng
	$sql = "UPDATE `orders` SET `status`=2 WHERE `id` = ".$id;
	if (mysqli_query($prconn, $sql)) {
		header("Location: manager_invoice.php");
	} else {
		echo "Lỗi: " . $sql . "<br>" . mysqli_error($prconn);
	}
}
?>