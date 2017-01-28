<?php //translate_class.php
Class Translate
{
	static function translate_input($input) {
		switch($input) {
			case 'password':
				$input = "Пароль";
				break;
			case 'fio':
				$input = "ФИО";
				break;
			case 'email':
				$input = "Email";
				break;
			case 'group_id':
				$input = "Группа";
				break;
			case 'phone':
				$input = "Контактный телефон";
				break;
			case 'site':
				$input = "Представительский сайт";
				break;
			case 'icq':
				$input = "ICQ";
				break;
		}
		return $input;
	}	
	
	static function month_ru($date)
	{
		$datetime_arr = explode(" ", $date);
				$date_arr = explode("/", $datetime_arr[0]);
				// $month_r = array( 
					// "01" => "Января", 
					// "02" => "Февраля", 
					// "03" => "Марта", 
					// "04" => "Апреля", 
					// "05" => "Мая", 
					// "06" => "Июня", 
					// "07" => "Июля", 
					// "08" => "Августа", 
					// "09" => "Сентября", 
					// "10" => "Октября", 
					// "11" => "Ноября", 
					// "12" => "Декабря"); 
				$date = $date_arr[0].".".$date_arr[1].".".$date_arr[2]." ".$datetime_arr[1];
		return $date;
	}	
	
	static function Estate_type($topic, $parent){		
		if($topic == 1 || $topic == 3)
		{
			$topic = "Аренда";
		}else{
			$topic = "Продажа";
		}
			
		switch($parent) {
			case '1':
				$parent = "Квартиры";
				break;
			case '2':
				$parent = "Новостройки";
				break;		
			case '3':
				$parent = "Дома";
				break;
			case '4':
				$parent = "Дачи";
				break;
			case '5':
				$parent = "Земля";
				break;
			case '6':
				$parent = "Гаражи";
				break;		
			case '7':
				$parent = "Коммерческая";
				break;			
			case '18':
				$parent = "Комната";
				break;	
			case 'all':
				$parent = "Все";
				break;				
		}
		return $topic." ".$parent;
	}
	
	static function Var_title($type_id, $topic_id, $parent_id, $room_count, $planning, $ap_layout, $deliv_period){
		if($type_id >= 19 && $type_id <= 24){
			$type_name = ($type_id-18) ."-комнатную";
		}else if($type_id == 0){
			$type_name = $room_count."-комнатную";
		}else if($type_id > 24){
			$type_name = DB::Select("`name`", "re_type_object", "`id`='".$type_id."'")[0]['name'];
			if($type_id > 24 && $type_id < 30 && $room_count >0){
				$type_name.="/".$room_count." ком.";
			}
		}
		if($planning != ""){
			if($planning != "студия"){
				$planning = preg_replace("/.{4}$/", 'ую', $planning);
			}else{
				$planning = "студию";
			}
		}		
		if($type_id != 18){
			switch($parent_id) {
				case '1':
					$parent_name = "квартиру";
					break;
				case '2':
					$parent_name = "новостройку";
					break;		
				case '3':
					$parent_name = "раздел (коттеджи/дома)";
					break;
				case '4':
					$parent_name = "дачу";
					break;
				case '5':
					$parent_name = "землю";
					break;
				case '6':
					$parent_name = "гараж";
					break;		
				case '7':
					$parent_name = "раздел (коммерческая)";
					break;			
				case '18':
					$parent_name = "комнату";
					break;
			}
		}else{
			$parent_name = "комнату";
		}
		switch ($topic_id){
			case '1':
				$topic_name = "Сдам";
				break;
			case '2':
				$topic_name = "Продам";
				break;
			case '3':
				$topic_name = "Сниму";
				break;
			case '4':
				$topic_name = "Куплю";
				break;
		}
		$topic_name = "<span class='gray'>".$topic_name.": </span>";
		
		if($deliv_period > 0 && $deliv_period < 13){
			$deliv_period_str = " (на ".$deliv_period." мес.)";
		}else if($deliv_period > 12){
			switch ($deliv_period)
			{
				case '13':
					$deliv_period_str = " (лето)";
					break;
				case '14':
					$deliv_period_str = " (длит)";
					break;
				case '15':
					$deliv_period_str = " (на продаже)";
					break;
			}
		}
		$deliv_period_str = " <span class='gray'>".$deliv_period_str."</span>";
		
		if($parent_id == 6){
			if($type_name == "Капитальный" || $type_name == "Металлический"){
				$ap_layout.=" гараж";
			}
		}
		if($parent_name != "квартиру" && $parent_name != "новостройку"){
			if($parent_name == "комнату" && $_SESSION['search_user_id'] == "ngs" && $_GET['task']!="profile"){
				$title = $topic_name."<span style='display: inline-block;text-transform: uppercase;'>".strtolower($parent_name)." ".strtolower($ap_layout).$deliv_period_str."</span>";
			}else{
				$title = $topic_name."<span style='display: inline-block;text-transform: uppercase;'>".strtolower($type_name=="Дача" ? "Дачу" : $type_name).($parent_name == "комнату" ? ", " : " ").strtolower($ap_layout).$deliv_period_str."</span>";
			}
		}else{
			$title = $topic_name."<span style='display: inline-block;text-transform: uppercase;'>".strtolower($type_name).", ".strtolower($planning).$deliv_period_str."</span>";
		}
		
		return $title;
	}
	
	static function Var_title_retro($type_id, $topic_id, $room_count, $planning, $dis, $street, $house, $ap_layout, $parent_id, $city, $action=false){
		if($action){
			if($type_id==18){
				$type_name = "комнату";
			}else if($type_id==1){
				$type_name = $room_count."-комн";
			}else if($type_id==3){
				$type_name = "Дом";
			}
		}else{
			if($type_id >= 19 && $type_id <= 24){
				$type_name = ($type_id-18) ."-ком";
			}else if($type_id == 0){
				$type_name = $room_count."-ком";
			}else if($type_id > 24){
				$type_name = DB::Select("`name_short`", "re_type_object", "`id`='".$type_id."'")[0]['name_short'];
				if($type_id > 24 && $type_id < 30 && $room_count >0){
					$type_name.="/".$room_count." комн";
				}
			}else{
				$type_name = "комн";
			}
		}
/**/		
		if($planning != ""){
			if($planning != "студия"){
				$pl_arr = explode(" ", $planning);
				if(count($pl_arr) == 2){
					$planning = substr($pl_arr[0], 0, 2).substr($pl_arr[1], 0, 2)." * ";
				}else if($planning == "см-изолированная"){
					$planning = "см-из * ";
				}
				else{
					//$planning = preg_replace("/.{4}$/", 'ую', $planning);
					$planning = substr($planning, 0, 4)." * ";
				}
			}else{
				$planning = "студ * ";
			}
		}
		switch ($topic_id){
			case '1':
				$topic_name = "Сдам";
				break;
			case '2':
				$topic_name = "Продам";
				break;
			case '3':
				$topic_name = "Сниму";
				break;
			case '4':
				$topic_name = "Куплю";
				break;
		}
		
		if($dis == "Железнодорожный"){
			$dis = "Ж/Д";
		}else if($dis == "Дзержинский"){
			$dis = substr($dis, 0, 4);			
		}else{
			$dis = substr($dis, 0, 6);
		}
		
		$topic_name = "<span style='color: #476bc6;font-size: 14px;font-weight: bold;'>".$topic_name.": </span>";
		
		if($ap_layout=="в квартире"){
			$ap_layout = "в кв";
		}else if($ap_layout=="в общежитии"){
			$ap_layout = "в общ";
		}else if($ap_layout=="в частном доме"){
			$ap_layout = "в ч/д";
		}else if($ap_layout=="в коттедже"){
			$ap_layout = "в кот";
		}
		
		if($parent_id == 6){
			if($type_name == "кап" || $type_name == "мет"){
				$ap_layout.=" гараж";
			}
		}
		$dis = $city!="Новосибирск" ? $city : $dis;
		if($parent_id == 18){
			$title ="{$topic_name}<span style='font-weight: normal;'> ".strtolower($type_name)." {$ap_layout} * ".strtolower($planning)."{$dis} * {$street} {$house} * </span>";
		}else{
			$title ="{$topic_name}<span style='font-weight: normal;'>".strtolower($type_name)." * ".strtolower($planning)."{$dis} * {$street} {$house} * </span>";
		}
		
		return $title;
	}

	static function Order_type_place($str){
		switch ($str){
				case 'tinkoff_card':
					$result = "Карта Тинькоff";
					break;
				case 'tinkoff':
					$result = "Тинькоff";
					break;
				case 'sber':
					$result = "Сбербанк";
					break;
				case 'qiwi':
					$result = "QIWI";
					break;
				case 'mobil':
					$result = "через мобильный банк";
					break;
				case 'lk':
					$result = "из ЛК";
					break;
				case 'bankomat':
					$result = "через банкомат";
					break;
				case 'cash':
					$result = "через кассира в сбербанке";
					break;
				case 'another_bank':
					$result = "с карты другого банка";
					break;
				case 'wallet':
					$result = "со своего кошелька";
					break;
				case 'terminal':
					$result = "через терминал";
					break;
				case 'euroset':
					$result = "Салон связи";
					break;
			}
		return $result;
	}
}

?>