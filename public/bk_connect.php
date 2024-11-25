<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'project_book2';

// Mở kết nối
$prconn = mysqli_connect($server, $username, $password, $database);

// Kiểm tra lỗi
if (!$prconn) {
	die("Kết nối thất bại: " . mysqli_connect_error());
}

// Hàm định dạng tiền tệ
//function formatCurrency($curr){
//	$fmt = numfmt_create("vi_VN", NumberFormatter::CURRENCY);
//	return numfmt_format_currency($fmt, $curr, "VND");
//}

// Hàm định dạng số
//function formatNumber($num, $decimal){
//	return number_format($num, $decimal, ',', '.'); // Định dạng kiểu thập phân là dấu <,>
//}

?>