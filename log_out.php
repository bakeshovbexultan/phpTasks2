<?php

session_start();
require 'functions.php';

$_SESSION['login'] = null;
redirect_to("page_register.php");