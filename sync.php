<?/*
	ini_set('display_errors', 0);
	date_default_timezone_set('Asia/Novosibirsk');
	require_once 'application/includes/config.php';
	$db1 = mysql_connect($db_host,$db_user,$db_pass, true);
	mysql_select_db($db_name, $db1);
	mysql_query("SET CHARACTER SET utf8", $db1);
	mysql_query("SET NAMES utf8", $db1);
	mysql_query("SET time_zone = '+06:00'", $db1);
	
	$db3 = mysql_connect($db_host3,$db_user3,$db_pass3, true);
	mysql_select_db($db_name3, $db3);
	mysql_query("SET CHARACTER SET utf8", $db3);
	mysql_query("SET NAMES utf8", $db3);
	
	$query = mysql_query("SELECT v.* FROM re_var as v, re_user as u, re_photos as p WHERE v.user_id = u.user_id AND p.var_id = v.id AND p.water_mark=0 AND u.for_open_site =1 AND v.active=1 AND v.photo=1 AND v.date_last_edit >= NOW() AND topic_id=1 GROUP BY (v.id) ORDER BY v.date_last_edit DESC", $db1);
	while($var = mysql_fetch_assoc($query)){
		try{
			$exist = mysql_query("SELECT * FROM objects WHERE fort_id={$var['id']}", $db3);
			if(mysql_num_rows($exist)>0){
				Sync($var, "update", $db3, $db1);
			}else{
				Sync($var, "insert", $db3, $db1);
			}
		}catch(Exception $ex){}
	}
	
	function Sync($arr, $method, $db3, $db1){
		if($method=="insert"){
			$pages_arr = array(
				1=>3,
				18=>19,
				3=>20,
				4=>21,
				6=>22,
				7=>23,
				5=>24
			);			
			$page = $pages_arr[$arr['parent_id']];
			$people_res = mysql_query("SELECT name, phone, u.people_id, ph.var_id, ph.photo FROM re_people as p, re_user as u, re_photos as ph WHERE u.people_id = p.id AND ph.people_id = p.id AND ph.var_id = {$arr['id']}", $db1);
			while($people = mysql_fetch_assoc($people_res)){
				$people_arr[]=$people;
				mysql_query("INSERT INTO photos (photo, var, people, date_add) VALUE ('{$people['photo']}', '{$people['var_id']}', '{$people['people_id']}', NOW())", $db3);
			}
			if(count($people_arr)>0)
			{
				$type_res=mysql_query("SELECT name FROM re_type_object WHERE id={$arr['type_id']}", $db1);
				$type=mysql_fetch_assoc($type_res)["name"];
				mysql_query("INSERT INTO objects (topic_id, fort_id, page_id, active, live_point, dis, street, house, orientir, sq_all, sq_live, sq_k, sq_land, planning, furn, tv, washing, refrig, park, floor, floor_count, room_count, price, name, phone, date_last_edit, rent_type, type, ap_layout) VALUE ({$arr['topic_id']}, '{$arr['id']}', '{$page}', 'Y', '{$arr['live_point']}', '{$arr['dis']}', '{$arr['street']}', '{$arr['house']}', '{$arr['orientir']}', '{$arr['sq_all']}', '{$arr['sq_live']}', '{$arr['sq_k']}', '{$arr['sq_land']}', '{$arr['planning']}', '{$arr['furn']}', '{$arr['tv']}', '{$arr['washing']}', '{$arr['refrig']}', '{$arr['park']}', '{$arr['floor']}', '{$arr['floor_count']}', '{$arr['room_count']}', '{$arr['price']}', '{$people_arr[0]['name']}', '{$people_arr[0]['phone']}', '{$arr['date_last_edit']}', '{$arr['rent_type']}', '".($arr['ap_layout']=="в общежитии" ? "комнату без хозяйки" : $type)."', '{$arr['ap_layout']}')", $db3);
			}
		}else if($method=="update"){
			$type_res=mysql_query("SELECT name FROM re_type_object WHERE id={$arr['type_id']}", $db1);
			$type=mysql_fetch_assoc($type_res)["name"];
			$query = "UPDATE objects SET sq_all = '{$arr['sq_all']}',  sq_live='{$arr['sq_live']}', sq_k='{$arr['sq_k']}', sq_land='{$arr['sq_land']}', planning='{$arr['planning']}', furn='{$arr['furn']}', tv='{$arr['tv']}', washing='{$arr['washing']}', refrig='{$arr['refrig']}', price='{$arr['price']}', date_last_edit='{$arr['date_last_edit']}', type='".($arr['ap_layout']=="в общежитии" ? "комнату без хозяйки" : $type)."', ap_layout='{$arr['ap_layout']}' WHERE fort_id='{$arr['id']}'";
			mysql_query($query , $db3);
		}
	}
	$res = mysql_query("SELECT var_id from for_delete", $db1);
	while($delete = mysql_fetch_assoc($res)){
		mysql_query("UPDATE objects SET for_delete = 1 WHERE fort_id={$delete['var_id']}", $db3);
		mysql_query("DELETE FROM for_delete WHERE var_id={$delete['var_id']}", $db1);
	}
	header("location: http://sibkv.ru/sync.php");
?>