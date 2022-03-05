<?php

session_start();
require 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$status = $_POST['status'];

$username = $_POST['username'];
$job_title = $_POST['job_title'];
$phone_number = $_POST['phone_number'];
$address = $_POST['address'];

$avatar = $_FILES['avatar'];

$vkontakte = $_POST['vkontakte'];
$telegram = $_POST['telegram'];
$instagram = $_POST['instagram'];


$user = get_user_by_email($email);



if (!empty($user)) {
	set_flash_message('danger', '<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.');
	redirect_to('create_user.php');
}


$user_id = add_user($email, $password);
edit_information($username, $job_title, $phone_number, $address, $user_id);
set_status($status, $user_id);
upload_avatar($avatar, $user_id);
add_social_links($telegram, $instagram, $vkontakte, $user_id);

set_flash_message('success', 'Пользователь был успешно добавлен');
redirect_to('users.php');






















