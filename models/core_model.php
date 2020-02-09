<?php

// в этом классе определены методы для коннекта к БД
// и подключения отдельных моделей для работы с таблицами
class Core_model {


	// коннект к базе данных
	public static function db_connect() {
		$db = mysqli_connect('localhost', 'id12521812_tasker_user', 'tasker_pass', 'id12521812_tasker_db');
		if(!$db) return null;

		$db->query("SET character_set_results = 'utf8'");
		return $db;
	}



	// подключение модели для работы с таблицами
	public static function new_model($name) {
		$model_class = 'model_'.$name;
		$model_path = 'models/'.$model_class.'.php';
		if(file_exists($model_path)) require_once $model_path;
		else return null;

		return new $model_class;
	}


}
