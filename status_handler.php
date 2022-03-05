<?php

session_start();
require 'functions.php';

$status = $_POST['status'];
$user_id = $_SESSION['edit_id'];

set_status($status, $user_id);

set_flash_message("success", "Профиль успешно обновлен");
redirect_to("page_profile.php?id=$user_id");
