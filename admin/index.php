<?php require_once "./public/check_admin_login.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Shop Online</title>
	<link rel="stylesheet" href="../css/main_style.css">
</head>

<body>
	<!-- Header -->
	<header><?php require_once 'public/header.php'; ?></header>

	<!-- Body -->
	<div class="content-center main-body">
		<!-- Danh mục -->
		<div style="width: 20%; float:left; overflow: hidden; box-sizing: border-box;">
			<?php include_once 'menu.php'; ?>
		</div>
		<!-- Nội dung -->
		<div style="width: 80%; float:left; overflow: hidden; box-sizing: border-box; padding: 10px;">
			<h1>Thống kê báo cáo</h1>
			<!-- Mở kết nối tới csdl -->
			<?php
			include_once 'public/bk_connect.php';
			require_once 'public/upload_file.php';
			?>
			<!-- Xử lý thêm/sửa/xóa khách hàng-->
			<?php
			// Lấy tổng số lượng sản phẩm
			$sql_total_products = "SELECT COUNT(*) AS total_products FROM `products`";
			$result_total_products = mysqli_query($prconn, $sql_total_products);
			$total_products = mysqli_fetch_assoc($result_total_products)['total_products'];

			// Tổng giá trị sản phẩm
			$sql_total_value = "SELECT SUM(`price`) AS total_value FROM `products`";
			$result_total_value = mysqli_query($prconn, $sql_total_value);
			$total_value = mysqli_fetch_assoc($result_total_value)['total_value'];

			// Số lượng sản phẩm có hàng
			$sql_in_stock = "SELECT COUNT(*) AS in_stock FROM `products` WHERE `status` = 1";
			$result_in_stock = mysqli_query($prconn, $sql_in_stock);
			$in_stock = mysqli_fetch_assoc($result_in_stock)['in_stock'];

			// Số lượng sản phẩm hết hàng
			$sql_out_of_stock = "SELECT COUNT(*) AS out_of_stock FROM `products` WHERE `status` = 0";
			$result_out_of_stock = mysqli_query($prconn, $sql_out_of_stock);
			$out_of_stock = mysqli_fetch_assoc($result_out_of_stock)['out_of_stock'];

			// Số lượng sản phẩm sắp hết hàng (ví dụ: số lượng <= 5)
			$sql_almost_out_of_stock = "SELECT COUNT(*) AS almost_out_of_stock FROM `products` WHERE `status` = 1 
			-- AND `quantity` <= 5
			";
			$result_almost_out_of_stock = mysqli_query($prconn, $sql_almost_out_of_stock);

			?>
			<!-- Thông tin thống kê -->
			<div style="margin-bottom: 20px;">
				<h3>Tổng số sản phẩm: <?php echo $total_products; ?></h3>
				<h3>Tổng giá trị sản phẩm: <?php echo number_format($total_value, 0, ',', '.'); ?> VNĐ</h3>
				<h3>Số lượng sản phẩm có hàng: <?php echo $in_stock; ?></h3>
				<h3>Số lượng sản phẩm hết hàng: <?php echo $out_of_stock; ?></h3>
			</div>

			<!-- Danh sách sản phẩm -->
			<h2>Danh sách sản phẩm</h2>
			<table border="1" width="100%" cellpadding="6" cellspacing="2">
				<tr>
					<th>Mã sản phẩm</th>
					<th>Tên sản phẩm</th>
					<th>Giá tiền</th>
					<th>Trạng thái</th>
				</tr>
				<?php
				$sql_products = "SELECT * FROM `products`";
				$result_products = mysqli_query($prconn, $sql_products);

				while ($row = mysqli_fetch_assoc($result_products)) {
					echo "<tr>";
					echo "<td>" . $row["id"] . "</td>";
					echo "<td>" . $row["name"] . "</td>";
					echo "<td>" . number_format($row["price"], 0, ',', '.') . " VNĐ</td>";
					echo "<td>" . ($row["status"] == 1 ? 'Có hàng' : 'Hết hàng') . "</td>";
					echo "</tr>";
				}
				?>
			</table>
		</div>
	</div>

	<!-- Footer -->
	<footer>
		<div class="content-center">
			<?php include_once 'public/footer.php';?>
		</div>
	</footer>
</body>

</html>