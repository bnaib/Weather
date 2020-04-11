<?php/* ******************************************************************** */
    /*                                                  *  * **             */
   /*   By: Nikolaev Sergey                            ** * *              */
  /*   Updated: 2020.04.11                            * **   *            */
 /*                                                  *  *  **            */
/* ******************************************************************** */?>

<?php
	require "cfg.appid.php";
	function show_all_info($arr, $str = '')
	{
		foreach($arr as $key => $value)
		{
			echo $str.'['.$key.'] = '.$value.'<br>';
			if (is_array($value))
				show_all_info($value,  $str.'['.$key.']');
		}
	}

	if ($curl = curl_init())
	{
		$url = 'http://api.openweathermap.org/data/2.5/weather';
		$get_array = array(
			'q' => 'Moscow,RU',
			'appid' => $SETTINGS['appid'],
		);
		$get_query = http_build_query($get_array);
		curl_setopt($curl, CURLOPT_URL, $url.'?'.$get_query);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$curl_result = curl_exec($curl);
		curl_close($curl);
		$result_array = json_decode($curl_result, TRUE);
		show_all_info($result_array);
	}
?>