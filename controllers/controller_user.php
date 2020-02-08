<?php

// контроллер для обработки POST запросов, связанных с пользователями
class Controller_user extends Controller {


	function __construct() {
		parent::__construct();
		$this->model = Core_model::new_model('user');
	}


	private function validate_login($variable) {
		return preg_match("/^[-_а-яёa-z0-9]{3,64}$/iu", $variable);}


	private function validate_name($variable) {
		return preg_match("/^[\s-_а-яёa-z0-9]{0,128}$/iu", $variable);}


	private function validate_pass($variable) {
		return preg_match("/^[a-f0-9]{64}$/", $variable);}


	private function validate_mail($variable) {
		return preg_match("/^([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z0-9]+)*(\.[a-z]{2,})){0,64}$/", $variable);}


	function action_login() {
		$data = array(
			'login' => $_POST['login'],
			'pass' => $_POST['pass']
		);


		// проверка на корректность
		$isValid = true;

		$isValid &= $this->validate_login($data['login']);
		$isValid &= $this->validate_pass($data['pass']);

		if($isValid == 0) {echo 'alert("Валидация не пройдена");'; return;}

		$result = null;

		try {
			$result = $this->model->login($data);
		} catch (Exception $e) {
			echo 'alert("'.addslashes($e->getMessage()).'");';
			return;
		}

		if(!is_null($result)) {
			$_SESSION['user'] = $result;
			echo 'window.location.href = "/";'; // редирект, если всё прошло успешно
		}
	}


	function action_logout() {
		$_SESSION['user'] = null;
		echo '<script>window.location.href = "/";</script>'; // редирект
	}


	function action_register() {
		$data = array(
			'login' => $_POST['login'],
			'pass' => $_POST['pass'],
			'name' => $_POST['name'],
			'mail' => $_POST['mail']
		);


		// проверка на корректность
		$isValid = true;

		// TODO допилить валидацию для имени и майла, так как они не обязательные
		$isValid &= $this->validate_login($data['login']);
		$isValid &= $this->validate_pass($data['pass']);
		$isValid &= $this->validate_name($data['name']);
		$isValid &= $this->validate_mail($data['mail']);

		if($isValid == 0) {echo 'alert("Валидация не пройдена");'; return;}

		try {
			$this->model->register($data);
		} catch (Exception $e) {
			echo 'alert("'.addslashes($e->getMessage()).'");';
			return;
		}

		//echo 'window.location.href = "/";'; // редирект, если всё прошло успешно

		// TODO Пока нет подтверждения регистрации авто-авторизация будет происходить вот таким вот образом
		$result = null;

		try {
			$result = $this->model->login($data);
		} catch (Exception $e) {
			echo 'alert("'.addslashes($e->getMessage()).'");';
			return;
		}

		if( !is_null($result) ) {
			$_SESSION['user'] = $result;
			echo 'window.location.href = "/";'; // редирект, если всё прошло успешно
		}
	}

}
