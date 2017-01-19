<?
	require 'application/modules/connect_mod.php';
	
	function translate_var_to_new($data, $db1, $db2)
	{
		$dis = "";
		$live_point = "";
		$ap_layout = "";
		$heating = "";
		$park = "";
		$wash = "";		
		$room_count = "";	
		$planning = "";
		//Тип объекта
		 if($data['object']=='15'){
			$type_id =  '48';
			$parent_id = '18';
			$ap_layout = 'в квартире';
			$room_count = $data['comn'];
		}else if($data['object']=='4'){
			$type_id =  '49';
			$parent_id = '18';
			$ap_layout = 'в квартире';
			$room_count = $data['comn'];
		}else if($data['object']=='19'){
			$type_id =  '51';
			$parent_id = '18';
			$ap_layout = 'в квартире';
			$room_count = $data['comn'];
		}else if($data['object']=='5'){
			$type_id =  '50';
			$parent_id = '18';
			$ap_layout = 'в квартире';
			$room_count = $data['comn'];
		}else if($data['object']=='16'){
			$type_id =  '52';
			$parent_id = '18';
			$ap_layout = 'в квартире';
			$room_count = $data['comn'];
		}else if($data['object']=='6'){
			$type_id =  '49';
			$parent_id = '18';
			$ap_layout = 'в общежитии';
		}else if($data['object']=='7'){
			$type_id =  '0';
			$parent_id = '1';
			$ap_layout = 'малосемейка';
			$room_count = '1';
		}else if($data['object']=='8'){
			$type_id =  '0';
			$parent_id = '1';
			$room_count = '1';
		}else if($data['object']=='9'){
			$type_id =  '0';
			$parent_id = '1';
			$room_count = '2';
		}else if($data['object']=='10'){
			$type_id =  '0';
			$parent_id = '1';
			$room_count = '3';
		}else if($data['object']=='11'){
			$type_id =  '0';
			$parent_id = '1';
			$room_count = '4';
		}else if($data['object']=='12'){
			$type_id =  '0';
			$parent_id = '1';
			$room_count = '5';
		}else if($data['object']=='2'){
			$type_id =  '25';
			$parent_id = '3';		
		}else if($data['object']=='17'){
			$type_id =  '26';
			$parent_id = '3';		
		}else if($data['object']=='3'){
			$type_id =  '27';
			$parent_id = '3';	
		}else if($data['object']=='18'){
			$type_id =  '28';
			$parent_id = '3';	
		}
		
		//сдача или снятие
		$topic_id = $data['action'] == "demise" ? 1 : 3;
		
		//район и населенный пункт
		if($data['area']=="2"){
			$dis =  'Железнодорожный';	
			$live_point = 'Новосибирск';
		}else if($data['area']=="3"){
			$dis =  'Заельцовский';		
			$live_point = 'Новосибирск';	
		}else if($data['area']=="4"){
			$dis =  'Центральный';		
			$live_point = 'Новосибирск';
		}else if($data['area']=="5"){
			$dis =  'Октябрьский';	
			$live_point = 'Новосибирск';
		}else if($data['area']=="6"){
			$dis =  'Дзержинский';	
			$live_point = 'Новосибирск';
		}else if($data['area']=="7"){
			$dis =  'Калининский';		
			$live_point = 'Новосибирск';
		}else if($data['area']=="8"){
			$dis =  'Ленинский';	
			$live_point = 'Новосибирск';
		}else if($data['area']=="9"){
			$dis =  'Кировский';	
			$live_point = 'Новосибирск';
		}else if($data['area']=="10"){
			$dis =  'Первомайский';		
			$live_point = 'Новосибирск';
		}else if($data['area']=="11"){
			$dis = 'Советский';	
			$live_point = 'Новосибирск';
		}else if($data['area']=="12"){
			$live_point = 'Краснообск';
			$dis = "";						
		}else if($data['area']=="13"){
			$live_point = 'Бердск';	
			$dis = "";
		}else if($data['area']=="14"){
			$live_point = 'Обь';	
			$dis = "";
		}else if($data['area']=="20"){
			$live_point = 'Элитный пос.';	
			$dis = "";
		}else if($data['area']=="21"){
			$live_point = 'Кудряши';	
			$dis = "";
		}else if($data['area']=="22"){
			$live_point = 'Криводановка';						
			$dis = "";
		}else if($data['area']=="23"){
			$dis = 'Советский';	
			$live_point = 'Новосибирск';
		}else if($data['area']=="24"){
			$live_point = 'Кольцово';
			$dis = "";
		}else if($data['area']=="25"){
			$live_point = 'Толмачево';						
			$dis = "";
		}else if($data['area']=="26"){
			$live_point = 'Мочище пос.';						
			$dis = "";
		}else if($data['area']=="27"){
			$live_point = 'Мочище ст.';						
			$dis = "";
		}else if($data['area']=="28"){
			$dis = 'Калининский';	
			$live_point = 'Новосибирск';
		}else if($data['area']=="29"){
			$live_point = 'Раздольное';		
			$dis = "";
		}else{
			$dis = "";
			$live_point = "";						
		}
		//echo $data['area']." ".$dis."<br />";
		
		//дата
		$date_arr = explode('/', $data['date_first']);
		$date = $date_arr[2]."-".$date_arr[1]."-".$date_arr[0];
		
		//планировка крартиры
		if($data['conti']=='2'){
			$planning =  'изолированная';		
		}else if($data['conti']=='4'){
			$planning =  'студия';				
		}else if($data['conti']=='3'){
			$planning =  'см-изолированная';	
		}else if($data['conti']=='1'){
			$planning =  'смежная';			
		}
		
		//этаж, этажность
		$floor_db = explode("/", $data['floor']);		
		if(count($floor_db) == 2){
			$floor = $floor_db[0];
			$floor_count = $floor_db[1];
		}
		$floor_count = $data['floor'];
		$floor = $data['flr'] == "ср" ? "" : $data['flr'];
		
		//тип туалета
		$wc = $data['toilet'] == "dom" ? "раздельный" : 
									($data['toilet'] == "out" ? "на улице" : "");
		
		//кого берут
		$residents = "Семейных||С детьми||Строителей||Одиноких мужчин||Одиноких женщин||";
		$residents.= $data['ner'] == '1' ? "Нерусских||" : "";
		$residents.= $data['stud'] == '1' ? "Студентов||" : "";
		
		//дополнительные платы
		if(ereg('sy', $data['dop_price'])){
			$utility_payment = "платить дополнительно";	
		}else if(ereg('vyo', $data['dop_price'])){
			$utility_payment = "дополнительно только за воду";
		}else if(ereg('syo', $data['dop_price'])){
			$utility_payment = "дополнительно только за воду";				
		}else{
			$utility_payment = "оплата включена в цену";
		}
		
		//отопление
		if($data['otopl'] =='gaz'){
			$heating = "газовое";	
		}else if($data['otopl'] =='pech'){
			$heating = "печное";	
		}else if($data['otopl'] =='centr'){
			$heating = "центральное";	
		}	
		
		//вода
		$ap_view_price = $data['my_show'] == 1 ? null : $data['my_show'];
		$water = $data['water'] == "dom" ? "х" : ($data['water']=="kolonka" ? "колонка" : "");
		$sewage = $data['toilet'] == "dom" ? "раздельный" : ($data['toilet'] == "out" ? "на улице" : "");
		
		//парковка
		if($data['mashina']== 'in'){
			$park = "парковка во дворе";
		}else if($data['mashina']== 'out'){
			$park = "парковка у дома";
		}else if($data['mashina']== 'no'){
			$park = "отсутствует";
		}
		
		//где мыться
		if($data['washing']=='banya'){
			$wash = "баня";	
		}else if($data['washing']=='dush'){
			$wash = "душ";	
		}else if($data['washing']=='no'){
			$wash = "негде";
		}
		
		//даты просмотра заезда
		if(isset($data['zaezd']) && isset($data['smotr'])){
			$date_smotr = substr($data['smotr'], 0, 4)."-".substr($data['smotr'], 4, 2)."-".substr($data['smotr'], 6, 2);
			$date_zaezd = substr($data['zaezd'], 0, 4)."-".substr($data['zaezd'], 4, 2)."-".substr($data['zaezd'], 6, 2);
		}else{
			$date_smotr = date('Y-m-d');
			$date_zaezd = date('Y-m-d');
		}
		
		$date_last_edit = substr($data['date_opt'], 0, 4)."-".substr($data['date_opt'], 4, 2)."-".substr($data['date_opt'], 6, 2)." ".substr($data['date_opt'], 8, 2).":".substr($data['date_opt'], 10, 2);
		
		$index = explode(',', $data['name_used'])[0];
		$names = explode(" * ", $data['name']);
		$name = count($names) >= ($index+1) 
								? $names[intval($index)] 
								: $names[0];
		/*на тот случай если в строку имени запихали отчество*/
		$name = explode(" ", $name)[0];
		$user_id = update_people($data['mid'], $name, $db1, $db2);

		if(isset($user_id)){
			$make_photo = (($data['photo1']!=""||$data['photo2']!=""||$data['photo3']!=""||$data['photo4']!=""||$data['photo5']!=""||$data['photo6']!="") ? 1 : 0);
			
			$column = "`user_id`, `active`, `group`, `topic_id`, `type_id`, `parent_id`,
					`live_point`, `dis`, `street`, `house`, `sq_all`, `sq_live`, `sq_k`,
					`planning`, `ap_layout`, `wc_type`, `furn`, `refrig`, `tv`, `washing`,
					`floor`, `floor_count`, `text`, `hidden_text`, `price`, `rent_type`, `torg`,
					`deliv_period`, `residents`, `prepayment`, `deposit`,
					`utility_payment`, `commission`, `ap_view_price`, `ap_view_date`,
					`ap_race_date`, `status`, `premium`, `room_count`, `heating`, `water`,
					`sewage`, `park`, `wash`, `date_added`, `date_last_edit`, `photo`, `fortuna_id`, `orientir`";
			
			$values = "'".$user_id."', 
						'".($data['archive']=='1' ? 0 : 1)."',
						'1', 
						'".$topic_id."', 
						'".$type_id."', 
						'".$parent_id."',
						'".($live_point == "" ? "Новосибирск" : $live_point)."', 
						'".$dis."',
						'".$data['street']."', 
						'".$data['house']."', 
						'".$data['s_o']."', 
						'".$data['s_j']."', 
						'".$data['s_k']."', 
						'".$planning."', 
						'".$ap_layout."', 
						'".$wc."',
						'".$data['meb']."', 
						'".$data['hol']."', 
						'".$data['tv']."',
						'".$data['stir']."', 
						'".$floor."', 
						'".$floor_count."', 
						'".$data['text']."',
						'".$data['prim']."',
						'".$data['price']."', 
						'".($data['dlit']=='1'? "месяц" : "сутки")."',
						'".$data['torg']."', 
						'".$data['period']."', 
						'".$residents."',
						'".$data['predopl']."', 
						'".$data['deposit']."', 
						'".$utility_payment."',
						'".$data['comm']."', 
						'".$ap_view_price."', 
						'".$date_smotr."', 
						'".$date_zaezd."', 
						'".$data['exkl']."', 
						'".$data['premium']."',
						'".$room_count."', 
						'".$heating."', 
						'".$water."', 
						'".$sewage."',
						'".$park."', 
						'".$wash."', 
						'".$date."',
						'".$date_last_edit."',
						'".$make_photo."',
						'".$data['tid']."',
						'".$data['station']."'";
			
			$check = mysql_query("SELECT count(*) as c FROM re_var WHERE fortuna_id = '".$data['tid']."'", $db1);
			$count = mysql_fetch_assoc($check)['c'];
			if($count == 0){
				unset($count);
				mysql_query("INSERT INTO re_var(".$column.") VALUE (".$values.")", $db1);
				
				//добавление фоток
				if($make_photo == 1 && $_GET["photo"] == 1){
					add_photos($data['tid'], $db1, $db2);
				}
				
				return "Добавлен вариант ".$data['tid']."<br />";
			}else{
				// $column_arr = explode(',', $column);
				// $values_arr = explode(',', $values);
				// $count = count($column_arr);
				// $result = "";
				// for($c=0; $c<$count; $c++){
					// $result .= $column_arr[$c]."=".$values_arr[$c].", ";
				// }
				// unset($count, $c, $column_arr, $values_arr, $column, $values);
				// mysql_query("UPDATE re_var SET ".substr($result, 0, -2)." WHERE fortuna_id = '".$data['tid']."'", $db1);
				mysql_query("UPDATE re_var SET `user_id`='{$user_id}', `active` = '".($data['archive']=='1' ? 0 : 1)."', `group`='1', `topic_id`='{$topic_id}', `type_id`='{$type_id}', `parent_id`='{$parent_id}', `live_point`='".($live_point == "" ? "Новосибирск" : $live_point)."', `dis`='{$dis}', `street`='{$data['street']}', `house`='{$data['house']}', `sq_all`='{$data['s_o']}', `sq_live`='{$live_sq}', `sq_k`='{$data['s_k']}', `planning`='{$planning}', `ap_layout`='{$ap_layout}', `wc_type`='{$wc}', `furn`='{$data['meb']}', `refrig`='{$data['hol']}', `tv`='{$data['tv']}', `washing`='{$data['stir']}', `floor`='{$floor}', `floor_count`='{$floor_count}', `text`='{$data['text']}', `hidden_text`='{$data['prim']}', `price`='{$data['price']}', `rent_type`='".($data['dlit']=='1'? "месяц" : "сутки")."', `torg`='{$data['torg']}', `deliv_period`='{$data['period']}', `residents`='{$residents}', `prepayment`='{$data['predopl']}', `deposit`='{$data['deposit']}', `utility_payment`='{$utility_payment}', `commission`='{$data['comm']}', `ap_view_price`='{$ap_view_price}', `ap_view_date`='{$date_smotr}', `ap_race_date`='{$date_zaezd}', `status`='{$data['exkl']}', `premium`='{$data['premium']}', `room_count`='{$room_count}', `heating`='{$heating}', `water`='{$water}', `sewage`='{$sewage}', `park`='{$park}', `wash`='{$wash}', `date_added`='{$date}', `date_last_edit`='{$date_last_edit}', `photo`='{$make_photo}', `fortuna_id`='{$data['tid']}', `orientir`='{$data['station']}' WHERE fortuna_id = '{$data['tid']}'", $db1);
				//добавление фоток
				if($make_photo == 1 && $_GET["photo"] == 1){
					add_photos($data['tid'], $db1, $db2);
				}
				
				return "Обновлен вариант ".$data['tid']."<br />";
			}
		}
	}
	
	function update_people($mid, $name, $db1, $db2){
		if($_GET["employee"] == 1){
			// //получение данных всех риэлторов АН варианта
			$res = mysql_query("SELECT r.mid, r.rid, p.fio, r.name, r.famil, r.otch, r.tel, r.tel2, r.date_in, r.AN, r.comm, p.prm_start, p.prm_end, l.login, l.pass, l.pay_till, l.block_IP, l.payment, l.penalty, l.ballance, l.trans_mail, l.trans_mail_dop, l.profile, l.archive FROM rieltors as r, prm_values as p, list as l WHERE p.mid = r.mid AND l.mid = r.mid AND (p.mid = ".$mid.")", $db2);
		}else{
			//получение данных владельца варианта
			$res = mysql_query("SELECT r.mid, r.rid, p.fio, r.name, r.famil, r.otch, r.tel, r.tel2, r.date_in, r.AN, r.comm, p.prm_start, p.prm_end, l.login, l.pass, l.pay_till, l.block_IP, l.payment, l.penalty, l.ballance, l.trans_mail, l.trans_mail_dop, l.profile, l.archive FROM rieltors as r, prm_values as p, list as l WHERE p.mid = r.mid AND l.mid = r.mid AND p.mid = '".$mid."' AND r.name = '".$name."' LIMIT 1", $db2);
		}
		$update_count = 0;
		while($rieltor = mysql_fetch_assoc($res)){
			$company_id = mysql_fetch_assoc(mysql_query("select `id` from re_company where fortuna_mid = '".$rieltor['mid']."'", $db1))['id'];
			$date_arr = explode('/', $rieltor['date_in']);
			if(count($date_arr) >= 3){
				$date = $date_arr[2]."-".$date_arr[1]."-".$date_arr[0];
			}else{
				$date = date("Y-m-d");
			}
			
			$pay_til_arr = explode('/', $rieltor['pay_till']);
			$pay_til = $pay_til_arr[2]."-".$pay_til_arr[1]."-".$pay_til_arr[0];
			$prm = $rieltor['prm_end'] != "" ? $rieltor['prm_end'] : $rieltor['prm_start'];
			
			if(!isset($_GET["employee"])){
				$count = mysql_fetch_assoc(mysql_query("select count(*) as count, id from re_company where fortuna_mid = '".$rieltor['mid']."'", $db1));
				//создание или обновление АН
				if($count["count"] == 0){
					mysql_query("INSERT INTO re_company (`company_name`, `rent_premium`, `balance`, `duty`, `subscription`, `date_company_reg`, `fortuna_mid`, `tariff_id`) VALUE ('".$rieltor['AN']."', '".$prm."', '".$rieltor['ballance']."', '".$rieltor['penalty']."', '".$rieltor['payment']."', '".$date."', '".$rieltor['mid']."', '".$rieltor['archive']."')", $db1);
					
					mysql_query("INSERT INTO re_access_date_end (`company_id`, `rent_date_end`) VALUE ('".$company_id."', '".$pay_til."')", $db1);
					//echo "Добавлено АН ".$company_id."<br />";
				}else{
					mysql_query("UPDATE re_company SET rent_premium = '".$prm."', balance = '".$rieltor['ballance']."', duty = '".$rieltor['penalty']."', subscription='".$rieltor['payment']."', tariff_id='".$rieltor['archive']."' WHERE id='".$company_id."'", $db1);
					mysql_query("UPDATE re_access_date_end SET rent_date_end='".$pay_til."' WHERE company_id='".$company_id."'", $db1);
					//mysql_query("UPDATE re_people SET copmany_id")
					//echo "Обновленно АН ".$company_id."<br />";
				}
				unset($count);
			}else if($update_count==0){
				$id = mysql_fetch_assoc(mysql_query("select id from re_company where fortuna_mid = '".$rieltor['mid']."'", $db1))['id'];
				mysql_query("UPDATE re_company SET rent_premium = '".$prm."', balance = '".$rieltor['ballance']."', duty = '".$rieltor['penalty']."', subscription='".$rieltor['payment']."', tariff_id='".$rieltor['archive']."' WHERE id='".$id."'", $db1);
				mysql_query("UPDATE re_access_date_end SET rent_date_end='".$pay_til."' WHERE company_id='".$id."'", $db1);
				$update_count++;
			}
			$people_id = mysql_fetch_assoc(mysql_query("SELECT `id` FROM re_people WHERE fortuna_rid='".$rieltor['rid']."'", $db1))['id'];
			//добавление владельца варианта в новую базу(в случае отсутствия)
			if(intval($people_id) == 0){
				if($rieltor['comm'] == "директор"){
					return add_director($rieltor, $company_id, $date, $db1, $db2);
				}else{
					$parent_id = mysql_fetch_assoc(mysql_query("SELECT u.user_id FROM re_user as u, re_people as p, re_company as c, re_access_date_end as a WHERE u.people_id = p.id AND p.company_id = c.id AND p.company_id = a.company_id AND u.parent=0 AND c.fortuna_mid = '".$rieltor['mid']."'", $db1))['user_id'];
					
					//создание директора АН в новой базе(в случае его отсутствия)
					if($parent_id == ""){
						$res1 = mysql_query("SELECT r.mid, r.rid, p.fio, r.name, r.famil, r.otch, 	r.tel, r.tel2, r.date_in, r.AN, r.comm, p.prm_start, p.prm_end, l.login, l.pass, l.pay_till, l.block_IP, l.payment, l.penalty, l.ballance, l.trans_mail, l.trans_mail_dop, l.profile FROM rieltors as r, prm_values as p, list as l WHERE p.mid = r.mid AND l.mid = r.mid AND p.mid = '".$mid."' AND r.comm='директор'", $db2);
						$director = mysql_fetch_assoc($res1);
						$d_arr = explode('/', $director['date_in']);
						if(count($d_arr) >= 3){
							$date_d = $d_arr[2]."-".$d_arr[1]."-".$d_arr[0];
						}else{
							$date_d = date("Y-m-d");
						}
						$parent_id = add_director($director, $company_id, $date_d, $db1, $db2);
					}
					
					$phone_addon = "";
					$phone_addon_arr = explode(',', $rieltor['tel2']);
					$phone = substr($rieltor['tel'], 0, 1)." (".substr($rieltor['tel'], 1, 3).") ".substr($rieltor['tel'], 4, 3)."-".substr($rieltor['tel'], 7, 4);
					for($xxx=0; $xxx<count($phone_addon_arr); $xxx++){
						$phone_addon .= substr($phone_addon_arr[$xxx], 0, 1)." (".substr($phone_addon_arr[$xxx], 1, 3).") ".substr($phone_addon_arr[$xxx], 4, 3)."-".substr($phone_addon_arr[$xxx], 7, 4)."||";
					}
										
					mysql_query("INSERT INTO re_people (`company_id`, `phone`, `phone_addon`, `date_reg`, `surname`, `name`, `second_name`, `comment`, `fortuna_rid`) VALUE ('".$company_id."', '".$phone."', '".$phone_addon."', '".$date."', '".$rieltor['famil']."', '".$rieltor['name']."', '".$rieltor['otch']."', '".$rieltor['trans_mail']."||".$rieltor['trans_mail_dop']."||".$rieltor['profile']."', '".$rieltor['rid']."')", $db1);	
					
					$people_id = mysql_fetch_assoc(mysql_query("select `id` from re_people where company_id = '".$company_id."' AND surname='".$rieltor['famil']."' AND `name`='".$rieltor['name']."' AND second_name='".$rieltor['otch']."' AND date_dismiss = '0000-00-00 00:00:00'", $db1))['id'];
					
					$ips = explode(' ', preg_replace("/\s+/", ' ', $rieltor['block_IP']));
					for($j=0; $j<count($ips); $j++){
						mysql_query("INSERT INTO re_addresses (`people_id`, `active`, `archive`, `sell`, `rent`, `ip`) VALUE ('".$people_id."', '1', '0', '0', '1', '".$ips[$j]."')", $db1);
					}
					
					//генерация пароля
					$password = rand(100000, 999999);
					
					//генерация логина подчиненного
					unset($res1);
					$res1 = mysql_query("SELECT login FROM re_user GROUP BY login", $db1);
					while($login = mysql_fetch_assoc($res1)){
						$logins[] = $login["login"];
					}
					$login = rand(8000, 8999);
					while(in_array($login, $logins)){
						$login = rand(8000, 8999);
					}
					unset($res1, $logins);
					
					mysql_query("INSERT INTO re_user (`people_id`, `login`, `active`, `archive`, `password`, `parent`, `group_topic_id`) VALUE ('".$people_id."', '".$login."', '1', '0', '".$password."', '".$parent_id."', '1')", $db1);
					
					//echo "Добавлен сотрудник ".$rieltor['name']." ".$rieltor['otch']."<br />";
					
					$res1 = mysql_query("SELECT user_id FROM re_user WHERE people_id='".$people_id."' AND active=1 AND archive=0 AND login = '".$login."'", $db1);
					if(!isset($_GET["employee"])){
						return mysql_fetch_assoc($res1)['user_id'];
					}
				}
			}else{
				if($_GET["employee"]==1){
					mysql_query("UPDATE re_people SET company_id=".$company_id." WHERE id='".$people_id."'", $db1);				
				}
				$res1 = mysql_query("SELECT user_id FROM re_user WHERE people_id='".$people_id."' AND active=1 AND archive=0", $db1);
				if(!isset($_GET["employee"])){
					return mysql_fetch_assoc($res1)['user_id'];
				}
			}
		}
	}
	
	function add_director($rieltor, $company_id, $date, $db1, $db2){
		$famil_str = explode('*', $rieltor['famil']);
		$surname = $famil_str[0];
		$email = $famil_str[1];
		$phone_addon = "";
		$phone_addon_arr = explode(',', $rieltor['tel2']);
		$phone = substr($rieltor['tel'], 0, 1)." (".substr($rieltor['tel'], 1, 3).") ".substr($rieltor['tel'], 4, 3)."-".substr($rieltor['tel'], 7, 4);
		for($xxx=0; $xxx<count($phone_addon_arr); $xxx++){
			$phone_addon .= substr($phone_addon_arr[$xxx], 0, 1)." (".substr($phone_addon_arr[$xxx], 1, 3).") ".substr($phone_addon_arr[$xxx], 4, 3)."-".substr($phone_addon_arr[$xxx], 7, 4)."||";
		}
	
		mysql_query("INSERT INTO re_people (`company_id`, `email`, `phone`, `phone_addon`, `date_reg`, `surname`, `name`, `second_name`, `comment`, `fortuna_rid`) VALUE ('".$company_id."', '".$email."', '".$phone."', '".$phone_addon."', '".$date."', '".$surname."', '".$rieltor['name']."', '".$rieltor['otch']."', '".$rieltor['trans_mail']."||".$rieltor['trans_mail_dop']."||".$rieltor['profile']."', '".$rieltor['rid']."')", $db1);	
		
		$people_id = mysql_fetch_assoc(mysql_query("select `id` from re_people where company_id = '".$company_id."' AND surname='".$surname."' AND `name`='".$rieltor['name']."' AND second_name='".$rieltor['otch']."' AND date_dismiss = '0000-00-00 00:00:00'", $db1))['id'];
		
		$ips = explode(' ', preg_replace("/\s+/", ' ', $rieltor['block_IP']));
		for($j=0; $j<count($ips); $j++){
			mysql_query("INSERT INTO re_addresses (`people_id`, `active`, `archive`, `sell`, `rent`, `ip`) VALUE ('".$people_id."', '1', '0', '0', '1', '".$ips[$j]."')", $db1);
		}	
		
		mysql_query("INSERT INTO re_user (`people_id`, `login`, `active`, `archive`, `password`, `parent`, `group_topic_id`) VALUE ('".$people_id."', '".$rieltor['fio']."', '1', '0', '".$rieltor['pass']."', '0', '1')", $db1);
		
		//echo "Добавлен директор ".$rieltor['name']." ".$rieltor['otch']."<br />";
		
		unset($res);
		$res = mysql_query("SELECT user_id FROM re_user WHERE people_id='".$people_id."' AND active=1 AND archive=0 AND login = '".$rieltor['fio']."'", $db1);
		return mysql_fetch_assoc($res)['user_id'];
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
					//echo $photo_name."<br />";
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
	
	function add_water_mark($people_id, $var_id, $photo_dir, $db1){
		$photo_res = mysql_query("SELECT id, photo, water_mark FROM re_photos WHERE people_id = '".$people_id."' AND var_id = '".$var_id."'", $db1);
		
		$water_mark_file = $_SERVER['DOCUMENT_ROOT'].'/images/waterMark.png';
		$watermark = imagecreatefrompng($water_mark_file); 
		$watermark_width = imagesx($watermark); 
		$watermark_height = imagesy($watermark); 
		
		while($photo = mysql_fetch_assoc($photo_res)){
			if($photo["water_mark"] == 0){
				$file = $photo_dir."/".$photo["photo"];
				
				$image = imagecreatetruecolor($watermark_width, $watermark_height); 
				$image = imagecreatefromjpeg($file); 
				$size = getimagesize($file); 
				$dest_x = ($size[0] - $watermark_width)/2; 
				$dest_y = ($size[1] - $watermark_height)/2; 
				imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, 20); 
				imagejpeg($image, $file);
				imagedestroy($image); 
				
				mysql_query("UPDATE re_photos SET water_mark=1 WHERE id='".$photo['id']."'", $db1);
				//echo "Наложен водяной знак на ".$photo['id']."<br />";
			}
		}
		imagedestroy($watermark); 
	}
	
	/*удаление папок*/
	function removeDirectory($dir){
		if ($objs = glob($dir."/*")){
			foreach($objs as $obj) {
				is_dir($obj) ? removeDirectory($obj) : unlink($obj);
			}
		}
		try{
			rmdir($dir);
		}catch(Exeption $e){}
	}
	
	if(isset($_GET["archive"]) && isset($_GET["photo"]) && isset($_POST["ids"])){
		$mids = str_replace(",", " OR t.mid=", $_POST["ids"]);
		$mids = substr($mids, 0, -10);
		$res = mysql_query("select t.*, l.name, l.phone from text_smart as t, list as l where l.mid = t.mid AND t.object != 20 and t.object != 13 and t.object != 14 and (t.mid = ".$mids.") and t.archive = ".$_GET["archive"]." ORDER BY t.date_opt", $db2);
		unset($mids);
		while($data = mysql_fetch_assoc($res)){
			echo translate_var_to_new($data, $db1, $db2);
		}
		
		$res_var = mysql_query("SELECT v.id as var_id, p.id as people_id FROM re_var as v, re_user as u, re_people as p WHERE v.delete = 1 AND v.user_id = u.user_id AND p.id = u.people_id", $db1);
		while($var = mysql_fetch_assoc($res_var)){
			mysql_query("DELETE FROM re_var WHERE id='".$var['var_id']."'", $db1);
			mysql_query("DELETE FROM re_photos WHERE var_id='".$var['var_id']."'", $db1);
			removeDirectory($_SERVER['DOCUMENT_ROOT'].'/images/'.$var['people_id'].'/'.$var['var_id']);
		}
	}else if($_GET["employee"] == 1){
		$mids = str_replace(",", " OR p.mid=", $_POST["ids"]);
		$mids = substr($mids, 0, -10);
		echo update_people($mids, null, $db1, $db2);
	}
	
	unset($res, $data);
?>