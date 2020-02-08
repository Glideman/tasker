<?php

// все действия с пользователями через эту модель
class Model_user extends Model {



	// вход на сайт
	public function login($data) {
		$result = null;

		$login = $data['login'];
		$pass = $data['pass'];


		// коннект к бд
		if(is_null(App::$db)) App::$db = Core_model::db_connect();


		// авторизация
		if(App::$db) {
			// тут возвращается имя юзера, если оно не пустое
			// если пустое возвращается логин
			$query_str = "	select `uid`, `mail`, `permissions`, case 
							when `name` != '' then `name` 
							else `login`
							end as `name`
							from `users`
							where `login` = '".$login."' and `pass` = '".$pass."'";
			$query_result = App::$db->query($query_str);
			if($query_result === false) throw new Exception('Что-то пошло не так :( не могу выполнить запрос '.$query_str);
			else if($query_result->num_rows == 0) {
				$query_result->close();
				throw new Exception('Неправильная пара логин/пароль');}
			else {
				$row = mysqli_fetch_object($query_result);
				$result = $row;
				$query_result->close();
			}
		} else throw new Exception('Что-то пошло не так :( не могу подключиться к бд');

		return $result;
	}



	// регистрация на сайте
	public function register($data) {
		$login = $data['login'];
		$pass = $data['pass'];
		$name = $data['name'];
		$mail = $data['mail'];


		// коннект к бд
		if(is_null(App::$db)) App::$db = Core_model::db_connect();


		// регистрация
		if(App::$db) {
			// поиск такого-же логина
			$query_str = "	select `uid`
	 						from `users`
							where `login` = '".$login."'";
			$query_result = App::$db->query($query_str);
			if($query_result === false) throw new Exception('Что-то пошло не так :(');
			else if($query_result->num_rows > 0) {
				$query_result->close();
				throw new Exception('Такой пользователь уже зарегистрирован');}
			else {
				$query_str = "	insert into `users` (`login`, `pass`, `name`, `mail`)
								values ('".$login."','".$pass."','".$name."','".$mail."')";
				$query_result = App::$db->query($query_str);
				if($query_result === false) throw new Exception('Что-то пошло не так :( не могу выполнить запрос '.$query_str);
			}
		} else throw new Exception('Что-то пошло не так :( не могу подключиться к бд');
	}


}
