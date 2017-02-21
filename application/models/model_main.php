<?php

class Model_Main extends Model
{
	public $row_list_ngs = "id, user_id, active, dis, planning, live_point, street, parent_id, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, contact_name, contact_tel, contact_email, inet, furn, tv, washing, refrig, conditioner, favorit, link, photos, review";	

	public $row_list = "v.id, v.user_id, v.active, v.owner, ap_layout, v.parent_id, v.commission, c.company_name, p.name, p.id as people_id, p.second_name, p.phone, dis, planning, live_point, street, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, room_count, coords, deliv_period, prepayment, utility_payment, deposit, furn, tv, washing, refrig, ap_view_date, ap_race_date, status, premium, favorit, ap_view_price, in_black_list, review, residents, wc_type, heating, wash, park, water, sewage, torg, warning, metro_name, distance_to_metro";
	
	public function get_data()
	{
		if(!isset($_SESSION['fio'])) return null;
		
		$_SESSION['search_user_id'] = "site";
		$room_count = "";
		$dis = "";
		$sq=0;
		
		$_SESSION['in_black_list'] = DB::Select('GROUP_CONCAT(people_id) as in_black_list', 're_black_list', "owner_people_id = {$_SESSION['people_id']}")[0]['in_black_list'].",";
		
		$group_inc_user = Get_functions::Get_group_inc_user($_SESSION['fio']);
		
		$condition = " v.active = 1 ";
		$condition .= isset($_GET['live_point']) ? " AND live_point='{$_GET['live_point']}'" :  " AND live_point='Новосибирск'";
		if($_SESSION['group_topic_id'] != 2 && ($_GET["topic_id"]%2!=0 OR !isset($_GET['topic_id']))){
			$hours = isset($_GET['hours']) ? $_GET['hours'] : "24 hour";
			$condition .= " AND DATE_ADD(date_last_edit, INTERVAL {$hours}) >= NOW()";			
		}else if(isset($_GET['hours'])){
			$condition.=" AND DATE_ADD(date_last_edit, INTERVAL {$_GET['hours']}) >= NOW() ";		}else{
			$condition.=" AND DATE_ADD(date_last_edit, INTERVAL 3 day) >= NOW() ";
		}
		if($_SESSION['people_id'] == 1 && isset($_GET["suspicion"]) && $_GET["suspicion"]!='' ){
				$condition.=" AND `suspicion`= ".$_GET["suspicion"]." ";
		}

		if(!isset($_GET["topic_id"]) && ($_SESSION['group_topic_id'] == 3 || $_SESSION['group_topic_id'] == 1)){
			$condition .= " AND topic_id=1 ";
			$_SESSION["topic_id"] = 1;
		}else if(!isset($_GET["topic_id"]) && $_SESSION['group_topic_id'] == 2){
			$condition .= " AND topic_id=2 ";
			$_SESSION["topic_id"] = 2;
		}
		
		if($_GET["topic_id"]%2!=0 && $_SESSION['group_topic_id'] == 2){
			$_SESSION["topic_id"] = 2;
			return null;
		}
		
		if(isset($_GET['view_type']) && $_GET['view_type'] == "map"){
			$_SESSION['limit'] = 50;
			$table = "re_var as v";
			$column = "id, coords";
		}else{
			$table = "re_var as v, re_user as u, re_people as p, re_company as c, re_access_date_end as a";
			$condition .= " AND v.user_id = u.user_id AND u.people_id = p.id AND p.company_id = c.id AND a.company_id = c.id AND rent_date_end > NOW()";
			$column = $this->row_list .", DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`, '%d/%m/%Y %H:%i') as `date_added_format`";
		}

		if(isset($_GET["race_now"]) && $_GET["race_now"] == 'now'){
			$today = date('Y-m-d');
			$condition.=" AND `ap_view_date` <= '{$today}' AND `ap_race_date` <= '{$today}' ";
		}



		//if($_SESSION['people_id'] == 1) print_r("\n\n\n<br><br><br><br>".$condition);
		$condition = Helper::Get_filters($condition);
		//if($_SESSION['people_id'] == 1) print_r("\n\n\n<br><br><br><br>".$condition);
		if(isset($_GET["id"])){
			$condition .= " AND v.id={$_GET['id']} ";
		}

		if($group_inc_user != ""){
			$group_arr = explode(',', $group_inc_user);
			if((count($group_arr)-1) == 1){
				$condition.=" AND (v.user_id!='".$group_arr[0]."' OR v.group=0)";
			}else{
				$num = count($group_arr)-1;
				for($j=0; $j< $num; $j++){
					if($j==0){
						$condition.=" AND (v.user_id!='".$group_arr[$j]."'";
					}else if($j == (count($group_arr)-2)){
						$condition.=" && v.user_id!='".$group_arr[$j]."' OR v.group=0)";
					}else{
						$condition.=" && v.user_id!='".$group_arr[$j]."'";
					}
				}
			}
		}
		
		if(isset($_GET["company_id"]) && $_GET["company_id"]>0){
			$condition .= " AND p.company_id={$_GET['company_id']} ";
		}
		
		$people_ids = DB::Select("GROUP_CONCAT(people_id) as people_ids", "re_white_list", "owner_people_id={$_SESSION['people_id']}")[0]['people_ids'];
		$_SESSION['white_list'] =  DB::Select("GROUP_CONCAT(`user_id`) as user_ids", "re_user", "people_id=".str_replace(',', " or people_id=", $people_ids))[0]["user_ids"];
		
		if(isset($_GET['order'])){
			if($_GET['order']=="while_list"){
				$order = "v.user_id=".str_replace(',', " DESC, v.user_id=", $_SESSION['white_list'])." DESC, ";
			}else{
				$order = $_GET["order"]!="date_last_edit" ? $_GET["order"]." DESC, " : "";
			}				
			$condition.=" ORDER BY ".$order."premium DESC, date_last_edit DESC";
		}else{
			$condition .=" ORDER BY premium DESC, date_last_edit DESC";			
		}
			
		// if($_SESSION['admin']==1)
		// {
			// echo "Select {$column} FROM {$table} where {$condition} <br />";
			// //print_r ($_GET);
		// }
		
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$limit_max = Get_functions::Get_limit_max();
		$limit = Get_functions::Get_limit($limit_max, $page);
		
		
		
		$data = DB::Select($column, $table, $condition." limit {$limit}, {$limit_max}");
		$data[0]['count'] = DB::Select("count(*) as c", $table, $condition)[0]['c'];
		$num = count($data);
		for($j=0; $j<$num; $j++)
		{
	//*		$data[$j]['date_last_edit'] = Translate::month_ru($data[$j]['date_last_edit_format']);
			$data[$j]['date_added'] = Translate::month_ru($data[$j]['date_added_format']);
		}
		
		return $data;
	}
	
