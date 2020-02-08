<?php

// все действия с задачами через эту модель
class Model_task extends Model {



	// добавление задачи
	function addTask($data) {
		$user = $data['user'];
		$mail = $data['mail'];
		$text = $data['text'];
		$img = $data['file'];

		// коннект к бд
		if(is_null(App::$db)) App::$db = Core_model::db_connect();

		if(App::$db) {
			// вставка
			$query_str = "	insert into `tasks` (`user`, `mail`, `text`, `imgpath`)
 							values (".$user.", '".$mail."', '".$text."', '".$img."')";
			$query_result = App::$db->query($query_str);
			if($query_result === false) throw new Exception('Что-то пошло не так :( не могу выполнить запрос '.$query_str);
		} else throw new Exception('Что-то пошло не так :( не могу подключиться к бд');
	}



	// смена статуса у задачи
	function setStatus($data) {
		$id_task = $data['taskid'];
		$status = $data['status'];

		// коннект к бд
		if(is_null(App::$db)) App::$db = Core_model::db_connect();

		if(App::$db) {
			$query_str = "update `tasks` set `status` = '".$status."' where `taskid` = ".$id_task;
			$query_result = App::$db->query($query_str);
			if($query_result === false) throw new Exception('Что-то пошло не так :( не могу выполнить запрос '.$query_str);
		} else throw new Exception('Что-то пошло не так :( не могу подключиться к бд');

	}



	// изменение данных задачи
	function updateTask($data) {
		$taskid = $data['taskid'];
		$mail = $data['mail'];
		$text = $data['text'];
		$status = $data['status'];
		$img = $data['file'];


		// коннект к бд
		if(is_null(App::$db)) App::$db = Core_model::db_connect();

		if(App::$db) {
			$query_str = "	update `tasks` set
 							`text` = '".$text."',
 							`mail` = '".$mail."',
							`status` = '".$status."'";
			if( $img != '') $query_str.= ", `imgpath` = '".$img."' ";
			$query_str.= "where `taskid` = ".$taskid;

			$query_result = App::$db->query($query_str);
			if($query_result === false) throw new Exception('Что-то пошло не так :( не могу выполнить запрос '.$query_str);
		} else throw new Exception('Что-то пошло не так :( не могу подключиться к бд');

	}



	// удаление картики отдельно от редактирования
	// можно потом будет добавить удаление других ячеек
	// но по задаче мне нужно только удаление картинки
	function deleteImg($data) {
		$taskid = $data['taskid'];

		// коннект к бд
		if(is_null(App::$db)) App::$db = Core_model::db_connect();

		if(App::$db) {
			$query_str = "	update `tasks` set
 							`imgpath` = ''
 							where `taskid` = ".$taskid;
			$query_result = App::$db->query($query_str);
			if($query_result === false) throw new Exception('Что-то пошло не так :( не могу выполнить запрос '.$query_str);
		} else throw new Exception('Что-то пошло не так :( не могу подключиться к бд');

	}



	// удаление задачи
	function deleteTask($data) {
		$taskid = $data['taskid'];

		// коннект к бд
		if(is_null(App::$db)) App::$db = Core_model::db_connect();

		if(App::$db) {
			$query_str = "delete from `tasks` where `taskid` = ".$taskid;
			$query_result = App::$db->query($query_str);
			if($query_result === false) throw new Exception('Что-то пошло не так :( не могу выполнить запрос '.$query_str);
		} else throw new Exception('Что-то пошло не так :( не могу подключиться к бд');

	}



	// получение задачи
	function getTask($data) {
		$taskid = $data['taskid'];
		$task = null;


		// коннект к бд
		if(is_null(App::$db)) App::$db = Core_model::db_connect();

		if(App::$db) {
			// столбец 'name' сложнее других.
			// если у задачи нет юзера, то возвращается 'Гость'
			// если есть юзер и у юзера есть имя, то возвращает это имя
			// иначе возвращает логин
			// тут-же меняем статус int на str из соседней таблицы по связи
			$query_str = "	select `taskid`, `user`, `status`, `statuses`.`description` as `status_desc`, `tasks`.`mail`, `text`, `imgpath`, case
							when (`users`.`name` != '') then `users`.`name`
							when (`tasks`.`user`) then `users`.`login`
							else 'Гость'
							end as `name`
							from `tasks` 
							left join `users` on `tasks`.`user` = `users`.`uid`
							left join `statuses` on `tasks`.`status` = `statuses`.`statid`
							where `taskid` = ".$taskid;
			$query_result = App::$db->query($query_str);
			if($query_result === false) throw new Exception('Что-то пошло не так :( не могу выполнить запрос '.$query_str);
			else {
				$row = mysqli_fetch_object($query_result);
				$task = $row;

				$query_result->close();}
		} else throw new Exception('Что-то пошло не так :( не могу подключиться к бд');

		return $task;
	}



	// получение кол-ва задач
	public function getNumberOfTasks() {
		$result = null;

		$query_str = "	select count(*)
						from `tasks`";

		// коннект к бд
		if(is_null(App::$db)) App::$db = Core_model::db_connect();

		if(App::$db) {
			$query_result = App::$db->query($query_str);
			if($query_result === false) throw new Exception('Что-то пошло не так :( не могу выполнить запрос '.$query_str);
			else {
				$row = mysqli_fetch_row($query_result);
				$result = $row[0];
				$query_result->close();}
		} else throw new Exception('Что-то пошло не так :( не могу подключиться к бд');

		return $result;
	}



	// получение списка задач
	public function getTaskList($data) {
		$list = null;

		// выражение 1-1 даёт -0 как результат, и это ломает запрос.
		// поэтому abs
		$query_offset = abs($data['page']-1) * $data['tpp'];


		// столбец 'name' сложнее других.
		// если у задачи нет юзера, то возвращается 'Гость'
		// если есть юзер и у юзера есть имя, то возвращает это имя
		// иначе возвращает логин
		// тут-же меняем статус int на str из соседней таблицы по связи
		$query_str = "	select `taskid`, `user`, `statuses`.`description` as `status`, `tasks`.`mail`, `text`, `imgpath`, case
						when (`users`.`name` != '') then `users`.`name`
						when (`tasks`.`user`) then `users`.`login`
						else 'Гость'
						end as `name`
						from `tasks` 
						left join `users` on `tasks`.`user` = `users`.`uid`
						left join `statuses` on `tasks`.`status` = `statuses`.`statid`
						order by ";

		if($data['order'] == 1) $query_str .= "`name`";
		else if($data['order'] == 2) $query_str .= "`mail`";
		else if($data['order'] == 3) $query_str .= "`status`";
		else $query_str .= "`taskid`";

		if($data['bw'] == 0) $query_str .= " asc";
		else $query_str .= " desc";

		$query_str .= " limit ".$data['tpp']." offset ".$query_offset;

		// коннект к бд
		if(is_null(App::$db)) App::$db = Core_model::db_connect();

		if(App::$db) {
			$list = array();

			// список задач
			$query_result = App::$db->query($query_str);
			if($query_result === false) throw new Exception('Что-то пошло не так :( не могу выполнить запрос '.$query_str);
			else {
				for($i=0; $i < $query_result->num_rows; $i++) {
					$row = mysqli_fetch_object($query_result);
					array_push($list, $row);}

				$query_result->close();}
		} else throw new Exception('Что-то пошло не так :( не могу подключиться к бд');

		return $list;
	}


}
