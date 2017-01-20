<?php
class Model_Profile extends Model
{
	public $query_users = "re_user INNER JOIN re_people ON re_user.people_id = re_people.id	INNER JOIN re_company ON re_people.company_id = re_company.id INNER JOIN re_access_date_end ON re_people.company_id = re_access_date_end.company_id";

    private $text_file = "application/includes/txt/rules.txt";

	public function get_data()
	{
		mysql_set_charset( 'utf8' );
		$query = "SELECT * FROM `re_data` where ((`user_id` = '". $_SESSION['user'] ."') AND (`active` = '1'))";
		$q_res = mysql_query($query);
		$data = array();
		$q_num = mysql_num_rows($q_res);
		return $data_res;
	}

    public function get_data_rules()
    {
        if(isset($_SESSION['people_id'])){
            $data = $this->text_file;
            return $data;
        }
    }

	public function get_data_type()
	{
		mysql_set_charset( 'utf8' );
		$topic_search = "";
		$parent_search = "";	
		$active = "";
		$favorites = "";
		$_SESSION['for_open_site'] = DB::Select("for_open_site", "re_user", "user_id={$_SESSION['user']}")[0]["for_open_site"];
		$_SESSION['post'] = $_GET;
		$_SESSION["topic_id"] = $_POST["topic_id"];
		$colums_var = "re_var.id, re_var.user_id, re_var.fortuna_id as tid, re_var.photo, re_user.parent as user_parent, access_var, re_var.active, re_var.owner, ap_layout, re_var.parent_id, re_var.rent_type, re_var.commission, col_date, re_company.company_name, re_people.name, re_people.id as people_id, re_people.second_name, re_people.phone, dis, planning, live_point, street, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, room_count, coords, deliv_period, prepayment, utility_payment, deposit, furn, tv, washing, refrig, ap_view_date, ap_race_date, status, premium, favorit, ap_view_price, in_black_list, review, residents, hidden_text, DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`,'%d/%m/%Y %H:%i') as `date_added_format`,  wc_type, heating, wash, water, sewage, torg";
		
		if (!isset($_POST["recipients_ids"])){
			$r=0;/*счетчики повторов*/
			$p=0;
			$d=0;
			$s=0;
			$t=0;
			if($_GET['action'] != "favorites_parse" && $_GET['action'] != "favorites_pay_parse"){
				$condition_var = "(".(isset($_GET['active']) ? " re_var.active = '".$_GET['active']."'" : " re_var.active  = '1'").")";
			}
			
			if($_GET['action'] != "favorites" && $_GET['action'] != "favorites_parse" && $_GET['action'] != "favorites_pay_parse"){
				if($_SESSION['access_var']==1){
					$condition_var .= " AND company_id = {$_SESSION['company_id']} ";
				}else{
					$condition_var .= " AND (re_user.user_id='".$_SESSION['user']."' OR re_user.parent='".$_SESSION['user']."')";
				}		
			}else if($_GET['action'] != "favorites_parse" && $_GET['action'] != "favorites_pay_parse"){
				$condition_var .= " AND favorit like '%|".$_SESSION['people_id']."|%'";
			}else{
				$condition_var .= " favorit like '%|".$_SESSION['people_id']."|%'";
			}
							
			foreach($_GET as $k => $v){
				if(!ereg("Выбрано", $v) && $k!="task" && $k!="action" && $k!="active" && $k!="page" && $v!="all" && $k!="res" && $k!="order"){
					if (ereg('room_count', $k) && $r==0 && $v!=""){
						if($_GET['action']=="favorites_parse"){$condition_var.=" AND (`type_id`='".($v+18)."'";}
						else{$condition_var.=" AND (`room_count`='".$v."'";}	$r++;						
					}else if(ereg('type_id', $k) && $v!=""){
						if($t==0){$type_id.="type_id={$v}"; $t++;}
						else{$type_id.="||{$v}"; $t++;}
					}else if(ereg('room_count', $k) && $v!=""){
						if($_GET['action']=="favorites_parse"){$condition_var.=" OR `type_id`='".($v+18)."'";}
						else{$condition_var.=" OR `room_count`='".$v."'";}
					}else if(ereg('price', $k) && $p==0){
						if ($r != 0){$condition_var.=")"; $r = 0;}
						if ($v != ""){$condition_var.=" AND (`price` BETWEEN ".str_replace(' ', '', $v); $p++;}
						else{$condition_var.=" AND (`price` BETWEEN 1"; $p++;}
					}else if(ereg('price', $k)){
						if($v!=""){$condition_var.=" AND ".str_replace(' ', '', $v).")";}
						else{$condition_var.=" AND 999999999)";}
					}else if(ereg('dis', $k) && $d==0){
						if($v!=""){$condition_var.=" AND (`dis`='".$v."'"; $d++;}
					}else if(ereg('dis', $k)){
						if($v!=""){$condition_var.=" OR `dis`='".$v."'";}
					}else if(ereg('street', $k) && $s==0){
						if ($d != 0){$condition_var.=")";$d=0;}
						if($v!=""){$condition_var.=" AND (`street`='".$v."'"; $s++;}
					}else if(ereg('street', $k)){
						if($v!=""){$condition_var.=" OR `street`='".$v."'";}
					}else{
						if ($s != 0){$condition_var.=")";$s=0;}
						if ($v != ""){$condition_var.=" AND `".$k."`='".$v."'";}
					}					
				}
			}
			if($t>0){
				$condition_var.= " AND (".(str_replace("||", " OR type_id=", $type_id)).")";
			}
		}else{
			$condition_var = " (re_var.id=".str_replace(',', " OR re_var.id=", $_POST["recipients_ids"].")");
		}
		$limit = $_GET['page']>0 ? ($_GET['page']-1) * 100 : 0;
		if($_GET['action'] != "favorites_pay_parse"){
			$table = "`re_var` INNER JOIN re_user ON re_var.user_id = re_user.user_id INNER JOIN re_people ON re_user.people_id = re_people.id INNER JOIN re_company ON re_people.company_id = re_company.id";
			$row_list_ngs = "id, user_id, active, dis, planning, live_point, street, parent_id, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, contact_name, contact_tel, contact_email, inet, furn, tv, washing, refrig, conditioner, favorit, link, photos, review";		
			if($_GET['action'] != "favorites_parse"){
				$limit = $_GET['limit'] == "all" && $_GET['active']==1 ? "" : "LIMIT {$limit}, 100";
				$order = $_GET['order'] == "" ? "date_last_edit DESC" : "{$_GET['order']} DESC";
				$data_res = DB::Select($colums_var, $table, $condition_var." ORDER BY premium DESC, {$order} {$limit}");
				$count = count($data_res);
				$data_res[0]['count'] = DB::Select("count(*) as c", $table, $condition_var)[0]['c'];
			}else{
				$data_res = DB::Select($row_list_ngs, "re_parse", $condition_var." ORDER BY date_last_edit DESC LIMIT {$limit}, 100");
				$count = count($data_res);
			}
			for($j=0; $j<$count; $j++)
			{
				//$data_res[$j]['date_last_edit'] = Translate::month_ru($data_res[$j]['date_last_edit_format']);
				$data_res[$j]['date_added'] = Translate::month_ru($data_res[$j]['date_added_format']);
			}
			unset($count);		
		}else{
			$data_res = DB::Select("*", "re_pay_parse", $condition_var." ORDER BY date_last_edit DESC LIMIT {$limit}, 100");
		}
		return $data_res;		
	}
	
	public function newvar()
	{
		
	}
	
	public function newvar_old()
	{
		$data = 2;
		return $data;
	}
	
