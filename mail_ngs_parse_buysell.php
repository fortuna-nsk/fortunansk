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

require 'application/modules/simple_html_dom.php';

function ToUtf8($str){
  return iconv("WINDOWS-1251", "UTF-8", $str );
}
function ToWin1251($str){
  return iconv( "KOI8-R", "KOI8-R + WINDOWS-1251", $str );
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
   return $existLink['cnt'];
}

function createHouseSnimuQueryString($attach = '') {
}

function createGarageSnimuQueryString($attach = '') {
}

function createBuyAppartmentQueryString($attach = ''){
  $attach_array_sem = explode("Изображения\n;", $attach);
  $attach_array_end = explode("Изображения\n", $attach);
  if(sizeof($attach_array_sem)== 2)
    $attachValues = explode(';', $attach_array_sem[1]);
  elseif (sizeof($attach_array_end)== 2) {
    $attach_array_end[1].= ";".$attach_array_end[1]; 
    $attachValues = explode(';', $attach_array_end[1]);
  }else{
    return false;
  } 

  if(linkAgain($attachValues[33]) > 0) return 'DUBL';  

  $live_point = $attachValues[0];
  $dis = $attachValues[1];
  $street = $attachValues[3];
  $house = $attachValues[4];
  $orientir = $attachValues[5];
  $floor  = $attachValues[6]; 
  $floor_count  = $attachValues[7];
  $wall_type  = $attachValues[8];
  $parentId = '1';
  $palning = '';
  $ap_layout = '';
    switch ($attachValues[9]) {
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
    $sq_all = $attachValues[10];
    $sq_live = $attachValues[11];
    $sq_k = $attachValues[12];
    $ap_layout = '';
    if(!empty($attachValues[13]))$ap_layout = str_replace('"','', $attachValues[13]);
    $planning = '';
    if(!empty($attachValues[15]))$planning = str_replace('"','', $attachValues[15]); 
    

    $wc_type = $attachValues[16];
    $val_bal  = $attachValues[17];
    $val_lodg = $attachValues[18];
    $tel = 0;    
    if($attachValues[19] =='есть') $tel  = 1;
    $rent_type   = $attachValues[20]; 

    $text   = str_replace("'","", str_replace('"','', $attachValues[21]));
    $priceArray =  explode(' руб', $attachValues[22]);   $price  = str_replace('"', '',str_replace(' ', '', $priceArray[0]));

    $torg        = $attachValues[23];
    $obmen       = $attachValues[24];
    $chist_prod  = $attachValues[25];
    $ipoteka    = $attachValues[26];
    $photos      = $attachValues[27];
    $y_done      = $attachValues[28];
    $contact_name   = str_replace('"','',$attachValues[29]);
    $contact_tel  = str_replace('"','', $attachValues[30]);
    $tel_comment  = str_replace('"','',$attachValues[31]);

    $contact_email  = $attachValues[32];
    $link   = $attachValues[33];
    $own_type = $attachValues[34];
    $user_id = 'ngs';
    
    $query =  "INSERT INTO `re_parse` ( `user_id`, `active`, `topic_id`,  `type_id`,    `parent_id`,  `live_point`,   `dis`,    `street`,   `house`,    `orientir`,      `sq_all`,     `sq_live`,    `sq_k`,     `planning`,    `ap_layout`,    `wc_type`,  `val_bal`,    `val_lodg`,      `tel`,   `own_type`,   `y_done`,   `floor`,    `floor_count`,    `wall_type`,    `text`,    `price`,    `torg`,    `obmen`,     `chist_prod`,    `ipoteka`,    `rent_type`,   `link`,  `date_added`, `date_last_edit`, `contact_name`,    `contact_tel`,    `tel_comment`,      `contact_email`, `photos`)
                               VALUES ('{$user_id}',    1,      2,       '{$typeId}', '{$parentId}', '{$live_point}', '{$dis}', '{$street}', '{$house}', '{$orientir}', '{$sq_all}', '{$sq_live}', '{$sq_k}', '{$planning}', '{$ap_layout}', '{$wc_type}', '{$val_bal}', '{$val_lodg}', '{$tel}', '{$own_type}', '{$y_done}', '{$floor}', '{$floor_count}', '{$wall_type}', '{$text}', '{$price}', '{$torg}', '{$obmen}', '{$chist_prod}', '{$ipoteka}', '{$rent_type}', '{$link}', NOW(),       NOW(),          '{$contact_name}', '{$contact_tel}', '{$tel_comment}', '{$contact_email}', '{$photos}');";     
    echo " !!!-> ".$query." <-!!!";
    return $query;
}


function createBuyHouseQueryString($attach = ''){
  if( strpos($attach, "Изображения\n;") >0 ){
    $attach_array_sem = explode("Изображения\n;", $attach);
    $attachValues = explode(';', ";".$attach_array_sem[1]);
  }elseif ( strpos($attach, "Изображения\n") >0 ) {
    $attach_array_end = explode("Изображения\n", $attach);
    $attachValues = explode(';', $attach_array_end[1]);
  }elseif( strpos($attach, "Изображения\n") ==0 ) {
    $attach_array_sewage = explode("Канализация", $attach);
    $attachValues = explode(';', ";".$attach_array_sewage[1]);
  }else{
    return false;
  } 
  if(strpos($attachValues[32], 'ngs.ru') == 0) {return 'ERROR Attach<br/><br/>';}
  if(linkAgain($attachValues[32]) > 0) {  return 'DUBL';  }

  $live_point = $attachValues[1];
  $dis = $attachValues[2];
  $street = $attachValues[4];
  $house = $attachValues[5];
  $orientir = $attachValues[6];
  //$floor  = $attachValues[6]; 
  $floor_count  = $attachValues[7];
  $wall_type  = $attachValues[8];
  $rooms = $attachValues[9];
  $parentId = '3';
  $palning = '';
  $ap_layout = '';
    switch ($attachValues[11]) {
      case 'Дом':
        $typeId = "25"; 
        break;
      case 'Часть дома':
        $typeId = "26";
        break;
      case 'Коттедж':
        $typeId = "27";
        break;
      case 'Часть коттеджа':
        $typeId = "28";
        break;
      case 'Таунхаус':
        $typeId = "29";
        break;
      default:
        $typeId = "25";
        break;
    }
    $sq_land  = $attachValues[10];
    $sq_all = $attachValues[12];
    $sq_live = $attachValues[13];
    $sq_k = $attachValues[14];
    $planning = '';
    if(!empty($attachValues[15]))$planning = str_replace('"','', $attachValues[15]); 

    $wc_type = $attachValues[16];
    $val_bal  = $attachValues[17];
    $val_lodg = $attachValues[18];
    $tel = 0;if($attachValues[19] =='есть') $tel  = 1;

    $text   =  str_replace("'","", $attachValues[20]).". ".$attachValues[9]."-комн.";
    $priceArray =  explode(' руб', $attachValues[21]);   $price  = str_replace('"', '',str_replace(' ', '', $priceArray[0]));
    $torg        = $attachValues[22];
    $chist_prod  = $attachValues[23];
    $obmen       = $attachValues[24];
    $ipoteka    = $attachValues[25];
    $photos      = $attachValues[26];  
    $y_done      = $attachValues[27];

    $contact_name   = str_replace('"','',$attachValues[28]);
    $contact_tel  = str_replace('"','', $attachValues[29]);  
    $tel_comment  = str_replace('"','',$attachValues[30]);
    $contact_email  = $attachValues[31];
    $link   = $attachValues[32];

    $elec = $attachValues[33];
    $water = $attachValues[34];
    $gas = $attachValues[35];
    $heating = $attachValues[36];
    $heating_type = $attachValues[37];
    $sewage = $attachValues[38];
    $own_type = ''; if(isset($attachValues[39])) $own_type = $attachValues[39];
    $user_id = 'ngs';
    
    $query =  "INSERT INTO `re_parse` ( `user_id`,  `date_added`, `date_last_edit`, `active`, `topic_id`,  `type_id`,    `parent_id`,  `live_point`,   `dis`,    `street`,      `house`,    `orientir`,      `sq_all`,     `sq_live`,    `sq_k`, `sq_land`,     `planning`,    `wc_type`,  `val_bal`,       `val_lodg`,      `tel`,   `own_type`,    `y_done`,     `floor_count`,    `wall_type`,   `elec`,    `water`,      `gas`,      `heating`,    `heating_type`,     `text`,    `price`,    `torg`,    `obmen`,     `chist_prod`,    `ipoteka`,  `link`,  `contact_name`,    `contact_tel`,    `tel_comment`,      `contact_email`, `photos`)
                               VALUES ('{$user_id}', NOW(),           NOW(),             1,      2,         '{$typeId}', '{$parentId}', '{$live_point}', '{$dis}', '{$street}', '{$house}', '{$orientir}', '{$sq_all}', '{$sq_live}', '{$sq_k}', '{$sq_land}', '{$planning}', '{$wc_type}', '{$val_bal}', '{$val_lodg}',    '{$tel}', '{$own_type}', '{$y_done}', '{$floor_count}', '{$wall_type}', '{$elec}', '{$water}', '{$gas}', '{$heating}',   '{$heating_type}',    '{$text}', '{$price}', '{$torg}', '{$obmen}', '{$chist_prod}', '{$ipoteka}', '{$link}',  '{$contact_name}', '{$contact_tel}', '{$tel_comment}', '{$contact_email}', '{$photos}');";     
    echo " !!!-> ".$query." <-!!!";
    return $query;
}

function createBuyNewHomesQueryString($attach = ''){
//  echo $attach;
  if( strpos($attach, "Изображения\n;") >0 ){
//    echo "%%%";
    $attach_array_sem = explode("Изображения\n;", $attach);
    $attachValues = explode(';', ";".$attach_array_sem[1]);
  }elseif ( strpos($attach, "Изображения\n") >0 ) {
//    echo "&&&";
    $attach_array_end = explode("Изображения\n", $attach);
    $attachValues = explode(';', $attach_array_end[1]);
  }else{
//        echo "****<br/>";
    return false;
  } 
//    print_r($attachValues);
  if(strpos($attachValues[36], 'ngs.ru') == 0) {
//   echo "@@@( ".$attachValues[36]." )@@@";/**/ 
    return 'ERROR Attach';  
 }
  if(linkAgain($attachValues[36]) > 0) { 
//    echo "???( ".$attachValues[36]." )???";/**/
   return 'DUBL';  
  }

  $live_point = $attachValues[1];
  $dis = $attachValues[2];
  $street = $attachValues[4];
  $house = $attachValues[5];
  $orientir = $attachValues[6];
  $floor  = $attachValues[7]; 
  $floor_count  = $attachValues[8];
  $wall_type  = $attachValues[9];
  $park = $attachValues[10];
  $developer = $attachValues[11];
  $parentId = '2';
  $sdan = $attachValues[12];
  switch ($attachValues[13]) {
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
    case '6':
      $typeId = "24";
      break;
    default:
      $typeId = "19";
      break;
  }
  $sq_all = $attachValues[14];
  $sq_live = $attachValues[15];
  $sq_k = $attachValues[16];
  $ap_layout = ''; if(!empty($attachValues[17]))$ap_layout = str_replace('"','', $attachValues[17]);
  $planning = ''; if(!empty($attachValues[18]))$planning = str_replace('"','', $attachValues[18]); 

  $wc_type = $attachValues[19];
  $val_bal  = $attachValues[20];
  $val_lodg = $attachValues[21];
  $tel = 0;if($attachValues[22] =='есть') $tel  = 1;

  $text   = str_replace('"','', str_replace("'","", $attachValues[24]));
  if($sdan == 'сдан') {
    $text.= $text." Дом сдан."; 
  }else{
    $text.= $text." Дом HE сдан. ";
  }
  if(!empty($attachValues[23]) ) $text.= $text." Оформление отношений : ".$attachValues[23].".";

  $priceArray =  explode(' руб', $attachValues[25]);   $price  = str_replace('"', '',str_replace(' ', '', $priceArray[0]));
  $torg        = $attachValues[26];
  $chist_prod  = $attachValues[27];
  $obmen       = $attachValues[28];
  $ipoteka     = $attachValues[29];
  $photos      = $attachValues[30];  
  $y_done      = $attachValues[31];

  $contact_name   = str_replace('"','',$attachValues[32]);
  $contact_tel  = str_replace('"','', $attachValues[33]);  
  $tel_comment  = str_replace('"','',$attachValues[34]);
  $contact_email  = $attachValues[35];
  $link   = $attachValues[36];
  $own_type = ''; if(isset($attachValues[37])) $own_type = $attachValues[37];
  $user_id = 'ngs';
  
  $query =  "INSERT INTO `re_parse` ( `user_id`,  `date_added`, `date_last_edit`, `active`, `topic_id`,  `type_id`,    `parent_id`,  `live_point`,   `dis`,    `street`,      `house`,    `orientir`,      `sq_all`,     `sq_live`,    `sq_k`,     `planning`,  `ap_layout`,  `park`,     `developer`, `wc_type`,  `val_bal`,       `val_lodg`,      `tel`,   `own_type`,    `y_done`,     `floor_count`,  `floor`,    `wall_type`,     `text`,    `price`,    `torg`,    `obmen`,     `chist_prod`,    `ipoteka`,  `link`,  `contact_name`,    `contact_tel`,    `tel_comment`,      `contact_email`, `photos`)
                             VALUES ('{$user_id}', NOW(),           NOW(),             1,      2,         '{$typeId}', '{$parentId}', '{$live_point}', '{$dis}', '{$street}', '{$house}', '{$orientir}', '{$sq_all}', '{$sq_live}', '{$sq_k}',   '{$planning}', '{$ap_layout}', '{$park}', '{$developer}', '{$wc_type}', '{$val_bal}', '{$val_lodg}',    '{$tel}', '{$own_type}', '{$y_done}', '{$floor_count}', '{$floor}', '{$wall_type}', '{$text}', '{$price}', '{$torg}', '{$obmen}', '{$chist_prod}', '{$ipoteka}', '{$link}',  '{$contact_name}', '{$contact_tel}', '{$tel_comment}', '{$contact_email}', '{$photos}');";     
  echo " !!!-> ".$query." <-!!!";
  return $query;
}



function firstAttachments($parts, $mess_num, $mbox){
  if(isset($parts) && count($parts))
  {
      for($i = 0; $i < count($parts); $i++)
      {
          $attachments[$i] = [
              'is_attachment' => false,
              'filename' => '',
              'name' => '',
              'attachment' => ''
          ];
          if($parts[$i]->ifdparameters)
          {             
              foreach($parts[$i]->dparameters as $object)
              {
                  if(strtolower($object->attribute) == 'filename')
                  {
                      $attachments[$i]['is_attachment'] = true;
                      $attachments[$i]['filename'] = $object->value;
                  }
              }
          }
          if($parts[$i]->ifparameters)
          {
              foreach($parts[$i]->parameters as $object)
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

              $attachments[$i]['attachment'] = imap_fetchbody($mbox, $mess_num , $i+1);
              if($parts[$i]->encoding == 3)
              {
                  $attachments[$i]['attachment'] = imap_base64($attachments[$i]['attachment']);
              }
              elseif($parts[$i]->encoding == 4)
              {
                  $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
              }
          }
      }
  }
  return $attachments[1]['attachment'];
}


$mbox = imap_open('{imap.mail.ru:143}/tst', "vint.br@mail.ru", "0703Vitaly") or die("can't connect: " . imap_last_error());
$MC = imap_check($mbox);
// Fetch an overview for all messages in tmp
$result = imap_fetch_overview($mbox,"1:{$MC->Nmsgs}",0);
foreach ($result as $overview) {
  $query = '';
  $structure = imap_fetchstructure($mbox, $overview->msgno);

  $subj = $overview->subject;
  $subj = str_replace("=?utf-8?B?", '', $subj);
  $subj = str_replace("?=", '', $subj);
  $buysell = 'sell';
  $topicId = '4';
  if(strpos(base64_decode($subj), "Куплю") ){$topicId = '4'; $buysell = 'buy';}
  $parent = 1;
  if(strpos(base64_decode($subj), "Жилая недвижимость") ) $parent = 1;
  if(strpos(base64_decode($subj), "Новостройки") ) $parent = 2;
  if(strpos(base64_decode($subj), "Коттеджи, дома") ) $parent = 3;
  if(strpos(base64_decode($subj), "Дачи") ) $parent = 4;
  if(strpos(base64_decode($subj), "Земля") ) $parent = 5;
  if(strpos(base64_decode($subj), "Гаражи") ) $parent = 6;
  if(strpos(base64_decode($subj), "Коммерческая") ) $parent = 7;
  
  
 
    $parts = $structure->parts;
    $part = $parts[1];
    $filename=$part->parameters[0]->value; 

    if($filename == 'attach.csv'){
       $attach =  ToUtf8(firstAttachments($parts,$overview->msgno, $mbox));

      if($parent == 1){
        $query = createBuyAppartmentQueryString($attach);
      }
      if($parent == 2){
        $query = createBuyNewHomesQueryString($attach);
      }
      if($parent == 3){
        $query = createBuyHouseQueryString($attach);
      }

        $attachValues = [];
        $attach_array = [];         

        if($query == '') {
            $query = '';
            imap_mail_move ( $mbox, $overview->msgno , "Продам_Архив" ); 
            continue;
        }

      if($query == 'DUBL'){
        imap_mail_move ( $mbox, $overview->msgno , "Продам_Архив" );
        echo " DUBL\n\r";    
      }elseif(!empty($query) && mysql_query($query)) {
        imap_mail_move ( $mbox, $overview->msgno , "Продам_Архив" );
        echo " NEW VALUE\n\r";    
      }else{
        echo " ()!!! ".$overview->msgno. " ERROR Invalid query: " . mysql_error()."\n\r<br/><br/>";  
//        imap_mail_move ( $mbox, $overview->msgno , "Варианты с ошибками" );      
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

 