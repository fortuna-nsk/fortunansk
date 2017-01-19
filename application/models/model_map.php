<?
class Model_Map extends Model
{	
	public function get_coords()
	{
		if($_SESSION["user"]){
			$condition = Helper::Post_filters("active=1 and coords!='' and coords is not null");
			$data = DB::Select("coords, id", "re_var", $condition); 
			$data_str ="";
			for($i=0; $i<count($data); $i++){
				if($data[$i]['coords']!=""){
					$data_str .= $data[$i]['coords'].",".$data[$i]['id']."|";
				}
			}
			echo $data_str;
		}
	}
	
	public function get_data_by_coords()
	{
		if($_SESSION["user"] && $_POST['coords']){
			/*$condition = Helper::Post_filters("active=1");*/
			$idList = explode(',', $_POST['idList']);
			$count=count($idList)-1;
			$condition = "v.active=1";
			if($count > 0){
				for($i=0; $i<$count; $i++){
					if($count == 1){
						$condition.=" AND v.id=".$idList[$i];
					}else if($i==0){
						$condition.=" AND (v.id=".$idList[$i];
					}else if($i == $count-1){
						$condition.=" OR v.id=".$idList[$i].")";
					}else{
						$condition.=" OR v.id=".$idList[$i]." ";
					}
				}		
			}else{
				$condition .= Helper::Post_filters();
			}
			//echo $condition;
			unset($idList, $count);
			$order = $_POST ? $_POST["order"] : "date_last_edit";
			$res = mysql_query("SELECT 
							v.id, v.street, v.house, v.price, v.type_id, v.topic_id, v.parent_id, v.room_count, v.planning, v.ap_layout,
							 v.deposit, v.ap_view_date, v.ap_race_date,
							v.deliv_period, v.favorit, v.text, v.sq_all, v.sq_live, v.sq_k, v.furn, v.tv, v.washing, v.refrig, v.residents, 
							v.owner, c.company_name, p.id as people_id, p.name, p.second_name, p.phone, u.user_id 
								FROM re_var as v, re_company as c, re_people as p, re_user as u WHERE v.user_id = u.user_id AND u.people_id = p.id AND p.company_id = c.id AND ".$condition." ORDER BY premium DESC, ".$order." DESC");
			unset($data_str);
			while($data = mysql_fetch_assoc($res)){
				$first_photo = "images/".$data['people_id']."/".$data['id']."/main.jpg";				
				$product_title = Translate::Var_title($data['type_id'], $data['topic_id'], $data['parent_id'], $data['room_count'], $data['planning'], $data['ap_layout'], $data['deliv_period']);
				$f_box = file_exists($first_photo) 
						? "<a class='fancybox-thumbs pull-left' href='".$first_photo."' data-fancybox-group='msg".$data['id']."'><img class='media-object' style='max-width: 100px; width: 100%; height:75px;' src='".$first_photo."'></a>" 
						: "";
				$data_str .= 
				"<div class='balloonContent' data-id={$data['id']}>"
					.$f_box
					.$product_title."<br />"
					.$data['street']." ".$data['house'].
					"<span class='price'>"
						.number_format($data['price'], 0, ',', ' ');
						if($data['deposit'] >0) $data_str .= " (<font style = 'color:red' >Депозит:{$data['deposit']}</font>)</span><br />";
					$data_str .= "</span><br />"
					.($data['owner']!='' ? "проживает: ".$data['owner']."<br />" : "").
					"«".$data["company_name"]."»<br />"
					.$data['name']." ".$data['second_name']."<br />"
					.$data['phone'];
					
					$data_str .= "<input data-name='favorit' type='hidden' value='".$data['favorit']."'>";
					$favorit = !preg_match("/\|".$_SESSION['people_id']."\|/", $data['favorit']);
						if($favorit){
							$data_str .= "<a data-name='fav_star' href='javascript:void(0)' onClick='addToFavorites(\"".$data['user_id']."\", ".$data['id'].")'><img src='images/icon/favorites.png' style='cursor:pointer;height: 30px;float: right;margin-top: -15px;'></a>";
						}else{
							$data_str .= "<a data-name='fav_star' href='javascript:void(0)' onClick='removeFromFavorites(\"".$data['user_id']."\", ".$data['id'].")'><img src='images/icon/favorites_all.png' style='cursor:pointer;height: 30px;float: right;'></a>";
						}
					if($data['text'] != ""){
						$data_str .="<div><a href='javascript:void(0)' onClick='$(this).next().toggleClass(\"hidden\")'>Расширенное описание</a><div class='hidden' style='background-color:#fff;position:absolute;display:block;z-index:9999;padding:5px;left:10px;  border: 1px solid #A0A0A0;'>{$data['text']}";

						if(isset($data['ap_view_date']) && isset($data['ap_race_date'])){
							
							if(date("Y-m-d", strtotime($data['ap_race_date'])) < date("Y-m-d")){
								$data_str .= "<br/><font class='retro-green'>Смотреть и заезжать сегодня!</font><br/>";
							}else{
								$data_str .= "<br/><font class='retro-gray'>Смотреть c : </font><font  style='color: rgb(255, 0, 0);'>".date("d.m", strtotime($data['ap_view_date']))."</font><font class='retro-gray'> заезд c : </font><font  style='color: rgb(255, 0, 0);'>".date("d.m", strtotime($data['ap_race_date']))."</font><br/>";
							}
						}
						if(floatval($data['sq_all']) || floatval($data['sq_live'])|| floatval($data['sq_k']))
						{ 
							$data_str .= "<font class='retro-gray'> пл:</font><font class='retro-green'>";
							if($parent != "Гаражи" && $parent != "Дачи"){
								if($data['sq_all']){$data_str .= $data['sq_all']."/";}else{$data_str .= "-/";}
								if($data['sq_live']){$data_str .= $data['sq_live']."/";}else{$data_str .= "-/";}
								if($data['sq_k']){$data_str .= $data['sq_k'];}else{$data_str .= "-";}
							}else if (floatval($data['sq_live']) && !$ngs){
								$data_str .= $data['sq_live'];
							}else{
								$data_str .= $data['sq_all'];
							}
							$data_str .= "</font>"; 
						}
						if($topic != "Продажа"){
							$data_str .= "<br /><font style='font-weight: normal;font-weight: bold;'>".Helper::FurnListRetro($data['furn'], $data['tv'], $data['washing'], $data['refrig'],  $data['residents'], $ngs)."</font>";
						}
						$data_str.="</div>";
					}
					$data_str .="</div></div>";
			}			
			echo $data_str;
		}
	}
	
	public function map_tolist()
	{
		if(isset($_SESSION['user']) && isset($_POST['coords'])){
			$condition = " (coords='".str_replace("||", "' OR coords='", $_POST["coords"])."')";
			$_POST['coords'] = "";
			$condition = Helper::Post_filters($condition);
			$row_list = "re_var.id, re_var.user_id, re_var.active, re_var.owner, ap_layout, re_var.parent_id, re_var.rent_type, re_var.commission, re_company.company_name, re_people.name, re_people.id as people_id, re_people.second_name, re_people.phone, dis, planning, live_point, street, house, orientir, text, topic_id, type_id, price, date_last_edit, sq_all, sq_live, sq_k, sq_land, floor, floor_count, room_count, coords, deliv_period, prepayment, utility_payment, deposit, furn, tv, washing, refrig, ap_view_date, ap_race_date, status, premium, favorit, ap_view_price, in_black_list, review, residents, wc_type, heating, wash, water, sewage, torg, DATE_FORMAT(DATE_ADD(`date_last_edit`, INTERVAL -1 hour),'%d/%m/%Y %H:%i') as `date_last_edit_format`, DATE_FORMAT(`date_added`, '%d/%m/%Y %H:%i') as `date_added_format`";
			$table = "`re_var` INNER JOIN re_user ON re_var.user_id = re_user.user_id INNER JOIN re_people ON re_user.people_id = re_people.id INNER JOIN re_company ON re_people.company_id = re_company.id INNER JOIN re_access_date_end ON re_company.id = re_access_date_end.company_id";
			$data = DB::Select($row_list, $table, $condition." ORDER BY premium DESC, date_last_edit DESC");
			$num = count($data);
			for($j=0; $j<$num; $j++)
			{
				$data[$j]['date_last_edit'] = Translate::month_ru($data[$j]['date_last_edit_format']);
				$data[$j]['date_added'] = Translate::month_ru($data[$j]['date_added_format']);
			}
			return $data;
		}
	}
}
?>