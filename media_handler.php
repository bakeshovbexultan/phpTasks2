<?php

session_start();
require 'functions.php';

$avatar = $_FILES['avatar'];

$user = get_user_by_id($_SESSION['edit_id']);
$user_id = $user[0]['id'];

upload_avatar($avatar, $user_id);
set_flash_message('success', 'Профильно успешно обновлен.');
redirect_to("page_profile.php?id=$user_id");