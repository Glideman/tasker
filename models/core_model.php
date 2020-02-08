<?php

class Core_model {


	// коннект к базе данных
	public static function db_connect() {
		$db = mysqli_connect('localhost', 'id12521812_0xfc0de_tasker_user', '0xfc0de-tasker', 'id12521812_0xfc0de_tasker_db');
		if(!$db) return null;

		$db->query("SET character_set_results = 'utf8'");
		return $db;
	}



	// подключение модели для работы с таблицами
	public static function new_model($name) {
		// подключаем файл с классом модели, если такой есть
		$model_class = 'model_'.$name;
		$model_path = 'models/'.$model_class.'.php';
		if(file_exists($model_path)) require_once $model_path;
		else return null;

		return new $model_class;
	}


}
