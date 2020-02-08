<?php

// контроллер, создающий страницу создания задачи
class Controller_newtask extends Controller {

	function __construct() {
		parent::__construct();
	}

	function action_default() {
		App::$pageTitle = "Добавление задачи";
		$this->view->generate('view_newtask.php', 'template.php');
	}
}