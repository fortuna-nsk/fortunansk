<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Novosibirsk'); 

require 'application/modules/phpthumb/ThumbLib.inc.php';
require_once 'application/includes/config.php';

$db1 = mysql_connect($db_host,$db_user,$db_pass, true);

mysql_select_db($db_name, $db1);
mysql_query("SET CHARACTER SET utf8", $db1);
mysql_query("SET NAMES utf8", $db1);
mysql_query("SET time_zone = '+07:00'", $db1);

$query = "SELECT `id`, `suspicion`, `user_id`, `text` FROM `re_var` WHERE  `suspicion`  = 0 ORDER BY `date_last_edit` DESC  LIMIT 0,10";

  $result = mysql_query($query);

    if (mysql_num_rows($result) > 0)
    { 
      while ($row = mysql_fetch_array($result))
      {
        $suspWord = false;
        $words = ['тысяч', 'тыс', 'коммуналка', 'комуналка', 'коммунальные', 'комунальные', 'плюс', 'задаток', 'плюс', 'залог', 'звонить'];
        foreach ($words as $key => $value) 
          if(strpos($row['text'],$value)){
            $suspWord = true; break;
          }

        preg_match_all("/[0-9]{1}/", $row['text'], $out);
        $duo1 = preg_match("/\d{2}/", $row['text']);
        $duo2 = preg_match("/\d{1}.\d{1}/", $row['text']);

        if($duo1 || $duo2 || sizeof($out[0]) > 3 || $suspWord){
          $qUpdate = "UPDATE `re_var` SET `suspicion`=1 WHERE (`id`={$row['id']})";
            if(mysql_query($qUpdate)){
             echo "{$row['id']} - {$row['text']}<br/><br/>";
           }else{
              echo $qUpdate."<br/><br/>";
           }
        }
        
      }
    }
?>

 