	public function parse(){
		$_SESSION['search_user_id'] = "ngs";
		if(($_SESSION["tariff_id"] != '1' OR ($_GET['topic_id'] != '1' && $_GET['topic_id'] != '3' && isset($_GET['topic_id']))) AND (date("Y-m-d", strtotime($_SESSION['sell_date_end'])) >= date("Y-m-d") OR ($_GET['topic_id'] != '2' && $_GET['topic_id'] != '4' && isset($_GET['topic_id'])))){
			$table = "`re_parse`";
			$column = $this->row_list_ngs .", DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -2 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`, '%d/%m/%Y %H:%i') as `date_added_format`";
			if(isset($_GET['topic_id']) && isset($_GET['parent_id'])){
				$condition = "active='1'";
				$condition = Helper::Get_filters($condition);
				
				if(!empty($_GET['photos']) || !empty($_POST['photos']) ){
					$condition = preg_replace("/photos\=\'Есть\ фотографии\.\'/", "( photos like '%фотографии%' OR photos ='да') ", $condition);
				}
				
				if($_SESSION['people_id'] == 3568){
					echo "@@".$_GET['photos']."@@".$condition;
				}
				if($_GET['parent_id'] == 1)$condition.=" AND `type_id`!=18";
				$condition.=" ORDER BY `date_last_edit` DESC";
				
				//if($_SESSION['admin']==1)echo "Select {$column} FROM {$table} where {$condition}";
				
				$page = isset($_GET['page']) ? $_GET['page'] : 1;
				$limit_max = Get_functions::Get_limit_max();
				$limit = Get_functions::Get_limit($limit_max, $page);
				
				$data = DB::Select($column, $table, $condition." limit {$limit}, {$limit_max}");
				$data[0]['count'] = DB::Select("count(*) as c", $table, $condition)[0]['c'];
				$num = count($data);
				for($j=0; $j<$num; $j++)
				{
					$data[$j]['date_last_edit'] = Translate::month_ru($data[$j]['date_last_edit_format']);
					$data[$j]['date_added'] = Translate::month_ru($data[$j]['date_added_format']);
				}


				return $data;
			}
		}else{
			header("Location: http://{$_SERVER['SERVER_NAME']}/?task=main&action=parse&topic_id={$_SESSION['topic_id']}&parent_id=1");
		}
	}
	
