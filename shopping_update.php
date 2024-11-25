<?php
session_start();
if (isset($_POST["submit"]) && isset($_POST["soluong"])) {	
	// echo "CẬP NHẬT GIỎ HÀNG";
	$soluong = $_POST["soluong"];
	// print_r($soluong);
	foreach ($soluong as $key => $value) {
		$_SESSION["cart"][$key] = ($value > 0)? $value : 1; // Nếu số lượng <= 0 thì cài đặt về 1
	}
	// print_r($_SESSION["cart"]);

	header("Location: shopping_cart.php"); // Chuyển về giỏ hàng
}
?>