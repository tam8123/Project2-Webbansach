<?php
session_start();
if (isset($_GET["prodId"])) {	
	$idp = $_GET["prodId"];	
	
	// Kiểm tra đã có biến session giỏ hàng chưa
	if (isset($_SESSION["cart"][$idp])) {
		unset($_SESSION["cart"][$idp]); // Loại sản phẩm khỏi giỏ hàng
	}

	header("Location: shopping_cart.php");
	// echo "Sản phẩm ID ". $_GET["prodId"] . " đã có " . $_SESSION["cart"][$idp];
}
?>