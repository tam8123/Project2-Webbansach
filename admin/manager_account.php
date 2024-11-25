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
			<!-- Trang quản lý tài khoản -->
			<h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý Tài khoản</h1>
			<!-- Mở kết nối tới csdl -->
			<?php
			include_once 'public/bk_connect.php';
			require_once 'public/upload_file.php';
			?>
			<!-- Xử lý thêm/sửa/xóa admin-->
			<?php
			if (isset($_POST["submit"])) {
				if ($_POST["submit"] == "Thêm") {
					$username = $_POST["txtUsername"];
					$password = $_POST["txtPassword"];

					// Mã hóa mật khẩu trước khi lưu vào CSDL (lưu ý: cách mã hóa phụ thuộc vào cách triển khai của bạn)
					$hashed_password = password_hash($password, PASSWORD_DEFAULT);

					$sql = "INSERT INTO `admin`(`username`, `password`) VALUES ('$username', '$hashed_password')";
					mysqli_query($prconn, $sql);

					if (mysqli_errno($prconn)) {
						$_SESSION['message'] = "Thêm admin thất bại: " . mysqli_error($prconn);
					} else {
						$_SESSION['message'] = "Thêm admin thành công!";
					}
				} elseif ($_POST["submit"] == "Sửa") {
					$id = $_POST["updateId"];
					$username = $_POST["txtUsername"];
					$password = $_POST["txtPassword"];

					// Mã hóa mật khẩu trước khi cập nhật vào CSDL (nếu có sửa mật khẩu)
					if (!empty($password)) {
						$hashed_password = md5($password);
						$sql = "UPDATE `admins` SET `username`='$username', `password`='$hashed_password' WHERE `id`='$id'";
					} else {
						$sql = "UPDATE `admins` SET `username`='$username' WHERE `id`='$id'";
					}

					mysqli_query($prconn, $sql);

					if (mysqli_errno($prconn)) {
						$_SESSION['message'] = "Sửa admin thất bại: " . mysqli_error($prconn);
					} else {
						$_SESSION['message'] = "Sửa admin thành công!";
					}
				} elseif ($_POST["submit"] == "Xóa") {
					$id = $_POST["updateId"];

					$sql = "DELETE FROM `admins` WHERE `id`='$id'";
					mysqli_query($prconn, $sql);

					if (mysqli_errno($prconn)) {
						$_SESSION['message'] = "Xóa admin thất bại: " . mysqli_error($prconn);
					} else {
						$_SESSION['message'] = "Xóa admin thành công!";
					}
				}
			}

			// Lấy danh sách admin
			$sql = "SELECT * FROM `admins`";
			$result = mysqli_query($prconn, $sql);

			// Lấy thông tin để chỉnh sửa
			$pID = 0;
			$pUsername = "";
			$pPassword = "";
			if (isset($_GET["adminid"])) {
				$sql_edit = "SELECT * FROM `admins` WHERE `id`=" . $_GET["adminid"];
				$result_edit = mysqli_query($prconn, $sql_edit);

				if (mysqli_num_rows($result_edit) > 0) {
					$row = mysqli_fetch_assoc($result_edit);
					$pID = $row["id"];
					$pUsername = $row["username"];
					// Không nên hiển thị mật khẩu cũng như không nên gửi lại mật khẩu cũ trên form khi sửa
				}
			}
			?>
			<!-- Tạo form nhập dữ liệu admin -->
			<fieldset style="margin-bottom: 10px; margin-top: 10px">
				<legend>THÊM/SỬA TÀI KHOẢN ADMIN</legend>
				<form action="#" method="post">
					<input type="hidden" name="updateId" value="<?php echo $pID ?>">

					<label for="txtUsername">Tên đăng nhập:</label>
					<input type="text" id="txtUsername" name="txtUsername" value="<?php echo $pUsername ?>" required><br><br>

					<label for="txtPassword">Mật khẩu:</label>
					<input type="password" id="txtPassword" name="txtPassword"><br><br>

					<input type="submit" name="submit" value="Thêm">
					<input type="submit" name="submit" value="Sửa">
					<input type="submit" name="submit" value="Xóa">
					<input type="reset" value="Làm lại">
				</form>
			</fieldset>

			<!-- Danh sách admin -->
			<table border="1" width="100%" cellpadding="6" cellspacing="2">
				<tr>
					<th>ID</th>
					<th>Tên đăng nhập</th>
					<th>Thao tác</th>
				</tr>
				<?php
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td>" . $row["id"] . "</td>";
					echo "<td>" . $row["username"] . "</td>";
					echo "<td><a href='?adminid=" . $row["id"] . "'>Sửa/Xóa</a></td>";
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