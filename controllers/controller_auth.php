<?php

// контроллер, создающий страницу регистрации/авторизации
class Controller_auth extends Controller {

	function __construct() {
		parent::__construct();
	}

	function action_default() {
		App::$pageTitle = "Вход";
		$this->view->generate('view_auth.php', 'template.php');
	}
}