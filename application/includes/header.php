<div class="container" style="position: fixed;top: 0;z-index: 99;width: 100%;max-width: 2000px;">
	<div class="row">
		<div class="header center" id="user-menu">
			<a class="left" href="/?task=main&action=index&parent_id=1&topic_id=1" style="margin: -11px -10px -11px -20px;padding: 13px;">На главную</a>
			<span class="dropdown left" style="display: block;margin-top: 0px;">
				<a href="javascript:void(0)" id="dropdownMenu4" data-toggle="dropdown" style="margin: -11px -10px -11px 10px;padding: 13px;" class="left">Меню<span class="caret"></span></a>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu4">
					<?if($_SESSION['parent'] == 0){?>
						<li><a href="?task=profile&action=order_txt"><font color = red>ОПЛАТА и Отправка данных об оплате</font></a></li>
						<li><a href="?task=profile&action=order"><font color = red>ОПЛАТА</font></a></li>
						<li><a href="?task=profile&action=services"><font color = red>Продление доступа</font></a></li>
						<li><a href="?task=profile&action=user_list">Список сотрудников</a></li>
						<li><a href="?task=profile&action=tariffs">Тарифы и условия</a></li>
					<?}?>
					<!--<li><a href="?task=profile&action=check_rielter">Проверка АН риелтора в базе</a></li>-->
					<li><a href="?task=profile&action=rules">Правила</a></li>					
					<li><a href="?task=profile&action=messages">Сообщения от админа</a></li>
					<li><a href="?task=profile&action=send_message">Написать админу</a></li>
					<li><a href="?task=profile&action=caution&type=1">"Осторожно!"</a></li>
					<?if($_SESSION['block_forum'] == 0){?>
						<li><a href="?task=profile&action=forum">Форум</a></li>
					<?}?>
					<li><a href="?task=profile&action=lists&type=black">Черный и белый список риэлтеров</a></li>
					<li><a href="?task=profile&action=callboard&callboard_topic=sell">Доска объявлений</a></li>
					<li><a href="?task=profile&action=group_setting">Настройка своей группы</a></li>
					<li><a href="/?task=instruction">Инструкция пользования Фортуной</a></li>
					<!--<li><a href="?task=profile&action=forum">Форум</a></li>-->
				</ul>
			</span>
			
				<span class="dropdown left dropdownMenu1" style="display: block;margin-top: 0px;margin-left: 38%;position: absolute;font-size: 18px;">
					<a class="left" href="javascript:void(0)" id="dropdownMenu1" data-toggle="dropdown" style="float:left;    margin: -13px -10px -11px 10px; padding: 12px; color: rgb(205, 24, 24);" aria-expanded="false">
						<?echo isset($topic) ? $topic : "Аренда";?><span class="caret"></span><span class='date-end'><?=date('d.m.Y', strtotime($topic=='Продажа' ? $_SESSION['sell_date_end'] : $_SESSION['rent_date_end']))?></span>
					</a>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<?php if($condition) { ?>
							<li>
								<a href="<?echo $url."&topic_id=1&parent_id=1";?>">Аренда</a>
							</li>
						<?}?>
						<li>
							<a href="<?echo $url."&topic_id=2&parent_id=1";?>">Продажа</a>
						</li>
					</ul>
				</span>									
			<? if(($_SESSION['user']) AND ($_SESSION['user'] != 'guest')) { 
				if($_SESSION['admin']==1){							
					echo "<a style='float: left; margin: -11px -10px -11px 10px;padding: 13px;' href='?task=admin'>Админка</a>";
				}
			if($_SESSION['parent']==0 && $_SESSION['admin']==0){?>
				<a class="left" href="?task=profile&action=send_message" style="margin: -11px -10px -11px 10px;padding: 13px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> админу</a>	
			<?}?>
			<a href="?task=profile&action=check_rielter" style="margin: -11px -10px -11px 10px;padding: 13px;" class="left">Кто звонит?</a>
			<a href="?task=profile&action=forum" style="margin: -11px -10px -11px 10px;padding: 13px;" class="left">ФОРУМ</a>
			<!--style="margin: -11px -10px -11px 10px;padding: 13px;" -->
			
			<a href="?task=login&action=logout" style="margin: -11px -20px -11px 10px;padding: 13px;" class="right">Выход</a>
			<?$link = $_SESSION['parent']==0 ? "?task=profile&action=order" : "?task=profile&action=rules";?>
			<a href="<?=$link?>" class="right" style="margin: -11px -10px -11px 10px;padding: 13px;">ЛK</a>
			<a href="?task=profile&action=recipients" class="right" style="margin: -11px -10px -11px 10px;padding: 13px;">Подборки</a>
			<?$my_obj_topic=isset($_GET['topic_id']) ? $_GET['topic_id'] : ($_SESSION["group_topic_id"] == 3 ? 1 : $_SESSION["group_topic_id"]);?>
			<span class="dropdown right" style="display: block;margin-top: 0px;">
				<a href="javascript:void(0)" id="dropdownMenu3" data-toggle="dropdown" style="margin: -11px -10px -11px 10px;padding: 13px;" class="right">Мои объекты<span class="caret"></span></a>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
					<li><a href="?task=profile&action=mytype&active=1&parent_id=all&limit=all&topic_id=<?=$my_obj_topic;?>">Активные</a></li>
					<li><a href="?task=profile&action=mytype&active=0&parent_id=all&topic_id=<?=$my_obj_topic;?>">Архивные</a></li>	
					<li><a href="?task=profile&action=favorites&parent_id=all&topic_id=<?=$my_obj_topic;?>">Избранное от АН</a></li>
					<li><a href="?task=profile&action=favorites_parse&parent_id=all&topic_id=<?=$my_obj_topic;?>">Избранное от хоз</a></li>
					<li><a href="?task=profile&action=favorites_pay_parse&parent_id=all&topic_id=<?=$my_obj_topic;?>">Избранное от хоз 2</a></li>
				</ul>
			</span>
			<span class="dropdown right" style="display: block;margin-top: 0px;">
				<a href="javascript:void(0)" id="dropdownMenu2" data-toggle="dropdown" style="margin: -11px -10px -11px 10px;padding: 13px;" class="right">Добавить объект<span class="caret"></span></a>
				<?if($topic == "Аренда" || !isset($topic)){?>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
						<li class="dropdown-header center">Аренда</li>
						<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=1">Квартира</a></li>
						<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=18">Комната</a></li>	
						<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=3">Коттеджи-дома</a></li>
						<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=4">Дачи</a></li>
						<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=6">Гаражи/Парковки</a></li>
						<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=7">Коммерческая</a></li>	
						<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=5">Земля</a></li>
					</ul>
				<?}
				else if($topic=="Продажа"){?>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
						<li class="dropdown-header center">Продажа</li>
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=1">Квартира</a></li>
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=18">Комната</a></li>	
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=2">Новостройки</a></li>	
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=3">Коттеджи-дома</a></li>
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=4">Дачи</a></li>
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=6">Гаражи/Парковки</a></li>
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=7">Коммерческая</a></li>	
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=5">Земля</a></li>			
					</ul>
				<?}?>
			</span>
		</div>		
	</div>
			<?php }  /* if((!$_SESSION['user']) OR ($_SESSION['user'] == 'guest')) { ?>
			<a href="javascript:void(0)" onClick="loginShow(1)" class="right" id="loginShow">Вход</a>
		</div>		
	</div>
	<form id="enter" action="/?task=login&action=enter" method="post" class="left" style="display:none">
		<span>Авторизация</span>
		<span class="glyphicon glyphicon-remove right" onClick="closeLogin()" id="close" style="cursor:pointer"></span>
		<input type="text" name="login" class="form-control" placeholder="Логин" required>
		<input type="password" name="password" class="form-control" placeholder="Пароль" required>
		<input type="submit" value="Войти" name="btn" class="btn btn-success right">
	</form>	
	<?php } */?>	
		</div>		
	</div>
</div>