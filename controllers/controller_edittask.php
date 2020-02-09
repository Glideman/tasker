<?php

// контроллер, создающий страницу редактирования задачи
class Controller_edittask extends Controller {

	function __construct() {
		parent::__construct();
		$this->model = Core_model::new_model('task');
	}



	function action_default() {
		$params = array(
			'taskid' => $_GET['taskid']
		);


		// получение инфы о задаче
		$result = null;
		try {
			$result = $this->model->getTask($params);
		} catch (Exception $e) {
			echo '<script>alert("'.addslashes($e->getMessage()).'");</script>';
			return;
		}


		// проверка на доступ к редактированию задачи
		$can_edit = false;
		if( !is_null(App::$user) ) {
			if(App::$user->permissions > 1 || App::$user->uid == $result->user) $can_edit = true;
		}


		if(!is_null($result) && $can_edit) {
			App::$pageTitle = "Редактирование задачи";
			$this->view->generate('view_edittask.php', 'template.php', $result);
		} else $this->wrong_action();
	}


}