	public function savevar_old()
	{
		if($_POST) {
			$data = $_POST;
			$data['photoes'] = $_FILES;
			
		}
		return $data;
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
				//echo "<li id='str{$j}' onclick='addStreet({$j})'>{$row_a['name']}</li>";
				echo "<li id='str{$j}' onclick='setStreet({$j}, \"{$row_a['name']}\")'>{$row_a['name']}</li>";
				
				$j = $j+1;
			}
			echo "</ul>";
		}elseif (mysql_num_rows($r_next_word) > 0)
		{	
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_next_word))
			{
				echo "<li id='str{$j}' onclick='setStreet({$j}, \"{$row_a['name']}\")'>{$row_a['name']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}elseif (mysql_num_rows($r_contains) > 0)
		{	
			echo "<ul id='str_list'>";
			$j = 0;
			while ($row_a = mysql_fetch_array($r_contains))
			{
				echo "<li id='str{$j}' onclick='setStreet({$j}, \"{$row_a['name']}\")'>{$row_a['name']}</li>";
				$j = $j+1;
			}
			echo "</ul>";
		}

		mysql_free_result($r_begin);
		mysql_free_result($r_next_word);
		mysql_free_result($r_contains);
	}
	
	public function search_city()
	{
		$name = $_POST['name'];		
		mysql_set_charset( 'utf8' );
		$q_a = 'SELECT * from `re_city` where (`name` like "%'. $name .'%") LIMIT 0,10';
		$r_a = mysql_query($q_a);
		$j = 0;
		if (mysql_num_rows($r_a) > 0)
			{	
				echo '<ul id="str_list">';
				$j = 0;
				while ($row_a = mysql_fetch_array($r_a))
					{
						echo '<li id="str'. $j .'" onclick="setCity('. $j .', \''.$row_a['name'].'\')" style="line-height: 1;">'
								.$row_a['name'];
						if($row_a["region"]!=""){
							echo '<br><span style="color: #969696; font-size: 12px;">р-н.:'.$row_a["region"].'</span>';
						}
						echo '</li>';
							$j = $j+1;
					}
				echo '</ul>';
			}
		mysql_free_result($r_a);
	}
	
	public function search_an()
	{
		$an = $_POST['an'];
		if($_SESSION['admin']==1){
			$q_a = "SELECT c.id, c.company_name FROM re_company as c, re_access_date_end as a, re_people as p, re_user as u WHERE p.company_id = c.id AND u.people_id=p.id AND c.id = a.company_id AND a.rent_date_end > now() AND ((c.company_name like '{$an}%') OR (u.login like '{$an}%')) GROUP BY c.company_name";
		}else{
			$q_a = 'SELECT c.id, c.company_name FROM re_company as c, re_access_date_end as a WHERE c.id = a.company_id AND a.rent_date_end > now() AND (c.company_name like "'. $an .'%")';
		}
		$r_a = mysql_query($q_a);
		$j = 0;
		if (mysql_num_rows($r_a) > 0)
			{	
				echo '<ul id="str_list">';
				$j = 0;
				while ($row_a = mysql_fetch_array($r_a))
					{
						echo '<li onclick="$(\'[data-name=an-list]\').val($(this).text()); $(\'[name=company_id]\').val('.$row_a['id'].'); $(\'.an_list\').slideUp()">'. $row_a['company_name'] .'</li>';
							$j = $j+1;
					}
				echo '</ul>';
			}
		mysql_free_result($r_a);
	}
	
	
	
	public function savevar()
	{
		if ($_POST) {
			$date_added = date('Y-m-d');
			$date_last_edit = date('Y-m-d H:i:s');
			$prem_count = Get_functions::Get_premium_balance();
			foreach($_POST as $k => $v){
				//$v = $k=="premium" && $v==1 && $prem_count>0 ? 1 : 0;
				$v = $k=="price" ? preg_replace('/\D/', '', $v) : $v;
				if($k == 'text'){
					$column.="`suspicion`, ";
					$values.="'1', ";	
					$values_update.="`suspicion`=".Get_functions::Get_suspicion_text($v).", ";	
					if(strpos($v, "<") !== false && strpos($v, ">") !== false) $v ="";
				}

				$column.="`".$k."`, ";
				$values.="'".$v."', ";
				$values_update.="`".$k."`='".$v."', ";
			}
			$column.="`user_id`, `active`, `date_added`, `date_last_edit`";
			$values.="'".$_SESSION['user']."', '1', '".$date_added."', '".$date_last_edit."'";
			$condition = "`user_id` = '".$_SESSION['user']."' AND `date_last_edit` = '".$date_last_edit."'";
			$values_update.="`date_last_edit`='".$date_last_edit."'";
			
			if(isset($_POST['id'])){
				DB::Update("`re_var`", $values_update.", date_added = '".date('Y-m-d')."'", "`id`=".$_POST['id']);
				$var_id = $_POST['id'];				
				DB::Delete("re_review", "var_id=".$_POST['id']);
				DB::Update("re_var", "review=0", "id=".$_POST['id']);
			}else{
				DB::Insert("`re_var`", $column, $values);	
				$cur_var = DB::Select("`id`", "`re_var`", $condition);					
				$var_id = $cur_var[0]['id'];
			}
			if ($var_id) {
				$_SESSION['cur_var'] = $var_id;
				if (file_exists($_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['people_id'])) {
					@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['people_id'] .'/'. $var_id, 0777);
				} else {
					@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['people_id'], 0777);
					@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['people_id'] .'/'. $var_id, 0777);
				}
			}
		}
	}	
	
	public function edit_group()
	{
		$data = "Изменение группы прошло не удачно.";
		if(isset($_POST['black_group']) && $_SESSION['fio']){
			$my_group = mysql_fetch_assoc(mysql_query("SELECT id FROM re_group WHERE group_owner = '{$_SESSION['fio']}'"))["id"];
			if(intval($my_group) > 0){
				DB::Update("re_group", "black_group='{$_POST['black_group']}' , `hide_black_group` = '{$_POST['hide_black_group']}' ", "id='".$my_group."'");
				$data = '1';
			}else{
				DB::Insert("re_group", "group_owner, black_group", "'".$_SESSION['fio']."', '".$_POST['black_group']."'");
				$data = '1';
			}
		}
		echo $data;
	}
	
	public function get_data_edit()
	{
		if ($_GET['id']) {
			$user_var = DB::Select("v.id", "re_var as v, re_user as u", "v.id=".$_GET['id']." AND v.user_id = u.user_id AND (v.user_id=".$_SESSION['user']." OR u.parent = ".$_SESSION['user']." OR (v.user_id = {$_SESSION['parent']} AND u.access_var=1))");
			if(isset($user_var[0]['id'])){
				$condition = "v.id=".$_GET['id']." AND v.user_id = u.user_id AND (v.user_id=".$_SESSION['user']." OR u.parent = ".$_SESSION['user']." OR (v.user_id = {$_SESSION['parent']} AND u.access_var=1))";
				$data_res = DB::Select("v.*", "re_var as v, re_user as u", $condition)[0];
				if($data_res['user_id']!=$_SESSION['user']){
					$data_res['photo_close']=1;
				}
				$_SESSION['cur_var'] = $_GET['id'];
			}else{
				header("Location: http://". $_SERVER['SERVER_NAME']);
			}
		} else {
			$data_res = "Ошибка передачи данных.";
		}
		return $data_res;
	}
		
	public function deletevar()
	{
		if(isset($_POST['var_ids']) && isset($_SESSION['user'])) {
			$ids_array = explode(',', $_POST['var_ids']);
			$count = count($ids_array) == 1 ? 2 : count($ids_array);
			for($i=0; $i<($count-1); $i++){
				if($count == 2){
					$condition_var = "`id`=".$ids_array[$i];
					$condition_pf = "`var_id`=".$ids_array[$i];
				}else if($i == 0 && $count>2){
					$condition_var = "(`id`=".$ids_array[$i];
					$condition_pf = "(`var_id`=".$ids_array[$i];
				}else if($i == $count-2 && $count>2){
					$condition_var .= " OR `id`=".$ids_array[$i].")";
					$condition_pf .= " OR `var_id`=".$ids_array[$i].")";
				}else{
					$condition_var .= " OR `id`=".$ids_array[$i];
					$condition_pf .= " OR `var_id`=".$ids_array[$i];
				}
			}			
			$user_var_count = DB::Select("COUNT(*)", "`re_var`", $condition_var." AND `user_id`='".$_SESSION['user']."'")[0]['COUNT(*)'];
			$director_count = DB::Select("COUNT(*)", "re_user", "parent='{$_SESSION['user']}'")[0]['COUNT(*)'];
			if($user_var_count == $count-1 || $director_count>0 || $_SESSION['admin']==1){
				$photos_array = DB::Select("*", "`re_photos`", $condition_pf);
				for($j=0; $j<count($photos_array); ++$j) {
					unlink($_SERVER['DOCUMENT_ROOT'] .'/images/'. $photos_array[$j]['people_id'] .'/'.  $photos_array[$j]['var_id'] .'/'.  $photos_array[$j]['photo']);
					unlink(''. $_SERVER['DOCUMENT_ROOT'] .'/images/'. $photos_array[$j]['people_id'] .'/'.  $photos_array[$j]['var_id'] .'/main.jpg');
					rmdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $photos_array[$j]['people_id'] .'/'.  $photos_array[$j]['var_id']);
				}
				DB::Insert("`for_delete`", "var_id", "'{$_POST['var_ids']}'");
				DB::Delete("`re_photos`", $condition_pf);
				DB::Delete("`re_var`", $condition_var);
				DB::Delete("`re_favorites`", $condition_pf);
				DB::Delete("`re_review`", $condition_pf);
				$data = "Вариант удален. <br />
				<h2><a href='javascript:history.go(-1)'>Назад</a></h2>";
			}
		} else {
			$data = "Ошибка удаления.";
		}
		return $data;
	}
	
	public function archive()
	{
		if($_POST['id'] && $_SESSION['user']) {
			$user_var_count = DB::Select('count(*) as count', "re_var as v, re_company as c, re_people as p, re_user as u", "v.user_id=u.user_id AND u.people_id=p.id AND c.id=p.company_id AND v.id=".$_POST['id']." AND c.id='".$_SESSION['company_id']."'")[0]['count'];
			if($user_var_count>0 || $_SESSION["admin"]==1){
				DB::Update("`re_var`", "`active`='".$_POST['active']."', premium = 0", "`id`=".$_POST['id']);
				DB::Insert("`for_delete`", "var_id", "'{$_POST['id']}'");
			}
			$data = "Вариант перемещен.";
		} else {
			$data = "Ошибка перемещения.";
		}
		return $data;
	
	}
	
	public function archive_list()
	{	
		mysql_set_charset( 'utf8' );
		$topic_filter = "`topic_id` = '".$_GET['topic_id']."'";
		$parent_filter = "`parent_id` = '".$_GET['parent_id']."'";
		$query = "SELECT *, DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit` FROM `re_var` where ((`active` = '0') 
				AND (`user_id` = '". $_SESSION['user'] ."')
				AND (".$topic_filter.")
				AND (".$parent_filter."))";
			$q_res = mysql_query($query);
				
			$q_num = mysql_num_rows($q_res);
				for($j=0; $j<$q_num; ++$j) {
					$q_row = mysql_fetch_array($q_res);					
					$data_res[] = $q_row;				
					
					if ($data_res[$j]['date_last_edit']){
						$data_res[$j]['date_last_edit'] = Translate::month_ru($data_res[$j]['date_last_edit']);
					}	
				}
	
	return $data_res;	
	}
	
	public function change_profile()
	{	
		mysql_set_charset( 'utf8' );
		$condition = "`parent` = '". $_SESSION['user'] ."' 
					AND user_id != '". $_SESSION['user'] ."' 
					AND `archive` = '0' ORDER BY login";
		$data_res = DB::Select("*", $this->query_users, $condition);
		return $data_res;
	}
	
	public function change_user(){
		if($_POST && $_SESSION['parent'] == '0'){
			$cur_date = date("Y-m-d H:i:s");
			foreach($_POST as $k=>$v){				
				if(ereg('ac-', $k)){
					$k = explode('-', $k)[1];
					$values_access_date_end.= "`".$k."`='".$v."', ";
				}else if(ereg('co-', $k)){
					$k = explode('-', $k)[1];
					$values_company.= "`".$k."`='".$v."', ";
				}else if(ereg('us-', $k)){
					$k = explode('-', $k)[1];
					$values_user.= "`".$k."`='".$v."', ";
				}else if(ereg('pe-', $k)){
					if(ereg('pe-phone_addon', $k))
					{
						$phone_addon.=$v."||";
					}else{
						$k = explode('-', $k)[1];
						$values_people.= "`".$k."`='".$v."', ";
					}
				}else if(ereg('ad-', $k)){
					if(ereg('ad-rent_ip-', $k)){
						$k = explode('-', $k);
						DB::Update("re_addresses", "`ip`='".$v."'", "id=".$k[2]);
					}
				}
			}
			if($values_access_date_end){
				DB::Update("re_access_date_end", substr($values_access_date_end, 0, -2), "company_id=".$_POST['company_id']);		
			}
			if($values_company){
			DB::Update("re_company", substr($values_company, 0, -2), "id=".$_POST['company_id']);		
			}
			if($values_user){
				DB::Update("re_user", substr($values_user, 0, -2), "user_id=".$_POST['user_id']);		
			}
			if($values_people || $phone_addon){
				$people_id = Get_functions::Get_people_id_by_user_id($_POST['user_id']);
				$values_people.= "`phone_addon`='".($phone_addon == "'||'" ? "NULL" : $phone_addon)."', `date_edit`='".$cur_date."'";
				DB::Update("re_people", $values_people, "`id` = ".$people_id);
			}
			if($_POST["co-without_vip"] == 1){
				$user_id = DB::Select("GROUP_CONCAT(user_id) as user_ids", "re_user as u, re_people as p", "u.people_id = p.id AND p.company_id = ".$_POST['company_id'])[0]["user_ids"];
				DB::Update("re_var", "status=1", "user_id=".(str_replace(",", " or user_id=", $user_id)));
			}
			echo 1;
		}
	}
	
	public function get_template()
	{	
		$data_res['type_id'] = $_POST['type_id'];
		$data_res['topic_id'] = $_POST['topic_id'];
		
		return $data_res;
	}
	
	public function save_profile() 
	{	
		$cur_date = date("Y-m-d H:i:s");
		if((!$_POST['submit']) AND (!$_POST['action'])) {
			$data = 'no';
		} else if ($_POST['action'] == 'new') {
			$fio = Get_functions::Get_fio_by_pnone($_POST['phone']);
			if($fio['surname'] == "" && $fio['name'] == ""){			
				$people_id = Get_functions::Get_people_id_by_login($_POST['login']);
				$fio = Get_functions::Get_fio_by_people_id($people_id);
				if($people_id == ""){
					$query = "SELECT * FROM `re_people` WHERE `surname` LIKE '%".$_POST['surname']."%' AND `name` LIKE '%".$_POST['name']."%' AND `second_name` LIKE '%".$_POST['second_name']."%' AND `date_dismiss` = '0000-00-00 00:00:00'";
					$peoples = mysql_query($query);
					$company_name = Get_functions::Get_company_name_by_id(mysql_fetch_assoc($peoples)['company_id']);
					$peoples_num = mysql_num_rows($peoples);
					if($peoples_num == 0){			
						mysql_query("INSERT INTO `re_people` (`surname`, `name`, `second_name`, `email`, `phone`, `company_id`, `date_reg`) VALUES ('".$_POST['surname']."', '".$_POST['name']."', '".$_POST['second_name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_SESSION['company_id']."', '".$cur_date."')");			
						$query = "SELECT `id` FROM `re_people` WHERE `surname` = '".$_POST['surname']."' AND `name` = '".$_POST['name']."' AND `second_name` = '".$_POST['second_name']."' AND `email` = '".$_POST['email']."' AND `phone` = '".$_POST['phone']."' AND `company_id` = '".$_SESSION['company_id']."' AND `date_reg` = '".$cur_date."'";			
						$people_id = mysql_fetch_assoc(mysql_query($query))['id'];
											
						$query = "INSERT INTO `re_user` (`login`, `nickname`, `active`, `people_id`, `password`, `parent`, `group_topic_id`, `ip_rent`, `street_rent`, `house_rent`, `office_rent`, `comment_rent`, `ip_sell`, `street_sell`, `house_sell`, `office_sell`, `comment_sell`) VALUES ('". $_POST['login'] ."', '". $_POST['nickname'] ."', '".$_SESSION['admin']."', '".$people_id."', '". $_POST['password'] ."', '".$_SESSION['user']."', '". $_SESSION['group_topic_id'] ."', '".$_POST['ip_rent']."', '".$_POST['street_rent']."', '".$_POST['house_rent']."', '".$_POST['office_rent']."', '".$_POST['comment_rent']."', '".$_POST['ip_sell']."', '".$_POST['street_sell']."', '".$_POST['house_sell']."', '".$_POST['office_sell']."', '".$_POST['comment_sell']."')";			
						$res = mysql_query($query);
						
						if ($_SESSION['admin'] == "0"){
							$query = "SELECT `user_id` FROM re_user INNER JOIN re_people ON re_user.people_id = re_people.id WHERE `login` = '".$_POST['login']."' AND `active` = '0' AND `people_id` = '".$people_id."' AND `date_reg` = '".$cur_date."'";
							$user_id = mysql_fetch_assoc(mysql_query($query))['user_id'];
							
							mysql_query("INSERT INTO `re_applications` (`user_id`, `people_id`, `company_id`, `date`, `comment`) VALUES ('".$user_id."', '".$people_id."', '".$_SESSION['company_id']."', '".$cur_date."', 'Новый сотрудник')");
						}
						echo "1";
					}else{echo "Данный риелтер работает в агенстве '".$company_name."'";}
				}else{echo "Логин '".$_POST['login']."' прикреплён за '".$fio."'";}
			}else{echo "Телефон '".$_POST['phone']."' прикреплён за '".$fio['surname']." ".$fio['name']." ".$fio['second_name']."'";}
		}
	}
		
	public function add_favorites()
	{
		if($_POST['var_id'] && isset($_SESSION['people_id']))
		{
			if(isset($_POST["ngs"])){
				$table = "re_parse";
			}else if(isset($_POST["pay_parse"])){
				$table = "re_pay_parse";
			}else{
				$table = "re_var";
			}
			$result = DB::Update($table, 'favorit=concat(favorit, "|'.$_SESSION['people_id'].'|")', 'id='.$_POST['var_id']);
			unset($table, $_POST);
			return $result;
		}
		else{
			return "Попытка не удалась";
		}
	}
	
	public function remove_from_favorites(){
		if(isset($_POST['favorit_str']) && isset($_POST['var_id']) && isset($_SESSION['people_id'])){
			if(isset($_POST["ngs"])){
				$table = "re_parse";
			}else if(isset($_POST["pay_parse"])){
				$table = "re_pay_parse";
			}else{
				$table = "re_var";
			}
			//$favoritNew = str_replace('|'.$_SESSION['people_id'].'|', "", $_POST['favorit_str']);
			DB::Update($table, 'favorit=REPLACE(favorit, "|'.$_SESSION['people_id'].'|", "")', 'id='.$_POST['var_id']);
			unset($table);
		}
	}
	
	public function var_extend()
	{
		if($_POST['var_ids'] && isset($_SESSION['user']))
		{
			$ids_array = explode(',', $_POST['var_ids']);
			$count = count($ids_array) == 1 ? 2 : count($ids_array);
			for($i=0; $i<($count-1); $i++){
				if($count == 2){
					$condition = "`id`=".$ids_array[$i];					
				}else if($i == 0 && $count>2){
					$condition = "(`id`=".$ids_array[$i];					
				}else if($i == $count-2 && $count>2){
					$condition .= " OR `id`=".$ids_array[$i].")";					
				}else{
					$condition .= " OR `id`=".$ids_array[$i];
				}
			}
			//$user_var_count = DB::Select("COUNT(*)", "`re_var`", $condition." AND `user_id`='".$_SESSION['user']."'")[0]['COUNT(*)'];
			//if($user_var_count == $count-1){
				$date = date("Y-m-d H:i");
				$values = "`date_last_edit`='". $date ."'";
				DB::Update("`re_var`", $values, $condition." AND DATE_ADD(date_last_edit, INTERVAL 1 HOUR) <= '".$date."'");
				return "Ok";
			//}
		}	
		else{
			return "Попытка не удалась";
		}
	}
	
	public function delete_profile()
	{
		$date = date("Y-m-d H:i");
		if($_SESSION['parent'] == 0 || $_SESSION['admin'] == 1){
			if(($_SESSION['parent'] == '0') AND ($_GET['user_id'])){
				if($_GET['user_id'] == $_SESSION["user"]){
					return false;
				}
				$people_id = Get_functions::Get_people_id_by_user_id($_GET['user_id']);			
				DB::Update("re_people", "`date_dismiss`='".$date."'", "id=".$people_id);
				DB::Update("re_addresses", "active=0, archive=1", "people_id=".$people_id);
				DB::Delete("re_user", "`user_id`='". $_GET['user_id'] ."'");
				DB::Update("re_var", "active = 0, owner_people_id='".$people_id."'", "user_id='". $_GET['user_id'] ."'");
				DB::Update("re_applications", "`archive` = '1'", "user_id='".$_GET['user_id']."'");
				DB::Insert("re_applications", "user_id, people_id, company_id, date, comment", "'".$_SESSION["user"]."', '".$_SESSION['people_id']."', '".$_SESSION['company_id']."', '".$date."', 'Из АН уволен сотрудник. Пересмотрите абонентку.'");
				DB::Delete("re_session", "people_id=".$people_id);
			} else {
				header("Location: http://". $_SERVER['SERVER_NAME']);
			}
		}
	}
	
	public function profile_to_archive()
	{
		$date = date("Y-m-d H:i");
		if(($_SESSION['parent'] == '0') AND ($_GET['user_id'])){
			$people_id = Get_functions::Get_people_id_by_user_id($_GET['user_id']);
			mysql_query("UPDATE `re_people` SET `date_dismiss` = '".$date."' where `id` = '".$people_id."'");
			
			$query = "UPDATE `re_user` SET `archive` = '1', `active` = '0' where `user_id` = '". $_GET['user_id'] ."'";
			mysql_query($query);
			
			$query = "SELECT `id` FROM `re_applications` WHERE `user_id` = ".$_GET['user_id'];
			$res = mysql_query($query);
			if(mysql_num_rows($res)>0)
			{
				mysql_query("UPDATE `re_applications` SET `archive` = '1' WHERE `id` = ".mysql_fetch_assoc($res)['id']);
			}
		} else {
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function create_login()
	{
		if(($_SESSION['admin'] == 1) AND ($_POST['us-login'])) {
			$cur_date = date("Y-m-d H:i:s");
			foreach($_POST as $k=>$v){
				if(ereg('co-', $k)){
					$k = explode('-', $k)[1];
					$column_company.= "{$k}, ";
					$values_company.= "'{$v}', ";
				}else if(ereg('us-', $k)){
					$k = explode('-', $k)[1];
					$column_user.= "{$k}, ";
					$values_user.= "'{$v}', ";
				}else if(ereg('pe-', $k)){
					$k = explode('-', $k)[1];
					$column_people.= "{$k}, ";
					$values_people.= "'{$v}', ";
					$for_search.= "{$k}='{$v}' AND ";
				}
			}
			if(isset($values_company)){
				DB::Insert("re_company", "{$column_company} date_company_reg", "{$values_company} '{$cur_date}'");
			}
			
			$query_company = "SELECT id FROM re_company WHERE company_name = '".$_POST['co-company_name']."' AND date_company_reg = '".$cur_date."'";
			$company_id = mysql_fetch_assoc(mysql_query($query_company))['id'];			
			
			$rent_date_end = $_POST['rent_date_end'] ? 
			date("Y-m-d H:i:s", strtotime($_POST['rent_date_end'])) : "";
			
			$sell_date_end = $_POST['sell_date_end'] ? 
			date("Y-m-d H:i:s", strtotime($_POST['sell_date_end'])) : "";	
			
			mysql_query("INSERT INTO re_access_date_end (rent_date_end , sell_date_end, company_id) VALUES ('".$rent_date_end."', '".$sell_date_end."', '".$company_id."')");
			
			for($j=1; $j<=4; $j++)
			{
				$phone_addon .= $_POST['phone_addon'.$j] ? $_POST['phone_addon'.$j]."||" : "";
			}
			
			if(isset($values_people)){
				DB::Insert("re_people", "{$column_people} phone_addon, company_id, date_reg", "{$values_people} '{$phone_addon}', '{$company_id}', '{$cur_date}'");
			}
			
			$people_id = DB::Select("id", "re_people", "{$for_search} company_id='{$company_id}' AND date_reg='{$cur_date}'")[0]["id"];
			
			DB::Insert("re_addresses", "people_id, active, sell, rent, ip, comment", "'{$people_id}', '1', '1', '1', '{$_POST['ip']}', '{$_POST['comment']}'");
			
			if(isset($values_user)){
				DB::Insert("re_user", "{$column_user} people_id", "{$values_user} {$people_id}");
			}
			$people_dir = $_SERVER['DOCUMENT_ROOT'].'/images/'.$people_id;
			@mkdir($people_dir, 0777);
			
			if($_POST['old-people-id']>0){
				$old_people = DB::Select("count(*) as c", "re_people", "id={$_POST['old-people-id']} AND surname='{$_POST['pe-surname']}' AND name='{$_POST['pe-name']}' AND surname='{$_POST['pe-surname']}'")[0]["c"];
				if($old_people>0){
					$user = DB::Select("user_id", "re_user", "people_id=".$people_id)[0]["user_id"];
					DB::Update("re_var", "user_id={$user}, owner_people_id=null", "owner_people_id=".$_POST['old-people-id']);
					DB::Update("re_photos", "people_id=".$people_id, "people_id=".$_POST['old-people-id']);
					$old_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'.$_POST['old-people-id'];
					if(file_exists($old_dir)){
						if ($objs = glob($old_dir."/*")){
							foreach($objs as $obj) {
								if(is_dir($obj)){
									$new_dir = str_replace("/images/".$_POST['old-people-id'], "/images/".$people_id, $obj);
									rename($obj, $new_dir);
								}
							}
						}
						Helper::removeDirectory($old_dir);
					}
				}
			}
			
			@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id, 0777);
			try{
				$document_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/documents';
				@mkdir($document_dir, 0777);
				$document_file = PhpThumbFactory::create($_FILES['passport']['tmp_name']);
				$document_file->resize(600);
				$document_file->save($document_dir."/document.jpg");
			}catch(Exception $e){}
			try{
				$user_face_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/user_face';
				@mkdir($user_face_dir, 0777);								
				$face_file = PhpThumbFactory::create($_FILES['face']['tmp_name']);
				$face_file->resize(600);
				$face_file->save($user_face_dir."/face.jpg");
			}catch(Exception $e){}
			
			header("Location: http://". $_SERVER['SERVER_NAME']."/?task=admin&action=user_list");
			return $data;
		} else {
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function show_formnew()
	{
		
	}
	
	public function add_phone(){
		if($_POST['phone'] && $_POST['user']){
			$phone = $_POST['phone'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			$query = "SELECT phone_addon FROM re_people WHERE `id` = '".$people_id."'";
			$phones_in_db = mysql_fetch_assoc(mysql_query($query));
			if($phones_in_db['phone_addon'] != ""){$phone = $phone."||".$phones_in_db['phone_addon'];}
			$query_add = "UPDATE re_people SET phone_addon = '".$phone."', `date_edit` = '".date("Y-m-d H:i:s")."' WHERE `id` = '".$people_id."'"; 
			$_SESSION['phone_addon'] = $phone;
			mysql_query($query_add);
		}
	}

	
	public function add_email_work(){
		if($_POST['email'] && $_POST['user']){
			$email = $_POST['email'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			$query_update = "UPDATE re_people SET email_work = '".$email."', `date_edit` = '".date("Y-m-d H:i:s")."' WHERE `id` = '".$people_id."'"; 
			$_SESSION['email_work'] = $email;
			mysql_query($query_update);
		}
	}

	public function add_email_pass(){
		if($_POST['pass'] && $_POST['user']){
			$pass = $_POST['pass'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			$query_update = "UPDATE re_people SET email_pass = '".$pass."', `date_edit` = '".date("Y-m-d H:i:s")."' WHERE `id` = '".$people_id."'"; 
			$_SESSION['email_pass'] = $email;
			mysql_query($query_update);
		}
	}


	public function set_photo_limit(){
		if($_POST['photo_limit'] && $_POST['user']){
			$photoLimit = $_POST['photo_limit'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			$query_update = "UPDATE re_people SET photo_limit = '".$photo_limit."', `date_edit` = '".date("Y-m-d H:i:s")."' WHERE `id` = '".$people_id."'"; 
			$_SESSION['photo_limit'] = $photoLimit;
			mysql_query($query_update);
		}
	}


	
	public function add_ip(){
		if($_POST['ip'] && $_POST['user'] && $_POST['rentOrSell']){
			$ip = $_POST['ip'];
			
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);
			DB::Insert("re_addresses", "people_id, `active`, `".$_POST['rentOrSell']."`, `ip`", "'".$people_id."', '1', '1', '".$_POST['ip']."'");
			$id = DB::Select("`id`", "re_addresses", "people_id = '".$people_id."' AND `".$_POST['rentOrSell']."` = '1' AND `ip`='".$_POST['ip']."'")[0]['id'];
			echo $id;
		}
	}
	
	public function phone_column_new($phone_column, $people_id, $phone){
		$phones_in_db = DB::Select($phone_column, "re_people", "`id`='".$people_id."'")[0];
		$phones_in_db_array = explode('||', $phones_in_db[$phone_column]);	
		$phone_column_new = "";
		for($i=0; $i<count($phones_in_db_array); $i++)
		{
			if($phones_in_db_array[$i] != $phone)
			{
				$phone_column_new.=$phones_in_db_array[$i]."||";
			}
		}	
		$phone_column_new = substr($phone_column_new, 0, -2);
		return $phone_column_new;
	}
	
	public function delete_phone(){
		if($_POST['phone'] && $_POST['user']){
			$cur_date = date("Y-m-d H:i:s");	
			$phone = $_POST['phone'];
			$people_id = Get_functions::Get_people_id_by_user_id($_POST['user']);			
			$phone_addon_new = $this->phone_column_new("phone_addon", $people_id, $phone);			
			if ($_SESSION['admin'] == "0"){
				$values = "phone_addon = '".$phone_addon_new."', 
							`date_edit` = '".date("Y-m-d H:i:s")."', 
							phone_for_archive = concat(phone_for_archive, '".$phone."||')";
				$condition = "`id` = '".$people_id."'";
				DB::Update("re_people", $values, $condition);

				$column = "`user_id`, `people_id`, `company_id`, `date`, `comment`";
				$values = "'".$_POST['user']."', '".$people_id."', '".$_SESSION['company_id']."', '".$cur_date."', 'Удаление номера ".$phone ."'";
				DB::Insert("re_applications", $column, $values);
			}else if($_SESSION['admin'] == "1"){
				$values = "phone_addon = '".$phone_addon_new."', 
						`date_edit` = '".date("Y-m-d H:i:s")."', 
						phone_archive = concat(phone_archive, '".$phone."||')";		
				$condition = "`id` = '".$people_id."'";
				DB::Update("re_people", $values, $condition);
			}
			$_SESSION['phone_addon'] = $phone_addon_new;
		}
	}
	
	// public function applications(){
		// $data = DB::Select("*", "re_applications", "archive = '0'");
		// return $data;
	// }
	
	public function user_activation(){
		if($_SESSION['admin'] == "1" && $_POST['user_id'] && $_POST['application_id'])
		{
			DB::Update("re_user", "active = '1'", "user_id = '".$_POST['user_id']."'");
			DB::Update("re_applications", "`archive` = '1'", "`id` = '".$_POST['application_id']."'");
		}
	}
	
	public function phone_to_archive(){
		if($_SESSION['admin'] == "1" && $_POST['app_id'] && $_POST['phone'])
		{
			$app_id = $_POST['app_id'];
			$phone = $_POST['phone'];
			$people_id = $_POST['people_id'];			
			$phone_for_archive_new = $this->phone_column_new("phone_for_archive", $people_id, $phone);
			$values = "phone_for_archive = '".$phone_for_archive_new."', 
					`date_edit` = '".date("Y-m-d H:i:s")."', 
					phone_archive = concat(phone_for_archive, '".$phone."||')";
			$condition = "`id` = '".$people_id."'";
			DB::Update("re_people", $values, $condition);
			DB::Update("re_applications", "archive=1", "`id`=".$app_id);
		}
	}
	
	public function employee_list(){
		if($_SESSION['parent'] == 0 && (isset($_POST['company_id']) || $_SESSION["company_id"])){
			$company_id = $_POST['company_id'] ? $_POST['company_id'] : $_SESSION["company_id"]; 
			$data = DB::Select("*", $this->query_users, "re_company.id=".$company_id." AND `archive` = '0' ORDER BY parent");
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function an_info(){
		if($_POST['var_id'] && isset($_SESSION['user'])){
			$user = mysql_fetch_assoc(mysql_query("select re_user.user_id, re_user.people_id, re_user.parent from re_user INNER JOIN re_var ON re_user.user_id = re_var.user_id where re_var.id = ".$_POST['var_id']));
			/*если владелец варианта директор АН*/
			if($user['parent'] == 0){
				$people = mysql_fetch_assoc(mysql_query("select re_people.id, re_company.company_name, re_people.name, re_people.second_name, re_people.email, re_people.phone, re_people.phone_addon, re_addresses.street, re_addresses.house, re_addresses.office FROM re_people	INNER JOIN re_company ON re_company.id = re_people.company_id INNER JOIN re_addresses ON re_people.id = re_addresses.people_id where re_people.id = ".$user['people_id']." GROUP BY re_people.id"));
				$data = "<div style='text-align: center;'><h3>АН «".$people['company_name']."»</h3>
							<span>".$people['street']." ".$people['house']." ".$people['office']."</span>
						</div>
						<div><b>Директор АН и владелец сообщения:</b><br> 
								".$people['name']." ".$people['second_name']."
								<br>тел.: ".$people['phone']."
								<br />доп.тел.: ".str_replace('||', ', ', $people['phone_addon'])."
						</div>";
			}else{
				$res = mysql_query("select re_user.user_id, re_people.id as people_id, re_company.company_name, re_people.name, re_people.second_name, re_people.email, re_people.phone, re_people.phone_addon, re_addresses.street, re_addresses.house, re_addresses.office FROM re_user INNER JOIN re_people ON re_people.id = re_user.people_id	INNER JOIN re_company ON re_company.id = re_people.company_id INNER JOIN re_addresses ON re_people.id = re_addresses.people_id where re_user.user_id = ".$user['user_id']." OR re_user.user_id = ".$user['parent']);
				$num = mysql_num_rows($res);
				for($v=0; $v<$num; $v++){
					$fetch = mysql_fetch_assoc($res);
					$people[$fetch['user_id']] = $fetch;
				}
				$data = "<div style='text-align: center;'><h3>АН «".$people[$user['user_id']]['company_name']."»</h3>
							<span>".$people[$user['parent']]['street']." ".$people[$user['parent']]['house']." ".$people[$user['parent']]['office']."</span>
						</div>
						<div class='row' style='text-align: center;'>
							<div class='col-xs-6'><b>Директор АН:</b><br> 
									".$people[$user['parent']]['name']." ".$people[$user['parent']]['second_name']."
									<br>тел.: ".$people[$user['parent']]['phone'].", 
									<br />доп.тел.: ".str_replace('||', ', ', $people[$user['parent']]['phone_addon'])."
							</div>						
							<div class='col-xs-6'><b>Владелец сообщения:</b><br> 
									".$people[$user['user_id']]['name']." ".$people[$user['user_id']]['second_name']."
									<br>тел.: ".$people[$user['user_id']]['phone'].", 
									<br />доп.тел.: ".str_replace('||', ', ', $people[$user['user_id']]['phone_addon'])."
							</div>
						</div>";
			}
			echo $data;
			unset($user, $people, $res, $v, $num, $fetch);
		}
	}
	
	public function send_review()
	{
		if(isset($_POST['var_id']) && isset($_SESSION['people_id']) && isset($_POST['review'])){
			if($_POST['table']=="site"){
				$anonymous = isset($_POST["anonymous"]) ? 1 : 0;
				DB::Insert('re_review', 'var_id, people_id, review, anonymous', $_POST['var_id'].', '.$_SESSION['people_id'].', "'.$_POST['text'].'", '.$anonymous);
				if($anonymous==0 && $_POST['review']==0){
					DB::Update('re_var', 'review=1', 'id='.$_POST['var_id']);
				}else{
					echo "wqeqwe";
				}
				
				unset($anonymous);
			}else if($_POST['table']=="parse"){
				$date = date("Y-m-d H:i:s");
				DB::Update('re_parse', 'review=1', "id={$_POST['var_id']}");
				DB::Insert('re_review_parse', 'people_id, parse_id, text, date', "{$_SESSION['people_id']}, {$_POST['var_id']}, '{$_POST['text']}', '{$date}'");
			
			}else if($_POST['table']=="pay_parse"){
				$date = date("Y-m-d H:i:s");
				DB::Update('re_pay_parse', 'review=1', "id={$_POST['var_id']}");
				DB::Insert('re_review_pay_parse', 'people_id, parse_id, text, date', "{$_SESSION['people_id']}, {$_POST['var_id']}, '{$_POST['text']}', '{$date}'");
			}
		}
	}
	
	public function check_comment_set()
	{
		if($_POST && $_SESSION['user']){
			$result = DB::Update("re_check_rielter", "check_comment='".$_POST['comment']."'", "people_id=".$_POST['people_id']." AND search_str='".$_POST['search_str']."'");
			return $result;
		}
	}
	
	public function messages(){
		if($_SESSION['user']){
			$data = DB::Select("*, max(new)", "re_messages", "people_id_to=".$_SESSION['people_id']." GROUP BY people_id_from ORDER BY date_send DESC, new DESC");
			return $data;
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function send_messages(){
		if($_SESSION['user'] &&  $_POST){
			$date = date("Y-m-d H:i:s");
			$result = DB::Insert("re_messages", "people_id_from, login_from, people_id_to, text, date_send, new", $_SESSION["people_id"].", '".$_SESSION['login']."', 1, '".$_POST['text']."', '".$date."', 1");
			$data = $result==1 ? "<div style='margin: 20px;color: rgb(78, 202, 58);'>Сообщение отправлено</div>" : "<div style='margin: 20px;color: rgb(202, 58, 58);'>Произошла ошибка попробуйте позже</div>";
			
			$to  = "balistic@ngs.ru";
			$subject = "Сообщение от пользователя. Логин ".$_SESSION['login'];
			$message = $_POST['text'];						
			$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
			$headers .= "From: Fortunasib.com <fortunasib@mail.ru>\r\n"; 
			//$headers = "From: ".$_SESSION['io']." <".$_SESSION['email'].">\r\n";
			mail($to, $subject, $message, $headers); 
		
			unset($date, $result, $to, $subject, $message, $headers);
			return $data;
		}
	}
	
	public function order(){
		if($_SESSION["parent"] == 0){
			$data = DB::Select("*", "re_order", "company_id='".$_SESSION['company_id']."' ORDER BY id DESC");
			$res = mysql_query("SELECT order_access FROM re_company WHERE id=".$_SESSION['company_id']);
			$data[0]['order_access'] = mysql_fetch_assoc($res)["order_access"];
			$_SESSION["order_access"] = $data[0]['order_access'];
			return $data;
		}
	}
	
	public function order_send(){
		if($_SESSION["parent"] == 0 && $_POST['access']=="on" && $_SESSION["order_access"] == 1 && $_POST["order_place"]!="" && isset($_SESSION["company_id"])){

			$pay_date = $_POST['pay_date']." ".$_POST['pay_time'];
			$sum = str_replace(' ', '', $_POST["sum"]);
			
			if($_POST["order_type"]=="qiwi"){
				$sum = $sum - 20;
			}
			
			foreach($_POST as $k=>$v){
				if($v!="" && $k!="pay_date" && $k != "pay_time" && $k != "card_number"&& $k != "wallet_num" && $k != "sum" && $k != "access" && $k!="name" && $k!="surname" && $k!="second_name"){
					$values .= "'".$v."', ";
					$columns .= "`".$k."`, ";
				}
			}

			$values .= "'".$pay_date."', '".$sum."', '".date("Y-m-d H:i:s")."'";
			$columns .= "`pay_date`, `sum`, `date_order`";

			if(!empty($_POST["surname"])){
				//$second_name = substr($_POST["second_name"], 0, 2);
				$values .= ", '".$_POST["name"]." ".$_POST["surname"]." ".$_POST["second_name"]."'";
				$columns .= ", `wallet_num`";
			}

			if($_POST["order_type"]=="sber"){
				$values .= ", '{$_POST['card_number']}'";
				$columns .= ", `card_number`";
			}
			if($_POST["order_type"]=="qiwi"){
				$values .= ", '{$_POST['wallet_num']}'";
				$columns .= ", `wallet_num`";
			}


			$new_bal = intval(DB::Select("balance", "re_company", "id=".$_SESSION["company_id"])[0]['balance']) + $sum;

			DB::Update("re_company", "order_access = 0, balance = ".$new_bal, "id=".$_SESSION["company_id"]);
			DB::Insert("re_order", $columns, $values);
			$_SESSION["order_access"] = 0;
			header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=services&show=message");
		}else{
			session_destroy();
			header("Location: http://". $_SERVER['SERVER_NAME']);
			// if(!isset($_SESSION['user'])){
				// header("Location: http://". $_SERVER['SERVER_NAME');
			// }else{
				// header("Location: http://". $_SERVER['SERVER_NAME']);			
			// }
		}
	}
	
	public function check_rielter()
	{
		$colums_var = "re_var.id, re_var.user_id, re_var.fortuna_id as tid, re_var.photo, re_user.parent as user_parent, access_var, re_var.active, re_var.owner, ap_layout, re_var.parent_id, re_var.rent_type, re_var.commission, col_date, re_company.company_name, re_people.name, re_people.id as people_id, re_people.second_name, re_people.phone, dis, planning, live_point, street, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, room_count, coords, deliv_period, prepayment, utility_payment, deposit, furn, tv, washing, refrig, ap_view_date, ap_race_date, status, premium, favorit, ap_view_price, in_black_list, review, residents, hidden_text, DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`,'%d/%m/%Y %H:%i') as `date_added_format`,  wc_type, heating, wash, water, sewage, torg";
		$condition_var  =  " re_var.active = 1 AND (re_user.user_id='".$_SESSION['user']."' OR re_user.parent='".$_SESSION['user']."')";
		$table = "`re_var` INNER JOIN re_user ON re_var.user_id = re_user.user_id INNER JOIN re_people ON re_user.people_id = re_people.id INNER JOIN re_company ON re_people.company_id = re_company.id";
		$data_res['var_list'] = DB::Select($colums_var, $table, $condition_var." ORDER BY premium DESC ");
		$data = [];
		if(!empty($_POST)){
			if($_SESSION['user'] && ($_POST["phone"] != "" || $_POST["company_id"] != "") && !empty($_POST['var_id']) && ($_POST['var_id'] !="***" || $_POST["company_id"] != "")){
				$date = date("Y-m-d H:i:s");
				$check_list = DB::Select("re_check_rielter.id, people_id, search_str, search_result, DATE_ADD(date_search, INTERVAL -1 hour) as date_search, check_comment, second_name, name, phone, company_name", "re_check_rielter INNER JOIN re_people ON re_check_rielter.people_id = re_people.id INNER JOIN re_company ON re_people.company_id = re_company.id", "search_str = '".$_POST['phone']."' ORDER BY `id` DESC");
				$continue = $check_list[0]['people_id'] != $_SESSION['people_id'] ? true : false;			
				$company_id = $_POST["company_id"] == "" ? "" : "AND a.company_id=".$_POST["company_id"];
				if($_POST['phone']!=""){
					$data = DB::Select("parent, date_dismiss, second_name, name, phone, phone_addon, phone_archive, date_reg, company_name, warning, active", "re_people as p, re_company as c, re_user as u, re_access_date_end as a", "p.company_id = c.id AND u.people_id=p.id AND a.company_id = c.id AND rent_date_end > NOW() AND (phone like '%".$_POST['phone']."%' OR phone_addon like '%".$_POST['phone']."%' OR phone_archive like '%".$_POST['phone']."%') ".$company_id." AND u.active=1 ORDER BY date_dismiss");
				}else if($company_id !=""){
					$data = DB::Select("parent, date_dismiss, second_name, name, phone, phone_addon, phone_archive, date_reg, company_name, warning, active", "re_people as p, re_company as c, re_user as u, re_access_date_end as a", "p.company_id = c.id AND u.people_id=p.id AND a.company_id = c.id AND rent_date_end > NOW() ".$company_id." AND u.active=1 ORDER BY date_dismiss");
				}
				$count = count($data);
				if($count > 0){
					for($s=0; $s<$count; $s++){
						$data[$s]['status'] = $data[$s]['date_dismiss'] == '0000-00-00 00:00:00' ? "работник агенства" : "<span style='color:red'>уволен, дата увольнения: ".date("d.m.Y H:i:s", strtotime($data[$s]['date_dismiss']))."</span>";
					}
					$search_result = $data[0]['date_dismiss'] == '0000-00-00 00:00:00' || $data[0]['active']==1 ? 2 : 1;
					$data['check_list'] = null;
				}else{
					$data['check_list'] = $check_list;
					$search_result = 0;
				}		
				if($continue){
					DB::Insert("re_check_rielter", "people_id, search_str, search_result, date_search, variant", "{$_SESSION['people_id']}, '{$_POST['phone']}', {$search_result}, '{$date}', '{$_POST['var_id']}'");
				}			
				unset($search_result, $count, $s, $check_list);
			}elseif ($_POST['var_id'] =="***") {
				$data['error']	=	"***";
			}
		}
		return array_merge($data, $data_res);
	}
	
	public function find_rielter(){
		if($_SESSION['user'] && ($_POST["tel"] || $_POST['id'])){
			if(isset($_POST["tel"])){
				$query = "SELECT `company_name`, `surname`, `name`, `second_name`, `phone`, CONCAT_WS(' ', surname, name, second_name) as fio FROM `re_people` INNER JOIN re_company ON re_company.id = re_people.company_id WHERE phone='".$_POST["tel"]."' OR phone_addon like '%".$_POST["tel"]."%'";
			}else{
				$query = "SELECT `company_name`, `surname`, `name`, `second_name`, `phone`, CONCAT_WS(' ', surname, name, second_name) as fio FROM `re_people` INNER JOIN re_company ON re_company.id = re_people.company_id WHERE re_company.id={$_POST['id']}";
			}
			$res = mysql_query($query);
			$num = mysql_num_rows($res);
			$result = "";
			for($t=0; $t<$num; $t++){
				$people = mysql_fetch_assoc($res);
				$result.=	"<tr>
							  <td>".$people['company_name']."</td>
							  <td>".$people['name']." ".$people['second_name']."</td>
							  <td>".$people['phone']."</td>
							  <td><a href='javascript:void(0)' onclick='$(\"[data-id=black-group] tbody\").append($(\"tr\").has($(this))); $(\"tr\").has($(this)).find(\".hidden\").removeClass(\"hidden\"); $(\"td\").has($(this)).addClass(\"hidden\")'>исключить</a></td>
							  <td class='hidden'><input type='checkbox' value='".$people['fio']."'></td>
						</tr>";
			}
			echo $result;
		}
	}
	
	public function create_profile(){
		$cur_date = date("Y-m-d H:i:s");
		if($_SESSION['parent']==0 AND $_SESSION['company_id']){
			$fio = Get_functions::Get_fio_by_pnone($_POST['pe-phone']);
			if($fio['pe-surname'] == "" && $fio['pe-name'] == ""){			
				$people_id = Get_functions::Get_people_id_by_login($_POST['us-login']);
				$fio = Get_functions::Get_fio_by_people_id($people_id);
				if($people_id == ""){
					unset($people_id);
					$query = "SELECT * FROM `re_people` WHERE `surname` LIKE '%".$_POST['pe-surname']."%' AND `name` LIKE '%".$_POST['pe-name']."%' AND `second_name` LIKE '%".$_POST['pe-second_name']."%' AND `date_dismiss` = '0000-00-00 00:00:00'";
					$peoples = mysql_query($query);
					$company_name = Get_functions::Get_company_name_by_id(mysql_fetch_assoc($peoples)['company_id']);
					$peoples_num = mysql_num_rows($peoples);
					if($peoples_num == 0){
						$parent_id = mysql_fetch_assoc(mysql_query("select user_id from re_user INNER JOIN re_people on re_user.people_id = re_people.id where company_id = ".$_SESSION['company_id']." AND re_user.parent = 0"))['user_id'];
						
						foreach($_POST as $k=>$v){				
							if($v!=""){
								if(ereg('us-', $k)){
									$k = explode('-', $k)[1];
									$values_user.= "'".$v."', ";
									$columns_user.= "`".$k."`, ";
									$condition_user.= "`".$k."`='".$v."' AND ";
								}else if(ereg('pe-', $k)){
									$k = explode('-', $k)[1];									
									$values_people.= "'".$v."', ";
									$columns_people.= "`".$k."`, ";
									$condition_people.= "`".$k."`='".$v."' AND ";
								}else if(ereg('ad-', $k)){
									if(ereg('ad-rent', $k)){
										$k = explode('-', $k)[2];		
										$values_address_rent.= "'".$v."', ";
										$columns_address_rent.= "`".$k."`, ";
										$condition_address_rent.= "`".$k."`='".$v."' AND ";
									}else if(ereg('ad-sell', $k)){
										$k = explode('-', $k)[2];
										$values_address_sell.= "'".$v."', ";
										$columns_address_sell.= "`".$k."`, ";
										$condition_address_sell.= "`".$k."`='".$v."' AND ";
									}
								}
							}
						}
						if($values_people){	
							$columns_people.="`date_reg`, `company_id`";
							$values_people.="'".$cur_date."', ".$_POST['company_id'];
							$condition_people.=" company_id=".$_POST['company_id'];
							$data = DB::Insert("re_people", $columns_people, $values_people);
							$people_id = DB::Select("id", "re_people", $condition_people)[0]['id'];
						}
						if(isset($people_id)){
							if(isset($values_user)){
								$columns_user.="`people_id`, `parent`";
								$values_user.="'".$people_id."', '".$parent_id."'";
								$data = DB::Insert("re_user", $columns_user, $values_user);
								
							}
							if(isset($values_address_rent)){
								$columns_address_rent.="`active`, `rent`, `people_id`";
								$values_address_rent.="'1', '1', ".$people_id;
								$data = DB::Insert("re_addresses", $columns_address_rent, $values_address_rent);
							}
							if(isset($values_address_sell)){
								$columns_address_sell.="`active`, `sell`, `people_id`";
								$values_address_sell.="'1', '1', ".$people_id;
								$data = DB::Insert("re_addresses", $columns_address_sell, $values_address_sell);								
							}	
							
							if($_SESSION["admin"]==0){
								$query = "SELECT user_id FROM re_user WHERE people_id=".$people_id;
								$user_id = mysql_fetch_assoc(mysql_query($query))["user_id"];
								DB::Insert("re_applications", "user_id, people_id, company_id, date, comment", $user_id.", ".$people_id.", ".$_SESSION["company_id"].", '".$cur_date."', 'Новый сотрудник'");
							}
							
							@mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id, 0777);
							try{
								$document_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/documents';
								@mkdir($document_dir, 0777);
								$document_file = PhpThumbFactory::create($_FILES['passport']['tmp_name']);
								$document_file->resize(600);
								$document_file->save($document_dir."/document.jpg");
							}catch(Exception $e){}
							try{
								$user_face_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $people_id .'/user_face';
								@mkdir($user_face_dir, 0777);								
								$face_file = PhpThumbFactory::create($_FILES['face']['tmp_name']);
								$face_file->resize(600);
								$face_file->save($user_face_dir."/face.jpg");
							}catch(Exception $e){}
							$data = "Готово!";
							header("Location: http://".$_SERVER['SERVER_NAME']."/?task=profile&action=user_list");
						}
					}else{$data = "Данный риелтер работает в агенстве '".$company_name."'";}
				}else{$data =  "Логин '".$_POST['login']."' прикреплён за '".$fio."'";}
			}else{$data =  "Телефон '".$_POST['phone']."' прикреплён за '".$fio['surname']." ".$fio['name']." ".$fio['second_name']."'";}
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
		return $data;
	}
	
	public function user_list()
	{
		if($_SESSION['parent'] == 0) {	
			$data = DB::Select("re_company.id, re_company.company_name, re_access_date_end.rent_date_end, re_access_date_end.sell_date_end", "re_company INNER JOIN re_access_date_end ON re_company.id=re_access_date_end.company_id", "company_name='".$_SESSION['company_name']."' ORDER BY company_name");
			return $data;
		} else {
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	public function services()
	{
		return Helper::Services_data();
	}
	
	public function services_payment()
	{
		if($_SESSION['parent']==0 && $_POST){
			$financeNeed =  DB::Select("subscription, duty", "re_company", "id=".$_SESSION["company_id"])[0];
			if($_POST["type"] == "rent"){
				if(!Helper::Service_Need_Finance(1,$_POST["rent_month_count"],$financeNeed['subscription'],$financeNeed['duty'])) return false;
				$date = DB::Select("rent_date_end", "re_access_date_end", "company_id=".$_SESSION["company_id"])[0]["rent_date_end"];
				if(date('Y-m-d', strtotime($date)) >= date('Y-m-d')){
					$new_date = date('Y-m-d', strtotime("{$date} + {$_POST["rent_month_count"]} month"));
				}else{
					$new_date = date('Y-m-d', strtotime("+{$_POST["rent_month_count"]} month"));
				}
				DB::Update("re_access_date_end", "rent_date_end='".$new_date."'", "company_id=".$_SESSION["company_id"]);
				DB::Update("re_company", "balance=balance-subscription*".($_POST["rent_month_count"])."-`duty`, duty=0", "id=".$_SESSION["company_id"]);
				$balance_change = mysql_fetch_assoc(mysql_query("select subscription*".$_POST["rent_month_count"]." as balance_change from re_company where id = ".$_SESSION["company_id"]))["balance_change"];
				DB::Insert("re_payment", "company_id, month_count, sum, date_payment, date_finish", $_SESSION["company_id"].", '".$_POST["rent_month_count"]."', '".$balance_change."', '".date("Y-m-d H:i:s")."', '".$new_date."'");
				unset($balance_change);
				if($_SESSION['group_topic_id'] == 2){
					$_SESSION['group_topic_id'] = 3;
				}
				$_SESSION['rent_date_end'] = date("d.m.Y", strtotime($new_date));
				echo date("d.m.Y", strtotime($new_date));
				$res = mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ' OR people_id=') as ids from re_people where company_id={$_SESSION['company_id']} AND id!={$_SESSION['people_id']}");
				$ids = mysql_fetch_assoc($res)['ids'];
				if($ids!=""){
					DB::Delete("re_session", "people_id={$ids}");
				}
			}else if($_POST["type"] == "premium"){
				if($_POST["rent_premium_period"]>0 && $_POST["rent_premium_count"]>0){
				if(!Helper::Service_Need_Finance(1.33,$_POST["rent_premium_count"],$_POST["rent_premium_period"],$financeNeed['duty'])) return false;
				$date_finish = date('Y-m-d', strtotime("+".$_POST["rent_premium_period"]." day"));
				$rent_premium_count = mysql_fetch_assoc(mysql_query("select rent_premium from re_access_date_end where id=".$_SESSION["company_id"]))["rent_premium"] + $_POST["rent_premium_count"];
				DB::Insert("re_payment", "company_id, day_count, premium_count, sum, date_payment, date_finish", "'".$_SESSION["company_id"]."', '".$_POST["rent_premium_period"]."', '".$_POST["rent_premium_count"]."', ".$_POST["rent_premium_period"]."*".$_POST["rent_premium_count"]."*1.33, '".date("Y-m-d H:i:s")."', '".$date_finish."'");
				DB::Update("re_company", "rent_premium=`rent_premium`+".$_POST["rent_premium_count"].", balance=balance-1.33*".($_POST["rent_premium_count"]*$_POST["rent_premium_period"])."-`duty`, duty=0", "id=".$_SESSION["company_id"]);
				unset($date_finish);
				}
			}else if($_POST["type"] == "pay_parse"){
				if($_POST["pay_parse_period"]>0){
					if(!Helper::Service_Need_Finance(1,$_POST["pay_parse_period"],6.66,$financeNeed['duty'])) return false;
					$date = DB::Select("pay_parse_date_end", "re_access_date_end", "company_id=".$_SESSION["company_id"])[0]["pay_parse_date_end"];
					if(date('Y-m-d', strtotime($date)) >= date('Y-m-d')){
						$new_date = date('Y-m-d', strtotime("{$date} + {$_POST["pay_parse_period"]} day"));
					}else{
						$new_date = date('Y-m-d', strtotime("+{$_POST["pay_parse_period"]} day"));
					}
					DB::Insert("re_payment", "company_id, day_count, sum, date_payment, date_finish, comment", "'{$_SESSION["company_id"]}', '{$_POST["pay_parse_period"]}', ".$_POST["pay_parse_period"]."*6.66, '".date("Y-m-d H:i:s")."', '{$new_date}', 'Оплата частников 2'");
					DB::Update("re_company", "balance=balance-(6.66*".$_POST["pay_parse_period"].")-`duty`, duty=0", "id=".$_SESSION["company_id"]);
					DB::Update("re_access_date_end", "pay_parse_date_end='{$new_date}'", "company_id=".$_SESSION["company_id"]);
					unset($date_finish);
					$_SESSION["pay_parse_date_end"] = $new_date;
					$res = mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ' OR people_id=') as ids from re_people where company_id={$_SESSION['company_id']} AND id!={$_SESSION['people_id']}");
					$ids = mysql_fetch_assoc($res)['ids'];
					if($ids!=""){
						DB::Delete("re_session", "people_id={$ids}");
					}
				}
			}else if($_POST["type"] == "sell"){
				if(!Helper::Service_Need_Finance(1,$_POST["sell_month_count"],200,$financeNeed['duty'])) return false;
				$date = DB::Select("sell_date_end", "re_access_date_end", "company_id=".$_SESSION["company_id"])[0]["sell_date_end"];
				if(date('Y-m-d', strtotime($date)) >= date('Y-m-d')){
					$new_date = date('Y-m-d', strtotime("{$date} +{$_POST["sell_month_count"]} month"));
				}else{
					$new_date = date('Y-m-d', strtotime("+{$_POST["sell_month_count"]} month"));
				}
				DB::Update("re_access_date_end", "sell_date_end='".$new_date."'", "company_id=".$_SESSION["company_id"]);
				$balance_change = $_POST["sell_month_count"] * 200;
				DB::Update("re_company", "balance=balance-".$balance_change."-duty, duty=0", "id=".$_SESSION["company_id"]);
				unset($balance_change);
				echo date("d.m.Y", strtotime($new_date));
			}else if($_POST["type"] == "application"){
				$balance_change = $_POST["rielter_count"] ? $_POST["rielter_count"] * 100 : $_POST["rielter_sum"];
				DB::Update("re_company", "balance=balance-".$balance_change."-duty, duty=0", "id=".$_SESSION["company_id"]);
				DB::Insert("re_applications", "user_id, people_id, company_id, date, comment", $_SESSION['user'].", ".$_SESSION['people_id'].", ".$_SESSION["company_id"].", '".date("Y-m-d H:i:s")."', '".$_POST["comment"]." (оплачено: ".$balance_change.")'");
				unset($balance_change);
			}else if($_POST["duty"]){

				$duty_comment = mysql_fetch_assoc(mysql_query("SELECT duty_comment FROM re_company WHERE id=".$_SESSION["company_id"]))["duty_comment"];
				DB::Insert("re_payment", "company_id, sum, date_finish, date_payment, active, comment", "'".$_SESSION["company_id"]."', '".$_POST["duty"]."', '".date("Y-m-d")."', '".date("Y-m-d H:i:s")."', 0, 'Гашение долга. ".$duty_comment."'");
				$duty = DB::Select("duty", "re_company", "id=".$_SESSION["company_id"])[0]['duty'];
				if($duty > 0){
					DB::Update("re_company", "balance=`balance`-".$_POST["duty"].", duty=`duty`-".$_POST["duty"].", duty_comment=''", "id=".$_SESSION["company_id"]);					
				}
				header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=services");
				unset($duty_comment);
			}
		}
	}
	
	public function callboard(){
		if($_SESSION["user"] && $_GET["callboard_topic"])
		{
			$columns = "re_callboard.id, re_callboard.text, re_people.id as people_id, DATE_FORMAT(re_callboard.date,'%d.%m.%Y %H:%i') as date, name, phone, company_name, photo";
			$table = "re_callboard INNER JOIN re_people ON re_people.id=re_callboard.people_id INNER JOIN re_company ON re_company.id=re_people.company_id";
			$data = DB::Select($columns, $table, "callboard_topic = '".$_GET["callboard_topic"]."' ORDER BY id DESC");
			unset($columns, $table);
			return $data;
		}
	}
	
	public function delete_callboard(){
		if(isset($_POST['id']) && isset($_SESSION['people_id'])){
			$query = mysql_query("SELECT people_id FROM re_callboard WHERE id={$_POST['id']}");
			$people_id = mysql_fetch_assoc($query)["people_id"];
			if($people_id == $_SESSION['people_id']){
				$dir = $_SERVER['DOCUMENT_ROOT'] ."/images/{$people_id}/callboard/{$_POST['id']}";
				if(file_exists($dir)){
					if ($objs = glob($dir."/*")) {
					   foreach($objs as $obj) {
							unlink($obj);
					   }
					}
					rmdir($dir);
				}
				DB::Delete("re_callboard", "id={$_POST['id']}");
			}
		}
	}
	
	public function forum(){
		if(isset($_SESSION["people_id"])){
			$blackListForum = Get_functions::Get_black_list_forum();
			/*выборка тем обсуждения форума*/
			if(!isset($_GET["new"]) && !isset($_GET["topic"])){
				$data = DB::Select("f.id, f.title, f.people_id, p.name, p.second_name, c.company_name", "re_forum_topic as f, re_people as p, re_company as c", "f.people_id = p.id AND p.company_id=c.id ORDER BY f.date DESC");
				return $data;
			}else if($_GET["new"]=="title" && isset($_POST["title"])){
				/*Добавление новой темы для обсуждения*/
				DB::Insert("re_forum_topic", "people_id, title, date", "'".$_SESSION["people_id"]."', '".$_POST["title"]."', NOW()");
				$res = mysql_query("SELECT id FROM re_forum_topic WHERE people_id='".$_SESSION["people_id"]."' AND title='".$_POST["title"]."'");
				$id = mysql_fetch_assoc($res)["id"];
				header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum&topic=".$id);
			}else if(isset($_GET["topic"])){
				if($_GET["new"]=="text" && isset($_POST["text"])){
					/*добавление нового сообщения в теме и обновление даты темы*/
					DB::Insert("re_forum", "topic_id, people_id, text, date", "'".$_GET["topic"]."', '".$_SESSION["people_id"]."', '".$_POST["text"]."', NOW()");
					DB::Update("re_forum_topic", "date=NOW()", "id=".$_GET["topic"]);
					header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum&topic=".$_GET["topic"]);
				}else if($_GET["new"]=="comment" && isset($_POST["text"])){
					/*добавление комментария к сообщению в теме и обновление даты комментируемого сообщения*/
					DB::Insert("re_forum", "topic_id, people_id, text, comment_id, date", "'".$_GET["topic"]."', '".$_SESSION["people_id"]."', '".$_POST["text"]."', '".$_POST["id"]."', NOW()");
					DB::Update("re_forum", "date=NOW()", "id=".$_POST["id"]);
					header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=forum&topic=".$_GET["topic"]);
				}
				/*выборка сообщений и комментариев в теме*/
				$page = $_GET['page']>1 ? $_GET['page'] : 1;
				$limit = ($page - 1)*50;
				$res = mysql_query("SELECT f.*, DATE_FORMAT(DATE_ADD(f.date, INTERVAL -1 hour), '%H:%i %d.%m.%Y') as date_f, p.name, p.second_name, c.company_name,
				 (SELECT count(topic_id) FROM re_forum as f2 WHERE f2.comment_id = f.id AND f2.people_id NOT IN ({$blackListForum}) GROUP BY topic_id) as comment_count,
				  (SELECT count(*) as count from re_forum WHERE topic_id={$_GET['topic']} AND comment_id is null AND people_id NOT IN ({$blackListForum})) as count
				   FROM re_forum as f, re_people as p, re_company as c
				    WHERE f.topic_id={$_GET['topic']} AND f.people_id = p.id AND p.company_id = c.id AND f.comment_id is null AND f.people_id NOT IN ({$blackListForum}) ORDER BY f.date 
				    DESC LIMIT {$limit}, 50");

				while($row = mysql_fetch_assoc($res)){
					$data[]=$row;
				}				
				unset($res);
				/*выбор заголовка темы*/
				$res = mysql_query("SELECT title FROM re_forum_topic WHERE id=".$_GET["topic"]);
				$data[0]["title"] = mysql_fetch_assoc($res)["title"];
				unset($res);
				return $data;
			}
		}
	}
	
	public function forum_comments()
	{	$blackListForum = Get_functions::Get_black_list_forum();
		if(isset($_SESSION['people_id']) && $_POST["id"]){
			$res = mysql_query("SELECT f.*, DATE_FORMAT(f.date, '%H:%i %d.%m.%Y') as date_f, p.name, p.second_name, c.company_name, 
				(SELECT count(topic_id) FROM re_forum as f2 WHERE f2.comment_id = f.id AND f2.people_id NOT IN ({$blackListForum}) GROUP BY topic_id) as comment_count
				 FROM re_forum as f, re_people as p, re_company as c
				  WHERE f.comment_id={$_POST['id']} AND f.people_id = p.id AND p.company_id = c.id AND f.people_id NOT IN ({$blackListForum}) ORDER BY f.date");
			while($row = mysql_fetch_assoc($res)){
				$data[]=$row;
			}
			return $data;
		}
	}
	
	public function delete_from_forum()
	{
		if($_SESSION["admin"]==1){
			if($_POST["name"]=="title"){
				DB::Delete("re_forum_topic", "id=".$_POST["id"]);
				DB::Delete("re_forum", "topic_id=".$_POST["id"]);
			}else if($_POST["name"]=="text"){
				DB::Delete("re_forum", "id=".$_POST["id"]." OR comment_id=".$_POST["id"]);
			}
		}
	}
	
	public function recipients(){
		if(isset($_SESSION["people_id"])){
			$data = DB::Select("GROUP_CONCAT(DISTINCT text) as ids, id, address, DATE_FORMAT(DATE_ADD(date, INTERVAL -1 hour), '%d.%m.%Y %H:%i') as date", "re_recipients_list", "people_id = ".$_SESSION['people_id']." GROUP BY address, DATE(date) ORDER BY date DESC");
			return $data;
		}
	}
	
	public function caution()
	{
		if(isset($_SESSION["people_id"])){
			$condition="";
			if(isset($_POST["phone"]) && isset($_POST["comment"]) && !isset($_POST["search"])){
				$column ="";
				$values ="";
				foreach($_POST as $k => $v){
					if($v!=""){
						$column.="`".$k."`, ";
						$values.="'".$v."', ";
					}
				}
				$column.="`date`, owner_people_id";
				$values.="'".date("Y-m-d H:i:s")."', {$_SESSION['people_id']}";
				DB::Insert("re_caution", $column, $values);
				if($_POST["type"]==1){
					$query = mysql_query("SELECT p.id FROM re_people as p, re_company as c WHERE p.company_id = c.id AND p.phone='{$_POST["phone"]}' AND c.company_name='{$_POST["an"]}'");
					$people_id = mysql_fetch_assoc($query)['id'];
					if(isset($people_id)){
						DB::Update("re_people", "warning=1", "id={$people_id}");
					}
				}
				header("Location: http://". $_SERVER['SERVER_NAME']."/?task=profile&action=caution&type=".$_POST["type"]);
			}else if(isset($_POST["search"])){
				foreach($_POST as $k=>$v){
					if($v!="" && $k!="type" && $k!="search"){
						$condition.="`".$k."`='".$v."' AND ";
					}
				}
			}
			$condition.="type=".$_GET["type"];
			$data = DB::Select("*, DATE_FORMAT(DATE_ADD(date, INTERVAL -1 hour), '%H:%i:%s %d.%m.%Y') as date_time", "re_caution", $condition." ORDER BY date DESC");
			return $data;
		}
	}
	
	public function delete_caution()
	{
		if($_SESSION['admin']==1 && isset($_POST["id"])){
			$people_an = DB::Select("an, phone", "re_caution", "id={$_POST['id']}")[0];
			DB::Delete("re_caution", "id='".$_POST["id"]."'");
			$count = DB::Select("count(*) as c", "re_caution", "an='{$people_an['an']}' AND phone='{$people_an['phone']}'")[0]['c'];
			if($count == 0){
				$query = mysql_query("SELECT p.id FROM re_people as p, re_company as c WHERE p.company_id = c.id AND p.phone='{$people_an["phone"]}' AND c.company_name='{$people_an["an"]}'");
				$people_id = mysql_fetch_assoc($query)['id'];
				if(isset($people_id)){
					DB::Update("re_people", "warning=0", "id={$people_id}");
				}
			}
		}
	}
	
	public function lists()
	{
		if(isset($_SESSION['people_id'])){
			$data = [];
			$table= $_POST['list_type'] == 'white' || $_GET['type'] == 'white' ? "re_white_list" : "re_black_list";
			if($_POST['type']=='search' && (isset($_POST['phone']) || isset($_POST['an_id']))){
				$phone = isset($_POST['phone']) ? " p.phone like '%{$_POST['phone']}%' OR p.phone_addon like '%{$_POST['phone']}%' OR p.phone_archive like '%{$_POST['phone']}%'" : "";
				$company_id= isset($_POST['an_id']) ? " c.id={$_POST['an_id']} " : "";
				$data = DB::Select("p.id, p.name, p.second_name, p.phone, c.company_name as an", "re_people as p, re_company as c", "p.company_id=c.id AND ({$phone}".($phone!="" && $company_id!="" ? " OR " : "")."{$company_id})");
				return $data;
			}else if($_POST['type']=='add' && isset($_POST['id'])){				
				if(!ereg($_POST['id'].",", $_SESSION['in_black_list']) ){
					DB::Insert($table, "owner_people_id, people_id", "{$_SESSION['people_id']}, {$_POST['id']}");
					$_SESSION['in_black_list'].= $_POST['id'].",";
				}
				$table_delete = array(
					"re_white_list"=>"re_black_list",
					"re_black_list"=>"re_white_list"
				);
				DB::Delete($table_delete[$table], "owner_people_id='{$_SESSION['people_id']}' AND people_id='{$_POST['id']}'");
			}else if($_POST['type']=='delete'){				
				DB::Delete($table, "people_id={$_POST['id']} AND owner_people_id={$_SESSION['people_id']}");
			}else{
				$text = $table=="re_black_list" ? ", l.text" : "";
				$data = DB::Select("p.id, p.name, p.second_name, p.phone, c.company_name as an{$text}, l.show_var, l.show_forum", "re_people as p, re_company as c, {$table} as l", "p.company_id=c.id AND l.people_id=p.id AND l.owner_people_id={$_SESSION['people_id']}");
				
			}

			if($_POST['mess_view']=='show_var'){				
				$show = 1; if($_POST['show'] == 1) $show = 0;
				DB::Update($table, "show_var=".$show, "people_id={$_POST['id']} AND owner_people_id={$_SESSION['people_id']}");
			}
			if($_POST['mess_view']=='show_forum'){				
				$show = 1; if($_POST['show'] == 1) $show = 0;
				DB::Update($table, "show_forum=".$show, "people_id={$_POST['id']} AND owner_people_id={$_SESSION['people_id']}");
			}
			
			return $data;

		}
	}
	
	public function update()
	{
		if($_SESSION['parent']==0){
			DB::Update("re_{$_POST['name']}", "{$_POST['col']}={$_POST['value']}", "user_id={$_POST['id']}");
		}
	}
	
	public function delete(){
		if($_POST['people_id']==$_SESSION['people_id'] || $_SESSION['admin']==1){
			if($_POST['name']=="review_parse"){
				$count = DB::Select("count(*) as c, parse_id", "re_review_parse", "parse_id=(SELECT parse_id FROM re_review_parse WHERE id={$_POST['id']})")[0];
				if(($count['c']-1)==0){
					DB::Update("re_parse", "review=0", "id={$count['parse_id']}");
				}
			}else if($_POST['name']=="review_pay_parse"){
				$count = DB::Select("count(*) as c, parse_id", "re_review_pay_parse", "parse_id=(SELECT parse_id FROM re_review_pay_parse WHERE id={$_POST['id']})")[0];
				if(($count['c']-1)==0){
					DB::Update("re_pay_parse", "review=0", "id={$count['parse_id']}");
				}
			}else if($_POST['name']=="review"){
				$count = DB::Select("count(*) as c, var_id", "re_review", "var_id=(SELECT var_id FROM re_review WHERE id={$_POST['id']})")[0];
				if(($count['c']-1)==0){
					DB::Update("re_var", "review=0", "id={$count['var_id']}");
				}
			}
			DB::Delete("re_{$_POST['name']}", "id={$_POST['id']}");
		}
	}
	
	public function find_on_phone(){
		if(isset($_SESSION['user'])){
			if($_POST['type']=="for_caution"){
				$data = DB::Select("p.name, p.second_name, c.company_name", "re_people as p, re_company as c", "p.company_id = c.id AND p.date_dismiss = '0000-00-00 00:00:00' AND (p.phone = '{$_POST['phone']}' OR p.phone_addon='{$_POST['phone']}')")[0];
				echo "{$data['name']};{$data['second_name']};{$data['company_name']}";
			}
		}
	}
	
	public function for_open_site(){
		if(isset($_SESSION['user']) && isset($_POST['val'])){
			DB::Update("re_user", "for_open_site={$_POST['val']}", "user_id={$_SESSION['user']}");
		}
		if($_POST['val']==2){
			$res = mysql_query("SELECT id FROM re_var WHERE user_id={$_SESSION['user']} AND photo=1");
			while($var = mysql_fetch_assoc($res)){
				DB::Insert("for_delete", "var_id", $var['id']);
			}
		}
	}
	
	public function session_update(){
		if(isset($_SESSION["start_time"]) && $_SESSION['admin']==0){
			$date = date("Y-m-d H:i:s");
			//DB::Delete("re_session", "DATE_ADD(date_start, INTERVAL +5 HOUR) < NOW()");
			$count = mysql_fetch_assoc(mysql_query("SELECT count(*) as count FROM re_session WHERE people_id = '{$_SESSION['people_id']}' AND name='".session_id()."'"))['count'];
			$ip = DB::Select("count(*) AS c", "re_addresses", "people_id={$_SESSION['people_id']} AND (('{$_SERVER['REMOTE_ADDR']}' LIKE replace('0%', '0', ip) AND ip!='') OR ip='1')")[0]['c'];
			if($count == 0 || $ip==0){
				DB::Delete("re_session", "people_id='{$_SESSION['people_id']}'");
				session_destroy();
				header('Location: http://'. $_SERVER['SERVER_NAME']);
			}else{
				$_SESSION["start_time"] = $date;
				DB::Update("re_session", "date_start = '{$date}'", "people_id = '{$_SESSION["people_id"]}'");
			}
			//echo $date;
			unset($date, $ses_date);
		}else if(!isset($_SESSION["start_time"])){
			header('Location: http://'.$_SERVER['SERVER_NAME']);
		}
	}
	
	public function group_setting(){
		if(isset($_SESSION['people_id'])){
			$group_list = Get_functions::Get_black_group_list($_SESSION['fio']);
			$group_list_arr = explode('||', $group_list['black_group']);
			$count = count($group_list_arr);
			$condition = "";
			for($i=0; $i<$count; $i++){
				if($group_list_arr[$i] != ""){
					$condition .= "CONCAT_WS(' ', surname, name, second_name)='".$group_list_arr[$i]."' OR ";
				}
			}
			$peoples = "";
			if($condition != ""){
				$condition = substr($condition, 0, -3);
				$column = "`company_name`, `surname`, `name`, `second_name`, `phone`";
				$table = "`re_people` INNER JOIN re_company ON re_company.id = re_people.company_id";
				$data = DB::Select($column, $table, $condition);
			}
			return $data;
		}
	}

}
