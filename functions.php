<?php

function get_user_by_email ($email) {
	$driver = 'mysql';
	$host = 'localhost';
	$db_name = 'marlinpractice';
	$db_user = 'root';
	$db_password = '';
	$charset = 'utf8';

	$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
	$dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
	$pdo = new PDO($dsn, $db_user, $db_password, $options);
	$sql = "SELECT * FROM users WHERE email =:email";

	$statement = $pdo->prepare($sql);

	$statement->execute(['email' => $email]);
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $result;
}
function add_user ($email, $password) {
		$driver = 'mysql';
		$host = 'localhost';
		$db_name = 'marlinpractice';
		$db_user = 'root';
		$db_password = '';
		$charset = 'utf8';

		$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
		$dsn = "$driver:host=$host;dbname=$db_name;charset=$charset";
		$pdo = new PDO($dsn, $db_user, $db_password, $options);

		$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";

		$statement = $pdo->prepare($sql);

		$statement->execute([
			'email' => $email,
			'password' => password_hash($password, PASSWORD_DEFAULT)
		]);



		$sql = "SELECT * FROM users WHERE email =:email";

		$statement = $pdo->prepare($sql);

		$statement->execute(['email' => $email]);
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $result[0]['id'];
}
function set_flash_message ($name, $message) {

	$_SESSION[$name] = $message;
}
function display_flash_message ($name) {
	if (isset($_SESSION[$name])) {
		echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";
		unset($_SESSION[$name]);
	}
}
function redirect_to ($path) {
	header("Location: $path");
	exit;
}
function login ($login, $password) {
	$user = get_user_by_email($login);
	$_SESSION['id'] = $user[0]['id'];

	if (!empty($user)) {
		if (password_verify($password, $user[0]['password'])) {
			$_SESSION['login'] = true;
			$_SESSION['email'] = $user[0]['email'];
			$_SESSION['role'] = $user[0]['role'];
			return true;
		}
	} else {
		return false;
	}
}
function is_not_logged_in () {
	if (!$_SESSION['login']) {
		redirect_to("page_login.php");
	}
}
function is_admin () {
	if ($_SESSION['role'] == 'admin') {
		return true;
	} else {
		return false;
	}
}
function edit_information ($name, $profession, $phone_number, $address, $user_id) {
	$pdo = new PDO('mysql:host=localhost;dbname=marlinpractice;charset=utf8', 'root', '');
		
	$sql = "UPDATE users SET name = :name, profession = :profession, phone_number = :phone_number, address = :address WHERE id = $user_id";

	$statement = $pdo->prepare($sql);

	$statement->execute([
		'name' => $name,
		'profession' => $profession,
		'phone_number' => $phone_number,
		'address' => $address
	]);
}
function set_status ($status, $user_id) {
	$pdo = new PDO('mysql:host=localhost;dbname=marlinpractice;charset=utf8', 'root', '');
		
	$sql = "UPDATE users SET status = :status WHERE id = $user_id";

	$statement = $pdo->prepare($sql);

	$statement->execute(['status' => $status]);
}
function upload_avatar ($avatar, $user_id) {
	$filename = $_FILES['avatar']['name'];
	$tmp_name = $_FILES['avatar']['tmp_name'];
	$result = pathinfo($filename);

	$filename = uniqid() . "." . $result['extension'];

	move_uploaded_file($tmp_name, 'img/demo/avatars/' . $filename);
	$avatar = 'img/demo/avatars/' . $filename;

	$pdo = new PDO("mysql:host=localhost;dbname=marlinpractice;", "root", "");
	$sql = "UPDATE users SET avatar = :avatar WHERE id = $user_id";
	$statement = $pdo->prepare($sql);
	$statement->execute(['avatar' => $avatar]);
}
function add_social_links ($telegram, $instagram, $vkontakte, $user_id) {
	$pdo = new PDO('mysql:host=localhost;dbname=marlinpractice;charset=utf8', 'root', '');
		
	$sql = "UPDATE users SET telegram = :telegram, instagram = :instagram, vkontakte = :vkontakte WHERE id = $user_id";

	$statement = $pdo->prepare($sql);

	$statement->execute([
		'telegram' => $telegram,
		'instagram' => $instagram,
		'vkontakte' => $vkontakte
	]);
}
function is_author ($logged_user_id, $edit_user_id) {
	if ($logged_user_id == $edit_user_id) {
		return true;
	} else {
		if (!is_admin()) {
			set_flash_message("danger", "Можно редактировать только свой профиль");
		}
		redirect_to("users.php");
	}
}
function get_user_by_id ($id) {
	$pdo = new PDO('mysql:host=localhost;dbname=marlinpractice;charset=utf8', 'root', '');
	$sql = "SELECT * FROM users WHERE id =:id";

	$statement = $pdo->prepare($sql);

	$statement->execute(['id' => $id]);
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $result;
}
function edit_credentials ($id, $email, $password) {
	$pdo = new PDO('mysql:host=localhost;dbname=marlinpractice;charset=utf8', 'root', '');
		
	$sql = "UPDATE users SET email = :email, password = :password WHERE id = $id";

	$statement = $pdo->prepare($sql);

	$statement->execute([
		'email' => $email,
		'password' => password_hash($password, PASSWORD_DEFAULT)
	]);
}
function get_statuses () {
	$pdo = new PDO('mysql:host=localhost;dbname=marlinpractice;charset=utf8', 'root', '');
	$sql = "SELECT * FROM statuses";

	$statement = $pdo->prepare($sql);

	$statement->execute(['id' => $id]);
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);

	return $result;
}
function has_image ($user_id) {
    $user = get_user_by_id($_SESSION['edit_id']);
    if (empty($user[0]['avatar'])) {
    	return false;
    } else {
	    return true;
	}
}
function delete ($id) {
	$pdo = new PDO("mysql:host=localhost;dbname=marlinpractice;", "root", "");
    $sql = "DELETE FROM users WHERE id = :id";
	$statement = $pdo->prepare($sql);
	$statement->execute(['id' => $id]);
}