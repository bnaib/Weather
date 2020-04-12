<?   /* ******************************************************************** */
    /*                                                  *  * **             */
   /*   By: Nikolaev Sergey                            ** * *              */
  /*   Updated: 2020.04.12                            * **   *            */
 /*                                                  *  *  **            */
/* ******************************************************************** */?>

<html>
	<head>
	</head>
	<body>
<?php
	//Включаем варнинги для теста
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	//Подключаем файл с классом NS_Weather
	require __DIR__ . '/weather.class.php';

	/*
	** Создаем объект класса NS_Weather.
	** Параметр - это город для которого надо узнать погоду.
	**   Он должен присутствовать как ключ в массиве $SETTINGS['cities']
	**   из файла "./config/cities.php".
	**   Если его нет, то будет взят город из $SETTINGS['cities']['default']
	*/ 
	$OBJ = new NS_Weather('Moscow,RU');

	/*
	** Метод get_json возвращает json строку с данными о погоде
	** или NULL если были ошибки.
	** Метод можно применять например для передачи этих данных
	** для JavaScript на стороне пользователя.
	*/
	echo '<h1>JSON</h1>';
	echo $OBJ->get_json();

	//Метод show_json() выводит в читабельном виде json
	echo '<br /><hr style="width: 100%;"/><br /><h1>JSON >> array</h1>';
	$OBJ->show_json();

	
	//Метод show_errors() - вывод для теста текст ошибок
	echo '<br /><hr style="width: 100%;"/><br /><h1>Errors</h1>';
	$OBJ->show_errors();

	/*
	** Метод show() - вывод результата
	** Первый параметр - это абсолютный путь к файлу который отобразится
	**   при вызове метода show() или get_show() если не было ошибок.
	** Второй параметр - это абсолютный путь к файлу который отобразится
	**   при вызове метода show() или get_show() если были ошибки.
	*/
	echo '<br /><hr style="width: 100%;"/><br />' . 
		'<h1>Уровень сложности: Базовый</h1>';
	$OBJ->show(__DIR__ . '/templates/show.php',
		__DIR__ . '/templates/error.php');
	//Альтернатива с методом get_show()
	// echo $OBJ->get_show(__DIR__ . '/templates/show.php',
	// 	__DIR__ . '/templates/error.php');

	//Освобождаем объект класса NS_Weather
	unset($OBJ);
?>
	</body>
</html>