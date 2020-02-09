<?php

// контроллер, создающий главную страницу
class Controller_main extends Controller {

	function __construct() {
		parent::__construct();
		$this->model = Core_model::new_model('task');
	}



	function action_default() {
		// общее количество задач в бд
		$result = null;
		try {
			App::$maxTasks = $this->model->getNumberOfTasks();
			App::$maxPages = ceil( App::$maxTasks / App::$showPerPage );
		} catch (Exception $e) {
			echo '<script>alert("'.addslashes($e->getMessage()).'");</script>';
			return;
		}


		// если юзер захочет посмотреть дальше последней страницы, то у него ничего не выйдет
		if(App::$showPage > App::$maxPages) {
			App::$showPage = App::$maxPages;}

		if(App::$showPerPage > App::$maxTasks) {
			App::$showPerPage = App::$maxTasks;}


		// тут формируется список параметров для модели
		$data = array(
			'page' => App::$showPage,
			'tpp' => App::$showPerPage,
			'order' => App::$showOrder,
			'bw' => App::$showBackwards
		);


		// получаем таски
		$result = null;
		try {
			$result = $this->model->getTaskList($data);
		} catch (Exception $e) {
			echo '<script>alert("'.addslashes($e->getMessage()).'");</script>';
			return;
		}


		// генерим страничку
		if(!is_null($result)) {
			App::$pageTitle = "Задачник";
			$this->view->generate('view_main.php', 'template.php', $result);
		} else $this->wrong_action();
	}


}