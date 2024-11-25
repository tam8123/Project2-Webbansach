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
			<!-- Trang quản lý khách hàng -->
			<h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý Khách Hàng</h1>
			<!-- Mở kết nối tới csdl -->
			<?php
			include_once 'public/bk_connect.php';
			require_once 'public/upload_file.php';
			?>
			<!-- Xử lý thêm/sửa/xóa khách hàng-->
			<?php
			if (isset($_POST["submit"])) {
				if ($_POST["submit"] == "Thêm") {
					$taiKhoan = $_POST["txtTaiKhoan"];
					$matKhau = $_POST["txtMatKhau"];
					$tenKh = $_POST["txtTenKh"];
					$email = $_POST["txtemail"];
					$dienThoai = $_POST["txtDienThoai"];
					$diaChi = $_POST["txtDiaChi"];

					$sql = "INSERT INTO `users`(`username`, `password`, `name`, `email`, `phone_number`, `address`)
                VALUES ('$taiKhoan', '$matKhau', '$tenKh', '$email', '$dienThoai', '$diaChi')";
					mysqli_query($prconn, $sql);

					if (mysqli_errno($prconn)) {
						$_SESSION['message'] = "Thêm khách hàng thất bại: " . mysqli_error($prconn);
					} else {
						$_SESSION['message'] = "Thêm khách hàng thành công!";
					}
				} elseif ($_POST["submit"] == "Sửa") {
					$maKh = $_POST["updateId"];
					$taiKhoan = $_POST["txtTaiKhoan"];
					$matKhau = $_POST["txtMatKhau"];
					$tenKh = $_POST["txtTenKh"];
					$email = $_POST["txtemail"];
					$dienThoai = $_POST["txtDienThoai"];
					$diaChi = $_POST["txtDiaChi"];

					$sql = "UPDATE `users` SET `username`='$taiKhoan', `password`='$matKhau', `name`='$tenKh',
                `email`='$email', `phone_number`='$dienThoai', `address`='$diaChi' WHERE `id`='$maKh'";
					mysqli_query($prconn, $sql);

					if (mysqli_errno($prconn)) {
						$_SESSION['message'] = "Sửa khách hàng thất bại: " . mysqli_error($prconn);
					} else {
						$_SESSION['message'] = "Sửa khách hàng thành công!";
					}
				} elseif ($_POST["submit"] == "Xóa") {
					$maKh = $_POST["updateId"];

					$sql = "DELETE FROM `users` WHERE `id`='$maKh'";
					mysqli_query($prconn, $sql);

					if (mysqli_errno($prconn)) {
						$_SESSION['message'] = "Xóa khách hàng thất bại: " . mysqli_error($prconn);
					} else {
						$_SESSION['message'] = "Xóa khách hàng thành công!";
					}
				}
			}

			// Lấy danh sách khách hàng và phân trang
			$results_per_page = 10; // Số khách hàng trên mỗi trang
			if (!isset($_GET['page'])) {
				$page = 1;
			} else {
				$page = $_GET['page'];
			}
			$start_from = ($page - 1) * $results_per_page;

			$sql = "SELECT * FROM `users` LIMIT $start_from, $results_per_page";
			$result = mysqli_query($prconn, $sql);

			// Lấy tổng số lượng khách hàng
			$sql_count = "SELECT COUNT(*) AS total FROM `users`";
			$result_count = mysqli_query($prconn, $sql_count);
			$row_count = mysqli_fetch_assoc($result_count);
			$total_records = $row_count['total'];
			$total_pages = ceil($total_records / $results_per_page);

			// Lấy thông tin để chỉnh sửa
			$pID = 0;
			$pTaiKhoan = "";
			$pMatKhau = "";
			$pTenKh = "";
			$pemail = "";
			$pDienThoai = "";
			$pDiaChi = "";
			if (isset($_GET["cusid"])) {
				$sql_edit = "SELECT * FROM `users` WHERE `id`=" . $_GET["cusid"];
				$result_edit = mysqli_query($prconn, $sql_edit);

				if (mysqli_num_rows($result_edit) > 0) {
					$row = mysqli_fetch_assoc($result_edit);
					$pID = $row["id"];
					$pTaiKhoan = $row["username"];
					$pMatKhau = $row["password"];
					$pTenKh = $row["name"];
					$pemail = $row["email"];
					$pDienThoai = $row["phone_number"];
					$pDiaChi = $row["address"];
				}
			}
			?>
			<!-- Tạo form nhập dữ liệu khách hàng -->
			<fieldset style="margin-bottom: 10px; margin-top: 10px">
                <legend>THÊM/SỬA KHÁCH HÀNG</legend>
                <form action="#" method="post">
                    <input type="hidden" name="updateId" value="<?php echo $pID ?>">

                    <label for="txtTaiKhoan">Tài khoản:</label>
                    <input type="text" id="txtTaiKhoan" name="txtTaiKhoan" value="<?php echo $pTaiKhoan ?>" required><br><br>

                    <label for="txtMatKhau">Mật khẩu:</label>
                    <input type="password" id="txtMatKhau" name="txtMatKhau" value="<?php echo $pMatKhau ?>" required><br><br>

                    <label for="txtTenKh">Tên khách hàng:</label>
                    <input type="text" id="txtTenKh" name="txtTenKh" value="<?php echo $pTenKh ?>" required><br><br>

                    <label for="txtemail">email:</label>
                    <input type="email" id="txtemail" name="txtemail" value="<?php echo $pemail ?>" required><br><br>

                    <label for="txtDienThoai">Điện thoại:</label>
                    <input type="tel" id="txtDienThoai" name="txtDienThoai" value="<?php echo $pDienThoai ?>"><br><br>

                    <label for="txtDiaChi">Địa chỉ:</label><br>
                    <textarea id="txtDiaChi" name="txtDiaChi" rows="4" cols="50"><?php echo $pDiaChi ?></textarea><br><br>

                    <input type="submit" name="submit" value="Thêm">
                    <input type="submit" name="submit" value="Sửa">
                    <input type="submit" name="submit" value="Xóa">
                    <input type="reset" value="Làm lại">
                </form>
            </fieldset>

            <!-- Danh sách khách hàng -->
            <table border="1" width="100%" cellpadding="6" cellspacing="2">
                <tr>
                    <th>Mã KH</th>
                    <th>Tài khoản</th>
                    <th>Tên khách hàng</th>
                    <th>email</th>
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Thao tác</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row["id"]."</td>";
                    echo "<td>".$row["username"]."</td>";
                    echo "<td>".$row["name"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["phone_number"]."</td>";
                    echo "<td>".$row["address"]."</td>";
                    echo "<td><a href='?cusid=".$row["id"]."'>Sửa/Xóa</a></td>";
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