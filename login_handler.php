<?php

require 'functions.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];
$user = get_user_by_email($email);


if (login($email, $password)) {
	redirect_to('/users.php');
} else {
	set_flash_message('danger', 'Неправильный логин или пароль');
	redirect_to('page_login.php');
}