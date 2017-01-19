<?php 
	ini_set('display_errors', 1);
	date_default_timezone_set('Asia/Novosibirsk'); 
	require 'application/modules/phpthumb/ThumbLib.inc.php';
	require_once 'application/includes/config.php';

ini_set('date.timezone', 'Asia/Novosibirsk');
ini_set('session.save_path', '/var/www/fortuna/sessions');
ini_set('session.gc_maxlifetime', 3600000);
ini_set('session.cookie_lifetime', 3600000);

	$db1 = mysql_connect($db_host,$db_user,$db_pass, true);
	mysql_select_db($db_name, $db1);
	mysql_query("SET CHARACTER SET utf8", $db1);
	mysql_query("SET NAMES utf8", $db1);
	mysql_query("SET time_zone = '+07:00'", $db1);
	
	require 'application/modules/simple_html_dom.php';
	$html_url= "http://novosibirsk.cmns.ru/export/api.php?key=js1em2mdeuc94jfdp&filetip=htm&tip=4&dom=1,2,3,4,5,6,7&hour=2&goodaddr=2&repeats=1&ndzvon=1&limit=200";
	$html = file_get_html($html_url);
	$fp = fopen("/var/www/fortuna/parsing/cmns_parse", "a");

	$dir =  "/var/www/fortuna/images/parse/";
	$i=0;
	$tArr = array(
		1 => "date_last_edit",
		2 => "topic_id",
		3 => "parent_id",
		4 => "room_count",
		5 => "sq_all",
		6 => "sq_land",
		7 => "price",
		9 => "live_point",
		10 => "street", 
		11 => "dis",	
		14 => "coords",
		15 => "photos",
		16 => "text",
		17 => "floor",
		18 => "floor_count",
		19 => "origin",
		20 => "link",
		21 => "phone"
	);
	$topic = array(
		"Сдам" => 1,
		"Продам" => 2,
		"Сниму" => 3,
		"Куплю" => 4
	);
	
	$parent = array(
		"жилая" => 1
	);
	
	function ToUtf8($str){
		return mb_convert_encoding($str, 'utf8', 'cp1251');
	}

	$trs = $html->find('tr');	
	$data = [];
	
	foreach ($trs as $tr) { 
		$row = null;
		if($i>0){
			foreach($tr->find('td') as $td){
				$row[] = $td->plaintext;
			}
			$data[]=$row;
		}
		$i++;
	}
	$countVar = count($data);
	$date = date("Y-m-d");

	fwrite($fp, "\r\n".date("Y-m-d G:i:s T")." ". $countVar. " "); // Запись в файл

	for($i=0; $countVar>$i; $i++){
		$parsing_test_file = '';

		$countColumn = count($data[$i]);
		$column = "";
		$value = "";
		$strForUpd = "";
		$phone = "";
		for($j=0; $countColumn>$j; $j++){
			if(isset($tArr[$j])){
				if($j==20){
					$td = $trs[$i+1]->find('td');
					$a = $td[$j]->find('a');
					$href = $a[0]->href;
					$parsing_test_file .= $href." ";
					$value .= "'{$href}',";
					$column .= $tArr[$j].",";
				}else if($j==1){
					$dateLastUpd = date("Y-m-d"); //, strtotime($data[$i][$j]));
					$value .= "'{$dateLastUpd}', '{$date}',";
					$column .= $tArr[$j].", date_added,";
					$strForUpd .= $tArr[$j]."='{$dateLastUpd}',";
				}else if($j==10){
					$sHArr = explode(", ", $data[$i][$j]);
					if(count($sHArr) == 2){
						$column .= $tArr[$j].", house,";
						$value .= "'{$sHArr[0]}', '".str_replace(" ", "", $sHArr[1])."',";
						$strForUpd .= $tArr[$j]."='{$sHArr[0]}', house='".str_replace(" ", "", $sHArr[1])."',";
					}else{
						$column .= $tArr[$j].",";
						$value .= "'{$sHArr[0]}',";
						$strForUpd .= $tArr[$j]."='{$sHArr[0]}',";
					}
				}else if($j==2){
					$value .= "'{$topic[ToUtf8($data[$i][$j])]}',";
					$column .= $tArr[$j].",";
				}else if($j==3){
					if(ToUtf8($data[$i][4])=="Комната"){
						$value .= "'18',";
					}else if(ToUtf8($data[$i][4])=="Дом"){
						$value .= "'3',";
					}else{
						$value .= "'{$parent[ToUtf8($data[$i][$j])]}',";
					}
					$column .= $tArr[$j].",";
				}else if($j==19){
					if($data[$i][$j] =='mirkvartir') continue;
				}else if($j==15){
					$photos = "";
					$td = $trs[$i+1]->find('td');
					$a_arr = $td[$j]->find('a');	
					$column .= $tArr[$j].",";
					$value .= "1,";
					$strForUpd .= $tArr[$j]."=1,";
				}else{					
					if($j==21 && ereg('NGS', $data[$i][$j])){
						$res = mysql_query("SELECT contact_tel FROM re_parse WHERE link like '%{$href}%'", $db1);
						$phone = mysql_fetch_assoc($res)['contact_tel'];
						$value .= "'{$phone}',";
						$column .= $tArr[$j].",";
						$strForUpd .= $tArr[$j]."='{$phone}',";
					}else{
						$value .= "'{$data[$i][$j]}',";
						$column .= $tArr[$j].",";
						$strForUpd .= $tArr[$j]."='{$data[$i][$j]}',";
					}
				}
			}
		}

		$query = mysql_query("SELECT count(*) as c FROM re_pay_parse WHERE link='{$href}'", $db1);
		if(mysql_fetch_assoc($query)["c"] > 0){
			$strForUpd .=" `modified` = NOW(),";
			$strForUpd = ToUtf8(substr($strForUpd, 0, -1));
			$queryAdd = "UPDATE re_pay_parse SET {$strForUpd} WHERE link='{$href}'";
		}else{
			$column .= " `created`, `modified`,";
			$value .= " NOW(), NOW(),";
			$column = substr($column, 0, -1);
			$value = ToUtf8(substr($value, 0, -1));
			$queryAdd = "INSERT INTO re_pay_parse ({$column}) VALUES ({$value})";				
		}

		$parsing_test_file .= $queryAdd."\n\r";
		mysql_query($queryAdd, $db1);

		if($data[$i][19] == "avito.ru"){
			$columnP = "";
			$valueP = "";
			$strForUpdP = "";
			$parent_idP = "";
			$type_id = "";
			
			if(ToUtf8($data[$i][4])=="Комната"){
				$parent_idP = 18;
				$type_id = 18;
			}else if(ToUtf8($data[$i][4])=="Дом"){
				$parent_idP = 3;
				$type_id = 25;
			}else{
				$parent_idP = $parent[ToUtf8($data[$i][3])];
				$type_id = 18 + $parent_idP;
			}
			$dateLastInsert = date("Y-m-d H:i:s");
			$valueP = "1, '{$dateLastInsert}', '{$date}', '{$topic[ToUtf8($data[$i][2])]}', '{$parent_idP}', '{$type_id}', '{$data[$i][5]}', '{$data[$i][6]}', '{$data[$i][7]}', '{$data[$i][9]}', ";
			
			$strForUpdP = "date_last_edit='".date("Y-m-d H:i:s")."', ";
			
			if(count($sHArr) == 2){
				$valueP .= "'{$sHArr[0]}', '".str_replace(" ", "", $sHArr[1])."', ";
				$strForUpdP .= "street='{$sHArr[0]}', house='".str_replace(" ", "", $sHArr[1])."', ";
			}else{
				$valueP .= "'{$sHArr[0]}', '', ";
				$strForUpdP .= "street='{$sHArr[0]}', house='', ";
			}
			
			$strForUpdP .= "price='{$data[$i][7]}'";
			
			$valueP .= "'{$data[$i][11]}', '{$data[$i][16]}', '{$data[$i][17]}', '{$data[$i][18]}', 'avito', '{$href}', '{$data[$i][21]}'";
			
			$columnP = "active, date_last_edit, date_added, topic_id, parent_id, type_id, sq_all, sq_land, price, live_point, street, house, dis, text, floor, floor_count, user_id, link, contact_tel";
			
			$query = mysql_query("SELECT count(*) as c FROM re_parse WHERE link='{$href}'", $db1);
			
			if(mysql_fetch_assoc($query)["c"] > 0){
				$strForUpdP = ToUtf8($strForUpdP);
				$queryParseAdd = "UPDATE re_parse SET {$strForUpdP} WHERE link='{$href}'";
			}else{
				$valueP = ToUtf8($valueP);
				$queryParseAdd = "INSERT INTO re_parse ({$columnP}) VALUES ({$valueP})";
			}
			mysql_query($queryParseAdd, $db1);
		}
		
		if(count($a_arr)>0){
			foreach($a_arr as $a){
				$img_link = $a->href;
				$query = mysql_query("SELECT id FROM re_pay_parse WHERE link='{$href}'", $db1);
				$id = mysql_fetch_assoc($query)['id'];
				if($id>0){
					$save_way = $dir.$id;
					if(!file_exists($save_way)){
						mkdir($save_way, 0777);
						echo " make dir : ". $save_way ." ; ";
					}
					$p_name = explode("/",$img_link);
					$count = count($p_name);
					$img_name = $p_name[$count-1];
					$save_way.="/".$img_name;
					
					if(!file_exists($save_way)){
						echo " !! ".$save_way. " ".$img_link." !! ";
						file_put_contents($save_way, file_get_contents($img_link));
					}
				}
			}
		}

		fwrite($fp, $parsing_test_file);
	}
	fwrite($fp, " \r\n");

	fclose($fp); 

	/**/
?>
