<?   /* ******************************************************************** */
    /*                                                  *  * **             */
   /*   By: Nikolaev Sergey                            ** * *              */
  /*   Updated: 2020.04.12                            * **   *            */
 /*                                                  *  *  **            */
/* ******************************************************************** */?>

<?php
	$SETTINGS['cities'] = array();

	$SETTINGS['cities']['dir'] = __DIR__ . '/../weather_cities';
	$SETTINGS['cities']['default'] = 'Moscow,RU';

	$SETTINGS['cities']['Moscow,RU']['html'] = 'Россия,&nbsp;Москва';
	$SETTINGS['cities']['Moscow,RU']['file'] = 'RuMoscow.json';

	$SETTINGS['cities']['London,UK']['html'] = 'Великобритания,&nbsp;Лондон';
	$SETTINGS['cities']['London,UK']['file'] = 'UkLondon.json';

	$SETTINGS['cities']['Paris,FR']['html'] = 'Франция,&nbsp;Париж';
	$SETTINGS['cities']['Paris,FR']['file'] = 'FrParis.json';

	$SETTINGS['cities']['Berlin,DE']['html'] = 'Германия,&nbsp;Берлин';
	$SETTINGS['cities']['Berlin,DE']['file'] = 'DeBerlin.json';

	$SETTINGS['cities']['Washington,US']['html'] = 'США,&nbsp;Вашингтон';
	$SETTINGS['cities']['Washington,US']['file'] = 'UsWashington.json';
?>