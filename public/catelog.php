<h3 style="text-transform: uppercase; padding: 5px">Danh mục Thể Loại</h3>
<ul class="no-list-style catelog">	
	<a href="index.php"><li>Tất cả</li></a>	
	<?php
		$sql = "SELECT * FROM `categories`";
		$result = mysqli_query($prconn, $sql);

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<a href='index.php?category_id=". $row["id"] ."'><li>".$row["title"]."</li></a>";
			}
		} else {
			echo "-----";
		}		
	?>
</ul>