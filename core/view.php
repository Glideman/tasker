<?php

// родительский класс view
// классы для вида отдельных страниц наследуются от него
class View {
	// здесь можно указать общий вид по умолчанию.
	// впрочем, лучше наверное темплейт передавать в generate()
	//public $template_view;


	// собираем страницу по частям
	// подключение отдельных элементов
	// находится в темплейте и во вьюшках
	function generate($content_view, $template_view, $data = null) {
		if($template_view) include 'views/'.$template_view;
		else include 'views/'.$content_view;
	}
}