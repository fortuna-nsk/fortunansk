<?
	ini_set('display_errors', 1);
	date_default_timezone_set('Asia/Novosibirsk'); 
	require 'application/modules/phpthumb/ThumbLib.inc.php';
	require_once 'application/includes/config.php';
	$db1 = mysql_connect($db_host,$db_user,$db_pass, true);
	mysql_select_db($db_name, $db1);
	mysql_query("SET CHARACTER SET utf8", $db1);
	mysql_query("SET NAMES utf8", $db1);
	mysql_query("SET time_zone = '+07:00'", $db1);
	
	$db2 = mysql_connect($db_host2,$db_user2,$db_pass2, true);
	mysql_select_db($db_name2, $db2);
	mysql_query("SET CHARACTER SET utf8", $db2);
	mysql_query("SET NAMES utf8", $db2);
	
	
	if(isset($_POST['tid'])){
		add_photos($_POST['tid'], $db1, $db2);
	}
	
	function add_photos($tid, $db1, $db2){
		//получение id варианта и id владельца варианта
		$check = mysql_query("SELECT v.id as var_id, p.id as people_id FROM re_var as v, re_people as p, re_user as u WHERE fortuna_id = '".$tid."' AND v.user_id = u.user_id AND u.people_id = p.id", $db1);
		$ids = mysql_fetch_assoc($check);
		$people_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $ids['people_id'];
		$photo_dir = $people_dir .'/'. $ids['var_id'];
		if(count(glob($photo_dir."/*")) == 0){
			$res_photo = mysql_query("SELECT photo1, photo2, photo3, photo4, photo5, photo6 FROM text_smart WHERE tid = '".$tid."'", $db2);
			if(!file_exists($people_dir)){
				@mkdir($people_dir, 0777);
			}
			if(!file_exists($photo_dir)){
				@mkdir($photo_dir, 0777);
			}
			$next = '';
			while($photo = mysql_fetch_assoc($res_photo)){
				if($photo["photo1"] == '1'){
					$next = '1';
				}
				for($p=2; $p<7; $p++){
					if($photo["photo".$p] != ""){
						$photo_name = $photo["photo".$p]."_big.jpg";
						resize_photo($photo_dir, $ids['var_id'], $photo_name, $ids['people_id'], $db1);
					}
				}
			}
			if($next=='1'){	
				unset($res_photo, $photo);
				$res_photo = mysql_query("SELECT `name` FROM photos WHERE tid = '".$tid."'", $db2);
				while($photo = mysql_fetch_assoc($res_photo)){
					if(isset($photo["name"])){
						$photo_name = $photo["name"].".jpg";
						resize_photo($photo_dir, $ids['var_id'], $photo_name, $ids['people_id'], $db1);
					}
				}
			}
			$main_photo = glob($photo_dir."/*");
			
			if(count($main_photo) >0 ){
				main_photo_create($photo_dir, $main_photo[0]);
			}
		}else{
			//add_water_mark($ids['people_id'], $ids['var_id'], $photo_dir, $db1);
		}
	}
	
	function resize_photo($photo_dir, $var_id, $photo_name, $people_id, $db1){
		$file_url = "http://178.132.204.176/mail/documents/photo/".$photo_name;
		$save_way = $photo_dir."/".$photo_name;
		if(!file_exists($save_way)){
			try{
				file_put_contents($save_way, file_get_contents($file_url));
				if(filesize($save_way) > 0){
					$thumb = PhpThumbFactory::create($save_way);
					$thumb->resize(600);
					$thumb->save($save_way);
					mysql_query("INSERT INTO re_photos(`var_id`, `photo`, `people_id`, `date_added`) VALUE ('".$var_id."', '".$photo_name."', '".$people_id."', NOW())", $db1);
					echo $photo_name."<br />";
				}else{
					unlink($save_way);
				}
			}catch(Exception $ex){
				echo $ex;
			}
		}
	}
	
	function main_photo_create($photo_dir, $main_photo){
		try{
			if(!file_exists($photo_dir."/main.jpg")){
				$thumb = PhpThumbFactory::create($main_photo);
				$thumb->adaptiveResize(200, 150);
				$thumb->save($photo_dir."/main.jpg");
			}
		}catch(Exception $ex){}
	}
?>