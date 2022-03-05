<?php

session_start();
require 'functions.php';

$username = $_POST['username'];
$job_title = $_POST['job_title'];
$phone_number = $_POST['phone_number'];
$address = $_POST['address'];
$user_id = $_SESSION['edit_id'];

edit_information($username, $job_title, $phone_number, $address, $user_id);

set_flash_message("success", "Профиль успешно обновлен");
redirect_to("page_profile.php");