<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop Online</title>
    <link rel="stylesheet" href="css/main_style.css">
    <script type="text/javascript" src="js/main_script.js"></script>
</head>
<body>
    <!-- Header -->
    <header><?php require_once 'public/header.php';?></header>

    <!-- Body -->
    <div class="content-center main-body">
        <!-- Form đặt hàng -->
        <div style="width: 400px; height: 300px; margin: 0 auto; margin-top: 100px; overflow: hidden; box-sizing: border-box; padding: 10px">
            <fieldset style="padding: 10px">
                <legend><h2>Thông tin giao hàng</h2></legend>
                <form name="form_payment" action="#" method="POST" style="width: 100%">
                    <table style="width: 100%" cellspacing="6" cellpadding="6">
                        <!-- Mã khách hàng -->
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
                        <tr>
                            <td>Tên người nhận</td>
                            <td><input type="text" name="receiver_name" id="receiver_name" required value="<?php echo $_SESSION["username"]; ?>"> <span style="color: red">*</span></td>
                        </tr>
                        <tr>
                            <td>Điện thoại</td>
                            <td><input type="text" name="phone_number" id="phone_number" required value="<?php echo $_SESSION["phone_number"]; ?>"> <span style="color: red">*</span></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ</td>
                            <td><input type="text" name="address" id="address" value="<?php echo $_SESSION["address"]; ?>"></td>
                        </tr>
                        <tr>
                            <td>Thanh toán</td>
                            <td>
                                <select name="payment" id="">
                                    <option value="Thanh toán bằng tiền mặt">Tiền mặt</option>
                                    <option value="Thanh toán bằng thẻ">Thẻ</option>

                                </select>
                            </td>
                        </tr>
                        <tr>   
                            <td></td>                        
                            <td>
                                <input type="submit" name="submit" value="Đặt hàng" />
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

        <!-- Xử lý đặt hàng -->
        <?php
            if (isset($_POST["submit"])) {
                // Chuẩn bị câu lệnh SQL sử dụng lệnh prepare
                $sql = "INSERT INTO `orders`(`user_id`, `receiver_name`, `phone_number`, `address`, `payment`, `total_price`) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($prconn, $sql);

                // Kiểm tra và bind các tham số
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "issssd", $_POST["user_id"], $_POST["receiver_name"], $_POST["phone_number"], $_POST["address"], $_POST["payment"], $_SESSION["totalBill"]);

                    // Thực thi câu lệnh và kiểm tra kết quả
                    if (mysqli_stmt_execute($stmt)) {
                        echo "<h1 style='text-align:center'>Đặt hàng thành công</h1>";
                        $idhd = mysqli_insert_id($prconn); // Lấy ID hóa đơn sau khi thêm

                        // Xử lý chi tiết hóa đơn
                        $arrCart = $_SESSION["cart"];
                        // var_dump($arrCart);
                        $sql_details = "";
                        foreach ($arrCart as $key => $value) {
                            $sql_details .= "INSERT INTO `order_details`(`order_id`, `product_id`, `quantity`, `price`) VALUES ($idhd, $key, $value, (SELECT `price` FROM `products` WHERE `id` = $key));";
                        }

                        // Thực thi lệnh thêm chi tiết hóa đơn
                        if (mysqli_multi_query($prconn, $sql_details)) {
                            echo "<h3 style='text-align:center'>Thêm chi tiết hóa đơn thành công</h3>";
                        } else {
                            echo "<span style='color:red'>Lỗi thêm chi tiết hóa đơn: " . mysqli_error($prconn) . "</span>";
                        }

                        // Xóa thông tin giỏ hàng sau khi thanh toán
                        unset($_SESSION["cart"]);
                        unset($_SESSION["totalBill"]);
                    } else {
                        echo "<span style='color:red'>Lỗi thêm đơn hàng: " . mysqli_error($prconn) . "</span>";
                    }
                } else {
                    echo "<span style='color:red'>Lỗi prepare câu lệnh: " . mysqli_error($prconn) . "</span>";
                }

                // Đóng kết nối
                mysqli_stmt_close($stmt);
                mysqli_close($prconn);
            }
        ?>
    </div>
    
    <!-- Footer -->
    <footer>
        <div class="content-center">
            <?php include_once 'public/footer.php';?>
        </div>
    </footer>
</body>
</html>
