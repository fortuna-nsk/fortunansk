<?php

/*
podborka-arenda@mail.ru
khyuiop12

*/

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

require 'application/modules/simple_html_dom.php';

function ToUtf8($str){
  return iconv("WINDOWS-1251", "UTF-8", $str );
}
function ToWin1251($str){
  return iconv( "KOI8-R", "KOI8-R + WINDOWS-1251", $str );
}

require_once('lib/phpmailer/class.smtp.php'); //путь до класса phpmailer
require_once('lib/phpmailer/class.phpmailer.php'); //путь до класса phpmailer

function getServerHost($email){
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

function getSMTPMail($host, $username, $password)
{
  $__smtp = array(
    "debug" => 2,                   //отображение информации дебаггера (0 - нет вообще)
    "auth" => true,                 //сервер требует авторизации
    "port" => 465,                    //порт (по-умолчанию - 25)
    "secure"   => "ssl",
    );

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
      
      print_r($mail->connect());

    } catch (phpmailerException $e) {
      echo $e->errorMessage();
    } catch (Exception $e) {
      echo $e->getMessage();
    }
}


function createCatalog($var_id){
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

function mail_str_encode($str) {
    $str=trim($str);
    if (preg_match("!^[\\x20-\\x7E]+$!is",$str) || $str=="") return $str;
    $out="";
    for ($i=0; $i<strlen($str); $i+=60) {
        $tmp=substr($str,$i,60);
        if ($i>0) $out.="\r\n\t";
        $out.="=?Windows-1251?b?".base64_encode($tmp)."?=";
    }
    return $out;
} 


function linkAgain($link){
  $existLink = mysql_fetch_assoc(mysql_query("SELECT COUNT(id) as cnt FROM `re_parse` WHERE `link` = '{$link}'"));
   if($existLink > 0){
      $query =  mysql_query("DELETE FROM `re_parse` WHERE `link` = '{$link}'");
      return true;
    }
    return false;
}

function createHouseSnimuQueryString($attach = '') {
}

function createGarageSnimuQueryString($attach = '') {
}

function createGarageSdamQueryString($attach = '') {
$query = '';
  $attach_array = explode('Изображения'."\n;", $attach);
  if(sizeof($attach_array) != 2)
       return false;  
  $attachValues = explode(';', $attach_array[1]);
  $live_point = $attachValues[0];
  $dis = $attachValues[1];
  $street = $attachValues[3];
  $house = $attachValues[4];
  $parentId = 6;
   switch ($attachValues[5]) {
      case 'Капитальный гараж':
        $typeId = "35";
        break;
      case 'Металлический гараж':
        $typeId = "36";
        break;
      case 'Парковочное место':
        $typeId = "37";
        break;
      case 'Овощехранилище':
        $typeId = "38";
        break;
      default:
        $typeId = "35";
        break;
    }
    $orientir = $attachValues[8];
    $text   = str_replace('"','', $attachValues[6]);
    if($attachValues[10] == 'есть' ) $text.= " Погреб."; 
    if($attachValues[11] == 'есть' ) $text.= " Смотровая яма."; 
    $sq_all = $attachValues[9];
    $priceArray =  explode(' руб', $attachValues[12]);   $price  = str_replace('"', '',str_replace(' ', '', $priceArray[0]));
    $photos   = $attachValues[21];
    $contact_name   = str_replace('"','',$attachValues[15]);
    $contact_tel  = str_replace('"','', $attachValues[16]);
    $tel_comment  = str_replace('"','',$attachValues[17]);
    $contact_email  = $attachValues[18];
    $link   = $attachValues[19];
    linkAgain($link);

    $own_type = $attachValues[20];
    $user_id = 'ngs';
    $query =  "INSERT INTO `re_parse` ( `user_id`, `active`, `topic_id`, `type_id`, `parent_id`,     `live_point`,   `dis`,    `street`,   `house`,    `orientir`,     `sq_all`,    `text`,      `price`,  `link`, `date_added`, `date_last_edit`, `contact_name`,    `contact_tel`,    `tel_comment`,      `contact_email`, `photos`)
                                VALUES ('{$user_id}',    1,      1,      '{$typeId}', '{$parentId}', '{$live_point}', '{$dis}', '{$street}', '{$house}', '{$orientir}', {$sq_all}, '{$text}', '{$price}', '{$link}', NOW(),       NOW(),          '{$contact_name}', '{$contact_tel}', '{$tel_comment}', '{$contact_email}', '{$photos}');";
   
    return $query;
}

function createHouseSdamQueryString($attach = '') {
  $query = '';
  $attach_array = explode('Изображения'."\n;", $attach);
  if(sizeof($attach_array) != 2)
       return false;  


  $attachValues = explode(';', $attach_array[1]);
  $live_point = $attachValues[0];
  $dis = $attachValues[1];
  $parentId = 3;
  $street = $attachValues[3];
  $house = $attachValues[4];
  $orientir = $attachValues[5];
  $floor_count  = $attachValues[6];
  $wall_type  = $attachValues[7];
  if(!empty($attachValues[8])) $ap_layout = $attachValues[8];
  switch ($attachValues[10]) {
      case 'дом':
        $typeId = "25";
        break;
      case 'коттедж':
        $typeId = "27";
        break;
      case 'часть дома':
        $typeId = "26";
        break;
      case 'часть коттеджа':
        $typeId = "21";
        break;
      case 'Таунхаус':
        $typeId = "29";
        break;
      default:
        $typeId = "25";
        break;
    }

    
    $sq_all = $attachValues[11];
    $sq_live = $attachValues[12];
    $sq_k = $attachValues[13];
    $planning = '';
    $ap_layout = '';
    if(!empty($attachValues[14]))$planning = str_replace('"','', $attachValues[14]); 

    $wc_type = $attachValues[15];
    $val_bal  = $attachValues[16];
    $val_lodg = $attachValues[17];
    $tel = 0;
    if($attachValues[18] =='есть') $tel  = 1;
    $y_done   = $attachValues[23];
    $text   = str_replace('"','', $attachValues[19]);
    if($attachValues[9] >0 ) $text.= ". Площадь участка : ". $attachValues[9] . "м² ";  
    $priceArray =  explode(' руб', $attachValues[20]);   $price  = str_replace('"', '',str_replace(' ', '', $priceArray[0]));
    $torg   = $attachValues[22];
    $photos   = $attachValues[23];
    $contact_name   = str_replace('"','',$attachValues[25]);
    $contact_tel  = str_replace('"','', $attachValues[26]);
    $tel_comment  = str_replace('"','',$attachValues[27]);
    $contact_email  = $attachValues[28];
    $link   = $attachValues[29];
    linkAgain($link);
    $elec = $water = $gas = $heating = $heating_type = $sewage = $gr_house = $posadki = $banya = '';
    if($attachValues[30] == 'есть') $elec  = 1;
    if($attachValues[31] != 'нет') $elec  = $attachValues[31];
    if($attachValues[32] == 'есть') $gas  = 1;
    if($attachValues[33] != 'нет') $heating = $attachValues[33];
    if($attachValues[33] != 'нет') $heating_type = $attachValues[34];
    if($attachValues[35] == 'есть') $sewage = $attachValues[35];

    $user_id = 'ngs';
    $own_type = $attachValues[36];
    $query = "INSERT INTO `re_parse` ( `user_id`, `active`, `topic_id`, `type_id`, `parent_id`,     `live_point`,   `dis`,    `street`,   `house`,    `orientir`,     `sq_all`, `sq_live`, `sq_k`,    `planning`,    `ap_layout`,    `wc_type`,  `val_bal`,       `val_lodg`,     `tel`,     `own_type`,  `floor_count`,    `wall_type`,  `text`,      `price`,  `torg`,    `link`, `date_added`, `date_last_edit`, `contact_name`,    `contact_tel`,    `tel_comment`,      `contact_email`, `photos`,     `elec`,   `water`,    `heating`,    `heating_type`,     `gas`, `sewage`)
                            VALUES ('{$user_id}',    1,      1,       '{$typeId}', '{$parentId}', '{$live_point}', '{$dis}', '{$street}', '{$house}', '{$orientir}', {$sq_all}, {$sq_live}, {$sq_k}, '{$planning}', '{$ap_layout}', '{$wc_type}', '{$val_bal}', '{$val_lodg}', '{$tel}',  '{$own_type}', {$floor_count}, '{$wall_type}','{$text}', '{$price}', '{$torg}', '{$link}', NOW(),       NOW(),          '{$contact_name}', '{$contact_tel}', '{$tel_comment}', '{$contact_email}', '{$photos}','{$elec}', '{$water}', '{$heating}', '{$heating_type}', '{$gas}', '{$sewage}');";
                            echo $query;
    return $query;
}

function createSnimuQueryString($attach = '') {
  $query = '';
  $attach_array = explode('"Ссылка на объявление"'."\n;", $attach);
  if(sizeof($attach_array) != 2)
       return false;  
  $attachValues = explode(';', $attach_array[1]);
  $live_point = $attachValues[0];
  $dis = $attachValues[1];
  $parentId = 1;
  switch ($attachValues[3]) {
    case 'комната':
      $typeId = "18"; $parentId = 18;
      break;
    case '1':
      $typeId = "19";
      break;
    case '2':
      $typeId = "20";
      break;
    case '3':
      $typeId = "21";
      break;
    case '4':
      $typeId = "22";
      break;
    case '5':
      $typeId = "23";
      break;
    default:
      $typeId = "23";
      break;
  }
    $tel = $refrig = $furn = 0;

  if($attachValues[5] =='есть') $furn = 1;
  if($attachValues[6] =='есть') $refrig   = 1;
  if($attachValues[7] =='есть') $tel  = 1;
  $text   = str_replace('"','',$attachValues[10]);
  $priceArray =  explode(' руб', $attachValues[11]);   $price  = str_replace('"', '',str_replace(' ', '', $priceArray[0]));
  $contact_name   = str_replace('"','',$attachValues[13]);
  $contact_tel  = str_replace('"','',$attachValues[14]);
  $tel_comment  = str_replace('"','',$attachValues[15]);
  $contact_email  = str_replace('"','',$attachValues[16]);
  $link   = $attachValues[17];
  linkAgain($link);
  $user_id = 'ngs';

  return "INSERT INTO `re_parse` ( `user_id`, `active`, `topic_id`, `type_id`, `parent_id`,     `live_point`,   `dis`,       `tel`,  `furn`,  `refrig`,         `text`,      `price`,    `link`, `date_added`, `date_last_edit`, `contact_name`,    `contact_tel`,    `tel_comment`,      `contact_email`)
                          VALUES ('{$user_id}',    1,      3,        '{$typeId}', '{$parentId}', '{$live_point}', '{$dis}',  '{$tel}', '{$furn}', '{$refrig}',  '{$text}', '{$price}',  '{$link}', NOW(),       NOW(),          '{$contact_name}', '{$contact_tel}', '{$tel_comment}', '{$contact_email}');";
                        /*  */
  return $query;
}
function createSdamQueryString($attach = ''){
  $attach_array = explode("Изображения\n;", $attach);
  echo $attach;
  if(sizeof($attach_array) != 2)
       return false;  
  $attachValues = explode(';', $attach_array[1]);
  $live_point = $attachValues[0];
  $dis = $attachValues[1];
  $street = $attachValues[3];
  $house = $attachValues[4];
  $orientir = $attachValues[5];
  $parentId = '1';
  $palning = '';
  $ap_layout = '';
    switch ($attachValues[8]) {
      case 'комната':
        $typeId = "18"; $parentId = 18;
        break;
      case '1':
        $typeId = "19";
        break;
      case '2':
        $typeId = "20";
        break;
      case '3':
        $typeId = "21";
        break;
      case '4':
        $typeId = "22";
        break;
      case '5':
        $typeId = "23";
        break;
      default:
        $typeId = "23";
        break;
    }
    $square = explode('/', $attachValues[9]);

    $sq_all = $square[0];
    $sq_live = $square[1];
    $sq_k = $square[2];
    $planning = '';
    $ap_layout = '';
    if(!empty($attachValues[10]))$planning = str_replace('"','', $attachValues[10]); 
    if(!empty($attachValues[12]))$ap_layout = str_replace('"','', $attachValues[12]);
    $wc_type = $attachValues[13];
    $val_bal  = $attachValues[14];
    $val_lodg = $attachValues[15];
    $tel = $refrig = $furn = 0;
    if($attachValues[16] =='есть') $tel  = 1;
    if($attachValues[17] =='есть') $furn = 1;
    if($attachValues[18] =='есть') $refrig   = 1;
    $y_done   = $attachValues[23];
    $floorArray = explode('/', $attachValues[6]); $floor  = $floorArray[0]; $floor_count  = $floorArray[1];
    $wall_type  = $attachValues[7];

    $text   = str_replace('"','', $attachValues[19]);

    $priceArray =  explode(' руб', $attachValues[20]);   $price  = str_replace('"', '',str_replace(' ', '', $priceArray[0]));
    $torg   = $attachValues[21];

    $contact_name   = str_replace('"','',$attachValues[24]);
    $contact_tel  = str_replace('"','', $attachValues[25]);
    $tel_comment  = str_replace('"','',$attachValues[26]);
    $link   = $attachValues[28];
    linkAgain($link);
    $contact_email  = $attachValues[27];
    $photos   = $attachValues[22];
    $user_id = 'ngs';
    $own_type = $attachValues[29];
    return "INSERT INTO `re_parse` ( `user_id`, `active`, `topic_id`, `type_id`, `parent_id`,     `live_point`,   `dis`,    `street`,   `house`,    `orientir`,     `sq_all`, `sq_live`, `sq_k`,    `planning`,    `ap_layout`,    `wc_type`,  `val_bal`,    `val_lodg`, `tel`,  `furn`,  `refrig`,  `own_type`,   `y_done`,    `floor`, `floor_count`,    `wall_type`,  `text`,      `price`,                  `torg`,    `link`, `date_added`, `date_last_edit`, `contact_name`,    `contact_tel`,    `tel_comment`,      `contact_email`, `photos`)
                            VALUES ('{$user_id}',    1,      1,          '{$typeId}', '{$parentId}', '{$live_point}', '{$dis}', '{$street}', '{$house}', '{$orientir}', {$sq_all}, {$sq_live}, {$sq_k}, '{$planning}', '{$ap_layout}', '{$wc_type}', '{$val_bal}', '{$val_lodg}', '{$tel}', '{$furn}', '{$refrig}', '{$own_type}', '{$y_done}', {$floor}, {$floor_count}, '{$wall_type}',     '{$text}', '{$price}', '{$torg}', '{$link}', NOW(),       NOW(),          '{$contact_name}', '{$contact_tel}', '{$tel_comment}', '{$contact_email}', '{$photos}');";
}

$mbox = imap_open('{imap.mail.ru:143}/NGS', "89139552167@mail.ru", "BLKJf934tnkks4(nn") or die("can't connect: " . imap_last_error());
$MC = imap_check($mbox);
// Fetch an overview for all messages in tmp
$result = imap_fetch_overview($mbox,"1:{$MC->Nmsgs}",0);
foreach ($result as $overview) {

    $structure = imap_fetchstructure($mbox, $overview->msgno);

  $subj = $overview->subject;
  $subj = str_replace("=?utf-8?B?", '', $subj);
  $subj = str_replace("?=", '', $subj);
  $rent = 'sdam';
  $topic = '1';
  $parent = 1;
  if(strpos(base64_decode($subj), "Коттеджи") ) $parent = 3;
  if(strpos(base64_decode($subj), "Гаражи") ) $parent = 6;
  if(strpos(base64_decode($subj), "Сниму") ) $rent = 'snimu';


    $parts = $structure->parts;
    $part = $parts[1];
    $filename=$part->parameters[0]->value; 

    if($filename == 'attach.csv'){
       if(isset($structure->parts) && count($structure->parts))
            {
                for($i = 0; $i < count($structure->parts); $i++)
                {
                    $attachments[$i] = array(
                        'is_attachment' => false,
                        'filename' => '',
                        'name' => '',
                        'attachment' => ''
                    );
     
                    if($structure->parts[$i]->ifdparameters)
                    {
                        foreach($structure->parts[$i]->dparameters as $object)
                        {
                            if(strtolower($object->attribute) == 'filename')
                            {
                                $attachments[$i]['is_attachment'] = true;
                                $attachments[$i]['filename'] = $object->value;
                            }
                        }
                    }
     
                    if($structure->parts[$i]->ifparameters)
                    {
                        foreach($structure->parts[$i]->parameters as $object)
                        {
                            if(strtolower($object->attribute) == 'name')
                            {
                                $attachments[$i]['is_attachment'] = true;
                                $attachments[$i]['name'] = $object->value;
                            }
                        }
                    }
     
                    if($attachments[$i]['is_attachment'])
                    {
                        $attachments[$i]['attachment'] = imap_fetchbody($mbox, $overview->msgno, $i+1);
     
                        /* 4 = QUOTED-PRINTABLE encoding */
                        if($structure->parts[$i]->encoding == 3)
                        {
                            $attachments[$i]['attachment'] = imap_base64($attachments[$i]['attachment']);
                        }
                        /* 3 = BASE64 encoding */
                        elseif($structure->parts[$i]->encoding == 4)
                        {
                            $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                        }
                    }
                }
            }

            
            //header('Content-Disposition: attachment; filename='.$filename);
            $attach =  ToUtf8($attachments[1]['attachment']);
            $attachValues = [];
            $attach_array = [];         

        if($parent == 1){
          if($rent == 'sdam'){
              $query = createSdamQueryString($attach);
           }else{
              $query = createSnimuQueryString($attach);
           }                             
         }elseif ($parent == 3) {
          if($rent == 'sdam'){
              $query = createHouseSdamQueryString($attach);   
              }else{
                $query = createHouseSnimuQueryString($attach);   
              }
         }elseif ($parent == 6) {

          if($rent == 'sdam'){
              $query = createGarageSdamQueryString($attach);
            }else{
              $query = createGarageSnimuQueryString($attach);
            }

         }else{
              $query = '';
         }


          if(mysql_query($query)){
            imap_mail_move ( $mbox, $overview->msgno , "NGS_ARCHIVE" );
            echo " NEW VALUE\n\r";
          }else{
            if(strpos(mysql_error(), 'uplicate entry' )==0){
                echo " !!! ".$overview->msgno. " ERROR Invalid query: " . mysql_error()."\n\r";  
            }else{
                echo " !!! ".$overview->msgno. " ERROR Invalid query: " . mysql_error()."\n\r";  
                imap_mail_move ( $mbox, $overview->msgno , "NGS_ARCHIVE_ERROR" );    
            }
              
          }

          $query = '';
        }
}

imap_close($mbox);




/*
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>

        <?php
        header('Content-Type: text/html; charset=utf-8');

        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $username = 'user@gmail.com';
        $password = 'pass';

        $inbox = imap_open('{imap.mail.ru:143}', "89139552167@mail.ru", "BLKJf934tnkks4(nn") or die("can't connect: " . imap_last_error());


        $emails = imap_search($inbox, 'ALL');

        if ($emails) {
            $output = '';

            foreach ($emails as $email_number) {
                $overview = imap_fetch_overview($inbox, $email_number, 0);
                $message = imap_fetchbody($inbox, $email_number, 2);
  $message = str_replace("=?utf-8?B?", '', $message);
  $message = str_replace("?=", '', $message);
                $output.= '<div class="toggler ' . (imap_utf8($overview[0]->seen) ? 'read' : 'unread') . '">';
  $subj = $overview[0]->subject;
  $subj = str_replace("=?utf-8?B?", '', $subj);
  $subj = str_replace("?=", '', $subj);
               $output.= '<span class="subject">!!' . base64_decode($subj) . '!!</span> ';
              $output.= '<span class="from">' . ($overview[0]->from) . '</span>';
  //              $output.= '<span class="date">on ' . imap_utf8($overview[0]->date) . '</span>';
                $output.= '</div>';

                /* output the email body 
                $output.= '<div class="body">???' . base64_decode($message) . '???</div>';
                break;
            }

            echo $output;
        }
        imap_close($inbox);
        ?>
    </body>
</html>

<?php
/**/
?>

 