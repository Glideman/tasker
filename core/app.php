<?php

class App {



	// переменные, необходимые для работы приложения
	public static $showPerPage = 3;
	public static $showPage = 1;
	public static $showOrder = 0;
	public static $showBackwards = 0;

	public static $maxPages = 0;
	public static $maxTasks = 0;

	public static $user = null;
	public static $db = null;

	public static $pageTitle = "";
	public static $current_controller = "";
	public static $current_action = "";
	public static $gets = null;



	// самая главная функция
	// запускает приложение
	public static function start() {


		// сессия и переменные, необходимые для работы
		// TODO session id & cookies
		session_start();

		App::copyParams();

		if(isset($_GET['order'])) App::$showOrder = $_GET['order'];
		if(isset($_GET['tpp'])) App::$showPerPage = $_GET['tpp'];
		if(isset($_GET['bw'])) App::$showBackwards = $_GET['bw'];
		if(isset($_GET['page'])) App::$showPage = $_GET['page'];
		if(App::$showPage <= 0) App::$showPage = 1;


		if(isset($_SESSION['user'])) App::$user = $_SESSION['user'];
		else $_SESSION['user'] = App::$user;


		// контроллер и действие по умолчанию
		$controller_name = 'main';
		$action_name = 'default';


		// разбиваем ЮРИ
		$url = explode('?', $_SERVER['REQUEST_URI']);
		$routes = explode('/', $url[0]);


		// получаем имя контроллера
		if ( !empty($routes[1]) )
			$controller_name = strtolower($routes[1]);


		// получаем имя экшена
		if ( !empty($routes[2]) )
			$action_name = strtolower($routes[2]);


		// обязательный логин на сайт
		// юзеру выдаётся страница авторизации, если он не залогинен и контроллер != user
		// что-бы можно было залогинится или зарегистрироваться
		//if( is_null(App::$user) && $controller_name != 'user') {
		//	$controller_name = 'auth';
		//	$action_name = 'default';
		//}


		// добавляем префиксы
		$model_name = 'model_'.$controller_name;
		$controller_name = 'controller_'.$controller_name;
		$action_name = 'action_'.$action_name;


		// подключаем файл с классом контроллера
		$controller_path = 'controllers/'.$controller_name.'.php';
		if(!file_exists($controller_path)) {
			$controller_name = 'controller_404';
			$controller_path = 'controllers/'.$controller_name.'.php';}
		require_once $controller_path;


		// создаем контроллер
		$controller = new $controller_name;


		// получаем экшн
		if(!method_exists($controller, $action_name)) {
			$action_name = 'wrong_action';}


		App::$current_controller = $controller_name;
		App::$current_action = $action_name;


		// вызываем
		$controller->$action_name();
	}



	// функция копирует гет параметры для дальнейшего
	// модифицирования и использования в приложении
	public static function copyParams() {
		App::$gets = array();
		foreach ($_GET as $key => $value){
			App::$gets[$key] = $value;}
	}



	// возвращает построенную строку гет параметров
	public static function getParams() {
		$result = '';
		foreach (App::$gets as $key => $value){
			$result .= $key . "=" . $value . "&";}
		return substr($result, 0, -1);
	}


}