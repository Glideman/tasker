<?php

// контроллер для обработки POST запросов, связанных с задачами
class Controller_task extends Controller {


	function __construct() {
		parent::__construct();
		$this->model = Core_model::new_model('task');
	}



	// валидация e-mail
	private function validate_mail($variable) {
		return preg_match("/^([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z0-9]+)*(\.[a-z]{2,})){0,64}$/", $variable);
	}



	// аплоад и ресайз картинки в папку img/
	private function upload_img($variable) {
		$file = $variable;

		// преобразует 'image/png' в 'png' и так далее
		$file_type = substr($file['type'], 6);

		// тут кодирование имени. что-бы не повторялись имена и не перезатирали друг друга изображения
		// я беру текущее время в мс + название файла и хеширую
		$file_name = hash('sha256',$_SERVER["REQUEST_TIME_FLOAT"].$file['name']).'.'.$file_type;
		$file_dst = "img/".$file_name;

		// переносим картинку нам в папку
		move_uploaded_file($file['tmp_name'], $file_dst);

		// ресайз, если необходим
		list($iwidth, $iheight) = getimagesize($file_dst);
		$width = 320;
		$height = 240;

		if($iwidth > $width or $iheight > $height) {

			$imgsrc = null;
			$imgdst = null;

			$ratio = min($width/$iwidth, $height/$iheight);
			$width = $iwidth * $ratio;
			$height = $iheight * $ratio;

			$img_create_from = 'imagecreatefrom'.$file_type;
			$imgsrc = $img_create_from($file_dst);

			if($imgsrc) {
				$imgdst = imagecreatetruecolor($width, $height);

				if($imgdst) {
					imagecopyresampled($imgdst, $imgsrc, 0, 0, 0, 0, $width, $height, $iwidth, $iheight);
					$image_create = 'image'.$file_type;
					$image_create($imgdst, $file_dst);
				}
			}
		}

		return $file_name;
	}



	// проверка на то, может ли юзер редактировать заявку
	// если это простой юзер (не админ), то смотрим по айди юзера
	private function check_permissions($variable, $task = null) {
		if( !is_null(App::$user) ) {
			if(App::$user->permissions > 1) return true;
			else {
				// получение информации о задаче, если она не была передана как параметр
				if( $task == null) {
					try {
						$task = $this->model->getTask($variable);
					} catch (Exception $e) {
						echo 'alert("' . addslashes($e->getMessage()) . '");';
						return false;
					}
				}

				if( !is_null($task) )
					if( ($task->user == App::$user->uid) ) return true;
			}
		}

		return false;
	}



	// добавление задачи
	function action_add() {
		$data = array(
			'user' => is_null(App::$user) ? 'null' : App::$user->uid,
			'mail' => $_POST['mail'],
			'text' => htmlentities($_POST['text'], ENT_QUOTES),
			'file' => ''
		);


		// проверка на корректность
		$isValid = true;

		$isValid &= $this->validate_mail($data['mail']);

		if($isValid == 0) {echo 'alert("Валидация не пройдена");'; return;}


		// аплоад и ресайз картинки
		if(isset($_FILES['file'])) $data['file'] = $this->upload_img($_FILES['file']);


		try {
			$this->model->addTask($data);
		} catch (Exception $e) {
			echo 'alert("'.addslashes($e->getMessage()).'");';
			return;
		}

		echo 'window.location.href = "/";'; // переходим на главную
	}



	// изменение статуса
	// в текущей реализации не используется
	// делал для того, что-бы можно было менять статус с главной
	function action_status() {
		$data = array(
			'taskid' => $_POST['taskid'],
			'status' => $_POST['status']
		);


		if( !$this->check_permissions($data) ) {
			$this->wrong_action();
			return;}


		try {
			$this->model->setStatus($data);
		} catch (Exception $e) {
			echo 'alert("'.addslashes($e->getMessage()).'");';
			return;
		}

		echo 'window.location.href = "/";'; // переходим на главную
	}



	// удаление картинки
	function action_deleteimg() {
		$data = array(
			'taskid' => isset($_GET['taskid']) ? $_GET['taskid'] : $_POST['taskid']
		);


		// для удаления файла нужно знать название, поэтому получаем инфу о задаче
		$task = null;
		try {
			$task = $this->model->getTask($data);
		} catch (Exception $e) {
			echo 'alert("' . addslashes($e->getMessage()) . '");';
			return;
		}


		if( !$this->check_permissions($data, $task) ) {
			$this->wrong_action();
			return;}


		// чистим ячейку в бд
		try {
			$this->model->deleteImg($data);
		} catch (Exception $e) {
			echo 'alert("'.addslashes($e->getMessage()).'");';
			return;
		}

		// удаляем файл
		if(!is_null($task))
			if(file_exists($task->imgpath))
				unlink('img/'.$task->imgpath);

		echo '<script>window.location.href = "/edittask?taskid='.$task->taskid.'";</script>'; // переходим на страницу редактирования
	}



	// обновление данных задачи
	function action_update() {
		$data = array(
			'taskid' => $_POST['taskid'],
			'mail' => $_POST['mail'],
			'text' => htmlentities($_POST['text'], ENT_QUOTES),
			'status' => $_POST['status'],
			'file' => ''
		);


		if( !$this->check_permissions($data) ) {
			$this->wrong_action();
			return;}


		// проверка на корректность
		$isValid = true;

		$isValid &= $this->validate_mail($data['mail']);

		if($isValid == 0) {echo 'alert("Валидация не пройдена");'; return;}


		// аплоад и ресайз картинки
		if(isset($_FILES['file'])) $data['file'] = $this->upload_img($_FILES['file']);


		try {
			$this->model->updateTask($data);
		} catch (Exception $e) {
			echo 'alert("'.addslashes($e->getMessage()).'");';
			return;
		}

		echo 'window.location.href = "/";'; // переходим на главную
	}



	// удаление задачи
	function action_delete() {
		$data = array(
			'taskid' => isset($_GET['taskid']) ? $_GET['taskid'] : $_POST['taskid']
		);


		if( !$this->check_permissions($data) ) {
			$this->wrong_action();
			return;}


		try {
			$this->model->deleteTask($data);
		} catch (Exception $e) {
			echo 'alert("'.addslashes($e->getMessage()).'");';
			return;
		}

		echo '<script>window.location.href = "/";</script>'; // переходим на главную
	}


}
