<?
$arr_num = count($data);
$people_ids_in_an = Get_functions::Get_peoples_ids_in_an($_SESSION['company_id']);


for ($j=0; $j<$arr_num ; ++$j) {

	/**
		Блокировка из чёрного списка.
	*/
	if(ereg($data[$j]['people_id'].",", $_SESSION['in_black_list']) && !empty($data[$j]['people_id']) ){
		$people_id_black_show_var = Get_functions::Get_black_list_show_var($data[$j]['people_id']);
		if($people_id_black_show_var == 0) continue;		
	}
	
		//if($_SESSION['people_id'] == 1){
	//	print_r($data[$j]['date_last_edit']);
	//}
	unset($photo, $count_photo, $imgUrl);

	$favorit = !preg_match("/\|".$_SESSION['people_id']."\|/", $data[$j]['favorit']);
	
	$ngs = $data[$j]['user_id'] == 'ngs' || $data[$j]['user_id'] == 'avito';

	$contacts = Helper::FilterVal('without_cont')!=1;
	$company_var = $_SESSION["company_name"] == $data[$j]['company_name'];


	if(!$ngs){
		$dir = "images/".$data[$j]['people_id']."/".$data[$j]['id']."/*";
		$photo_arr = glob($dir);
		
		if($_SESSION['people_id']==1)
		{
		//	echo $dir;
		}
		//echo $data[$j]['id'];
		$count_photo = count($photo_arr);
		
		if($count_photo > 0){
			$photo = str_replace($_SERVER['DOCUMENT_ROOT'], "", $photo_arr[0]);
		}

	}else if(strlen($data[$j]['photos']) > 5){
		$imgUrl = $data[$j]['link'];
	}
	if($data[$j]['review']==1 && !$ngs && $_GET['action']!="pay_parse")
	$data[$j]['review'] = Helper::UpdateReview($data[$j]['id']);
	
	$online = Helper::Online_bool($data[$j]['people_id']);
	unset($dir, $photo_arr);
	$icon = array(
		"ngs"=>"/images/icon/source/ngs.png",
		"avito"=>"/images/icon/source/avito.ico"
	);
		$date_col = (isset($data[$j]['col_date']) && date("Y-m-d", strtotime($data[$j]['col_date'])) == date("Y-m-d") && $_GET['action']=="mytype" && $_GET["active"]=="0") ;
?>

	<div class="col-xs-12
		<?if(!$ngs && ereg($data[$j]['people_id'].",", $_SESSION['in_black_list'])){
			echo " product ";
		}else{
			echo ' product ';
		}?>
	  <?php if($date_col) echo "dateCol"; if($data[$j]['review']==1) echo "hasReview";?>" style="font-family: arial, verdana;font-size: 18px;line-height: normal;" data-coords="<?= $data[$j]['coords'];?>" id="msg<?= $j; ?>" data-id='<?= $data[$j]['id'];?>' data-addr="НСО, <?= $data[$j]['live_point'].", ".$data[$j]['street']." д.".$data[$j]['house'];?>" data-col="<?if($date_col) echo 1;?>" data-user="<?=$data[$j]['user_id']?>">
		<table>
			<tr>
				<td align="left" style='width: 4%;vertical-align: top;line-height: 0.8;'>
					<?php // echo $data[$j]['date_last_edit']?>
					<?if(!$ngs){?>
						<font size="2" data-id="last-edit"><?echo date("d/m H:i", strtotime($data[$j]['date_last_edit']));?></font>
					<?}else{?>
						<font size="2" style='margin-right: 25px;' data-id="last-edit"><?echo date("d/m/y H:i", strtotime($data[$j]['date_last_edit']));?></font>
					<?}?>
					<br />

					<?if($_GET['action'] == "mytype" && $_GET['active'] == 1 && $company_var)echo "<input type='checkbox' onChange='showButtons($(this))' data-id='{$data[$j]['id']}' style='margin: 10px 0;'>";?>
					<br />


					<?if($data[$j]['status'] == 3){
						if(!$phone_enter){?>
							<font color='red' style='font-size:11px'>  VIP </font><br /><img title='VIP-статус' width='14px' src='images/icon/zv_vip.gif'>
						<?}else{?>
							<font color='red' style='font-size:11px'>  VIP </font><br /><img title='VIP-статус' width='14px' src='images/icon/vip_phone.png'>
						<?}
					}else if(isset($imgUrl)){?>
						
						<a href='<?=$imgUrl;?>' data-id='new-window'><img style='padding: 2px;border: 1px solid silver;' src='images/zenit1.png'></a>

					<?}if(isset($data[$j]['link'])){?>
						<br/><a href="<?=$data[$j]['link'];?>" data-id='new-window' style='font-size: 12px;margin-left: 15px;display: inline-block;margin-top: 10px;'><img src="<?=$icon[$data[$j]['user_id']]?>" width="15"></a>
					<?}if(!$ngs && $count_photo){?>
					


						<br />
						<br />

						<?php 
							//отсутствует email отправки
							if ($_SESSION['email_work'] != NULL && $_SESSION['email_pass'] != NULL  ) {

						?>
								<span class="glyphicon glyphicon-envelope send-email" onClick="Open_send_email_form($(this))" aria-hidden="true" style="cursor: pointer;color: #35AFD4;"></span>
								<div class="send-email-form hidden">
									<div class="col-xs-4 deployed" style='margin-top: 20px;'>
										<label class="signature">Отправить клиенту</label>
										<input class="form-control" data-name="email_for_favor" placeholder="email" onclick="$('.dropdown-menu').has($(this)).show()">
									</div>
									<div class="col-xs-4 deployed" style="margin-top: 20px;">
										<label class="signature">Комментарий(можно редактировать)</label>
										<textarea class="form-control" rows="7" data-name="comment" placeholder="текст комментария"></textarea>
									</div>
									<div class="col-xs-2 deployed">
										<button type="button" onclick="SendVarToEmail($(this), <?=$data[$j]['id'];?>)" style="" class="btn btn-success btn-xs ">Отправить</button>
									</div>
								</div>
						<?php 
							}else{
						?>
							<span class="glyphicon glyphicon-envelope send-email" onClick="No_email_work()" aria-hidden="true" style="cursor: pointer;color: #35AFD4;"></span>
						<?php
							}
						?>
					<?}?>
				</td>
				<td>
					<div style="margin-top: -3px;">
						<?echo Translate::Var_title_retro($data[$j]['type_id'], $data[$j]['topic_id'], $data[$j]['room_count'], $data[$j]['planning'], $data[$j]['dis'], $data[$j]['street'], $data[$j]['house'], $data[$j]['ap_layout'],$data[$j]['parent_id'], $data[$j]['live_point']);
						if($topic != "Продажа" && $parent!="Коммерческая" && $parent!="Гаражи" && $data[$j]['user_id']!="avito"){?>
							<font style="font-weight: normal;font-weight: bold;"> 
								<?echo Helper::FurnListRetro($data[$j]['furn'], $data[$j]['tv'], $data[$j]['washing'], $data[$j]['refrig'],  $data[$j]['residents'], $ngs);?>
							</font>
						<?}?>

						<?echo Helper::PriceRetro($data[$j]['price'],$data[$j]['prepayment'],$data[$j]['utility_payment'], $data[$j]['torg'], $data[$j]['deliv_period'], $topic, $topic_id);
						/*if(ereg($data[$j]['user_id'].",", $_SESSION['white_list'].",")){?>
							<div class="white-user" title="риелтор в белом списке"></div>
						<?}*/?>
						<?if($ngs){?>
							<a href="javascript:void(0)" <?echo "onClick='show_address(\"".$data[$j]['coords']."\", ".$j.")' target='_blank' data-toggle='modal' data-target='#modal-win'";?>><img border="0" src="images/icon/maps.ico"></a>
						<?}?>
						<input data-name='favorit' type='hidden' value="<?=$data[$j]['favorit'];?>">
						<?$favorit = !preg_match("/\|".$_SESSION['people_id']."\|/", $data[$j]['favorit']);
						if($favorit){
							echo "<a data-name='fav_star' href='javascript:void(0)' onClick='addToFavorites(\"{$data[$j]['user_id']}\", {$data[$j]['id']})'><img src='images/icon/favorites.png' style='cursor:pointer;height: 30px;float: right;'></a>";
						}else{
							echo "<a data-name='fav_star' href='javascript:void(0)' onClick='removeFromFavorites(\"{$data[$j]['user_id']}\", {$data[$j]['id']})'><img src='images/icon/favorites_all.png' style='cursor:pointer;height: 30px;float: right;'></a>";
						}if($data[$j]['warning']==1){?>
							<a href="/?task=profile&action=caution&type=1&an=<?=$data[$j]['company_name']?>" class="warning" target="_blank" title="данный риелтор был занесен в раздел 'осторожно'">!</a>
						<?}if($_SESSION['admin']==1 && $ngs){?>
							<span class="delete right" style="font-size: 14px;margin: 8px;" onClick="Delete('parse', <?=$data[$j]['id'];?>)">удалить вариант</span>
						<?}?>
					</div>
					<div>
						<span data-name = "view-race">
						<?if(isset($data[$j]['ap_view_date']) && isset($data[$j]['ap_race_date'])){
							if(date("Y-m-d", strtotime($data[$j]['ap_race_date'])) < date("Y-m-d")){
								echo "<font class='retro-green'>Смотреть и заезжать сегодня!</font>";
							}else{
								echo "<font class='retro-gray'>Смотреть c : </font><font  style='color: rgb(255, 0, 0);'>".date("d.m", strtotime($data[$j]['ap_view_date']))."</font><font class='retro-gray'> заезд c : </font><font  style='color: rgb(255, 0, 0);'>".date("d.m", strtotime($data[$j]['ap_race_date']))."</font>";
							}
						}
						?>
						</span>
						<?php
						echo "<span data-name = 'deposit'>";
						if($data[$j]['deposit']>0){
							echo "<font class='retro-gray'> Депозит: </font><font style='color:#E81010' > {$data[$j]['deposit']}</font>";
						}
						echo "</span>";
						if($data[$j]['deliv_period'] > 0 && $data[$j]['deliv_period'] < 13){
							$deliv_period_str = "На {$data[$j]['deliv_period']} мес.";
							echo "<font class='retro-gray'> ".($topic_id!=3 && $topic_id!=4 ? "Период сдачи" : "Срок аренды").": </font><font ".($data[$j]['deliv_period'] == 12 ? "class='retro-green'" : "style='color:#E81010'").">".$deliv_period_str."</font>";
						}else if($data[$j]['deliv_period'] > 12){
							switch ($data[$j]['deliv_period'])
							{
								case '13':
									$deliv_period_str = "Лето";
									break;
								case '14':
									$deliv_period_str = "Длительно";
									break;
								case '15':
									$deliv_period_str = "На продаже";
									break;
								case '16':
									$deliv_period_str = "Сутки";
									break;
							}
							echo "<font class='retro-gray'> ".($topic_id!=3 && $topic_id!=4 ? "Период сдачи" : "Срок аренды").": </font><font ".($data[$j]['deliv_period'] == 14 ? "class='retro-green'" : "style='color:#E81010'").">".$deliv_period_str."</font>";
						}
						if($data[$j]['metro_name']!=''){
							echo "<font class='retro-gray'> Метро:</font><font class='retro-green'>{$data[$j]['metro_name']} {$data[$j]['distance_to_metro']}м.(по прямой)</font>";
						}
						?>
					</div>
					<div>
						<font style='color: #476BC6;font-size: 16px;'>Дополнение: </font>
						<?if(!$ngs && $topic!="Продажа" && $parent!="Коммерческая" && $data[$j]['topic_id']!=3){?>
							<font class='retro-gray' data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>С этой сделки наши </font>
							<font class='retro-green' data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>><?=floatval($data[$j]['price'])/100 * floatval($data[$j]['commission']) / 2;?></font><font class='retro-gray' data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>руб.</font>
							<?
							if($parent=="Комната"){
								echo "<font class='retro-gray'>метры : </font><font class='retro-green'>{$data[$j]['sq_live']}</font>";
							}
							echo Helper::ResidentsRetro($data[$j]['residents'], $topic_id);
							if(!empty($data[$j]['owner'])){
								echo "<font class='retro-gray'>, проживает : </font><font class='retro-green'>{$data[$j]['owner']}</font>";
							}
						}else if($data[$j]['topic_id']==3){
							echo Helper::ResidentsRetro($data[$j]['residents'], $topic_id);
						}?>
							
						<?php 
							if($data[$j]['floor'] && $parent != "Дома")
							{
								echo "<font class='retro-gray'>Этажность: </font><font class='retro-green' data-name='floor'>{$data[$j]['floor']}";
								if($data[$j]['floor_count']){
									echo "/{$data[$j]['floor_count']}";
								}
								echo "</font>";
							}else if($data[$j]['floor_count'] && $parent != "Дома"){
								echo "<font class='retro-gray'>Этажность: </font><font class='retro-green' data-name='floor'>ср/{$data[$j]['floor_count']}</font>";
							}
							if($data[$j]['floor_count'] && $parent == "Дома"){
								echo "<font class='retro-gray'>Этажность: </font><font class='retro-green' data-name='floor'>{$data[$j]['floor_count']}</font>";
							}
							if(floatval($data[$j]['sq_all']) || floatval($data[$j]['sq_live'])|| floatval($data[$j]['sq_k'])) 
							{ 
								echo "<font class='retro-gray'> пл:</font><font class='retro-green' data-name='sq'>";
								if($parent != "Гаражи" && $parent != "Дачи"){
									if($data[$j]['sq_all']){echo $data[$j]['sq_all']."/";}else{echo "-/";}
									if($data[$j]['sq_live']){echo $data[$j]['sq_live']."/";}else{echo "-/";}
									if($data[$j]['sq_k']){echo $data[$j]['sq_k'];}else{echo "-";}
								}else if (floatval($data[$j]['sq_live']) && !$ngs){
									echo $data[$j]['sq_live'];
								}else{
									echo $data[$j]['sq_all'];
								}
								echo "</font>"; 
							}
								if(floatval($data[$j]['sq_land'])){
									echo "<font class='retro-gray'> уч: </font><font class='retro-green' data-name='sq'>{$data[$j]['sq_land']}</font>";
								}
						if(!$ngs){
								if(($data[$j]['parent_id']==18 || $data[$j]['parent_id']==3) && $data[$j]['room_count']>0){
									echo "<font class='retro-gray'> комнат в ".($data[$j]['parent_id']==18 ? 'кв' : 'доме')." - </font><font class='retro-green'>{$data[$j]['room_count']}</font>";
								}
							?>
						<?}?>
					</div>
					<?if(!$ngs && $data[$j]['parent_id']==3 && $data[$j]['topic_id']!=3 && $data[$j]['topic_id']!=4){?>
						<div style='font-size: 12px;'>
							<span style="color: blue; font-size: 13px;">Удобства: </span>
							<font class='retro-gray'>Отопление: </font><font class="retro-green"><?=$data[$j]['heating'];?> </font>
							<font class='retro-gray'>| Вода: </font><font class="retro-green"><?=$data[$j]['water'];?> </font>
							<font class='retro-gray'>| Cлив: </font><font class="retro-green"><?=$data[$j]['sewage'];?> </font>
							<font class='retro-gray'>| Туалет: </font><font class="retro-green"><?=$data[$j]['wc_type'];?> </font>
							<font class='retro-gray'>| Место под машину: </font><font class="retro-green"><?=$data[$j]['park'];?> </font>
							<font class='retro-gray'>| Мыться: </font><font class="retro-green"><?=$data[$j]['wash'];?> </font>
						</div>
					<?}?>
					<div>
						<font style='color: #476BC6;font-size: 16px;'>Описание: </font><span style='text-transform: lowercase;' data-name='comment'><?=$data[$j]['text'];?></span>
						<?if(isset($data[$j]['hidden_text']) && $data[$j]['hidden_text']!="" && in_array($data[$j]['people_id'], $people_ids_in_an)){
							echo "<br /><font style='color: #476BC6;font-size: 16px;'>Скрытое примечание: </font>{$data[$j]['hidden_text']}";
						}?>
					</div>
					<div style="font-size: 16px;">
						<?if($ngs){?>
							<font style="color: #476bc6;font-size: 14px;font-weight: bold;">Имя : </font><font data-name='contacts'><?=$data[$j]['contact_name'];?></font>
							<?if($contacts){?>
								<font style="color: #476bc6;font-size: 14px;font-weight: bold;">тел: </font><font data-name='contacts'><?=$data[$j]['contact_tel']; ?></font>
							<?}?>
						<?}else{?>
							<font class='retro-gray'>тел: </font> 
							<font onclick="$(this).hide(); $(this).next().show();" data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>><?=$data[$j]['phone'];?></font>
							<font onclick="$(this).hide(); $(this).prev().show();"data-name='contacts-hide' <?=($contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>***********</font>
							<?$owner = ( $_SESSION["user"] == $data[$j]['user_id'] || (isset($data[$j]['user_parent']) && $_SESSION["user"] == $data[$j]['user_parent']));?>

							<font class='retro-gray'> имя : </font>
							<font <?if($owner) echo "onClick='EmployeeList(".$data[$j]['id'].",\"".$data[$j]['company_name']."\",".$data[$j]['user_id'].")' "; unset($owner);?> data-people-id='<?=$data[$j]['people_id'];?>' data-name='people'>
								<?=$data[$j]['name'];?>
							</font>
							<font class='retro-gray'> АН : </font><?=$data[$j]['company_name'];?>
							<?if($topic=="Аренда"){?><span data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>><font class='retro-gray'> Услуги АН не менее :</font><?=$data[$j]['commission'];?>%
							<font style="font-size:12px;color:grey;font-weight:bold">(50 на 50)</font></span><?}?>
							<?if($data[$j]['premium'] == 1){
								if(!$phone_enter){?>
									<img title='статус-премиум' width='14px' style='vertical-align: initial;float: right;    margin: 3px 3px;' src='images/icon/zv.gif'>
								<?}else{?>
									<img title='VIP-статус' width='14px' style='vertical-align: initial;float: right; margin: 3px 3px;' src='images/icon/prem_phone.png'>
								<?}
							}?>
						<?}if(!$ngs){
							//echo $data[$j]['date_added'];?>
							<font class="retro-green" style="float:right;margin-top: 3px; margin-left: 55px;" size="2">
								<?=date("d/m", strtotime($data[$j]['date_added']));?>
							</font>
						<?}?>
						<div style="display: inline-block;float:right;margin-left: 15px;">	

							<?
								$photosBase = DB::Select("photo", "re_photos as p", "p.var_id={$data[$j]['id']} ");

									$freshPhoto = [];
									foreach ($photosBase as $photo) 
										$freshPhoto[]	=	$photo['photo'];
									$photoLimitArray = DB::Select("photo_limit, photo_limit_used", "re_people", "id='{$_SESSION['people_id']}'" )[0];				
								if(
									$count_photo > 0
									 && in_array(str_replace($_SERVER['DOCUMENT_ROOT']."images/".$data[$j]['people_id']."/", '', $photo)['photo'], $freshPhoto) 
									 && (empty($photoLimitArray['photo_limit']) || $photoLimitArray['photo_limit']>$photoLimitArray['photo_limit_used'])
								) {
							?>
								<a title="есть фото" class="fancybox-thumbs pull-left" href="<?="images/".$data[$j]['people_id']."/".$data[$j]['id']."/".$photo['photo'];?>" data-fancybox-group="msg<?=$j;?>" style="margin-bottom: -8px;">
									<img class="media-object" src="images/zenit1.png" style="padding: 2px; border: 1px solid silver;">
								</a>
							<?}?>
						</div>
						<?if(!$ngs){?>
							<a href="javascript:void(0)" style="float:right" <?echo "onClick='show_address(\"".$data[$j]['coords']."\", ".$j.")' target='_blank' data-toggle='modal' data-target='#modal-win'";?>><img border="0" src="images/icon/maps.ico"></a>
						<?}?>
					</div>
					<?if($data[$j]['ap_view_price']>0){
						echo "<div style='font-size: 12px;color: grey;font-weight: bold;'>Если показываю и оформляю в одиночку, с вашей комиссии - <font style='color:#E81010'>{$data[$j]['ap_view_price']} pублей</font></div>";
					}
					if(!$ngs){?>
						<div style="font-size: 12px;color: grey;font-weight: bold;">
							<?
							if($_GET['task']=="profile" && $_GET["action"]=="mytype" && $_GET['res']!=1){								
								if($_GET['active'] == '1'){?>
									<a href="?task=profile&action=edit&topic_id=<?=("{$data[$j]['topic_id']}&id={$data[$j]['id']}&parent_id={$data[$j]['parent_id']}")?>" style='color: grey;'>Редактировать | </a>
									<a href='javascript:void(0)' style='color: grey;' onClick="DeleteVar(<?=$data[$j]['id']?>)">Удалить | </a>
									<a href='javascript:void(0)' style='color: grey;' onclick="VarArchive(<?=$data[$j]['id']?>, 'add')">В архив | </a>
									<a href='javascript:void(0)' style='color: grey;' onclick="VarExtend(<?=$data[$j]['id']?>)">Продлить вариант |</a>
									<span class="dropdown">
										<a href="javascript:void(0)"  style='color: grey;' id="check" data-toggle="dropdown" aria-expanded="false">Проверить</a>
										<ul class="dropdown-menu" aria-labelledby="check">
											<li><a href='javascript:void(0)' data-name='check-var' data-id='parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники</a></li>
											<li><a href='javascript:void(0)' data-name='check-var' data-id='pay_parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники 2</a></li>	
										</ul>
									</span>
								 <?}else if($_GET['active'] == '0' && isset($_GET['active'])){?>
									<a href='javascript:void(0)' style='color: grey;' onClick="DeleteVar(<?=$data[$j]['id']?>)">Удалить | </a>
									<a href="?task=profile&action=edit&topic_id=<?=("{$data[$j]['topic_id']}&id={$data[$j]['id']}&parent_id={$data[$j]['parent_id']}&active=1")?>" style='color: grey;'>Вынести из архива |</a>
									<a href="?task=profile&action=edit&topic_id=<?=("{$data[$j]['topic_id']}&id={$data[$j]['id']}&parent_id={$data[$j]['parent_id']}&active=0")?>" style='color: grey;'>Редактировать |</a>
									<span class="dropdown">
										<a href="javascript:void(0)"  style='color: grey;' id="check" data-toggle="dropdown" aria-expanded="false">Проверить</a>
										<ul class="dropdown-menu" aria-labelledby="check">
											<li><a href='javascript:void(0)' data-name='check-var' data-id='parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники</a></li>
											<li><a href='javascript:void(0)' data-name='check-var' data-id='pay_parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники 2</a></li>	
										</ul>
									</span>
								<?}
								/*if(isset($data[$j]['tid']) && $data[$j]['photo']==1 && $_GET['action']!='recipients' && $_GET['action']!='favorites'){
									echo "<a href='javascript:void()' onClick='PhotoSearch({$data[$j]['tid']}, {$data[$j]['id']})' style='color: grey;float: right;'>Перенос фото со старой фортуны</a>";
								}*/
							}else{?>
								<a href='javascript:void(0)' style='color: grey;' data-name='an-info' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Инфо об агентстве | </a>
								<?if($_SESSION["block_com_an"]==0){?>
									<a href='javascript:void(0)' style='color: grey;' data-name='send-review' target='_blank' data-toggle='modal' data-target='#send-review-modal-win'>оставить отзыв | </a>
								<?}?>
								<?/*if(!$favorit){
									echo "<a href='javascript:void(0)' style='color: grey;' onClick='removeFromFavorites(\"".$data[$j]['user_id']."\", ".$data[$j]['id'].")'>В избраном | </a>";
								}else{
									echo "<a href='javascript:void(0)' style='color: grey;' onClick='addToFavorites(\"".$data[$j]['user_id']."\", ".$data[$j]['id'].")'>Добавить в избраное | </a>";
								}*/

								if(ereg($data[$j]['people_id'].",", $_SESSION['in_black_list'])){?>
									<span data-name='black-agent' style='cursor:pointer; color:red; display:inline-block;font-size: 13px; 'target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'>
										Агент в черном списке</span>
								<?}else if(ereg($data[$j]['user_id'].",", $_SESSION['white_list'].",")){?>
									<span data-name='white-agent' style='cursor:pointer; display:inline-block;font-size: 13px;'><a href="?task=profile&action=lists&type=white" class="retro-green" target="_blank">
										Агент в белом списке</a></span>
								<?}else{?>
								<!--<a href='javascript:void(0)' style='color: grey;' data-name='add-to-black-list' target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'>Присвоить статус риелтору | </a>-->
								
								<span class="dropdown">
									<a href="javascript:void(0)"  style='color: grey;' id="people-status" data-toggle="dropdown" aria-expanded="false">Присвоить статус риелтору | </a>
									<ul class="dropdown-menu" aria-labelledby="people-status">
										<li><a href='javascript:void(0)' data-name='add-to-black-list' target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'>В черный список</a></li>
										<li><a href="javascript:void(0)" onClick="AddListFromMain('<?=$data[$j]['people_id'];?>')">В белый список</a></li>	
									</ul>
								</span>
						
								<?}?>
								<span class="dropdown">
									<a href="javascript:void(0)"  style='color: grey;' id="check" data-toggle="dropdown" aria-expanded="false">Проверить</a>
									<ul class="dropdown-menu" aria-labelledby="check">
										<li><a href='javascript:void(0)' data-name='check-var' data-id='parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники</a></li>
										<li><a href='javascript:void(0)' data-name='check-var' data-id='pay_parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники 2</a></li>	
									</ul>
								</span>
								<?if($online==1){?>
									<span class="right" style="color:#337ab7;font-weight: normal;" title="Данные обновляются раз в минуту">Сейчас на сайте</span>
								<?}
							}
							?>
							<?if($data[$j]['review'] == 1){?>								
								 | <a href='javascript:void(0)' style='color:#E81010' data-id='review' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Есть отзывы</a>
							<?}?>
						</div>
					<?}else{?>
						<div style="font-size: 12px;color: grey;font-weight: bold;">
							<?if($_SESSION["block_com_parse"]==0){?>
								<a href='javascript:void(0)' style='color: grey;' data-name='send-review' target='_blank' data-toggle='modal' data-target='#send-review-modal-win'>оставить отзыв</a>
							<?}if($data[$j]['review'] == 1){?>								
								 | <a href='javascript:void(0)' style='color:#E81010' data-id='review' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Есть отзывы</a>
							<?}?>
						</div>
					<?}?>
				</td>
			</tr>
		</table>
	</div>
<?}
?>