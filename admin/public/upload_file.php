<?php
function uploadFile($fileUpload, $name){
	$target_dir = "../public/images/";
	$target_file = $target_dir . basename($fileUpload["name"]); //  $_FILES["fileToUpload"]["name"]
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // Kiểu file
	$target_file_destination = $target_dir . $name; // Tên file đặt lại theo mã

	// Kiểm tra xem có phải là file ảnh hay ko
	$check = getimagesize($fileUpload["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "Tập tin không phải là ảnh.";
		$uploadOk = 0;
	}

	// Kiểm tra file đã tồn tại chưa?
	// if (file_exists($target_file_destination)) {
	// 	echo "Xin lỗi, file đã tồn tại.";
	// 	$uploadOk = 0;
	// }

	// Kiểm tra kích thước file ko lớn hơn 1Mb = 1024kb = 1024 * 1000 (byte)
	if ($fileUpload["size"] > 1024 * 1000) {
		echo "Xin lỗi, file quá lớn.";
		$uploadOk = 0;
	}

	// Kiểm tra định dạng
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		echo "Xin lỗi, chỉ upload định dạng: JPG, JPEG, PNG & GIF.";
		$uploadOk = 0;
	}

	// Các kiểm tra phải hoàn thành
	if ($uploadOk == 0) {
		echo "Xin lỗi, tập tin không thể upload.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($fileUpload["tmp_name"], $target_file_destination)) { // $target_file
			echo "The file ". basename( $fileUpload["name"]). " has been uploaded.";
		} else {
			echo "Đã xảy ra lỗi khi tải tập tin lên.";
		}
	}	
}
