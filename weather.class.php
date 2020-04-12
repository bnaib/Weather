<?   /* ******************************************************************** */
    /*                                                  *  * **             */
   /*   By: Nikolaev Sergey                            ** * *              */
  /*   Updated: 2020.04.12                            * **   *            */
 /*                                                  *  *  **            */
/* ******************************************************************** */?>

<?php
	class NS_Weather
	{
		private $error = FALSE;
		private $error_messages = array();
		private	$get_query;
		private	$result_json;
		private	$result_array;
		private $city_html;

		private function	check_dir($dir)
		{
			if ($this->error)
				return ($this->error);
			if (!is_dir($dir))
			{
				$html_dir = htmlspecialchars($dir, ENT_QUOTES);
				if (file_exists($dir))
				{
					$this->error_messages[] =
						'Невозможно создать директорию "' . $html_dir .
						'", так как существует файл с этим именем.<br />';
					$this->error = TRUE;
				}
				else
				{
					if (!mkdir($dir, 0777, true))
					{
						$this->error_messages[] =
							'Не удалось создать директорию "' .
							$html_dir . '".<br />';
						$this->error = TRUE;
					}
				}
			}
			return ($this->error);
		}

		private function	set_result($json)
		{
			if ($this->error)
				return ($this->error);
			$result_array = json_decode($json, TRUE);
			if (!is_array($result_array) || isset($result_array['message']))
			{
				$this->error_messages[] =
					'"json_decode" вернул невалидные данные.<br />';
				return ($this->error = TRUE);
			}
			if (!isset($result_array['update_time']))
			{
				$result_array['update_time'] = time();
				$json = json_encode($result_array);
				if ($json === FALSE)
				{
					$this->error_messages[] =
						'"json_encode" вернул ошибку.<br />';
					return ($this->error = TRUE);						
				}
			}
			$this->result_array = $result_array;
			$this->result_json = $json;
			return ($this->error);
		}

		private function	load_data_api()
		{
			if ($this->error)
				return ($this->error);
			if (($curl = curl_init()) === FALSE)
			{
				$this->error_messages[] = '"curl_init" выдал ошибку.<br />';
				$this->error = TRUE;
			}
			else
			{
				curl_setopt($curl, CURLOPT_URL, $this->get_query);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				$curl_result = curl_exec($curl);
				curl_close($curl);
				if ($curl_result === FALSE)
				{
					$this->error_messages[] = '"curl_exec" выдал ошибку.<br />';
					return ($this->error = TRUE);
				}
				$this->set_result($curl_result);
			}
			return ($this->error);
		}

		private function	check_city_data_update_time($file_data)
		{
			require __DIR__ . '/config/api.php';

			if ($file_data === FALSE)
				return (TRUE);
			$result_array = json_decode($file_data, TRUE);
			if (!is_array($result_array) ||
				isset($result_array['message']) ||
				!isset($result_array['update_time']) ||
				!ctype_digit($result_array['update_time']) ||
				(time() - $result_array['update_time'] >
				$SETTINGS['api']['update_delay']))
				return (TRUE);
			return (FALSE);
		}

		private function	load_city_data($q)
		{
			require __DIR__ . '/config/cities.php';

			if ($this->check_dir($SETTINGS['cities']['dir']))
				return ;
			$file = $SETTINGS['cities']['dir'] . '/' .
				$SETTINGS['cities'][$q]['file'];
			if ($file_data = file_exists($file))
				$file_data = file_get_contents($file);
			if ($this->check_city_data_update_time($file_data))
			{
				if ($this->load_data_api())
					return ($this->error);
				if (file_put_contents($file, $this->result_json) === FALSE)
				{
					$this->error_messages[] =
						'"file_put_contents" выдал ошибку.<br />';
					return ($this->error = TRUE);
				}
			}
			else
				$this->set_result($file_data);
			return ($this->error);
		}

		public function		__construct($q)
		{
			require __DIR__ . '/config/api.php';
			require __DIR__ . '/config/cities.php';

			if (!isset($SETTINGS['cities'][$q]))
				$q = $SETTINGS['cities']['default'];
			$this->city_html = $SETTINGS['cities'][$q]['html'];
			$get_array = array(
				'q' => $q,
				'appid' => $SETTINGS['api']['appid'],
				'units' => 'metric',
				'lang' => 'ru'
			);
			$this->get_query = $SETTINGS['api']['ulr'] . '?' .
				http_build_query($get_array);
			$this->load_city_data($q);
		}

		public function		get_json()
		{
			return (($this->error) ? NULL : $this->result_json);
		}

		public function		show_json($arr = NULL, $str = '')
		{
			if ($this->error)
			{
				echo 'В процессе выполнения скрипта была ошибка<br />';
				return ;
			}
			if (!is_array($arr))
				$arr = $this->result_array;
			foreach($arr as $key => $value)
			{
				if (is_array($value))
					$this->show_json($value,  $str.'['.$key.']');
				else
					echo $str.'['.$key.'] = '.$value.'<br />';
			}
		}

		public function		show_errors()
		{
			if ($this->error)
			{
				foreach($this->error_messages as $value)
					echo $value;
			}
			else
				echo 'Ошибок нет.<br />';
		}

		public function		show($temp, $temp_err)
		{
			if ($this->error)
				include($temp_err);
			else
				include($temp);
		}

		public function		get_show($temp, $temp_err)
		{
			ob_start();
			$this->show($temp, $temp_err);
			$result = ob_get_contents();
			ob_end_clean();
			return ($result);
		}
	}
?>