	public function pay_parse(){
		//if($_SESSION["pay_parse_date_end"] > date("Y-m-d")){
			//$_SESSION['search_user_id'] = "ngs";
			$condition .= " active=1 ";
			if(!isset($_GET["topic_id"]) && ($_SESSION['group_topic_id'] == 3 || $_SESSION['group_topic_id'] == 1)){
				$condition .= " AND topic_id=1 ";
			}else if(!isset($_GET["topic_id"]) && $_SESSION['group_topic_id'] == 2){
				$condition .= " AND topic_id=2 ";
			}
			
			if(!isset($_GET["parent_id"])){
				$condition .= " AND parent_id=1 ";
			}
			
			if($_SESSION["pay_parse_date_end"] > date("Y-m-d")){
				$condition = Helper::Get_filters($condition)." ORDER BY  `modified` DESC, `date_last_edit` DESC"; //date_last_edit
			}else{
				$condition .= " ORDER BY `modified` DESC, `date_last_edit` DESC";
			}

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$limit_max = Get_functions::Get_limit_max();
			$limit = Get_functions::Get_limit($limit_max, $page);
			

			$data = DB::Select("*", "re_pay_parse", $condition." limit {$limit}, {$limit_max}");
			//echo "SELECT * FROM re_pay_parse WHERE".$condition." limit {$limit}, {$limit_max} <br />";
			$data[0]['count'] = DB::Select("count(*) as c", "re_pay_parse", $condition)[0]['c'];
			if($_SESSION['people_id'] == 3546 )
				print_r($condition);
			return $data;
		//}
	}
	
	public function check_var(){
		if($_GET["var_id"] && $_SESSION){
			if($_GET['table']=="parse"){
				$table = "re_parse as p, re_var as v";
				$condition = "v.id=".$_GET["var_id"]." AND p.topic_id = v.topic_id AND p.parent_id = v.parent_id AND p.street = v.street AND (p.live_point=v.live_point OR p.live_point='') AND ((p.type_id >=19 AND p.type_id <=24 AND v.room_count = p.type_id-18) OR (p.type_id > 24 AND p.type_id=v.type_id) OR (p.type_id=18)) AND p.price BETWEEN v.price - 1000 AND v.price + 1000 ORDER BY date_last_edit DESC";
			}else if($_GET['table']=="pay_parse"){
				$table = "re_pay_parse as p, re_var as v";
				$condition = "v.id=".$_GET["var_id"]." AND p.topic_id = v.topic_id AND p.parent_id = v.parent_id AND p.street = v.street AND (p.live_point=v.live_point OR p.live_point='') AND p.parent_id = v.parent_id AND p.room_count = v.room_count AND p.price BETWEEN v.price - 1000 AND v.price + 1000 ORDER BY date_last_edit DESC";
			}
			if($_GET['table']!="pay_parse" || $_SESSION["pay_parse_date_end"] > date("Y-m-d")){
				$column = "p.*, DATE_FORMAT(DATE_ADD(p.date_last_edit, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(p.date_added,'%d/%m/%Y %H:%i') as `date_added_format`";
				$data_res = DB::Select($column, $table, $condition);
				$num = count($data_res);
				$data_res[0]['count'] = $num;
				for($j=0; $j<$num; $j++)
				{
					$data_res[$j]['date_last_edit'] = Translate::month_ru($data_res[$j]['date_last_edit_format']);
					$data_res[$j]['date_added'] = Translate::month_ru($data_res[$j]['date_added_format']);
				}
			}else{
				$data_res = "Нет доступа";
			}
			
			return $data_res;
		}
	}
	
