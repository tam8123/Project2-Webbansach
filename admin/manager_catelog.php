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
			<!-- Trang quản lý Danh mục -->
			<h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý Thể Loại</h1>
			<!-- Mở kết nối tới csdl -->
			<?php
				include_once 'public/bk_connect.php';
				require_once 'public/upload_file.php';
			?>
			<?php
            if (isset($_POST["submit"])) {
				if ($_POST["submit"] == "Thêm") {
					$title = $_POST["txtTitle"];
					$note = $_POST["txtNote"];
			
					$sql = "INSERT INTO `categories`(`title`, `note`) VALUES ('$title', '$note')";
					mysqli_query($prconn, $sql);
			
					if (mysqli_errno($prconn)) {
						$_SESSION['message'] = "Thêm thể loại thất bại: " . mysqli_error($prconn);
					} else {
						$_SESSION['message'] = "Thêm thể loại thành công!";
					}
				} elseif ($_POST["submit"] == "Sửa") {
					$id = $_POST["updateId"];
					$title = $_POST["txtTitle"];
					$note = $_POST["txtNote"];
			
					$sql = "UPDATE `categories` SET `title`='$title', `note`='$note' WHERE `id`='$id'";
					mysqli_query($prconn, $sql);
			
					if (mysqli_errno($prconn)) {
						$_SESSION['message'] = "Sửa thể loại thất bại: " . mysqli_error($prconn);
					} else {
						$_SESSION['message'] = "Sửa thể loại thành công!";
					}
				} elseif ($_POST["submit"] == "Xóa") {
					$id = $_POST["updateId"];
			
					$sql = "DELETE FROM `categories` WHERE `id`='$id'";
					mysqli_query($prconn, $sql);
			
					if (mysqli_errno($prconn)) {
						$_SESSION['message'] = "Xóa thể loại thất bại: " . mysqli_error($prconn);
					} else {
						$_SESSION['message'] = "Xóa thể loại thành công!";
					}
				}
			}
			
			// Lấy danh sách thể loại
			
			
			// Lấy thông tin để chỉnh sửa
			$pID = 0; $pTitle = ""; $pNote = "";
			if (isset($_GET["catid"])) {
				$sql = "SELECT * FROM `categories` WHERE id = " . $_GET["catid"];
				$result_edit = mysqli_query($prconn, $sql);
			
				if(mysqli_num_rows($result_edit) > 0){
					$row = mysqli_fetch_assoc($result_edit);
					$pID = $row["id"];
					$pTitle = $row["title"];
					$pNote = $row["note"];
				}
			}
			?>

			<!-- Tạo form nhập liệu thể loại-->
            <fieldset style="margin-bottom: 10px; margin-top: 10px">
                <legend>THÊM/SỬA THỂ LOẠI</legend>
                <form action="#" method="post">
                    <input type="hidden" name="updateId" value="<?php echo $pID ?>">

                    <label for="txtTitle">Tên thể loại:</label>
                    <input type="text" id="txtTitle" name="txtTitle" value="<?php echo $pTitle ?>" required><br><br>

                    <label for="txtNote">Ghi chú:</label><br>
                    <textarea id="txtNote" name="txtNote" rows="4" cols="50"><?php echo $pNote ?></textarea><br><br>

                    <input type="submit" name="submit" value="Thêm">
                    <input type="submit" name="submit" value="Sửa">
                    <input type="submit" name="submit" value="Xóa">
                    <input type="reset" value="Làm lại">
                </form>
            </fieldset>

            <!-- Danh sách thể loại -->
            <table border="1" width="100%" cellpadding="6" cellspacing="2">
                <tr>
                    <th>ID</th>
                    <th>Tên thể loại</th>
                    <th>Ghi chú</th>
                    <th>Thao tác</th>
                </tr>
                <?php
				$sql = "SELECT * FROM `categories`";
				$result = mysqli_query($prconn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row["id"]."</td>";
                    echo "<td>".$row["title"]."</td>";
                    echo "<td>".$row["note"]."</td>";
                    echo "<td><a href='?catid=".$row["id"]."'>Sửa/Xóa</a></td>";
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