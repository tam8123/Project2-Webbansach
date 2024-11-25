<?php require_once "./public/check_admin_login.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>QL Sản phẩm</title>
	<link rel="stylesheet" href="../css/main_style.css">
	<style>
		.phan-trang {
			width: 100%;
			text-align: center;
			list-style: none;
			list-style: none;
			font-weight: bold;
			font-size: 1.5em;
			overflow: hidden;
			margin-bottom: 10px;
		}

		.phan-trang li {
			display: inline;
		}

		.phan-trang a {
			padding: 10px;
			border: 1px solid #ebebeb;
			text-decoration: none;
		}
	</style>
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
			<!-- Trang quản lý sản phẩm -->
			<h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý sản phẩm</h1>
			<!-- Mở kết nối tới csdl -->
			<?php
				include_once 'public/bk_connect.php';
				require_once 'public/upload_file.php';
			?>
			<!-- Thêm/Sửa sản phẩm nếu có dữ liệu gửi đi -->
			<?php
			if (isset($_POST["submit"])) {
				$updateId = 0; // Mã cập nhật
				if (isset($_POST["updateId"])) {
					$updateId = $_POST["updateId"];
				}

				$idcat = isset($_POST["optCatelog"]) ? $_POST["optCatelog"] : 0;
				$name = $_POST["txtName"];
				$price = $_POST["txtPrice"];
				$desc = $_POST["txtDesc"];
				$author = $_POST["author"];
				$status = isset($_POST["chkStatus"]) ? 1 : 0;

				$sql = "";

				if ($updateId != 0) {
					// Đoạn mã cho trường hợp cập nhật sản phẩm
					$sql = "UPDATE `products` SET `category_id`=" . $idcat . ", `name`='" . $name . "', `price`=" . $price . ", `description`='" . $desc . "', `author`='" . $author . "', `status`=" . $status;
					// Kiểm tra nếu có file ảnh mới thì cập nhật cả imagelink
					if (!empty($imagelink)) {
						$sql .= ", `imagelink`='" . $imagelink . "'";
					}
					$sql .= " WHERE `id`=" . $updateId;
				} else {
					// Đoạn mã cho trường hợp thêm mới sản phẩm
					$sql = "INSERT INTO `products`(`category_id`, `name`, `price`, `description`, `author`, `status`";
					// Thêm imagelink vào câu lệnh chỉ khi có file ảnh được tải lên
					if (!empty($imagelink)) {
						$sql .= ", `imagelink`";
					}
					$sql .= ") VALUES (" . $idcat . ", '" . $name . "', " . $price . ", '" . $desc . "', '" . $author . "', " . $status;
					// Thêm giá trị imagelink vào câu lệnh INSERT
					if (!empty($imagelink)) {
						$sql .= ", '" . $imagelink . "'";
					}
					$sql .= ")";
				}


				mysqli_query($prconn, $sql);
				$idPrd = 0;
				if ($updateId == 0) {
					$idPrd = mysqli_insert_id($prconn);
				}

				if ($idPrd != 0 || $updateId != 0) {
					if ($updateId != 0) {
						echo "Sửa dữ liệu thành công!";
					} else {
						echo "Thêm dữ liệu thành công!";
					}
					// Tải file ảnh lên server
					if (!empty($_FILES["fileToUpload"]["name"])) {
						$filePath = $_FILES["fileToUpload"];
						$extension = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));
						$filename = "";
						if ($updateId != 0) {
							$filename = "prd_" . $updateId . "." . $extension; // Sửa
						} else {
							$filename = "prd_" . $idPrd . "." . $extension; // Thêm
						}

						uploadFile($filePath, $filename);

						// Cập nhật tên ảnh khi THÊM / SỬA
						$id4Update = ($updateId != 0) ? $updateId : $idPrd;
						$sql = "UPDATE `products` SET `imagelink`='" . $filename . "' WHERE id = " . $id4Update;

						mysqli_query($prconn, $sql); // Truy vấn						
					} else {
						// echo "Không có file tải lên";
					}
				} else {
					echo "Thất bại: " . mysqli_error($prconn) . "(" . $sql . ")";
				}
			}
			?>

			<!-- Tải danh mục sản phẩm -->
			<?php
			$sql = "SELECT * FROM `categories`";
			// Truy vấn
			$resultCat = mysqli_query($prconn, $sql); // Dữ liệu danh mục

			// Load dữ liệu sản phẩm theo ID
			$pID = 0;
			$pCat = 0;
			$pName = "";
			$pPrice = 0;
			$pDesc = "";
			$pAuthor = "";
			$pImage = "";
			$pStatus = true;
			if (isset($_GET["prdid"])) {
				$sql = "SELECT * FROM `products` WHERE id = " . $_GET["prdid"];

				$result = mysqli_query($prconn, $sql);

				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						$pID = $row["id"];
						$pCat = $row["category_id"];
						$pName = $row["name"];
						$pPrice = $row["price"];
						$pDesc = $row["description"];
						$pAuthor = $row["author"];
						$pImage = $row["imagelink"];
						$pStatus = $row["status"];
					}
				}
			}
			?>

			<!-- Tạo form nhập dữ liệu sản phẩm -->
			<fieldset style="margin-bottom: 10px; margin-top: 10px">
				<legend>THÊM SẢN PHẨM</legend>
				<form action="#" method="post" enctype="multipart/form-data">
					<!-- Mã ID của sản phẩm cho cập nhật -->
					<input type="hidden" id="updateId" name="updateId" value="<?php echo $pID ?>">

					<table width="100%" cellpadding="6" cellspacing="6">
						<tr>
							<th>Danh mục</th>
							<td>
								<select name="optCatelog" id="optCatelog">
									<option value="0">Empty</option>
									<?php
									while ($row = mysqli_fetch_assoc($resultCat)) {
										if ($pCat == $row["id"]) {
											echo "<option selected value='" . $row["id"] . "'>" . $row["title"] . "</option>";
										} else {
											echo "<option value='" . $row["id"] . "'>" . $row["title"] . "</option>";
										}
									}
									?>
								</select>
							</td>
							<td>Tên sản phẩm</td>
							<td><input type="text" name="txtName" id="txtName" value="<?= $pName ?>"></td>
							<td>Giá</td>
							<td><input type="number" name="txtPrice" id="txtPrice" value="<?php echo $pPrice ?>" min="0" step="100"></td>
						</tr>
						<tr>
							<td>Tác giả</td>
							<td colspan="5"><input type="text" name="author" value="<?= $pAuthor ?>"/>
							<!-- <textarea style="width: 100%" name="author" id="author"><?= $pAuthor ?></textarea> -->
							</td>
						</tr>
						<tr>
							<td>Mô tả</td>
							<td colspan="5" ><textarea style="width: 100%; min-height: 200px;" name="txtDesc" id="txtDesc"><?php echo $pDesc ?></textarea></td>
						</tr>
					
						<tr>
							<td>Ảnh minh họa</td>
							<td colspan="5">
								<?php
								if (!empty($pImage)) {
								?>
									<img width="200" height="200" src='<?=  "../public/images/" . $pImage ?>' alt="">
								<?php } ?>
								<input type="file" name="fileToUpload" id="fileToUpload">
							</td>
						</tr>
						<tr>
							<td>Có hàng</td>
							<td>
								<?php
								if ($pStatus) {
								?>
									<input type="checkbox" name="chkStatus" id="chkStatus" value="1" checked="">
								<?php } else { ?>
									<input type="checkbox" name="chkStatus" id="chkStatus" value="1">
								<?php } ?>
							</td>
							<td colspan="4">
								<?php
								if ($pID) {
								?>
									<input type="submit" name="submit" value="Sửa">
								<?php } else { ?>
									<input type="submit" name="submit" value="Thêm">
								<?php } { ?>
									<input type="submit" name="submit" value="Xóa">
								<?php } ?>
								<input type="reset" value="Làm lại">
							</td>
						</tr>
					</table>
				</form>
			</fieldset>
			<?php
			$page = 0;
			if (isset($_GET["page"])) {
				// echo $_GET["page"];
				$page = $_GET["page"] - 1;
			}

			// Lấy tổng số trang
			$sql = "SELECT CEIL((SELECT COUNT(*) FROM `products`) / 6) AS 'totalpage'"; // Mỗi page 6 items >>> có thể thay đổi theo tham số
			$result = mysqli_query($prconn, $sql);
			$totalpage = 0;
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$totalpage = $row["totalpage"];
				}
			}

			// Tải sản phẩm (all)
			// $sql = "SELECT * FROM `products`";
			// Lấy OFFSET hiện tại
			$sql = "SELECT " . $page . " * (SELECT (SELECT COUNT(*) FROM `products`) / (SELECT CEIL((SELECT COUNT(*) FROM `products`) / 6))) AS 'offset'";
			$result = mysqli_query($prconn, $sql);
			$offset = 0;
			while ($row = mysqli_fetch_assoc($result)) {
				$offset = (int) $row["offset"];
			}

			// Lấy items trong trang
			$sql = "SELECT * FROM `products` LIMIT " . $offset . ", 6";
			// echo $sql;

			$result = mysqli_query($prconn, $sql); // Truy vấn
			// $result = mysqli_multi_query($prconn, $sql); // Truy vấn

			// Duyệt hiển thị dữ liệu
			if (mysqli_num_rows($result) > 0) {
				// Code bảng dữ liệu hiển thị
			?>
				<!-- Phân trang -->
				<ul class="phan-trang">
					<?php
					for ($i = 1; $i <= $totalpage; $i++) {
						echo "<li><a href='?page=" . $i . "'>" . $i . "</a></li>";
					}
					?>
				</ul>
				<table border="1" width="100%" cellpadding="6" cellspacing="2">
					<tr>
						<th>Mã sản phẩm</th>
						<th>Danh mục</th>
						<th>Tên sản phẩm</th>
						<th>Giá tiền</th>
						<th>Tác giả</th>
						<th>Ảnh minh họa</th>
						<th>Ngày nhập</th>
						<th>Trạng thái</th>
						<th style="text-align: center">Actions</th>
					</tr>
					<?php
					// Duyệt vòng lặp lấy dữ liệu 
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" . $row["id"] . "</td>";
						echo "<td>" . $row["category_id"] . "</td>";
						echo "<td>" . $row["name"] . "</td>";
						echo "<td>" . $row["price"] . "</td>";
						echo "<td>" . $row["author"] . "</td>";
						echo "<td style='text-align: center'><img width='50' height='50' src='../public/images/" . $row["imagelink"] . "' alt='Lỗi hiển thị ảnh'></td>";
						echo "<td>" . $row["inputdate"] . "</td>";
						if ($row["status"] == 1) {
							echo "<td>còn hàng</td>";
						} else {
							echo "<td>Khóa</td>";
						}
						echo "<td style='text-align: center;'>
								<a href='?prdid=" . $row["id"] . "'>Edit</a>
								<a href='delete_product.php?prdid=" . $row["id"] . "'>Delete</a>
							</td>";
						
						echo "</tr>";
					}
					?>
				</table>
			<?php
			} else {
				echo "<span class='error'>Không tìm thấy sản phẩm phù hợp</span>";
			}
			?>

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
<?php
// Khái niệm phân trang: SELECT * FROM `products` LIMIT 0, 6
/*
		Lấy tổng số lượng: SELECT COUNT(*) FROM `products`
		Tổng số trang: SELECT CEIL((SELECT COUNT(*) FROM `products`) / 6) >>> làm tròn xuống FLOOR / làm tròn lên CEIL
		
		-- Số item trên mỗi trang
		SELECT (SELECT COUNT(*) FROM `products`) / (SELECT CEIL((SELECT COUNT(*) FROM `products`) / 6))
		-- limit mỗi trang: 6 item
		
		-- 2 là số trang hiện tại		
		SET @start = (SELECT 2 * (SELECT (SELECT COUNT(*) FROM `products`) / (SELECT CEIL((SELECT COUNT(*) FROM `products`) / 6))));
		PREPARE stmt FROM "SELECT * FROM `products` LIMIT ?, 6";
		EXECUTE stmt USING @start
	*/
?>