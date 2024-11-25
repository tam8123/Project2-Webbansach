<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Shop Online</title>
	<link rel="stylesheet" href="../../css/main_style.css">
	<script type="text/javascript" src="../../js/main_script.js"></script>
</head>

<body onload="onloadFormComplete()">
	<!-- Header -->
	<header><?php require_once 'header.php'; ?></header>

	<?php
	if (isset($_POST["submit"])) {
		$uname = $_POST["username"];
		$pass = md5($_POST["password"]);
		
		// Chuẩn bị câu lệnh SQL với MySQLi Prepared Statement
		$sql = "SELECT * FROM `admins` WHERE `username` = ? AND `password` = ?";
		$stmt = mysqli_prepare($prconn, $sql);
		mysqli_stmt_bind_param($stmt, "ss", $uname, $pass);
		mysqli_stmt_execute($stmt); // Thực thi câu lệnh prepare
		$result = mysqli_stmt_get_result($stmt); // Lấy kết quả trả về
	

		if (mysqli_num_rows($result) > 0) {
			// Đăng nhập thành công
			session_start();
			
			while ($row = mysqli_fetch_assoc($result)) {
				$_SESSION["admin_id"] = $row["id"]; // Lưu ID của admin vào session
				$_SESSION["admin_username"] = $row["username"]; // Lưu username của admin vào session
				// $_SESSION["admin_roll"] = $row["roll"]; // Lưu quyền hạn của admin vào session (nếu cần)
			}
			header("Location: ../index.php"); // Chuyển hướng đến trang index.php sau khi đăng nhập thành công
			exit();
		} else {
			// Đăng nhập thất bại
			echo "<script>alert('Tài khoản/mật khẩu không đúng!');</script>";
		}
	}
	?>

	<!-- Body -->
	<div class="content-center main-body">
		<!-- Form đăng nhập -->
		<div style="width: 400px; height: 300px; margin: 0 auto; margin-top: 100px; overflow: hidden; box-sizing: border-box; padding: 10px">
		<fieldset style="padding: 10px">
                <legend><h2>Đăng nhập Admin</h2></legend>
                <form name="form_login" action="#" method="POST" style="width: 100%">
                    <table style="width: 100%" cellspacing="6" cellpadding="6">
                        <tr>
                            <td>Tài khoản: </td>
                            <td><input type="text" name="username" id="username" required=""></td>
                        </tr>
                        <tr>
                            <td>Mật khẩu</td>
                            <td><input type="password" name="password" id="password" required=""></td>
                        </tr>
                        <tr>   
                            <td></td>                       
                            <td>
                                <input type="submit" name="submit" value="Đăng nhập" onclick="return validateLogin();" />
                                <input type="reset" value="Làm lại">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><span id="msg_error" style="color: red"></span></td>
                        </tr>
                    </table>
                </form>
            </fieldset>
		</div>
	</div>

	<!-- Footer -->
	<footer>
		<div class="content-center">
			<?php include_once 'footer.php'; ?>
		</div>
	</footer>
</body>

</html>