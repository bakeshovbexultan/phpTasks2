<?php

session_start();
require 'functions.php';

$delete_id = $_GET['id'];

if (!is_admin()) {
    is_author($_SESSION['id'], $delete_id);
}

delete ($delete_id);
set_flash_message("success", "Пользователь удален");


if (is_author($_SESSION['id'], $delete_id)) {
	redirect_to("log_out.php");
} else {
	redirect_to("users.php");
}