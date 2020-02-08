<?php

class Controller {

  public $model;
  public $view;

    function __construct() {
        $this->view = new View();
        $this->model = null;
    }

    function wrong_action() {
		App::$pageTitle = "404";
        http_response_code(404);
        $this->view->generate('view_404.php', null);
    }
}