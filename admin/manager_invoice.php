<?php require_once "./public/check_admin_login.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop Online</title>
    <link rel="stylesheet" href="../css/main_style.css">
    <style>
        table tr:hover{
            background-color: yellow;
        }
        .box-odd{
            background-color: cyan;
        }
    </style>
</head>
<body>
    <!-- Header -->    
    <header><?php require_once 'public/header.php';?></header>

    <!-- Body -->
    <div class="content-center main-body">
        <!-- Danh mục -->
        <div style="width: 20%; float:left; overflow: hidden; box-sizing: border-box;">
            <?php include_once 'menu.php';?>
        </div>
        <!-- Nội dung -->
        <div style="width: 80%; float:left; overflow: hidden; box-sizing: border-box; padding: 10px;">
            <!-- Trang quản lý hóa đơn -->
            <h1 style="border-bottom: 1px solid #ebebeb; margin-bottom: 10px">Quản lý Hóa Đơn</h1>
            <!-- Mở kết nối tới cơ sở dữ liệu -->
            <?php 
                include_once 'public/bk_connect.php';            
                // Truy vấn hóa đơn
                $sql = "SELECT * FROM `orders`";

                $result = mysqli_query($prconn, $sql); // Thực thi truy vấn

                // Hiển thị dữ liệu
                if (mysqli_num_rows($result) > 0) {
                    // Bảng dữ liệu hóa đơn
            ?>
                <table border="1" width="100%" cellpadding="6" cellspacing="2">
                    <tr>
                        <th>Mã hóa đơn</th>
                        <th>Mã khách hàng</th>
                        <th>Tên nhận</th>
                        <th>Điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Thanh toán</th>
                        <th>Ngày đặt</th>
                        <th style="text-align: center">Tình trạng</th>                        
                    </tr>       
                    <?php
                    $cnt = 1;
                    // Duyệt và hiển thị dữ liệu
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($cnt%2 != 0) {                            
                            echo "<tr class='box-odd'>";
                        } else {
                            echo "<tr>";
                        }
                        $cnt++;
                        echo "<td>".$row["id"]."</td>";
                        echo "<td>".$row["user_id"]."</td>";
                        echo "<td>".$row["receiver_name"]."</td>";
                        echo "<td>".$row["phone_number"]."</td>";
                        echo "<td>".$row["address"]."</td>";
                        echo "<td>".$row["payment"]."</td>";
                        echo "<td>".date("d/m/Y H:i:s", strtotime($row["created_at"]))."</td>"; // Định dạng ngày tháng
                        echo "<td style='text-align:center'>";
                        if ($row["status"] == 1) {
                            echo "<a href='invoice_delivery.php?invoiceId=".$row["id"]."'><img src='images/ic_delivery.png' alt='Giao hàng' title='Giao hàng'></a>";
                        } else {
                            echo "Hoàn thành";
                        }
                        echo "</td>";    
                        
                        echo "</tr>";
                    }
                    ?>
                </table>    

                <?php
            } else {
                echo "<span class='error'>Không tìm thấy hóa đơn nào</span>";
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
