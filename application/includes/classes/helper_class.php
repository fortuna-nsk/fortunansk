<?
Class Helper
{
	static function Address($address) {				
		for($i=0; $i<count($address); $i++){
			echo "<br />
			<div class='input-group interval xxl'>
				<span class='input-group-addon'>IP</span>
				<input type='text' class='form-control' value='".($address[$i]['ip'] == '1' ? "Любой" : $address[$i]['ip'])."' disabled>
			</div>
			<div class='input-group interval xxl'>
				<input type='text' class='form-control' placeholder='улица' value='".$address[$i]['street']."' disabled>
				<input type='text' class='form-control' placeholder='номер дома' value='".$address[$i]['house']."' disabled>
				<input type='text' class='form-control' placeholder='номер офиса' value='".$address[$i]['office']."' disabled>
			</div>
			<textarea type='text' class='form-control' placeholder='дополнение' disabled>".$address[$i]['comment']."</textarea>";
		}
	}
	
	static function Cost_for_user($j, $ip_rent, $ip_sell){
		$cost = $j*100 + (count(explode ("||",$ip_rent)) - 1)*400;
		$return_str = $cost == '0' ? 'бесплатный аккаунт' : $cost." р.";
		return $return_str;
	}
	
	static function Modal_win_change_user($data, $j){
		$address_rent = Get_functions::Get_address_by_people_id($data[$j]['people_id'], 'rent');	
		$num = count($address_rent);
		$rent_addressess = $num > 0 ? "<legend style='height:30px;'><div class='input-group interval xl left'>
								<span class='input-group-addon'>Доступ к аренде до</span><input type='text' name='rent_date_end' class='form-control' data-id='date' value='".date("Y-m-d",strtotime($data[$j]['rent_date_end']))."'></div><div class='input-group interval left'>
								<span class='input-group-addon'>Премиумы</span><input type='text' name='rent_premium' class='form-control' title='премиумы аренды' placeholder='премиумы аренды' value='".$data[$j]['rent_premium']."'></div><div class='input-group interval left'><span class='input-group-addon'>Переплата</span><input type='text' name='rent_premium' class='form-control' title='премиумы аренды' placeholder='премиумы аренды' value='".$data[$j]['balance']."'></div><div class='input-group interval left'><span class='input-group-addon'>Долг</span><input type='text' name='rent_premium' class='form-control' title='премиумы аренды' placeholder='премиумы аренды' value='".$data[$j]['duty']."'></div><div class='input-group interval left'><span class='input-group-addon'>Абонентка</span><input type='text' name='rent_premium' class='form-control' title='премиумы аренды' placeholder='премиумы аренды' value='".$data[$j]['subscription']."'></div></legend>" : "";
		for($i=0; $i<$num; $i++){
			$checked = $address_rent[$i]['active'] == 1 ? 'checked' : '';
			$rent_addressess .= 
			"<div style='margin: 20 0px;'><input type='text' name='ip_rent".$address_rent[$i]['id']."' class='form-control' title='ip' placeholder='ip' value='".$address_rent[$i]['ip']."'>
			<div class='checkbox' style='margin-left:20px'>
				<label>
				  <input type='checkbox' name='active_rent".$address_rent[$i]['id']."' ".$checked."> Активный
				</label>
			</div>
			<br />
			<input type='text' name='street_rent".$address_rent[$i]['id']."' class='form-control' title='улица' placeholder='улица' value='".$address_rent[$i]['street']."'>
			<input type='text' name='house_rent".$address_rent[$i]['id']."' class='form-control' title='дом' placeholder='дом' value='".$address_rent[$i]['house']."'>
			<input type='text' name='office_rent".$address_rent[$i]['id']."' class='form-control' title='офис' placeholder='офис' value='".$address_rent[$i]['office']."'><div style='height:20px'></div>			
			<textarea rows='4' cols='50' name='comment_rent".$address_rent[$i]['id']."' class='form-control' title='комментарий' placeholder='комментарий'>".$address_rent[$i]['comment']."</textarea></div>";
		}
		$address_sell = Get_functions::Get_address_by_people_id($data[$j]['people_id'], 'sell');
		$num = count($address_sell);
		$sell_addressess = $num > 0 ? "<legend><div class='input-group interval xl left'>
								<span class='input-group-addon'>Доступ к продаже до</span><input type='text' name='sell_date_end' class='form-control' value='".date("Y-m-d",strtotime($data[$j]['sell_date_end']))."'></div><div class='input-group interval left'>
								<span class='input-group-addon'>Премиумы</span><input type='text' name='sell_premium' class='form-control' title='премиумы продажи' placeholder='премиумы продажи' value='".$data[$j]['sell_premium']."'></div></legend>" : "";		
		for($i=0; $i<$num; $i++){
			$checked = $address_sell[$i]['active'] == 1 ? 'checked' : '';
			$sell_addressess .= 
			"<input type='text' name='ip_sell".$address_sell[$i]['id']."' class='form-control' title='ip' placeholder='ip' value='".$address_sell[$i]['ip']."'>
			<div class='checkbox' style='margin-left:20px'>
				<label>
				  <input type='checkbox' name='active_sell".$address_sell[$i]['id']."' ".$checked."> Активный
				</label>
			</div>
			<br />
			<input type='text' name='street_sell".$address_sell[$i]['id']."' class='form-control' title='улица' placeholder='улица' value='".$address_sell[$i]['street']."'>
			<input type='text' name='house_sell".$address_sell[$i]['id']."' class='form-control' title='дом' placeholder='дом' value='".$address_sell[$i]['house']."'>
			<input type='text' name='office_sell".$address_sell[$i]['id']."' class='form-control' title='офис' placeholder='офис' value='".$address_sell[$i]['office']."'><div style='height:20px'></div>
			<textarea rows='4' cols='50' name='comment_sell".$address_sell[$i]['id']."' class='form-control' title='комментарий' placeholder='комментарий'>".$address_sell[$i]['comment']."</textarea>";
		}		
		$modal =
		"<div class='modal fade' id='modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Изменение пользователя id (".$data[$j]['user_id'].")</h4>
			  </div>
			  <form class='form-inline'>				
				  <div class='modal-body'>							
					<legend>Данные авторизации<label class='right'>".$data[$j]['date_company_reg']."</label></legend>					
					<div class='row'>
						<div class='col-xs-5 deployed'>	
							<div class='input-group interval xxl'>
								<span class='input-group-addon'>А.Н.</span>
								<input type='text' name='company_name' class='form-control' title='ан' placeholder='ан' value='".$data[$j]['company_name']."' style='min-width: 300px;'>
							</div>		
						</div>
						<div class='col-xs-3 deployed'>	
							<div class='input-group interval xxl'>
								<span class='input-group-addon'>Логин</span>
								<input type='text' name='login' class='form-control' title='логин' placeholder='логин' value='".$data[$j]['login']."'>
							</div>		
						</div>	
						<div class='col-xs-3 deployed'>	
							<div class='input-group interval xxl'>
								<span class='input-group-addon'>Пароль</span>
								<input type='text' name= 'password' class='form-control' title='пароль' placeholder='пароль' value='".$data[$j]['password']."'>
							</div>		
						</div>	
					</div>	
					<div style='height: 20px;'></div>
					
					<legend>Личные данные</legend>
					<input type='text' name='surname' class='form-control' title='фамилия' placeholder='фамилия' value='".$data[$j]['surname']."'>
					<input type='text' name='name' class='form-control' placeholder='имя' title='имя' value='".$data[$j]['name']."'>					
					<input type='text' name='second_name' class='form-control' title='отчество' placeholder='отчество' value='".$data[$j]['second_name']."'>
					<br />
					<input type='text' data-id='phone' name='phone' class='form-control' title='телефон' placeholder='телефон' value='".$data[$j]['phone']."'>
					<input type='text' name='email' class='form-control' title='e-mail' placeholder='e-mail' value='".$data[$j]['email']."'>
					<input type='text' name='nickname' class='form-control' title='nickname' placeholder='nickname' value='".$data[$j]['nickname']."'>
					<textarea rows='3' cols='30' id='phone' name='phone_addon' class='form-control' title='доп.телефоны' placeholder='доп.телефоны' style='position: absolute; margin: -35px 0px 0px;'>".$data[$j]['phone_addon']."</textarea>					
					<div style='height: 20px;'></div>
					<textarea rows='4' cols='70' id='phone' name='comment' class='form-control' title='доп.телефоны' placeholder='коментарии с фортуны'>".$data[$j]['comment']."</textarea>
					<div style='height: 20px;'></div>					
					
					".$rent_addressess."
					<div style='height: 20px;'></div>
					
					".$sell_addressess."					
				  </div>
				  <input type='hidden' name='user_id' value='".$data[$j]['user_id']."'>
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary' onclick='formSubmit()'>Сохранить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}
	
	static function Modal_win_find_address(){
		$modal =
		"<div class='modal fade' id='modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%;'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Поиск адреса. Укажите место.</h4>
			  </div>
			  <form class='form-inline'>				
				  <div class='modal-body'>							
						 <div id='map' style='width: 100%; height: 400px'></div>						 
				  </div>				  
				  <div class='modal-footer'>
					<button type='button' data-id='toggleMap' class='btn btn-success left'>2 ГИС(в разработке...)</button>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary' onclick='formSubmit()'>Сохранить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}	
	
	static function Modal_win_clean(){
		//$del_button = $_GET['action']=='mytype' && $_GET['active']=='0' ? "<button type='button' onclick='ArchiveDeleteReview' class='btn btn-danger'>Удалить отзыв</button>" : "";
		$modal =
		"<div class='modal fade' id='clean-modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%; max-width:700px'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'></h4>
			  </div>
			  <form class='form-inline'>				
				  <div class='modal-body'></div>				  
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary'>Отправить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}
	
	static function Modal_win_send_review(){		
		$modal =
		"<div class='modal fade' id='send-review-modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%; max-width:700px'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Отзыв о сообщении</h4>
			  </div>
			  <form class='form-inline' id='send-review'>				
				  <div class='modal-body'>
					<p><textarea name='text' class='form-control' placeholder='содержание отзыва' rows='5' cols='80'></textarea></p>
					<div class='checkbox'>
						<label>
							<input type='checkbox' id='anonymous' name='anonymous' value='1'>Если хотите ,чтобы ваш комментарий увидел только администратор поставьте галочку
						</label>
					</div>
				  </div>				  
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary'>Отправить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}	
	
	static function Modal_win_add_to_black_list(){				
		$modal =
		"<div class='modal fade' id='add-to-black-list-modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%; max-width:700px'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Добавление риелтера в черный список</h4>
			  </div>
			  <form class='form-inline' id='add-to-black-list'>				
				  <div class='modal-body'>
					<p><textarea name='text' class='form-control' placeholder='причина добавления в черный список' rows='5' cols='80'></textarea></p>					
				  </div>				  
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary'>Отправить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		return $modal;
	}	
	
	static function Modal_win_messages(){				
		$modal =
		"<div class='modal fade' id='messages-modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%; max-width:700px'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Переписка</h4>
			  </div>
				<div class='modal-body'>
					<div class='messages_list'></div>
					<p><textarea name='text' class='form-control' placeholder='ответ' rows='5' cols='80'></textarea></p>					
				</div>				  
				<div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary'>Отправить</button>
				</div>
			</div>
		  </div>
		</div>";
		return $modal;
	}	
	
	static function Modal_win_group_setting(){
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
			//$condition = "CONCAT_WS(' ', surname, name, second_name)='".$_SESSION['fio']."'";
			$people_list = DB::Select($column, $table, $condition);
			for($i = 0; $i<count($people_list); $i++){			
				$fio = $people_list[$i]['surname']." ".$people_list[$i]['name']." ".$people_list[$i]['second_name'];
				$checked = (!ereg($fio, $group_list['black_group'])) ? "checked" : "";
				$peoples.=	"<tr>
								  <td>".$people_list[$i]['company_name']."</td>
								  <td>".$people_list[$i]['name']." ".$people_list[$i]['second_name']."</td>
								  <td>".$people_list[$i]['phone']."</td>
								  <td><input type='checkbox' value='".$fio."' ". $checked ."></td>
							</tr>";
			}
		}
		unset($group_list, $group_list_arr, $count, $condition, $table, $column, $people_list);
		$modal =
		"<div class='modal fade' id='modal-win-group' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%;'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'>Настройка своей группы. <span class='right'>В мою группу входят все кроме исключенных из нее</span></h4>
			  </div>
			  <form class='form-inline' id='group_setting'>				
				  <div class='modal-body'>	
						<div class='row info' style='margin:0'>
							<h4>Исключить из моей группы</h4>
							<hr>
							<div class='col-xs-4'>
								<label class='signature'>Телефон риелтера</label>
								<input type='text' class='form-control' data-id='phone' onkeyup='SearchRieleter($(this).val())'>								
							</div>
							<div class='col-xs-4'>	
								<label class='signature'>Название АН</label>
								<input type='text' class='form-control' data-name='an-list' placeholder='агентство' value=''>
								<div class='an_list' style='display: none;overflow: auto; height: 250px;'></div>
								<input type='hidden' name='company_id' value=''>		
							</div>
							<div class='col-xs-12'>
								<table class='table table-striped' data-id='seacrh-rielter'>
									<thead>
										<tr><th>Агентство</th><th>Имя</th><th>Телефон</th><th></th></tr>
									</thead>
									<tbody>		
									</tbody>
								</table>
							</div>
						</div>
						<div class='col-xs-12' style='font-size:17px; margin-top:25px'>Список риелтеров, которые не входят в мою группу и не видят мои варианты</div>
						<table class='table table-striped' data-id='black-group'>
							<thead>
								<tr><th>Агентство</th><th>Имя</th><th>Телефон</th><th>Амнистировать</th></tr>
							</thead>
							<tbody>			
								".$peoples."
							</tbody>
						</table>
				  </div>				  
				  <div class='modal-footer'>
					<button type='button' class='btn btn-default' data-dismiss='modal'>Отмена</button>
					<button type='button' class='btn btn-primary' onclick='formSubmit(\"group_setting\");'>Сохранить</button>
				  </div>
				</form> 
			</div>
		  </div>
		</div>";
		unset($people);
		return $modal;
	}
	
	static function Post_filters($condition)
	{
		$r=0;/*счетчики повторов*/
		$p=0;
		$d=0;
		$s=0;
		$sq=0;
		$t=0;
		$type_id="";
		foreach($_POST as $k => $v){
			if(!ereg("Выбрано", $v) && !ereg("не важно", $v) && $k != "search_user_id" && $k != "view_type" && $k!="without_cont" && $k!="order" && $k!="residents" && $k!="task" && $k!="action"){
				if (ereg('room_count', $k) && $r==0 && $v!=""){
					if($_SESSION['search_user_id'] == "site"){
						if($_POST["parent_id"] != 18){$condition.=" AND (`room_count`='".$v."'";}
						else{$condition.=" AND `room_count`<='".$v."'";}
					}else{$condition.=" AND (`type_id`='".($v + 18)."'";}
					$r++;
				}else if(ereg('room_count', $k) && $v != ""){
					if($_SESSION['search_user_id'] == "site"){
						$condition.=" OR `room_count`='".$v."'";}
					else{$condition.=" OR `type_id`='".($v + 18)."'";}
					$r++;
				}else if(ereg('planning', $k)){
					if ($r > 0){$condition.=")"; $r = 0;}
					if($v!="")$condition.=" AND `{$k}`='{$v}'";
				}else if(ereg('price', $k) && $p==0){
					if ($r > 0){$condition.=")"; $r = 0;}
					if ($v != ""){
						$condition.=" AND (`price` BETWEEN ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v);$p++;
					}else{$condition.=" AND (`price` BETWEEN 0"; $p++;}
				}else if(ereg('price', $k)){
					if($v!=""){
						$condition.=" AND ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v).")";
					}else{$condition.=" AND 999999999)";}
				}else if(ereg('dis', $k) && $d==0){
					if($v!=""){$condition.=" AND (`dis`='".$v."'"; $d++;}
				}else if(ereg('dis', $k)){
					if($v!=""){$condition.=" OR `dis`='".$v."'";}
				}else if(ereg('street', $k) && $s==0){
					if($d != 0){$condition.=")";$d=0;}
					if($v!=""){$condition.=" AND (`street`='".$v."'"; $s++;}
				}else if(ereg('street', $k)){
					if($v!=""){$condition.=" OR `street`='".$v."'";}
				}else if(ereg('house', $k)){
					if($s != 0){$condition.=")";$s=0;}
					if($v != ""){$condition.=" AND `".$k."`='".$v."'";}
				}else if(ereg('from', $k) && $sq==0){	
					$k = preg_replace("/from/", '', $k);
					if($v!=""){
						$condition.=" AND (`".$k."` BETWEEN ".$v.""; 
						$sq++;
					}else{$condition.=" AND (`".$k."` BETWEEN 0"; $sq++;}
				}else if(ereg('to', $k) && $sq>0){
					if($v!=""){
						$condition.=" AND '".$v."')"; 
						$sq=0;
					}else{$condition.=" AND 99999999)"; $sq=0;}
				}else if($k == "parent_id" && $v == "18" && $_SESSION['search_user_id'] == "ngs"){
					$condition.=" AND type_id=18";
				}else if($k == "live_point" && $v=="НСО"){
					$condition.=" AND `live_point` != 'Новосибирск'";
				}else if($k=="hours"){
					$condition.=" AND DATE_ADD(date_last_edit, INTERVAL ".$v.") >= NOW()";
				}else if($k=="to_metro" && $v!=""){
					$condition.=" AND `distance_to_metro` > 0 AND coords!='55.030199,82.92043' AND `distance_to_metro` < ".$v;
				}else if(ereg('type_id', $k) && $v!=""){
					if($t==0){$type_id.="type_id={$v}"; $t++;}
					else{$type_id.="||{$v}"; $t++;}
				}else if($k=="company_id" && $v != ""){
					$condition.=" AND re_people.company_id='".$v."'";
				}else{
					if ($v != ""){$condition.=" AND `".$k."`='".$v."'";}
				}
			}else if($k=="residents"){
				$residents = explode("||", $v);
				foreach($residents as $resident){
					if($resident!=""){
						$condition.=" AND residents like '%".$resident."%'";
					}
				}
			}
		}
		if($t>0){
			$condition.= " AND (".(str_replace("||", " OR type_id=", $type_id)).")";
		}
		return $condition;
	}
	
	static function Get_filters($condition){
		$room_count="";
		$dis="";
		$street="";
		$type_id="";
		$sq = 0;
		$p = 0;
		foreach($_GET as $k=>$v){
			if($k!="task" && $k!="action" && !ereg('Выбрано', $v) && $k!="residents" && $k!="order" && $k!="search_user_id" && $k!="hours" && $k!="view_type" && $k != "company_id" && $k != "page" && $k != "limit" && $k!="view_type" && $k!="residents" && $k!="without_cont"&& $k!="id"&& $k!="race_now"){
				if(ereg('room_count', $k) && $v!=""){
					if($_GET['action']!="parse"){
						$room_count.="{$v}||";
					}else{
						$room_count.=($v+18)."||";
					}
				}
				else if($k=='pricefrom'){
					if ($v != ""){
						$condition.=" AND (price BETWEEN ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v);
					}else{
						$condition.=" AND (price BETWEEN 0"; $p++;
					}
				}else if($k=='priceto'){
					if ($v != ""){
						$condition.=" AND {$v})";
					}else{
						$condition.=" AND 99999999)";
					}
				}else if(ereg('dis', $k) && $v!=""){
					$dis.="{$v}||";
				}else if(ereg('street', $k) && $v!=""){			
					//$v = str_replace(["проспект ", " проспект"], "", $v);
					$street.="{$v}||";
				}else if(ereg('from', $k) && $sq==0){
					$k = preg_replace("/from/", '', $k);
					if($v!=""){
						$condition.=" AND ({$k} BETWEEN {$v}"; 
						$sq++;
					}else{
						$condition.=" AND ({$k} BETWEEN 0"; $sq++;
					}
				}else if(ereg('to', $k) && $sq>0){
					if($v!=""){
						$condition.=" AND '{$v}')"; 
						$sq=0;
					}else{
						$condition.=" AND 99999999)"; $sq=0;
					}
				}else if($k=="favorit"){
					$condition.=" AND {$k} like '%|{$v}|%'";
				}else if($k=="parent_id"){
					if($v==18 && $_GET['action']=="parse"){
						$condition.=" AND ({$k} = '{$v}' OR type_id='18')";
					}else{
						$condition.=" AND {$k} = '{$v}'";
					}
				}else if($k=="to_metro" && $v!=""){
					$condition.=" AND `distance_to_metro` > 0 AND coords!='55.030199,82.92043' AND `distance_to_metro` < ".$v;
				}else if(ereg('type_id', $k) && $v!=""){
					$type_id.="{$v}||";
				}else if($v != ""){
					$condition.=" AND {$k}='{$v}'";
				}
			}
		}
		if($_GET['action']!="parse"){
			if($room_count!="")$condition .= Helper::MultiCondition("room_count='".$room_count, "' OR room_count='");
		}else{
			if($room_count!="")$condition .= Helper::MultiCondition("type_id='".$room_count, "' OR type_id='");
		}
		if($dis!="")$condition .= Helper::MultiCondition("dis='".$dis, "' OR dis='");

		//if($street!="")$condition .= Helper::MultiCondition("street = '".$street, "' OR street = '", "'");
		if($street!="")$condition .= Helper::MultiCondition("street = '".$street, "' OR street = '", "'");
		//if($street!="")$condition .= " AND `street`='{$street}' ";

		if($_GET['residents']!="")$condition .= Helper::MultiCondition("residents like '%".$_GET['residents'], "%' AND residents like '%", "%'");
		if($type_id!="")$condition .= Helper::MultiCondition("type_id='".$type_id, "' OR type_id='");
		if($_SESSION['people_id']==1){
		//	echo $condition;
		}
		return $condition;
	}
	
	static function MultiCondition($str, $delimiter, $s="'"){
		return " AND (".(str_replace("||", "{$delimiter}", substr($str, 0, -2)))."{$s})";		
	}
	
	static function Price($price, $prepayment, $utility_payment, $deposit, $view_date, $race_date){
		$str_price = number_format($price, 0, ',', ' ');
		if(isset($prepayment)){
			$str_price.="/".$prepayment;
		}
		switch ($utility_payment)
		{
			case 'платить дополнительно':
				$utility_payment = "+ <img title='дополнительно за свет' width='20px' style='margin-right:2px' src='images/icon/lite.png'> + <img title='дополнительно за воду' width='20px' src='images/icon/water.png'>";
				break;
			case 'оплата включена в цену':
				$utility_payment = " + <img title='все включено' width='20px' src='images/icon/allinc.png'>";
				break;
			case 'дополнительно только за воду':
				$utility_payment = " + <img title='дополнительно за воду' width='20px' src='images/icon/water.png'>";
				break;
			case 'дополнительно только за свет':
				$utility_payment = "+ <img title='дополнительно за свет' width='20px' src='images/icon/lite.png'>";
				break;
		}
		if($deposit > 0){
			$utility_payment.=" + депозит(".$deposit.")";
		}
		unset($price, $prepayment, $deposit);
		if($_SESSION['post']['view_type'] != "compact"){
			$result = $str_price." <span style='display: inline-block;font-size: 18px; vertical-align: text-top;'>".$utility_payment."</span>";
		}else{
			$result = $str_price." <span style='display: inline-block;font-size: 17px; vertical-align: top;'>".$utility_payment."</span>";
		}
		return $result;
	}
	
	static function PriceRetro($price, $prepayment, $utility_payment, $torg, $rent_type, $topic, $topic_id){
		$str_price = number_format($price, 0, ',', ' ');
		if($topic=="Аренда"){
			$rent_type = $rent_type == "16" ? "сут" : "мес";
			if(isset($prepayment) && $topic_id!=3 && $topic_id!=4){
				$str_price.=" / ".$prepayment."<font  class='retro-gray'> {$rent_type}.,".($torg==1 ? ' торг! ' : ' ')."</font>";
			}
			switch ($utility_payment)
			{
				case 'платить дополнительно':
					$utility_payment = "<font style='color:green; font-size: 13px'>+ ВОДА, СВЕТ.</font>";
					break;
				case 'оплата включена в цену':
					$utility_payment = "<font style='color:green; font-size: 13px'>ВСЕ ВКЛЮЧЕНО.</font>";
					break;
				case 'дополнительно только за воду':
					$utility_payment = "<font style='color:green; font-size: 13px'>+ ВОДА.</font>";;
					break;
				case 'дополнительно только за свет':
					$utility_payment = "<font style='color:green; font-size: 13px'>+ СВЕТ.</font>";;
					break;
			}
			unset($price, $prepayment);		
			$result = "<font style='color: #476BC6;font-size: 16px;'>цена: </font><span data-name='price'>{$str_price}</span> <font style='display: inline-block;font-size: 17px; vertical-align: top;'>".$utility_payment."</font>";		
		}else{
			$result = "<font style='color: #476BC6;font-size: 16px;'>цена: </font>{$str_price} <font  class='retro-gray'>".($torg==1 ? ' торг! ' : ' ')."</font>";
		}
		return $result;
	}
	
	static function FurnList($inet, $furn, $tv, $washing, $refrig, $conditioner, $view_date, $race_date, $residents){
		$class = array(0 => "_off",1 => "");
		$exist = array(0 => "отсутствует",1 => "есть");		
		$furnList = "<span style='display:inline-block'><img width='22px' title='мебель ".$exist[$furn]."' src='images/icon/furn".$class[$furn]."'></span>"
					."<span style='display:inline-block'><img width='22px' title='холодильнык ".$exist[$refrig]."' src='images/icon/refrig".$class[$refrig]."'></span>"
					."<span style='display:inline-block'><img width='22px' title='телевизор ".$exist[$tv]."' src='images/icon/tv".$class[$tv]."'></span>"
					."<span style='display:inline-block'><img width='22px' title='стиральная машина ".$exist[$washing]."' src='images/icon/washing".$class[$washing]."'></span>"	
					."<span style='display:inline-block'><img width='22px' title='интернет ".$exist[$inet]."' src='images/icon/wifi".$class[$inet]."'></span>"
					."<span style='display:inline-block'><img width='22px' title='кондиционер ".$exist[$conditioner]."' src='images/icon/conditioner".$class[$conditioner]."'></span>";
		$furnList.=Helper::Residents($residents);
		if(isset($view_date) && isset($race_date) && $_SESSION['post']['view_type'] != "compact"){
			$view_arr = explode('-', $view_date);
			$race_arr = explode('-', $race_date);
			$view = $view_arr[2].".".$view_arr[1].".".$view_arr[0];
			$race = $race_arr[2].".".$race_arr[1].".".$race_arr[0];
			if(date('d.m.y', strtotime($race)) < date('d.m.y') || $race_arr[0] == '0000'){
				$furnList.="<span style='  font-size: 14px;'>просмотр и заезд сегодня</span>";
			}else{
				$furnList.="<span style='  font-size: 14px;'> просмотр: ".$view.", заезд: ".$race."</span>";
			}
		}
		return $furnList;
	}
	
	static function FurnListRetro($furn, $tv, $washing, $refrig, $residents, $ngs, $pay_parse=false){
		$furnList = '';
		$class = array(1 => "color: rgb(0, 128, 0);text-transform: uppercase;",0 => "color: rgb(255, 0, 0);");
		$exist = array(0 => "-",1 => "+");	
		if(!$ngs){
			$furnList = "<font style='{$class[$furn]}'>м{$exist[$furn]}</font> "
					."<font style='{$class[$refrig]}'>х{$exist[$refrig]}</font> "
					."<font style='{$class[$tv]}'>tv{$exist[$tv]}</font> "
					."<font style='{$class[$washing]}'>ст{$exist[$washing]}</font>";		
		}else if(!$pay_parse){
			$furnList = "<font style='{$class[$furn]}'>м{$exist[$furn]}</font> "
					."<font style='{$class[$refrig]}'>х{$exist[$refrig]}</font> ";
		}
		return $furnList;
	}
	
	static function Residents($residents)
	{
		if (count(explode("||", $residents)) > 0){$img.="&nbsp;&nbsp;&nbsp;";}
		//$residents_arr = ;
		if(ereg("Одиноких мужчин", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут одиноких мужчин' src='images/icon/residents/man.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут одиноких мужчин' src='images/icon/residents/man_off.png' /></span>";
		}
		if(ereg("Одиноких женщин", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут одиноких женщин' src='images/icon/residents/woman.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут одиноких женщин' src='images/icon/residents/woman_off.png' /></span>";
		}
		if(ereg("Семейных", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут семейных' src='images/icon/residents/married.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут семейных' src='images/icon/residents/married_off.png' /></span>";
		}		
		if(ereg("С детьми", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут с детьми' src='images/icon/residents/baby.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут с детьми' src='images/icon/residents/baby_off.png' /></span>";
		}
		if(ereg("Студентов", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут студентов' src='images/icon/residents/student.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут студентов' src='images/icon/residents/student_off.png' /></span>";
		}
		if(ereg("Строителей", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут строителей' src='images/icon/residents/bilder.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут строителей' src='images/icon/residents/bilder_off.png' /></span>";
		}
		if(ereg("Нерусских", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут иностранцев' src='images/icon/residents/inostran.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут иностранцев' src='images/icon/residents/inostran_off.png' /></span>";
		}
		if(ereg("С животными", $residents)){
			$img.="<span class='resident'><img width='22px' title='берут с животными' src='images/icon/residents/animal.png' /></span>";
		}else{
			$img.="<span class='resident'><img width='22px' title='не берут с животными' src='images/icon/residents/animal_off.png' /></span>";
		}		
		unset($residents);
		return $img;
	}
	
	static function ResidentsRetro($residents, $topic_id)
	{
		if(!isset($img))$img = '';
		if (count(explode("||", $residents)) > 0){
			$img.="<font class='retro-gray'> ".($topic_id==1||$topic_id==2 ? "берут:" : "состав жильцов:")." </font><font class='retro-green'> ";
		}
		if(ereg("1м", $residents)){
			$img.="1м,";
		}
		if(ereg("1ж", $residents)){
			$img.="1ж,";
		}
		if(ereg("Сп\|", $residents)){
			$img.="сп,";
		}	
		if(preg_match("/Сп.р/", $residents)){
			$img.="сп*р,";
		}
		if(ereg("Студ", $residents)){
			$img.="студ,";
		}
		if(preg_match("/Ж.р/", $residents)){
			$img.="ж*р,";
		}
		if(ereg("Нер", $residents)){
			$img.="нер,";
		}
		if(ereg("Жив", $residents)){
			$img.="жив,";
		}
		if(ereg("2м", $residents)){
			$img.="2м,";
		}	
		if(ereg("2ж", $residents)){
			$img.="2ж,";
		}	
		if(ereg("субаренда", $residents)){
			$img.="субаренда,";
		}		
		unset($residents);
		return substr($img, 0, -1)."</font>";
	}
	
	static function An_options(){
		$an_names =  DB::Select('DISTINCT company_name, company_id', 're_company INNER JOIN re_people ON re_company.id = re_people.company_id', "date_dismiss = '0000-00-00 00:00:00' ORDER BY company_name");
		$num = count($an_names);
		for($c=0; $c<$num; $c++)
		{
			echo "<option value='".$an_names[$c]['company_id']."'>".$an_names[$c]['company_name']."</option>";
		}
		unset($num, $an_names, $c);
	}
	
	static function Login_options(){
		$logins =  DB::Select('surname, name, second_name, login, user_id', 're_people INNER JOIN re_user ON re_people.id = re_user.people_id', "archive = 0 ORDER BY login");
		$num = count($logins);
		for($l=0; $l<$num; $l++)
		{
			echo "<option value='".$logins[$l]['user_id']."'>".$logins[$l]['login']." ".$logins[$l]['surname']." ".$logins[$l]['name']." ".$logins[$l]['second_name']."</option>";
		}
		unset($num, $logins, $l);
	}
	
	static function City_list_options(){
		$cities = DB::Select("distinct name", "re_city");
		$cities['count'] = count($cities);
		return $cities;
	}
	
	static function Services_data(){
		if($_SESSION['parent']==0){
			$query = "SELECT u.group_topic_id, TO_DAYS(rent_date_end) - TO_DAYS(NOW()) as day_count, rent_premium, balance, duty, subscription, duty_comment, rent_date_end, sell_date_end FROM re_company as c, re_access_date_end as a, re_user as u, re_people as p WHERE c.id=a.company_id AND p.id=u.people_id AND p.company_id=c.id AND c.id = '{$_SESSION['company_id']}' AND u.parent=0 limit 1";
			$data = mysql_fetch_assoc(mysql_query($query));
			$res = mysql_query("(SELECT p.id, p.company_id, p.month_count, p.day_count, p.premium_count, p.sum, p.date_finish, p.date_payment, p.comment from re_payment as p where company_id = '".$_SESSION['company_id']."') UNION (SELECT a.id, a.company_id, null, null, null, a.comment, a.date, a.date, null from re_applications as a where company_id = '".$_SESSION['company_id']."' and `comment` like '%оплачено%') ORDER BY date_payment DESC");
			$count = mysql_num_rows($res);
			for($i=0; $i<$count; $i++){
				$res_data[] = mysql_fetch_assoc($res); 
			}
			$data["payment_list"] = $res_data;
			unset($res);
			$res = mysql_query("SELECT date_finish, SUM(premium_count) AS prem_sum FROM re_payment WHERE company_id = ".$_SESSION["company_id"]." AND active = 1 AND premium_count > 0 GROUP BY (date_finish) ORDER BY date_finish");
			while($row = mysql_fetch_assoc($res)){
				$data["prem_end_date"][] = $row;
			}
			unset ($query, $res, $count, $i, $res_data, $row);
			return $data;
		}
	}

	static function Service_Need_Finance($factor,$count,$sum,$duty){
		$balance = DB::Select("balance", "re_company", "id=".$_SESSION["company_id"])[0]['balance'];
		$financeNeed = $balance - ($factor * $count * $sum) - $duty;
		if($financeNeed >= 0) return true;
		return false;
	}
		
	
	static function Session_date_update(){

		if(isset($_SESSION["start_time"])){
			$date = date("Y-m-d H:i:s", strtotime("+2 hours"));
			$count = mysql_fetch_assoc(mysql_query("SELECT count(*) as count FROM re_session WHERE people_id = '{$_SESSION['people_id']}' AND name='".session_id()."'"))['count'];
			if($count == 0){
				$sessionDir = $_SERVER['DOCUMENT_ROOT'].'sessions/';
				unlink($sessionDir.session_id());
				DB::Delete("re_session", "people_id='{$_SESSION['people_id']}'");
				session_destroy();
				header('Location: /');
			}else{
				DB::Update("re_session", "date_update = '{$date}'", "people_id = '{$_SESSION["people_id"]}'");
			}
			unset($date, $ses_date);
		}
	}

	static function Session_update(){
		if(isset($_SESSION["start_time"]) && $_SESSION['admin']==0){
			$date = date("Y-m-d H:i:s");
			DB::Delete("re_session", "DATE_ADD(date_start, INTERVAL +5 HOUR) < NOW()");
			$count = mysql_fetch_assoc(mysql_query("SELECT count(*) as count FROM re_session WHERE people_id = '{$_SESSION['people_id']}' AND name='".session_id()."'"))['count'];
			if($count == 0){
				DB::Delete("re_session", "people_id='{$_SESSION['people_id']}'");
				session_destroy();
				header('Location: /');
				// $res = mysql_query("SELECT GROUP_CONCAT(v.id) as cond FROM re_user as u, re_people as p, re_access_date_end as a, re_var as v Where u.people_id = p.id AND p.company_id = a.company_id AND a.rent_date_end < NOW() AND u.user_id = v.user_id AND v.active = 1 AND DATE_ADD(date_last_edit, INTERVAL 24 hour) >= NOW() AND topic_id = 1");
				// $condition = mysql_fetch_assoc($res)['cond'];
				//DB::Update("re_var as v", "active=0", "v.id=".$condition);
			}else{
				$_SESSION["start_time"] = $date;
				DB::Update("re_session", "date_start = '{$date}'", "people_id = '{$_SESSION["people_id"]}'");
			}
			unset($date, $ses_date);
		}
	}
	
	static function Main_photo_update($way)
	{
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$way."main.jpg")){
			unlink($_SERVER['DOCUMENT_ROOT'].$way."main.jpg");
		}
		$i=0;
		$dir =  opendir(substr($way, 1, -1));
		while($file = readdir($dir)){
			if($file!="." && $file!=".." && $i==0){
				$thumb = PhpThumbFactory::create($_SERVER['DOCUMENT_ROOT'].$way.$file);
				$thumb->adaptiveResize(200, 150);
				$thumb->save($_SERVER['DOCUMENT_ROOT'].$way."main.jpg");
				$i++;
				unset($thumb);
			}
		}
	}
	
	static function Add_watermark($photo){		
		$watermark = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].'/images/waterMark.png'); 
		$watermark_width = imagesx($watermark); 
		$watermark_height = imagesy($watermark); 
		
		$image = imagecreatetruecolor($watermark_width, $watermark_height); 
		$image = imagecreatefromjpeg($photo); 
		
		$size = getimagesize($photo);
		$dest_x = $size[0] - $watermark_width - 40; 
		$dest_y = $size[1] - $watermark_height - 40; 
		
		imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, 50); 
		
		imagejpeg($image, $photo);
		imagedestroy($image); 
		imagedestroy($watermark); 
	}
	
	static function Send_mail($email, $subject, $text){
		//require 'modules/phpMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		//$mail->SMTPDebug = 3; // Enable verbose debug output

		$mail->isSMTP();
		$mail->Host = 'smtp.mail.ru';
		$mail->SMTPAuth = true;
		$mail->Username = '89139179516@mail.ru';
		$mail->Password = 'BLKJf934tnkks4(nn';
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
		
		$mail->CharSet='UTF-8';
		$mail->From = '89139179516@mail.ru';
		$mail->FromName = 'Fortunasib';
		$mail->addAddress($email);
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
		$mail->isHTML(true);

		$mail->Subject = $subject;
		$mail->Body    = $text;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
	}
	
	static function Online_count(){
		$res=mysql_query("SELECT count(*) as c FROM re_session WHERE DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -5 MINUTE), '%Y-%m-%d%H%i%s') < DATE_FORMAT(date_update, '%Y-%m-%d%H%i%s')");
		return mysql_fetch_assoc($res)['c'];
	}
	
	static function Online_bool($id){
		$res=mysql_query("SELECT count(*) as c FROM re_session WHERE DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -5 MINUTE), '%Y-%m-%d%H%i%s') < DATE_FORMAT(date_update, '%Y-%m-%d%H%i%s') AND people_id={$id}");
		return mysql_fetch_assoc($res)['c'];
	}
	
	static function Admin_message(){
		$mes = DB::Select("*", "re_messages", "people_id_to={$_SESSION['people_id']} AND new=1 AND people_id_from=1");
		if(count($mes)>0 || $_SESSION['show_message']==1){
			echo "<div class='admin-mes'><button type='button' class='close' style='padding-right: 5px;' onclick='$(this).parent().remove()'><span aria-hidden='true'>×</span></button>";
			if($_SESSION['show_message']==1){
				$access_data = DB::Select("DATE_FORMAT(a.rent_date_end,'%d.%m.%Y') as rent_date_end, DATE_FORMAT(a.sell_date_end,'%d.%m.%Y') as sell_date_end, c.company_name, c.balance, c.subscription, c.duty, c.rent_premium", "re_access_date_end as a, re_company as c", "c.id = {$_SESSION['company_id']} AND c.id = a.company_id")[0];
				$recharge = ($access_data['balance'] - 50 - $access_data['duty'] - $access_data['subscription']) > 0;
				$warn_rent = date('Y-m-d', strtotime($access_data['rent_date_end']." - 5 day")) <= date('Y-m-d') ? "rgb(205, 24, 24);" : "rgb(0, 128, 0);";
				$warn_sell = date('Y-m-d', strtotime($access_data['sell_date_end']." - 5 day")) <= date('Y-m-d') ? "rgb(205, 24, 24);" : "rgb(0, 128, 0);";
				$duty_color = $access_data['duty'] > 0 ? "rgb(205, 24, 24);" : "#000;";
				$balance_color = $access_data['balance'] > 0 ? "rgb(0, 128, 0);" : "#000";
				echo "<div style='padding: 5px;'><span style='display: block;text-align: center;'>АН «{$access_data['company_name']}»</span>";
				echo "</span><div>Аренда до: <font style='color:{$warn_rent}'>{$access_data['rent_date_end']}</font><br />Продажа от частников до: <font style='color:{$warn_sell}'>{$access_data['sell_date_end']}</font>";/*<br />Премиумы: {$access_data['rent_premium']};*/
				if($_SESSION['parent']==0)
				{
					$access_end = date('Y-m-d', strtotime($access_data['rent_date_end'])) <= date('Y-m-d');
					echo "<span style='margin-top: -40px;'><!--Аб. аредна: {$access_data['subscription']}--><br />Долг: <font style='color:{$duty_color}'>{$access_data['duty']}</font><br />Баланс: <font style='color:{$balance_color}'>{$access_data['balance']}</font></span>";
					if($access_end && !$recharge){
						echo "<span style='font-size: 38px;color: rgb(205, 24, 24);display: block;'>Доступ к аренде закончился!<br />
						Вам требуется: <br />
						1. пополнить баланс <br />
						2. продлить доступ 
						<a href='?task=profile&action=order'>Пополнить баланс</a>";
					}else if($access_end && $recharge){
						echo "<span style='font-size: 38px;color: rgb(205, 24, 24);display: block;'>Доступ к аренде закончился! 
						<br />Вам требуется:<br />
						<a href='?task=profile&action=services'>продлить доступ</a>";
					}
				}
				echo "</div></div>";
				
			}
			$count=count($mes);
			for($i=0; $i<$count; $i++){
				echo "<div style='margin: 15px;border: 1px solid #ccc;border-radius: 5px;padding: 5px;'><div style='text-decoration: underline;color:#E81010'>Сообщение от администратора:</div>";
				echo $mes[$i]['text'];
				echo "</div>";
			}
			echo "</div>";
		}
	}
	
	static function Retro_pag($count, $var_on_page){
		$pages = ceil($count/$var_on_page);
		$link = preg_replace("/&page=\d+/", '', $_SERVER['QUERY_STRING']);
		echo "<select onChange='window.location=\"?{$link}&page=\"+$(this).val()'>";
			for($i=1; $i<=$pages; $i++){
				$selected = $_GET['page']==$i || ($_GET['page']==0 && $i==1) ? "selected" : "";
				echo "<option value='{$i}' {$selected}>Страница {$i}</option>";
			}
		echo "</select>";
	}
	
	static function FilterVal($filter){
		if (isset($_GET[$filter])){
			return $_GET[$filter];
		}else{
			return false;
		}
	}
	
	static function UpdateReview($id)
	{
		if($id>0){
			$review = DB::Select("count(anonymous) as count, anonymous", "re_review", "var_id={$id} GROUP BY (anonymous)");
			$count = count($review);
			if($count == 1 && $review[0]['count']!=0){
				if($review[0]['anonymous'] == 1){
					return 0;
				}else{
					return 1;
				}
			}else if($count==0){
				DB::Update("re_var", "review=0", "id={$id}");
				return 0;
			}else{
				return 1;
			}
		}
	}
	
	static function Warn($date){
		return date('Y-m-d', strtotime($date." - 5 day")) <= date('Y-m-d') ? "color:rgb(205, 24, 24);" : "";
	}
	
	static function Pay_parse_company_count(){
		return DB::Select("count(*) as c", "re_access_date_end", "pay_parse_date_end > NOW()")[0]['c'];
	}
	
	static function Origins(){
		$origins = DB::Select("DISTINCT origin", "re_pay_parse", "origin !=''");
		$origin = Helper::FilterVal("origin");
		echo "<div class='col-xs-2 deployed'>
				<select class='form-control' name='origin'>
					<option value=''>все</option>";
					$origins_count = count($origins);
					for($or=0; $or<$origins_count; $or++){
						$selected = $origin == $origins[$or]['origin'] ? "selected" : "";
						echo "<option value='{$origins[$or]['origin']}' {$selected}>{$origins[$or]['origin']}</option>";
					}
			echo "</select>
			</div>";
		unset($origins, $origin, $origins_count, $or, $selected);
	}
	
	static function Free_ip_count(){
		return DB::Select("count(DISTINCT company_name) as c", "re_addresses as a, re_company as c, re_people as p", "a.people_id = p.id AND p.company_id = c.id AND a.ip = 1 and a.active=1")[0]['c'];
	}
	
	/*удаление папок*/
	static function removeDirectory($dir){
		if($_SESSION['admin']==1){
			if ($objs = glob($dir."/*")){
				foreach($objs as $obj) {
					is_dir($obj) ? Helper::removeDirectory($obj) : unlink($obj);
				}
			}
			try{
				rmdir($dir);
			}catch(Exeption $e){}
		}
	}
	
	static function Order_access_off_count(){
		return DB::Select("count(*) as c", "re_company", "order_access=0")[0]['c'];
	}
	
	static function Company_with_duty_count(){
		return DB::Select("count(*) as c", "re_company", "duty>0")[0]['c'];
	}
	
	static function Save_search(){
		return DB::Select("id, search_name, people_id, search_str, CONCAT_WS(' ', client_name, client_email, client_phone) as client, hidden_var, new_var, action, date", "re_save_search", "people_id=".$_SESSION['people_id']);
	}
	
	static function New_var_by_filter($filter_str, $table, $last_date){
		if($filter_str!=""){
			$filter_arr = explode("&", $filter_str);
			$condition = "date_added = DATE_FORMAT('{$last_date}', '%Y-%m-%d') AND DATE_ADD(date_last_edit, INTERVAL -1 hour) > DATE_FORMAT('{$last_date}', '%Y-%m-%d %H:%i:%s')";
			$room_count="";
			$dis="";
			$street="";
			$type_id="";
			$residents="";
			foreach($filter_arr as $filter){
				$kv = explode('=', $filter);
				$k = $kv[0];
				$v = $kv[1];
				if(ereg('room_count', $k) && $v!=""){
					if($_GET['action']!="parse"){
						$room_count.="{$v}||";
					}else{
						$room_count.=($v+18)."||";
					}
				}
				else if($k=='pricefrom'){
					if ($v != ""){
						$condition.=" AND (price BETWEEN ".preg_replace("/(&nbsp;)|(\s)|( )/", '', $v);
					}else{
						$condition.=" AND (price BETWEEN 0"; $p++;
					}
				}else if($k=='priceto'){
					if ($v != ""){
						$condition.=" AND {$v})";
					}else{
						$condition.=" AND 99999999)";
					}
				}else if(ereg('dis', $k) && $v!=""){
					$dis.="{$v}||";
				}else if(ereg('street', $k) && $v!=""){
					$street.="{$v}||";
				}else if(ereg('from', $k) && $sq==0){
					$k = preg_replace("/from/", '', $k);
					if($v!=""){
						$condition.=" AND ({$k} BETWEEN {$v}"; 
						$sq++;
					}else{
						$condition.=" AND ({$k} BETWEEN 0"; $sq++;
					}
				}else if(ereg('to', $k) && $sq>0){
					if($v!=""){
						$condition.=" AND '{$v}')"; 
						$sq=0;
					}else{
						$condition.=" AND 99999999)"; $sq=0;
					}
				}else if($k=="favorit"){
					$condition.=" AND {$k} like '%|{$v}|%'";
				}else if($k=="parent_id"){
					if($v==18 && $_GET['action']=="parse"){
						$condition.=" AND ({$k} = '{$v}' OR type_id='18')";
					}else{
						$condition.=" AND {$k} = '{$v}'";
					}
				}else if($k=="to_metro" && $v!=""){
					$condition.=" AND `distance_to_metro` > 0 AND coords!='55.030199,82.92043' AND `distance_to_metro` < ".$v;
				}else if(ereg('type_id', $k) && $v!=""){
					$type_id.="{$v}||";
				}else if($k == "residents"){
					$residents=$k;
				}else if($v != ""){
					$condition.=" AND {$k}='{$v}'";
				}
			}
			
			if($_GET['action']!="parse"){
				if($room_count!="")$condition .= Helper::MultiCondition("room_count='".$room_count, "' OR room_count='");
			}else{
				if($room_count!="")$condition .= Helper::MultiCondition("type_id='".$room_count, "' OR type_id='");
			}
			if($dis!="")$condition .= Helper::MultiCondition("dis='".$dis, "' OR dis='");
			if($street!="")$condition .= Helper::MultiCondition("street like '%".$street, "%' OR street like '%", "%'");
			if($_GET['residents']!="")$condition .= Helper::MultiCondition("residents like '%".$_GET['residents'], "%' AND residents like '%", "%'");
			if($type_id!="")$condition .= Helper::MultiCondition("type_id='".$type_id, "' OR type_id='");
			
			switch($table) {
				case 'parse':
					$table = "re_parse";
					break;
				case 'pay_parse':
					$table = "re_pay_parse";
					break;
				default:
					$table = "re_var";
			}
			$result = DB::Select("GROUP_CONCAT(id) as ids, count(*) as count", $table, $condition)[0];
			return $result;
			
		}
	}
	
	static function For_archive_interval(){
		$interval = DB::Select("for_archive_interval", "re_admin_data limit 1")[0]["for_archive_interval"];
		if(!is_null($interval)){
			DB::Update("re_var", "active=0", "DATE_ADD(date_added,INTERVAL +{$interval} day) < NOW() AND active =1");			
		}
		return $interval;
	} 
}
?>
