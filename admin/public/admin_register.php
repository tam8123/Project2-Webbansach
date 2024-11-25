<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shop Online</title>
	<link rel="stylesheet" href="../../css/main_style.css">
	<script type="text/javascript" src="../../js/main_script.js"></script>
</head>
<body>
	<!-- Header -->	
	<header><?php require_once 'header.php';?></header>
	<?php
	if (isset($_POST["submit"])) {
        $uname = $_POST["username"];
        $pass = md5($_POST["password"]); // Lấy mật khẩu chưa băm
        // $roll = "admin"; // Giả sử mặc định là admin

        // Lệnh prepare
        $sql = "INSERT INTO `admins`(`username`, `password`) VALUES (?,?)";
        $stmt = mysqli_prepare($prconn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $uname, $pass);
        $result = mysqli_stmt_execute($stmt); // Kích hoạt lệnh prepare

        if ($result) {
			session_start();
            // Đăng ký thành công
            $_SESSION["admin_username"] = $uname;
            // header("Location: index.php");
            header("Location: ../index.php");
            exit();
        } else {
            // Đăng ký thất bại
            echo "<script>alert('Đăng ký thất bại!');</script>";
        }
    }
	?>
	<!-- Body -->
	<div class="content-center main-body">
		<!-- Form đăng ký -->
		<div style="width: 400px; height: 300px; margin: 0 auto; margin-top: 100px; overflow: hidden; box-sizing: border-box; padding: 10px">
		<fieldset style="padding: 10px">
                <legend><h2>Đăng ký Admin</h2></legend>
                <form name="form_register" action="#" method="POST" style="width: 100%">
                    <table style="width: 100%" cellspacing="6" cellpadding="6">
                        <tr>
                            <td>Tài khoản: </td>
                            <td><input type="text" name="username" id="username" required=""> <span style="color: red">*</span></td>
                        </tr>
                        <tr>
                            <td>Mật khẩu: </td>
                            <td><input type="password" name="password" id="password" required=""> <span style="color: red">*</span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="submit" value="Đăng ký" />
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
			<?php include_once 'footer.php';?>
		</div>
	</footer>
</body>
</html>