<?php

session_start();
require 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$edit_id = $_SESSION['edit_id'];

$user = get_user_by_id($edit_id);

if (!empty(get_user_by_email($user[0]['email']))) {
	if (!$user[0]['email'] == $email) {
		set_flash_message("danger", "Данный эл. адрес занят другим пользователем");
		redirect_to("security.php?id=$edit_id");
	} else {
		edit_credentials ($edit_id, $email, $password);
		set_flash_message("success", "Профиль успешно обновлен");
		redirect_to("page_profile.php?id=$edit_id");
	}
}
