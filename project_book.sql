-- create database project_book;
use project_book;


CREATE TABLE `categories` (
  `id`INT AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(31) NOT NULL,
  `note` varchar(256)
);

CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT DEFAULT NULL,
  `name` VARCHAR(32) NOT NULL,
  `price` DOUBLE DEFAULT 0,
  `quantity` INT DEFAULT 0,
  `author` varchar(64) DEFAULT NULL,
  `description` VARCHAR(512) DEFAULT NULL,
  `imagelink` VARCHAR(256) DEFAULT NULL,
  `inputdate` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,

  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ;


INSERT INTO `products` (`category_id`, `name`, `price`, `quantity`, `author`, `description`, `imagelink`, `inputdate`, `status`) VALUES
(NULL, 'Một Lít Nước Mắt', 70000, 10,'Sáng tác bởi Kito Aya', 'Quyển nhật kí của Kito Aya viết về hành trình chống lại bệnh tật của cô vốn do bác sĩ chăm sóc cô đề xuất để tiện việc theo dõi tiến trình của căn bệnh – được cô viết cho đến khi cơ thể cô bị liệt hoàn toàn, sau đó được xuất bản không lâu trước khi Aya qua đời.', 'product_1.jpg', '2022-11-09 11:56:22', 1),
(NULL, 'Ma Đạo Tổ Sư', 415000, 10, 'Sáng tác bởi Mạc Hương Đồng Khứu', 'Mạc Hương Đồng Khứu. Xoay quanh cuộc sống và phiêu lưu của hai nhân vật chính là Ngụy Vô Tiện và Lam Vong Cơ, trong một thế giới tiên hiệp đầy tranh đấu và bí ẩn. Bối cảnh là các thế gia lớn. Truyện mô tả cuộc chiến trường kỳ và những âm mưu đen tối của gia tộc Kỳ Sơn Ôn thị, khiến các hiệp sĩ giang hồ hợp lực chống lại sự áp bức. Ngụy Vô Tiện, hay còn gọi là Di Lăng Lão Tổ, từng bị hãm hại và chết oan uổng, nhưng sau 13 năm, anh tái xuất giang hồ và bắt đầu phát hiện ra những bí ẩn và ân oán t', 'product_2.jpg', '2022-11-09 15:17:38', 1),
(NULL, 'Tôi Thấy Hoa Vàng Trên Cỏ Xanh', 112000, 10, 'Nguyễn Nhật Ánh', 'Nguyễn Nhật Ánh kể về tuổi thơ nghèo khó của hai anh em Thiều và Tường cùng cô bạn thân hàng xóm. Mạch truyện tự nhiên, dẫn dắt người đọc chứng kiến những rung động đầu đời của tụi nhỏ, xen vào đó là những nét đẹp của tình anh em và vài nốt trầm của sự đau đớn khi trưởng thành.', 'product_3.jpg', '2022-11-09 11:56:22', 1);



CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT current_timestamp(),
  `status` smallint(1) DEFAULT 1
);



CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) DEFAULT NULL,
  `receiver_name` varchar(100) NOT NULL,
  `receiver_email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(100) NOT NULL,
  `payment` varchar(200) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` smallint(1) DEFAULT 1,

  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);


CREATE TABLE `order_details` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,

  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

CREATE TABLE `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
);
