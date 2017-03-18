<?php 
	ini_set('display_errors', 1);
	date_default_timezone_set('Asia/Novosibirsk'); 
	require 'application/modules/phpthumb/ThumbLib.inc.php';
	require_once 'application/includes/config.php';
	$db1 = mysql_connect($db_host,$db_user,$db_pass, true);
	mysql_select_db($db_name, $db1);
	mysql_query("SET CHARACTER SET utf8", $db1);
	mysql_query("SET NAMES utf8", $db1);
	mysql_query("SET time_zone = '+07:00'", $db1);
	$sessionDir = '/var/www/fortuna/sessions/';

	/**
	 * проверка активности раз в 3 часа
	 */
	$querySession = "SELECT 
						c.id, c.fortuna_mid, c.company_name, s.date_update, s.name, s.id
					FROM
							 re_company as c
						JOIN re_access_date_end as a ON a.company_id = c.id
						JOIN re_people as p ON p.company_id = c.id
						JOIN re_session as s ON p.id = s.people_id
				  	WHERE
				  	 	c.company_name!='' 
				  		 AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -3 HOUR), '%Y%m%d%H%i%s') > DATE_FORMAT(s.date_update, '%Y%m%d%H%i%s') 
				  		 
						 
		  		 ";

	$res = mysql_query($querySession);

	if (mysql_num_rows($res) > 0){		
	  while ($session = mysql_fetch_array($res)){ 
    	mysql_query("DELETE FROM `re_session` WHERE `id` = {$session['id']}");
	  	@unlink($sessionDir."sess_".$session['name']);
	  }
	}

	/**
	 * Ночное обнуление
	 */
    if(isset($argv[1]) && $argv[1] == 'night_null'){
		$res = mysql_query("DELETE FROM `re_session` ", $db1);
		$dh = opendir($sessionDir);
		while ($file = readdir($dh)){
			if($file != "." && $file!="..")
				unlink($sessionDir.$file);
	    }
		$res = mysql_query("UPDATE `re_people` SET `photo_limit_used` =  0 ", $db1);
	}

?>