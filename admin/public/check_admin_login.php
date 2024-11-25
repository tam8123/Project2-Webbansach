<?php
session_start();
if(!$_SESSION['admin_username']) {
	header("Location: ./public/admin_login.php");
}