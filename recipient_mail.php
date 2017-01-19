<?php

/*
podborka-arenda@mail.ru
khyuiop12

*/


ini_set('display_errors', 1);
date_default_timezone_set('Asia/Novosibirsk'); 
require 'application/modules/phpthumb/ThumbLib.inc.php';
require_once 'application/includes/config.php';
$db1 = mysql_connect($db_host,$db_user,$db_pass, true);
mysql_select_db($db_name, $db1);
mysql_query("SET CHARACTER SET utf8", $db1);
mysql_query("SET NAMES utf8", $db1);
mysql_query("SET time_zone = '+07:00'", $db1);

require 'application/modules/simple_html_dom.php';


function ToUtf8($str){
  return iconv("WINDOWS-1251", "UTF-8", $str );
    //return mb_convert_encoding($str, 'utf8', 'cp1251');
}




function getServerHost($email){
  //
  $servers = [
    'mail'    => 'smtp.mail.ru',
    'bk'      => 'smtp.mail.ru',
    'inbox'      => 'smtp.mail.ru',
    'yandex'  => 'smtp.yandex.ru',
    'ngs'     => 'smtp.ngs.ru',
    'gmail'   => 'smtp.gmail.com',
  ];

    $host = explode(".", explode("@", $email)[1])[0]; 
     return $servers[$host];
  }



function smtpmail($to, $subject, $content, $host, $username, $password, $attaches=false)
{
  $__smtp = array(
    
    "debug" => 2,                   //отображение информации дебаггера (0 - нет вообще)
    "auth" => true,                 //сервер требует авторизации
    "port" => 465,                    //порт (по-умолчанию - 25)

  /*
    "host" => "smtp.gmail.com", //smtp сервер
    //"username" => "arenda.podborka.nsk@yandex.ru",//имя пользователя на сервере
    "username" => "arendavaha@gmail.com",//имя пользователя на сервере 
    "password" => "khyuiop12",//пароль
    //"password" => "khyuiop12",//пароль
    "addreply" => "arendavaha@gmail.com",//ваш е-mail
    "replyto"  => "arendavaha@gmail.com",      //e-mail ответа
   */
    "secure"   => "ssl",
    );



    require_once('lib/phpmailer/class.smtp.php'); //путь до класса phpmailer
    require_once('lib/phpmailer/class.phpmailer.php'); //путь до класса phpmailer
    $mail = new PHPMailer(true);

    $mail->IsSMTP();
    try {
      $mail->SMTPDebug  = $__smtp['debug'];
      $mail->SMTPAuth   = $__smtp['auth'];
      $mail->Port       = $__smtp['port'];
      $mail->SMTPSecure = $__smtp['secure'];

      $mail->Host       = $host;
      $mail->Username   = $username;
      $mail->Password   = $password;


      $mail->AddReplyTo($username, $username);
      $mail->AddAddress($to);                //кому письмо
      $mail->SetFrom($username, $username); //от кого (желательно указывать свой реальный e-mail на используемом SMTP сервере
      $mail->AddReplyTo($username, $username);
      $mail->Subject = htmlspecialchars($subject);
      $mail->MsgHTML($content);
      $mail->CharSet = 'UTF-8';
      foreach ($attaches as $attach) {
        if($attach)  $mail->AddAttachment($attach); 
      }
      if($mail->Send()){
        echo "Message sent {$to} Ok!</p>\n";
        return true;
      }
    } catch (phpmailerException $e) {
      echo $e->errorMessage();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
}


function createCatalog($var_id){
  //echo "SELECT * FROM `re_var` WHERE `id` = {$var_id} ";
  $queryObj = mysql_query("SELECT * FROM `re_var` WHERE `id` = {$var_id} ");
  $obj = mysql_fetch_assoc($queryObj);


  if($obj['user_id'] ==NULL){
    return NULL;

  }

  $queryUser = mysql_query("SELECT * FROM `re_user` WHERE `user_id` = {$obj['user_id']} ");
  $user = mysql_fetch_assoc($queryUser);
  return $user['people_id']."/".$var_id;
}

function createSubject($var_id){
  $queryObj = mysql_query("SELECT * FROM `re_var` WHERE `id` = {$var_id} ");
  $obj = mysql_fetch_assoc($queryObj);
  return $obj['room_count']."-комнатная, " . $obj['planning']." на " . $obj['street'] . " за ". $obj['price'];
}


mysql_query("UPDATE `re_recipients_list` as mess JOIN re_people as people on mess.people_id = people.id SET mess.active  = 3  WHERE  ( people.email_work IS NULL) OR (people.email_pass IS NULL)");


$queryMailList = "SELECT * FROM `re_recipients_list` WHERE `active` = 1   ORDER BY `date` DESC";
$resMailList = mysql_query($queryMailList);


if (mysql_num_rows($resMailList) > 0)
  {

  while ($rowMailList = mysql_fetch_array($resMailList)){ 

      $filelist = glob("/var/www/fortuna/images/".createCatalog($rowMailList['text'])."/*.jpg"); 

      if(sizeof($filelist) != 0){
        $queryPeople = mysql_query("SELECT * FROM `re_people` WHERE `id` = {$rowMailList['people_id']} ");
        $rieltor = mysql_fetch_assoc($queryPeople);
        $phone = $rieltor['phone'];
        $firstName = $rieltor['name'];
        $middleName = $rieltor['second_name'];      
        $subject = createSubject($rowMailList['text']);

        $mailText =" Ваш риелтор: {$firstName} {$middleName} т. {$phone} <br/> Выслал Вам вариант: {$rowMailList['comment']}";
        //'smtp.gmail.com', 'arendavaha@gmail.com', 'khyuiop12'
        echo $rowMailList['id']." !!! ";
        echo getServerHost($rieltor['email_work'])." ". $rieltor['email_work']." ".$rieltor['email_pass'];

        if(!empty($rieltor['email_work']) AND !empty($rieltor['email_pass'])){        
          if(smtpmail($rowMailList['address'], $subject, $mailText, getServerHost($rieltor['email_work']), $rieltor['email_work'], $rieltor['email_pass'], $filelist)){
            mysql_query("UPDATE re_recipients_list SET active = '0', `date_send` = NOW() WHERE id={$rowMailList['id']}");
          }else{
            mysql_query("UPDATE re_recipients_list SET active = '2', `date_send` = NOW() WHERE id={$rowMailList['id']}");
          }          
        }else{
            mysql_query("UPDATE re_recipients_list SET active = '3', `date_send` = NOW()WHERE id={$rowMailList['id']}");
          echo " {$rowMailList['id']} WORK EMAIL IS EMPTY | Отсутствует дополнительный ящик.";
        }

      }
       //echo "!!".$rowMailList['address']."";
       sleep(3);
    }
  }

mysql_free_result($resMailList);



//smtpmail('2999516@mail.ru','Hello', 'ТЕкст описание варианта',array('img.jpg','photo_stamp.jpg'));
/**/
?>