<?   /* ******************************************************************** */
    /*                                                  *  * **             */
   /*   By: Nikolaev Sergey                            ** * *              */
  /*   Updated: 2020.04.12                            * **   *            */
 /*                                                  *  *  **            */
/* ******************************************************************** */?>

<div>
	<p>Место: <?=$this->city_html;?></p>
	<p>Погода:&nbsp;<?=htmlspecialchars($this->result_array['weather']['0']['description'], ENT_QUOTES);?></p>
	<p>Температура:&nbsp;<?=htmlspecialchars($this->result_array['main']['temp'], ENT_QUOTES);?>&nbsp;&deg;C</p>
	<p>Скорость ветра:&nbsp;<?=htmlspecialchars($this->result_array['wind']['speed'], ENT_QUOTES);?>&nbsp;м/c</p>
</div>