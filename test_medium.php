<?   /* ******************************************************************** */
    /*                                                  *  * **             */
   /*   By: Nikolaev Sergey                            ** * *              */
  /*   Updated: 2020.04.12                            * **   *            */
 /*                                                  *  *  **            */
/* ******************************************************************** */?>

<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Базовая часть задания</title>
	</head>
	<body>
<?php
	//Включаем варнинги для теста
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	//Подключаем файл с классом NS_Weather
	require __DIR__ . '/weather.class.php';

	if (ini_get('magic_quotes_gpc'))
		$_POST['city'] = stripslashes($_POST['city']);
	if (!isset($_POST['city']) && isset($_SESSION['city']))
		$_POST['city'] = $_SESSION['city'];
	if (!isset($_POST['city']))
		$_POST['city'] = 'MoscowRU';
	/*
	** Создаем объект класса NS_Weather.
	** Параметр - это город для которого надо узнать погоду.
	**   Он должен присутствовать как ключ в массиве $SETTINGS['cities']
	**   из файла "./config/cities.php".
	**   Если его нет, то будет взят город из $SETTINGS['cities']['default']
	*/
	$OBJ = new NS_Weather($_POST['city']);
?>

<h1>Уровень сложности: Средний</h1>
<form action='' method='POST'>
	<select name='city'>
<?php
	require __DIR__ . '/config/cities.php';

	foreach($SETTINGS['cities'] as $key => $value)
	{
		if ($key != 'dir' && $key != 'default')
		{
			if ($key == $_POST['city'])
				$_SESSION['city'] = $_POST['city'];
			echo '<option value="'.htmlspecialchars($key, ENT_QUOTES).'"';
			if($key == $_SESSION['city'])
				echo ' selected';
			echo '>'.$value['html'].'</option>'.PHP_EOL;
		}
	}
?>
	</select>
	<input type='submit' value='Узнать погоду' />
</form>

<?php
	/*
	** Метод show() - вывод результата
	** Первый параметр - это абсолютный путь к файлу который отобразится
	**   при вызове метода show() или get_show() если не было ошибок.
	** Второй параметр - это абсолютный путь к файлу который отобразится
	**   при вызове метода show() или get_show() если были ошибки.
	*/		
	$OBJ->show(__DIR__ . '/templates/show.php',
		__DIR__ . '/templates/error.php');

	//Освобождаем объект класса NS_Weather
	unset($OBJ);
?>
	</body>
</html>