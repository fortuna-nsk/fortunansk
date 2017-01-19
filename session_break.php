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

	$datePhotoLimitBreak = date("His", strtotime("+0 hours"));
	$sessionDir = '/var/www/fortuna/sessions/';

	/**
	 * проверка активности раз в 3 часа
	 */
	$querySession = "SELECT c.id, c.fortuna_mid, c.company_name, a.rent_date_end, a.sell_date_end, a.pay_parse_date_end, s.date_update, s.name,s.id
					FROM re_company as c, re_access_date_end as a, re_session as s, re_people as p
				  	WHERE 
				  		 c.id = a.company_id 
				  		 AND p.company_id = c.id 
				  		 AND s.people_id = p.id 
				  		 AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -3 HOUR), '%Y%m%d%H%i%s') > DATE_FORMAT(s.date_update, '%Y%m%d%H%i%s') 
				  		 AND company_name!=''";

	$res = mysql_query($querySession);
	if (mysql_num_rows($res) > 0){		
	  while ($session = mysql_fetch_array($res)){ 
	  	
	  	echo (" " . $sessionDir."sess_".$session['name'] . " " . $session['date_update'] . " {$session['id']} \n\r");

		mysql_query("DELETE FROM `re_session` WHERE `id` = {$session['id']}");
	  	
	  	@unlink($sessionDir."sess_".$session['name']);
	  }

	}

	/**
	 * Ночное обнуление
	 */
	if($datePhotoLimitBreak > 020000 AND $datePhotoLimitBreak < 050000 ){
		$res = mysql_query("DELETE FROM `re_session` WHERE 1", $db1);
		$dh = opendir($sessionDir);
		while ($file = readdir($dh)){
			if($file != "." && $file!="..")
				unlink($sessionDir.$file);
	    }
		$res = mysql_query("UPDATE `re_people` SET `photo_limit_used` =  0 WHERE 1", $db1);
	}
?>