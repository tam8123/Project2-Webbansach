<div class="content-center" style="color: white">
	<!-- Mở kết nối tới csdl -->
	<?php include_once 'bk_connect.php';?>
	
	<div style="width: 60%; float: left; line-height: 100px">
		<h1 style="text-transform: uppercase;"><a href="index.php">Quản lý</a></h1>
	</div>
	<div style="width: 40%; float: left; line-height: 100px">
		<!-- Tài khoản đăng nhập / giỏ hàng -->
		<div style="width: 100%;float: right; height: 50px; padding: 0px; margin: 0px; line-height: 50px; text-align: right; vertical-align: middle;">
			<?php
				if (isset($_SESSION["admin_username"])) {
					echo "Xin chào " . $_SESSION["admin_username"] . " (<a href='public/logout.php'>Thoát</a>)";	
				} else {		
			?>
				<div style="height: 50px; line-height: 50px; float: right;">
					<a href="/project_bansach/admin/public/admin_login.php">Đăng nhập</a> | 
					<a href="/project_bansach/admin/public/admin_register.php">Đăng ký</a>	
				</div>	
			<?php } ?>
		</div>
	</div>
</div>