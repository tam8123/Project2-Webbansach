
// Tải dữ liệu ban đầu cho form đăng nhập
function onloadFormComplete(){
	var form = document.forms["form_login"];
	form.username.value = localStorage.getItem("username");
	form.password.value = localStorage.getItem("password");
	form.chkRemember.checked = localStorage.getItem("chkRemember");
}


// Xác thực dữ liệu nhập trên form đăng nhập
function validateLogin(){	
	var msgError = document.getElementById("msg_error");
	var form = document.forms["form_login"];	
	if(form.username.value == ""){
		// alert("Username không để trống!");
		msgError.innerHTML = "Username không để trống!";
		return false;
	}
	
	if(form.password.value == ""){
		// alert("Password không để trống!");
		msgError.innerHTML = "Password không để trống!";
		return false;
	}

	// Lưu thông tin đăng nhập
	if(form.chkRemember.checked){
		localStorage.setItem("username", form.username.value);
		localStorage.setItem("password", form.password.value);
		localStorage.setItem("chkRemember", form.chkRemember.checked);
	} else {
		localStorage.removeItem("username");
		localStorage.removeItem("password");
		localStorage.removeItem("chkRemember");
	}

	return true; // Form hợp lệ
}