<?php
class vazco_text_captcha{
	
	public static function getCaptchaChallengeArray()
	{
		$arr = array();
		$tasks_txt = elgg_get_plugin_setting('tasks','vazco_text_captcha');
		$tasks_txt = str_replace("\r\n", "\n", $tasks_txt);
		$tasks = explode("\n", $tasks_txt);
		foreach($tasks as $i => $row)
		{
			$pos = strrpos($row,"|");
			if($pos === false)
			{
				unset($tasks[$i]);
				continue;
			}
			$tasks[$i] = array(substr($row,0,$pos),substr($row,$pos+1));
		}
		if(!is_array($tasks))
			$tasks = array();
		
		$arr = array_merge($arr, $tasks);
		return $arr;
	}
	
	public static function getCaptchaChallenge()
	{
		$arr = vazco_text_captcha::getCaptchaChallengeArray();
		$id = array_rand($arr);
		return array_merge(array($id), $arr[$id]);
	}
	
	public static function getCaptchaChallengeById($id)
	{
		$arr = vazco_text_captcha::getCaptchaChallengeArray();
		return array_merge(array($id), $arr[$id]);
	}
	
}