	public function get_type()
	{
		if($_POST['topic_id'] == 2){
			$query = "SELECT * FROM `re_topic` where ((`parent_id` = '2') or (`parent_id` = '3'))";
		} else {
			$query = "SELECT * FROM `re_topic` where (`parent_id` = '1')";
		}
		echo "<option value=''>Тип обьекта</option>";
		$q_res = mysql_query($query);
		$q_num = mysql_num_rows($q_res);
		for($j=0; $j<$q_num; ++$j) {
			$q_row = mysql_fetch_array($q_res);
			if ($q_row['parent_id'] == '3') {
				echo "<option value='". $q_row['id'] ."'>Новостройка: ". $q_row['name'] ."</option>";
			} else {
				echo "<option value='". $q_row['id'] ."'>". $q_row['name'] ."</option>";
			}
		}			
	}
	
	public function search_street()
	{
		$str = $_POST['street'];
		mysql_set_charset( 'utf8' );
		$r_begin = mysql_query("SELECT * from `re_street` where `name` like '{$str}%' LIMIT 0,10");
		$r_next_word = mysql_query("SELECT * from `re_street` where `name` like '% {$str}%' LIMIT 0,10");
		$r_contains = mysql_query("SELECT * from `re_street` where `name` like '%{$str}%' LIMIT 0,10");
		
		if (mysql_num_rows($r_begin) > 0)
		{	
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_begin))
			{
				echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['name']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}elseif (mysql_num_rows($r_next_word) > 0)
		{	
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_next_word))
			{
				echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['name']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}elseif (mysql_num_rows($r_contains) > 0)
		{	
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_contains))
			{
				echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['name']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}

		mysql_free_result($r_begin);
		mysql_free_result($r_next_word);
		mysql_free_result($r_contains);
	}
	
	public function street_in_parse(){
		$str = $_POST['street'];
		mysql_set_charset( 'utf8' );
		$table = "re_parse";
		if($_POST["action"] == "pay_parse"){
			$table = "re_pay_parse";
		}
		$r_a = mysql_query("SELECT DISTINCT street FROM {$table} WHERE (street LIKE '%{$str}%') LIMIT 0,10");
		$j = 0;
		if (mysql_num_rows($r_a) > 0)
		{
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_a))
			{
				echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['street']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}
		mysql_free_result($r_a);
	}
	
	public function save_limit()
	{
		if($_POST['limit']){
			$_SESSION['limit'] = $_POST['limit'];
		} else {
			$_SESSION['limit'] = 50;
		}
	}
	
	public function save_page()
	{
		if($_POST['PAGE']){
			$_SESSION['PAGE'] = $_POST['PAGE'];
		} else {
			$_SESSION['PAGE'] = 1;
		}
	}
	
	public function refresh()
	{
		unset($_POST, $_SESSION["post"], $_SESSION['condition']);
	}
	
	public function another_view(){
		if(isset($_SESSION["people_id"]) && isset($_POST["id"])){
			$table = "`re_var` INNER JOIN re_user ON re_var.user_id = re_user.user_id INNER JOIN re_people ON re_user.people_id = re_people.id INNER JOIN re_company ON re_people.company_id = re_company.id";
			$column = $this->row_list .", DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`,'%d/%m/%Y %H:%i') as `date_added_format`";
			$data = DB::Select($column, $table, "re_var.id = ".$_POST["id"]);
			return $data;
		}
	}
}
?>