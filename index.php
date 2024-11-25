<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shop Online</title>
	<link rel="stylesheet" href="css/main_style.css">
</head>
<body>
	<!-- Header -->	
	<header><?php require_once 'public/header.php';?></header>
	
	<!-- Body -->
	<div class="content-center main-body">
		<!-- Danh mục -->
		<div class="side-bar" 
		>
			<?php include_once 'public/catelog.php';?>

			<div class="filter-price">
				<form action="" method="GET">
					<label for="filterPrice"><strong>Khoảng giá</strong></label>
					<div class="price-group" id="filterPrice">
						<input value="<?= $_GET["min-price"] ?? '' ?>" type="number" min="0" name="min-price" placeholder="₫ từ"/>
						<input value="<?= $_GET["max-price"] ?? '' ?>" type="number" min="0" name="max-price" placeholder="₫ đến"/>
					</div>
					<?= isset($_GET['search']) ? '<input type="hidden" name="search" value="' .$_GET['search']. '" />' : '' ?>
					<?= isset($_GET['category_id']) ? '<input type="hidden" name="category_id" value="' .$_GET['category_id']. '" />' : '' ?>
					<button type="submit">Áp dụng</button>
					<!-- <input id="filterPrice" type="range" name="price" id="" max="100" min="0" /> -->
				</form>
			</div>
		</div>
		<!-- Nội dung -->
		<div class="main-content">
			<?php include_once 'public/content-center.php';?>
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