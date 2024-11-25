<?php
	$condition = "WHERE status = 1 ";
	$filterCondition = '';


	if (isset($_GET["min-price"]) && isset($_GET["max-price"])) {
		if($_GET["min-price"] !== '' && $_GET["max-price"] !== '') {
			$filterCondition = " AND price BETWEEN " . $_GET["min-price"] . " AND " . $_GET["max-price"];
		}
	}

	if (isset($_GET["search"])) {
		$keywords = trim($_GET["search"]);
		$keywords = explode(' ', $keywords);
		foreach ($keywords as $word) {
			$condition .= "AND name LIKE '%$word%' " ;
		}
		$condition .= $filterCondition;

		$condition .= " OR status = 1 ";
		foreach ($keywords as $word) {
			$condition .= "AND description LIKE '%$word%' " ;
		}
		$condition .= $filterCondition;


		$condition .= " OR status = 1 ";
		foreach ($keywords as $word) {
			$condition .= "AND author LIKE '%$word%' " ;
		}
		// $condition .= $filterCondition;
	}

	if (isset($_GET["category_id"])) {
		$condition .= "AND category_id = " . $_GET["category_id"];
	}
	$condition .= $filterCondition;

	// 1. Lệnh truy vấn 
	$sql = "SELECT * FROM `products`" . $condition;

	// 2. Truy vấn
	$result = mysqli_query($prconn, $sql);

	// 3. Duyệt
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			// Sản phẩm
			echo "<div class='product-title'>";
			echo "<a href='product_detail.php?prodId=".$row["id"]."'><img width='290px' height='290px' src='public/images/".$row["imagelink"]."' alt='hp123'></a> ";
			echo "<h3>".$row["name"]."</h3>";
			echo "<div class='box-desc'>". $row["author"]."</div>";			
			echo "<div class='box-price'>". number_format($row["price"])."</div>";
			//echo "<div class='box-price'>".formatCurrency($row["price"])."</div>";
			echo "</div>";
		}
	}
?>