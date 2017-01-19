<!--Аренда -->  
	<div id="temp_1">
		1
	</div>
	<!--вторичка --> 
	<div id="temp_2">
		2
	</div>
	<!--Новостройки --> 
	<div id="temp_3">
		3
	</div>
	<!--Коттеджы-дома --> 
	<div id="temp_4">
		4
	</div>
	<!--Дачи --> 
	<div id="temp_5">
		5
	</div>
	<!--Земля --> 
	<div id="temp_6">
		6
	</div>
	<!--Гаражи/парковки --> 
	<div id="temp_7">
		7
	</div>
	<!--коммерческая --> 
	<div id="temp_8">
		8
	</div>


<!--Аренда -->  
<div>
	<form id="" method="POST" action="?task=main&action=search" >


	
	<div class="control-group checklabel topic_id">
		<div class="header-3">
			Я хочу
		</div>
		<input type="hidden" name="search_type" value="topic_id1" />
		<input class="invisible" id="vkl1rent" value="1"  type="radio" name="topic_id1" checked="checked" /> 
		<label id="label" for="vkl1rent">Снять</label>
		
		
	</div>
	
	<?php

?>
<table>
<tr>
<td style="width: 300px;">
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text"  value="<?php if($_POST['live_point']) { echo $_POST['live_point']; } ?>" /> <br />
	</div>
	
	
	<div onclick="showSelect('dis-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
text-align: left;
	cursor: pointer;
	" >Район</div>
	<div id="dis-select" style="display: none;" class="div-select">
		<div class="left">
		<label for="dis1" >Дзержинский</label> <input id="dis1" type="checkbox" name="dis1" /><br />
		<label for="dis2" >Железнодорожный</label><input id="dis2" type="checkbox" name="dis2" /><br />
		<label for="dis3" >Заельцовский</label> <input id="dis3" type="checkbox" name="dis3" /><br />
		<label for="dis4" >Калининский</label> <input id="dis4" type="checkbox" name="dis4" /><br />
		<label for="dis5" >Кировский</label> <input id="dis5" type="checkbox" name="dis5" />
		</div>
		<div class="right">
		<label for="dis6" >Ленинский</label> <input id="dis6" type="checkbox" name="dis6" /><br />
		<label for="dis7" >Октябрьский</label> <input id="dis7" type="checkbox" name="dis7" /><br />
		<label for="dis8" >Первомайский</label> <input id="dis8" type="checkbox" name="dis8" /><br />
		<label for="dis9" >Советский</label> <input id="dis9" type="checkbox" name="dis9" /><br />
		<label for="dis10" >Центральный</label> <input id="dis10" type="checkbox" name="dis10" />
		</div>
	</div>
	
	
	<div onclick="showSelect('str-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
	text-align: left;
	cursor: pointer;
	" >Улица<span id="streets_number" style="float: right; margin-right: 5px;"></span></div>
	<div id="str-select" style="display: none"  class="div-select" >
	<input type="text" id="str" name="street" style="background: #F2D7E7;"  value="<?php if($_POST['street']) {echo $_POST['street']; } ?>" 
					
	autocomplete="off"/> введите улицу, или часть
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					
					</div>
					<ul id="street_adds">
					<?php if($_POST['street0']) { ?>
					
					<label id="label-0" class="str_search_res" onclick="removeStreet('0')" for="street-0" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-0" class="invisible" name="street0" type="text" value="<?php echo $_POST['street0']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street1']) { ?>
					
					<label id="label-1" class="str_search_res" onclick="removeStreet('1')" for="street-1" style="color: black;"><?php echo $_POST['street1']; ?></label>
					<input id="street-1" class="invisible" name="street0" type="text" value="<?php echo $_POST['street1']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street2']) { ?>
					
					<label id="label-2" class="str_search_res" onclick="removeStreet('2')" for="street-2" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-2" class="invisible" name="street2" type="text" value="<?php echo $_POST['street2']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street3']) { ?>
					
					<label id="label-3" class="str_search_res" onclick="removeStreet('3')" for="street-3" style="color: black;"><?php echo $_POST['street3']; ?></label>
					<input id="street-3" class="invisible" name="street0" type="text" value="<?php echo $_POST['street3']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street4']) { ?>
					
					<label id="label-4" class="str_search_res" onclick="removeStreet('4')" for="street-4" style="color: black;"><?php echo $_POST['street4']; ?></label>
					<input id="street-4" class="invisible" name="street4" type="text" value="<?php echo $_POST['street4']; ?>" style="color: black;">
					
					<?php }
					?>
					</ul>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="house">№</label>
	<input id="house" name="house" type="text" value="<?php if($_POST['house']) {echo $_POST['house']; } ?>"/>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($_POST['orientir']) {echo $_POST['orientir']; } ?>"/>
	</div>
</td>
<td style="width: 420px;">
	
	<div class="control-group checklabel switch_buy_rent" style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;">
		<div class="header-3">
			Количество комнат
		</div> <br />
		
		
		<input class="invisible"  id="k" value="8"  type="checkbox" name="type_id1"  <?php if($_POST['type_id1'] == 8) echo "checked"; ?> /> 
		<label id="label" for="k">Комната</label>
		
		<input class="invisible"  id="k-1" value="9"  type="checkbox" name="type_id2"  <?php if($_POST['type_id2'] == 9) echo "checked"; ?> /> 
		<label id="label" for="k-1">1-к</label>
		
		<input class="invisible"  id="k-2" value="10" type="checkbox" name="type_id3"  <?php if($_POST['type_id3'] == 10) echo "checked"; ?> /> 
		<label id="label" for="k-2">2-к</label>
		
		<input class="invisible"  id="k-3" value="11" type="checkbox" name="type_id4"  <?php if($_POST['type_id4'] == 11) echo "checked"; ?> /> 
		<label id="label" for="k-3">3-к</label>
		
		<input class="invisible"  id="k-4" value="15" type="checkbox" name="type_id5"  <?php if($_POST['type_id5'] == 15) echo "checked"; ?> /> 
		<label id="label" for="k-4">4-к</label>
		
		<input class="invisible"  id="k-5" value="16" type="checkbox" name="type_id6"  <?php if($_POST['type_id6'] == 16) echo "checked"; ?> /> 
		<label id="label" for="k-5">5-к</label>
		
		<input class="invisible"  id="k-6" value="17" type="checkbox" name="type_id7"  <?php if($_POST['type_id7'] == 17) echo "checked"; ?> /> 
		<label id="label" for="k-6">6-к +</label>
	</div>

	<div class="control-group">
		<label class="control-label" id="planning">Планировка</label>
		
			<select  class="controls-select" name="planning" id="planning" >
				<option value="" >не важно</option>
				<option value="изолированная" <?php if($_POST['planning'] == "изолированная") echo "selected"; ?>  >изолированная</option>
				<option value="смежная" <?php if($_POST['planning'] == "смежная") echo "selected"; ?> >смежная</option>
				<option value="см-изолированная" <?php if($_POST['planning'] == "см-изолированная") echo "selected"; ?> >см-изолированная</option>
				<option value="свободная" <?php if($_POST['planning'] == "свободная") echo "selected"; ?> >свободная</option>
				<option value="студия" <?php if($_POST['planning'] == "студия") echo "selected"; ?> >студия</option>
				<option value="иное" <?php if($_POST['planning'] == "иное") echo "selected"; ?> >иное</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="ap_layout">Тип квартиры</label>
		
			<select  class="controls-select" name="ap_layout" id="ap_layout" >
				<option value="">не важно</option>
				<option value="общежитие" <?php if($_POST['ap_layout'] == "общежитие") echo "selected"; ?>  >общежитие</option>
				<option value="малосемейка" <?php if($_POST['ap_layout'] == "малосемейка") echo "selected"; ?> >малосемейка</option>
				<option value="улучшеная планировка" <?php if($_POST['ap_layout'] == "улучшеная планировка") echo "selected"; ?> >улучшеная планировка</option>
				<option value="типовая" <?php if($_POST['ap_layout'] == "типовая") echo "selected"; ?> >типовая</option>
				<option value="хрещевка" <?php if($_POST['ap_layout'] == "хрещевка") echo "selected"; ?> >хрущевка</option>
				<option value="полногабаритная" <?php if($_POST['ap_layout'] == "полногабаритная") echo "selected"; ?> >полногабаритная</option>
				<option value="малоэтажка" <?php if($_POST['ap_layout'] == "малоэтажка") echo "selected"; ?> >малоэтажка</option>
				<option value="пентхаус" <?php if($_POST['ap_layout'] == "пентхаус") echo "selected"; ?> >пентхаус</option>
				<option value="двухуровневая" <?php if($_POST['ap_layout'] == "двухуровневая") echo "selected"; ?> >двухуровневая</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="wc_type">Санузел</label>
		
			<select  class="controls-select" name="wc_type" id="wc_type" >
				<option value="" >не важно</option>
				<option value="раздельный" <?php if($_POST['wc_type'] == "раздельный") echo "selected"; ?>  >раздельный</option>
				<option value="совмещенный" <?php if($_POST['wc_type'] == "совмещенный") echo "selected"; ?> >совмещенный</option>
				<option value="без удобств" <?php if($_POST['wc_type'] == "без удобств") echo "selected"; ?> >без удобств</option>
				<option value="ванна" <?php if($_POST['wc_type'] == "ванна") echo "selected"; ?> >ванна</option>
				<option value="душ" <?php if($_POST['wc_type'] == "душ") echo "selected"; ?> >душ</option>
				<option value="2 санузла" <?php if($_POST['wc_type'] == "2 санузла") echo "selected"; ?> >2 санузла</option>
				<option value="3 санузла" <?php if($_POST['wc_type'] == "3 санузла") echo "selected"; ?> >3 санузла</option>
				
			</select>
		
	</div>
</td>
<td>
<div  style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;" >
<label for="pricefrom">Цена от</label>
		<input id="pricefrom" name="pricefrom" type="text" value="<?php if ($_POST['pricefrom']) echo $_POST['pricefrom']; ?>" style="width: 100px; text-align: right;"/> 
<label for="priceto">до</label>
		<input id="priceto" name="priceto" type="text" value="<?php if ($_POST['priceto']) echo $_POST['priceto']; ?>" style="width: 100px; text-align: right;"/>
		<br />
		<label class="control-label" id="rent_type">за </label>
		
			<select  class="controls-select" name="rent_type" id="rent_type" >
				<option value="месяц"  <?php if($_POST['rent_type'] == 'месяц') echo "selected"; ?> >месяц</option>
				<option value="сутки"  <?php if($_POST['rent_type'] == 'сутки') echo "selected"; ?> >сутки</option>
				<option value="час"  <?php if($_POST['rent_type'] == 'час') echo "selected"; ?> >час</option>
				
			</select>
		
	
		
		<label for="price">Торг</label>
		<input id="torg" name="torg" type="checkbox" <?php if($_POST['torg'] == 'on') echo "checked"; ?> /> 
		
<div class="control-group">	
	<table>
	  <tr>
		<td>
		<label for="inet"><span><img id="icons" src="images/inet.png" title="Интернет"/></span></label>
		</td>
		<td>
		<label for="furn"><span><img id="icons" src="images/mebel.png" title="Мебель"/></span></label>
		</td>
		<td>
		<label for="tv"><span><img id="icons" src="images/icon-tv.png" title="Телевизор"/></span></label>
		</td>
		<td>
		<label for="washing"><span><img id="icons" src="images/iconlaundry.png" title="Стиральная машина"/></span></label>
		</td>
		<td>
		<label for="refrig"><span><img id="icons" class="refrigerator" src="images/refrigerator.png" title="Холодильник"/></span></label>
		</td>
		<td>
		<label for="conditioner"><span><img id="icons" src="images/freashing.png" title="Кондиционер"/></span></label>
		</td>
	  </tr>	
	  <tr>	
		<td>
		<input id="inet" name="inet" type="checkbox"  <?php if($_POST['tel'] == 1) echo "checked"; ?>  /> 
		</td>
		<td>
		<input id="furn" name="furn" type="checkbox"  <?php if($_POST['furn'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="tv" name="tv" type="checkbox"  <?php if($_POST['tv'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="washing" name="washing" type="checkbox"  <?php if($_POST['washing'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="refrig" name="refrig" type="checkbox"  <?php if($_POST['refrig'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="conditioner" name="conditioner" type="checkbox"  <?php if($_POST['conditioner'] == 1) echo "checked"; ?> /> 
		</td>
	  </tr>
	</table>
	</div>
	
	

	</div>
</td>
</tr>
</table>
<table id="advansed-search" style="display: none;">
	<tr>
		<td style="width: 565px;">
			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Площадь (от)
				</div>
				<label for="sq_allfrom">Общая</label>
				<input id="sq_allfrom" name="sq_allfrom" type="text" value="<?php if($_POST['sq_allfrom']) {echo $_POST['sq_allfrom']; } ?>"  /> / 
				<label  for="sq_livefrom">Жилая</label>
				<input id="sq_livefrom" name="sq_livefrom" type="text" value="<?php if($_POST['sq_livefrom']) {echo $_POST['sq_livefrom']; } ?>"  /> / 
				<label for="sq_kfrom">Кухня</label>
				<input id="sq_kfrom" name="sq_kfrom" type="text" value="<?php if($_POST['sq_kfrom']) {echo $_POST['sq_kfrom']; } ?>"  />
				<br />
				<div class="header-3">
					Площадь (до)
				</div>
				<label for="sq_allto">Общая</label>
				<input id="sq_allto" name="sq_allto" type="text" value="<?php if($_POST['sq_allto']) {echo $_POST['sq_allto']; } ?>"  /> / 
				<label  for="sq_liveto">Жилая</label>
				<input id="sq_liveto" name="sq_liveto" type="text" value="<?php if($_POST['sq_liveto']) {echo $_POST['sq_liveto']; } ?>"  /> / 
				<label for="sq_kto">Кухня</label>
				<input id="sq_kto" name="sq_kto" type="text" value="<?php if($_POST['sq_kto']) {echo $_POST['sq_kto']; } ?>"  />
			</div>

			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Этаж / Этажность (от)
				</div>
				
				<input id="floorfrom" name="floorfrom" type="text" value="<?php if($_POST['floorfrom']) echo $_POST['floorfrom']; ?>" /> / 
				
				<input id="floor_countfrom" name="floor_countfrom" type="text" value="<?php if($_POST['floor_countfrom']) echo $_POST['floor_countfrom']; ?>" />
				<br />
				<div class="header-3">
					Этаж / Этажность (до)
				</div>
				
				<input id="floorto" name="floorto" type="text" value="<?php if($_POST['floorto']) echo $_POST['floorto']; ?>" /> / 
				
				<input id="floor_countto" name="floor_countto" type="text" value="<?php if($_POST['floor_countto']) echo $_POST['floor_countto']; ?>" />
			</div>

		</td>
		<td style="width: 732px;">
			<div class="control-group">
				<label class="control-label" id="park">Парковка/гараж</label>
					<select class="controls-select" name="park" id="park" >
						<option value="Благоустроенная парковка у дома"  <?php if($_POST['park'] == 'частная') echo "selected"; ?> >Благоустроенная парковка у дома</option>
						<option value="Парковка со шлагбаумом" <?php if($_POST['park'] == 'Парковка со шлагбаумом') echo "selected"; ?> >Парковка со шлагбаумом</option>
						<option value="Подземный гараж" <?php if($_POST['park'] == 'Подземный гараж') echo "selected"; ?> >Подземный гараж</option>
						<option value="Подземная парковка" <?php if($_POST['park'] == 'Подземная парковка') echo "selected"; ?> >Подземная парковка</option>
					</select>
			</div>
	
			<div class="control-group">
				<label class="control-label" id="wall_type">Материал стен</label>
					<select class="controls-select" name="wall_type" id="wall_type" >
						<option value="кирпичный"  <?php if($_POST['wall_type'] == 'кирпичный') echo "selected"; ?> >кирпичный</option>
						<option value="панельный"  <?php if($_POST['wall_type'] == 'панельный') echo "selected"; ?> >панельный</option>
						<option value="деревянный"  <?php if($_POST['wall_type'] == 'деревянный') echo "selected"; ?> >деревянный</option>
						<option value="монолит"  <?php if($_POST['wall_type'] == 'монолит') echo "selected"; ?> >монолит</option>
					</select>
			</div>
			<div class="control-group">
				<label class="control-label" id="val_bal">Количество балконов</label>
				<input id="val_bal" name="val_bal" type="text" value="<?php if($_POST['val_bal']) {echo $_POST['val_bal']; } ?>" /> 
				
				<label class="control-label" id="val_lodg">Количество лоджий</label>
				<input id="val_lodg" name="val_lodg" type="text" value="<?php if($_POST['val_lodg']) {echo $_POST['val_lodg']; } ?>" /> 
		
			</div>
		</td>
	</tr>
</table>
	<li id="control_panel" style="
		text-align: left;
		list-style: none;">
		<span id="control" style="
		cursor:pointer;
		"><a onclick="showSelect('advansed-search')">Расширенный поиск</a></span>
		
		<input id="search-button" type="submit" name="submit" value="Поиск" style="float: right;" />
		</li>
	
	</form>
	
</div>
<!--вторичка --> 
<div>
	<form id="" method="POST" action="?task=main&action=search" >


	
	<div class="control-group checklabel topic_id">
		<div class="header-3">
			Я хочу
		</div>
		<input type="hidden" name="search_type" value="topic_id2" />
		<input class="invisible" id="vkl2rent" value="2"  type="radio" name="topic_id2" checked="checked" /> 
		<label id="label" for="vkl1rent">Купить</label>
		
		
	</div>
	
	<?php

?>
<table>
<tr>
<td style="width: 300px;">
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text"  value="<?php if($_POST['live_point']) { echo $_POST['live_point']; } ?>" /> <br />
	</div>
	
	
	<div onclick="showSelect('dis-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
text-align: left;
	cursor: pointer;
	" >Район</div>
	<div id="dis-select" style="display: none;" class="div-select">
		<div class="left">
		<label for="dis1" >Дзержинский</label> <input id="dis1" type="checkbox" name="dis1" /><br />
		<label for="dis2" >Железнодорожный</label><input id="dis2" type="checkbox" name="dis2" /><br />
		<label for="dis3" >Заельцовский</label> <input id="dis3" type="checkbox" name="dis3" /><br />
		<label for="dis4" >Калининский</label> <input id="dis4" type="checkbox" name="dis4" /><br />
		<label for="dis5" >Кировский</label> <input id="dis5" type="checkbox" name="dis5" />
		</div>
		<div class="right">
		<label for="dis6" >Ленинский</label> <input id="dis6" type="checkbox" name="dis6" /><br />
		<label for="dis7" >Октябрьский</label> <input id="dis7" type="checkbox" name="dis7" /><br />
		<label for="dis8" >Первомайский</label> <input id="dis8" type="checkbox" name="dis8" /><br />
		<label for="dis9" >Советский</label> <input id="dis9" type="checkbox" name="dis9" /><br />
		<label for="dis10" >Центральный</label> <input id="dis10" type="checkbox" name="dis10" />
		</div>
	</div>
	
	
	<div onclick="showSelect('str-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
	text-align: left;
	cursor: pointer;
	" >Улица<span id="streets_number" style="float: right; margin-right: 5px;"></span></div>
	<div id="str-select" style="display: none"  class="div-select" >
	<input type="text" id="str" name="street" style="background: #F2D7E7;"  value="<?php if($_POST['street']) {echo $_POST['street']; } ?>" 
					
	autocomplete="off"/> введите улицу, или часть
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					
					</div>
					<ul id="street_adds">
					<?php if($_POST['street0']) { ?>
					
					<label id="label-0" class="str_search_res" onclick="removeStreet('0')" for="street-0" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-0" class="invisible" name="street0" type="text" value="<?php echo $_POST['street0']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street1']) { ?>
					
					<label id="label-1" class="str_search_res" onclick="removeStreet('1')" for="street-1" style="color: black;"><?php echo $_POST['street1']; ?></label>
					<input id="street-1" class="invisible" name="street0" type="text" value="<?php echo $_POST['street1']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street2']) { ?>
					
					<label id="label-2" class="str_search_res" onclick="removeStreet('2')" for="street-2" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-2" class="invisible" name="street2" type="text" value="<?php echo $_POST['street2']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street3']) { ?>
					
					<label id="label-3" class="str_search_res" onclick="removeStreet('3')" for="street-3" style="color: black;"><?php echo $_POST['street3']; ?></label>
					<input id="street-3" class="invisible" name="street0" type="text" value="<?php echo $_POST['street3']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street4']) { ?>
					
					<label id="label-4" class="str_search_res" onclick="removeStreet('4')" for="street-4" style="color: black;"><?php echo $_POST['street4']; ?></label>
					<input id="street-4" class="invisible" name="street4" type="text" value="<?php echo $_POST['street4']; ?>" style="color: black;">
					
					<?php }
					?>
					</ul>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="house">№</label>
	<input id="house" name="house" type="text" value="<?php if($_POST['house']) {echo $_POST['house']; } ?>"/>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($_POST['orientir']) {echo $_POST['orientir']; } ?>"/>
	</div>
</td>
<td style="width: 420px;">
	
	<div class="control-group checklabel switch_buy_rent" style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;">
		<div class="header-3">
			Количество комнат
		</div> <br />
		
		
		<input class="invisible"  id="k" value="8"  type="checkbox" name="type_id1"  <?php if($_POST['type_id1'] == 8) echo "checked"; ?> /> 
		<label id="label" for="k">Комната</label>
		
		<input class="invisible"  id="k-1" value="9"  type="checkbox" name="type_id2"  <?php if($_POST['type_id2'] == 9) echo "checked"; ?> /> 
		<label id="label" for="k-1">1-к</label>
		
		<input class="invisible"  id="k-2" value="10" type="checkbox" name="type_id3"  <?php if($_POST['type_id3'] == 10) echo "checked"; ?> /> 
		<label id="label" for="k-2">2-к</label>
		
		<input class="invisible"  id="k-3" value="11" type="checkbox" name="type_id4"  <?php if($_POST['type_id4'] == 11) echo "checked"; ?> /> 
		<label id="label" for="k-3">3-к</label>
		
		<input class="invisible"  id="k-4" value="15" type="checkbox" name="type_id5"  <?php if($_POST['type_id5'] == 15) echo "checked"; ?> /> 
		<label id="label" for="k-4">4-к</label>
		
		<input class="invisible"  id="k-5" value="16" type="checkbox" name="type_id6"  <?php if($_POST['type_id6'] == 16) echo "checked"; ?> /> 
		<label id="label" for="k-5">5-к</label>
		
		<input class="invisible"  id="k-6" value="17" type="checkbox" name="type_id7"  <?php if($_POST['type_id7'] == 17) echo "checked"; ?> /> 
		<label id="label" for="k-6">6-к +</label>
	</div>

	<div class="control-group">
		<label class="control-label" id="planning">Планировка</label>
		
			<select  class="controls-select" name="planning" id="planning" >
				<option value="" >не важно</option>
				<option value="изолированная" <?php if($_POST['planning'] == "изолированная") echo "selected"; ?>  >изолированная</option>
				<option value="смежная" <?php if($_POST['planning'] == "смежная") echo "selected"; ?> >смежная</option>
				<option value="см-изолированная" <?php if($_POST['planning'] == "см-изолированная") echo "selected"; ?> >см-изолированная</option>
				<option value="свободная" <?php if($_POST['planning'] == "свободная") echo "selected"; ?> >свободная</option>
				<option value="студия" <?php if($_POST['planning'] == "студия") echo "selected"; ?> >студия</option>
				<option value="иное" <?php if($_POST['planning'] == "иное") echo "selected"; ?> >иное</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="ap_layout">Тип квартиры</label>
		
			<select  class="controls-select" name="ap_layout" id="ap_layout" >
				<option value="">не важно</option>
				<option value="общежитие" <?php if($_POST['ap_layout'] == "общежитие") echo "selected"; ?>  >общежитие</option>
				<option value="малосемейка" <?php if($_POST['ap_layout'] == "малосемейка") echo "selected"; ?> >малосемейка</option>
				<option value="улучшеная планировка" <?php if($_POST['ap_layout'] == "улучшеная планировка") echo "selected"; ?> >улучшеная планировка</option>
				<option value="типовая" <?php if($_POST['ap_layout'] == "типовая") echo "selected"; ?> >типовая</option>
				<option value="хрещевка" <?php if($_POST['ap_layout'] == "хрещевка") echo "selected"; ?> >хрущевка</option>
				<option value="полногабаритная" <?php if($_POST['ap_layout'] == "полногабаритная") echo "selected"; ?> >полногабаритная</option>
				<option value="малоэтажка" <?php if($_POST['ap_layout'] == "малоэтажка") echo "selected"; ?> >малоэтажка</option>
				<option value="пентхаус" <?php if($_POST['ap_layout'] == "пентхаус") echo "selected"; ?> >пентхаус</option>
				<option value="двухуровневая" <?php if($_POST['ap_layout'] == "двухуровневая") echo "selected"; ?> >двухуровневая</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="wc_type">Санузел</label>
		
			<select  class="controls-select" name="wc_type" id="wc_type" >
				<option value="" >не важно</option>
				<option value="раздельный" <?php if($_POST['wc_type'] == "раздельный") echo "selected"; ?>  >раздельный</option>
				<option value="совмещенный" <?php if($_POST['wc_type'] == "совмещенный") echo "selected"; ?> >совмещенный</option>
				<option value="без удобств" <?php if($_POST['wc_type'] == "без удобств") echo "selected"; ?> >без удобств</option>
				<option value="ванна" <?php if($_POST['wc_type'] == "ванна") echo "selected"; ?> >ванна</option>
				<option value="душ" <?php if($_POST['wc_type'] == "душ") echo "selected"; ?> >душ</option>
				<option value="2 санузла" <?php if($_POST['wc_type'] == "2 санузла") echo "selected"; ?> >2 санузла</option>
				<option value="3 санузла" <?php if($_POST['wc_type'] == "3 санузла") echo "selected"; ?> >3 санузла</option>
				
			</select>
		
	</div>
</td>
<td>
<div  style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;" >
<label for="pricefrom">Цена от</label>
		<input id="pricefrom" name="pricefrom" type="text" value="<?php if ($_POST['pricefrom']) echo $_POST['pricefrom']; ?>" style="width: 100px; text-align: right;"/> 
<label for="priceto">до</label>
		<input id="priceto" name="priceto" type="text" value="<?php if ($_POST['priceto']) echo $_POST['priceto']; ?>" style="width: 100px; text-align: right;"/>
		<br />
		<label class="control-label" id="rent_type">за </label>
		
			<select  class="controls-select" name="rent_type" id="rent_type" >
				<option value="месяц"  <?php if($_POST['rent_type'] == 'месяц') echo "selected"; ?> >месяц</option>
				<option value="сутки"  <?php if($_POST['rent_type'] == 'сутки') echo "selected"; ?> >сутки</option>
				<option value="час"  <?php if($_POST['rent_type'] == 'час') echo "selected"; ?> >час</option>
				
			</select>
		
	
		
		<label for="price">Торг</label>
		<input id="torg" name="torg" type="checkbox" <?php if($_POST['torg'] == 'on') echo "checked"; ?> /> 
		
<div class="control-group">	
	<table>
	  <tr>
		<td>
		<label for="inet"><span><img id="icons" src="images/inet.png" title="Интернет"/></span></label>
		</td>
		<td>
		<label for="furn"><span><img id="icons" src="images/mebel.png" title="Мебель"/></span></label>
		</td>
		<td>
		<label for="tv"><span><img id="icons" src="images/icon-tv.png" title="Телевизор"/></span></label>
		</td>
		<td>
		<label for="washing"><span><img id="icons" src="images/iconlaundry.png" title="Стиральная машина"/></span></label>
		</td>
		<td>
		<label for="refrig"><span><img id="icons" class="refrigerator" src="images/refrigerator.png" title="Холодильник"/></span></label>
		</td>
		<td>
		<label for="conditioner"><span><img id="icons" src="images/freashing.png" title="Кондиционер"/></span></label>
		</td>
	  </tr>	
	  <tr>	
		<td>
		<input id="inet" name="inet" type="checkbox"  <?php if($_POST['tel'] == 1) echo "checked"; ?>  /> 
		</td>
		<td>
		<input id="furn" name="furn" type="checkbox"  <?php if($_POST['furn'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="tv" name="tv" type="checkbox"  <?php if($_POST['tv'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="washing" name="washing" type="checkbox"  <?php if($_POST['washing'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="refrig" name="refrig" type="checkbox"  <?php if($_POST['refrig'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="conditioner" name="conditioner" type="checkbox"  <?php if($_POST['conditioner'] == 1) echo "checked"; ?> /> 
		</td>
	  </tr>
	</table>
	</div>
	
	

	</div>
</td>
</tr>
</table>
<table id="advansed-search" style="display: none;">
	<tr>
		<td style="width: 565px;">
			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Площадь (от)
				</div>
				<label for="sq_allfrom">Общая</label>
				<input id="sq_allfrom" name="sq_allfrom" type="text" value="<?php if($_POST['sq_allfrom']) {echo $_POST['sq_allfrom']; } ?>"  /> / 
				<label  for="sq_livefrom">Жилая</label>
				<input id="sq_livefrom" name="sq_livefrom" type="text" value="<?php if($_POST['sq_livefrom']) {echo $_POST['sq_livefrom']; } ?>"  /> / 
				<label for="sq_kfrom">Кухня</label>
				<input id="sq_kfrom" name="sq_kfrom" type="text" value="<?php if($_POST['sq_kfrom']) {echo $_POST['sq_kfrom']; } ?>"  />
				<br />
				<div class="header-3">
					Площадь (до)
				</div>
				<label for="sq_allto">Общая</label>
				<input id="sq_allto" name="sq_allto" type="text" value="<?php if($_POST['sq_allto']) {echo $_POST['sq_allto']; } ?>"  /> / 
				<label  for="sq_liveto">Жилая</label>
				<input id="sq_liveto" name="sq_liveto" type="text" value="<?php if($_POST['sq_liveto']) {echo $_POST['sq_liveto']; } ?>"  /> / 
				<label for="sq_kto">Кухня</label>
				<input id="sq_kto" name="sq_kto" type="text" value="<?php if($_POST['sq_kto']) {echo $_POST['sq_kto']; } ?>"  />
			</div>

			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Этаж / Этажность (от)
				</div>
				
				<input id="floorfrom" name="floorfrom" type="text" value="<?php if($_POST['floorfrom']) echo $_POST['floorfrom']; ?>" /> / 
				
				<input id="floor_countfrom" name="floor_countfrom" type="text" value="<?php if($_POST['floor_countfrom']) echo $_POST['floor_countfrom']; ?>" />
				<br />
				<div class="header-3">
					Этаж / Этажность (до)
				</div>
				
				<input id="floorto" name="floorto" type="text" value="<?php if($_POST['floorto']) echo $_POST['floorto']; ?>" /> / 
				
				<input id="floor_countto" name="floor_countto" type="text" value="<?php if($_POST['floor_countto']) echo $_POST['floor_countto']; ?>" />
			</div>

		</td>
		<td style="width: 732px;">
			<div class="control-group">
				<label class="control-label" id="park">Парковка/гараж</label>
					<select class="controls-select" name="park" id="park" >
						<option value="Благоустроенная парковка у дома"  <?php if($_POST['park'] == 'частная') echo "selected"; ?> >Благоустроенная парковка у дома</option>
						<option value="Парковка со шлагбаумом" <?php if($_POST['park'] == 'Парковка со шлагбаумом') echo "selected"; ?> >Парковка со шлагбаумом</option>
						<option value="Подземный гараж" <?php if($_POST['park'] == 'Подземный гараж') echo "selected"; ?> >Подземный гараж</option>
						<option value="Подземная парковка" <?php if($_POST['park'] == 'Подземная парковка') echo "selected"; ?> >Подземная парковка</option>
					</select>
			</div>
	
			<div class="control-group">
				<label class="control-label" id="wall_type">Материал стен</label>
					<select class="controls-select" name="wall_type" id="wall_type" >
						<option value="кирпичный"  <?php if($_POST['wall_type'] == 'кирпичный') echo "selected"; ?> >кирпичный</option>
						<option value="панельный"  <?php if($_POST['wall_type'] == 'панельный') echo "selected"; ?> >панельный</option>
						<option value="деревянный"  <?php if($_POST['wall_type'] == 'деревянный') echo "selected"; ?> >деревянный</option>
						<option value="монолит"  <?php if($_POST['wall_type'] == 'монолит') echo "selected"; ?> >монолит</option>
					</select>
			</div>
			<div class="control-group">
				<label class="control-label" id="val_bal">Количество балконов</label>
				<input id="val_bal" name="val_bal" type="text" value="<?php if($_POST['val_bal']) {echo $_POST['val_bal']; } ?>" /> 
				
				<label class="control-label" id="val_lodg">Количество лоджий</label>
				<input id="val_lodg" name="val_lodg" type="text" value="<?php if($_POST['val_lodg']) {echo $_POST['val_lodg']; } ?>" /> 
		
			</div>
		</td>
	</tr>
</table>
	<li id="control_panel" style="
		text-align: left;
		list-style: none;">
		<span id="control" style="
		cursor:pointer;
		"><a onclick="showSelect('advansed-search')">Расширенный поиск</a></span>
		
		<input id="search-button" type="submit" name="submit" value="Поиск" style="float: right;" />
		</li>
	
	</form>
</div>
<!--Новостройки --> 
<div>
	<form id="" method="POST" action="?task=main&action=search" >


	
	<div class="control-group checklabel topic_id">
			<div class="header-3">
				Я хочу
			</div>
			<input type="hidden" name="search_type" value="topic_id3" />
			<input class="invisible" id="vkl3sell" value="2"  type="radio" name="topic_id3" checked="checked" /> 
			<label id="label" for="vkl3sell">Купить</label>
			
		
		</div>
	
	<?php

?>
<table>
<tr>
<td style="width: 300px;">
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text"  value="<?php if($_POST['live_point']) { echo $_POST['live_point']; } ?>" /> <br />
	</div>
	
	
	<div onclick="showSelect('dis-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
text-align: left;
	cursor: pointer;
	" >Район</div>
	<div id="dis-select" style="display: none;" class="div-select">
		<div class="left">
		<label for="dis1" >Дзержинский</label> <input id="dis1" type="checkbox" name="dis1" /><br />
		<label for="dis2" >Железнодорожный</label><input id="dis2" type="checkbox" name="dis2" /><br />
		<label for="dis3" >Заельцовский</label> <input id="dis3" type="checkbox" name="dis3" /><br />
		<label for="dis4" >Калининский</label> <input id="dis4" type="checkbox" name="dis4" /><br />
		<label for="dis5" >Кировский</label> <input id="dis5" type="checkbox" name="dis5" />
		</div>
		<div class="right">
		<label for="dis6" >Ленинский</label> <input id="dis6" type="checkbox" name="dis6" /><br />
		<label for="dis7" >Октябрьский</label> <input id="dis7" type="checkbox" name="dis7" /><br />
		<label for="dis8" >Первомайский</label> <input id="dis8" type="checkbox" name="dis8" /><br />
		<label for="dis9" >Советский</label> <input id="dis9" type="checkbox" name="dis9" /><br />
		<label for="dis10" >Центральный</label> <input id="dis10" type="checkbox" name="dis10" />
		</div>
	</div>
	
	
	<div onclick="showSelect('str-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
	text-align: left;
	cursor: pointer;
	" >Улица<span id="streets_number" style="float: right; margin-right: 5px;"></span></div>
	<div id="str-select" style="display: none"  class="div-select" >
	<input type="text" id="str" name="street" style="background: #F2D7E7;"  value="<?php if($_POST['street']) {echo $_POST['street']; } ?>" 
					
	autocomplete="off"/> введите улицу, или часть
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					
					</div>
					<ul id="street_adds">
					<?php if($_POST['street0']) { ?>
					
					<label id="label-0" class="str_search_res" onclick="removeStreet('0')" for="street-0" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-0" class="invisible" name="street0" type="text" value="<?php echo $_POST['street0']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street1']) { ?>
					
					<label id="label-1" class="str_search_res" onclick="removeStreet('1')" for="street-1" style="color: black;"><?php echo $_POST['street1']; ?></label>
					<input id="street-1" class="invisible" name="street0" type="text" value="<?php echo $_POST['street1']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street2']) { ?>
					
					<label id="label-2" class="str_search_res" onclick="removeStreet('2')" for="street-2" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-2" class="invisible" name="street2" type="text" value="<?php echo $_POST['street2']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street3']) { ?>
					
					<label id="label-3" class="str_search_res" onclick="removeStreet('3')" for="street-3" style="color: black;"><?php echo $_POST['street3']; ?></label>
					<input id="street-3" class="invisible" name="street0" type="text" value="<?php echo $_POST['street3']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street4']) { ?>
					
					<label id="label-4" class="str_search_res" onclick="removeStreet('4')" for="street-4" style="color: black;"><?php echo $_POST['street4']; ?></label>
					<input id="street-4" class="invisible" name="street4" type="text" value="<?php echo $_POST['street4']; ?>" style="color: black;">
					
					<?php }
					?>
					</ul>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="house">№</label>
	<input id="house" name="house" type="text" value="<?php if($_POST['house']) {echo $_POST['house']; } ?>"/>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($_POST['orientir']) {echo $_POST['orientir']; } ?>"/>
	</div>
</td>
<td style="width: 420px;">
	
	<div class="control-group checklabel switch_buy_rent" style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;">
		<div class="header-3">
			Количество комнат
		</div> <br />
		
		
		<input class="invisible"  id="k" value="8"  type="checkbox" name="type_id1"  <?php if($_POST['type_id1'] == 8) echo "checked"; ?> /> 
		<label id="label" for="k">Комната</label>
		
		<input class="invisible"  id="k-1" value="9"  type="checkbox" name="type_id2"  <?php if($_POST['type_id2'] == 9) echo "checked"; ?> /> 
		<label id="label" for="k-1">1-к</label>
		
		<input class="invisible"  id="k-2" value="10" type="checkbox" name="type_id3"  <?php if($_POST['type_id3'] == 10) echo "checked"; ?> /> 
		<label id="label" for="k-2">2-к</label>
		
		<input class="invisible"  id="k-3" value="11" type="checkbox" name="type_id4"  <?php if($_POST['type_id4'] == 11) echo "checked"; ?> /> 
		<label id="label" for="k-3">3-к</label>
		
		<input class="invisible"  id="k-4" value="15" type="checkbox" name="type_id5"  <?php if($_POST['type_id5'] == 15) echo "checked"; ?> /> 
		<label id="label" for="k-4">4-к</label>
		
		<input class="invisible"  id="k-5" value="16" type="checkbox" name="type_id6"  <?php if($_POST['type_id6'] == 16) echo "checked"; ?> /> 
		<label id="label" for="k-5">5-к</label>
		
		<input class="invisible"  id="k-6" value="17" type="checkbox" name="type_id7"  <?php if($_POST['type_id7'] == 17) echo "checked"; ?> /> 
		<label id="label" for="k-6">6-к +</label>
	</div>

	<div class="control-group">
		<label class="control-label" id="planning">Планировка</label>
		
			<select  class="controls-select" name="planning" id="planning" >
				<option value="" >не важно</option>
				<option value="изолированная" <?php if($_POST['planning'] == "изолированная") echo "selected"; ?>  >изолированная</option>
				<option value="смежная" <?php if($_POST['planning'] == "смежная") echo "selected"; ?> >смежная</option>
				<option value="см-изолированная" <?php if($_POST['planning'] == "см-изолированная") echo "selected"; ?> >см-изолированная</option>
				<option value="свободная" <?php if($_POST['planning'] == "свободная") echo "selected"; ?> >свободная</option>
				<option value="студия" <?php if($_POST['planning'] == "студия") echo "selected"; ?> >студия</option>
				<option value="иное" <?php if($_POST['planning'] == "иное") echo "selected"; ?> >иное</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="ap_layout">Тип квартиры</label>
		
			<select  class="controls-select" name="ap_layout" id="ap_layout" >
				<option value="">не важно</option>
				<option value="общежитие" <?php if($_POST['ap_layout'] == "общежитие") echo "selected"; ?>  >общежитие</option>
				<option value="малосемейка" <?php if($_POST['ap_layout'] == "малосемейка") echo "selected"; ?> >малосемейка</option>
				<option value="улучшеная планировка" <?php if($_POST['ap_layout'] == "улучшеная планировка") echo "selected"; ?> >улучшеная планировка</option>
				<option value="типовая" <?php if($_POST['ap_layout'] == "типовая") echo "selected"; ?> >типовая</option>
				<option value="хрещевка" <?php if($_POST['ap_layout'] == "хрещевка") echo "selected"; ?> >хрущевка</option>
				<option value="полногабаритная" <?php if($_POST['ap_layout'] == "полногабаритная") echo "selected"; ?> >полногабаритная</option>
				<option value="малоэтажка" <?php if($_POST['ap_layout'] == "малоэтажка") echo "selected"; ?> >малоэтажка</option>
				<option value="пентхаус" <?php if($_POST['ap_layout'] == "пентхаус") echo "selected"; ?> >пентхаус</option>
				<option value="двухуровневая" <?php if($_POST['ap_layout'] == "двухуровневая") echo "selected"; ?> >двухуровневая</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="wc_type">Санузел</label>
		
			<select  class="controls-select" name="wc_type" id="wc_type" >
				<option value="" >не важно</option>
				<option value="раздельный" <?php if($_POST['wc_type'] == "раздельный") echo "selected"; ?>  >раздельный</option>
				<option value="совмещенный" <?php if($_POST['wc_type'] == "совмещенный") echo "selected"; ?> >совмещенный</option>
				<option value="без удобств" <?php if($_POST['wc_type'] == "без удобств") echo "selected"; ?> >без удобств</option>
				<option value="ванна" <?php if($_POST['wc_type'] == "ванна") echo "selected"; ?> >ванна</option>
				<option value="душ" <?php if($_POST['wc_type'] == "душ") echo "selected"; ?> >душ</option>
				<option value="2 санузла" <?php if($_POST['wc_type'] == "2 санузла") echo "selected"; ?> >2 санузла</option>
				<option value="3 санузла" <?php if($_POST['wc_type'] == "3 санузла") echo "selected"; ?> >3 санузла</option>
				
			</select>
		
	</div>
</td>
<td>
<div  style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;" >
<label for="pricefrom">Цена от</label>
		<input id="pricefrom" name="pricefrom" type="text" value="<?php if ($_POST['pricefrom']) echo $_POST['pricefrom']; ?>" style="width: 100px; text-align: right;"/> 
<label for="priceto">до</label>
		<input id="priceto" name="priceto" type="text" value="<?php if ($_POST['priceto']) echo $_POST['priceto']; ?>" style="width: 100px; text-align: right;"/>
		<br />
		<label class="control-label" id="rent_type">за </label>
		
			<select  class="controls-select" name="rent_type" id="rent_type" >
				<option value="месяц"  <?php if($_POST['rent_type'] == 'месяц') echo "selected"; ?> >месяц</option>
				<option value="сутки"  <?php if($_POST['rent_type'] == 'сутки') echo "selected"; ?> >сутки</option>
				<option value="час"  <?php if($_POST['rent_type'] == 'час') echo "selected"; ?> >час</option>
				
			</select>
		
	
		
		<label for="price">Торг</label>
		<input id="torg" name="torg" type="checkbox" <?php if($_POST['torg'] == 'on') echo "checked"; ?> /> 
		
<div class="control-group">	
	<table>
	  <tr>
		<td>
		<label for="inet"><span><img id="icons" src="images/inet.png" title="Интернет"/></span></label>
		</td>
		<td>
		<label for="furn"><span><img id="icons" src="images/mebel.png" title="Мебель"/></span></label>
		</td>
		<td>
		<label for="tv"><span><img id="icons" src="images/icon-tv.png" title="Телевизор"/></span></label>
		</td>
		<td>
		<label for="washing"><span><img id="icons" src="images/iconlaundry.png" title="Стиральная машина"/></span></label>
		</td>
		<td>
		<label for="refrig"><span><img id="icons" class="refrigerator" src="images/refrigerator.png" title="Холодильник"/></span></label>
		</td>
		<td>
		<label for="conditioner"><span><img id="icons" src="images/freashing.png" title="Кондиционер"/></span></label>
		</td>
	  </tr>	
	  <tr>	
		<td>
		<input id="inet" name="inet" type="checkbox"  <?php if($_POST['tel'] == 1) echo "checked"; ?>  /> 
		</td>
		<td>
		<input id="furn" name="furn" type="checkbox"  <?php if($_POST['furn'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="tv" name="tv" type="checkbox"  <?php if($_POST['tv'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="washing" name="washing" type="checkbox"  <?php if($_POST['washing'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="refrig" name="refrig" type="checkbox"  <?php if($_POST['refrig'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="conditioner" name="conditioner" type="checkbox"  <?php if($_POST['conditioner'] == 1) echo "checked"; ?> /> 
		</td>
	  </tr>
	</table>
	</div>
	
	

	</div>
</td>
</tr>
</table>
<table id="advansed-search" style="display: none;">
	<tr>
		<td style="width: 565px;">
			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Площадь (от)
				</div>
				<label for="sq_allfrom">Общая</label>
				<input id="sq_allfrom" name="sq_allfrom" type="text" value="<?php if($_POST['sq_allfrom']) {echo $_POST['sq_allfrom']; } ?>"  /> / 
				<label  for="sq_livefrom">Жилая</label>
				<input id="sq_livefrom" name="sq_livefrom" type="text" value="<?php if($_POST['sq_livefrom']) {echo $_POST['sq_livefrom']; } ?>"  /> / 
				<label for="sq_kfrom">Кухня</label>
				<input id="sq_kfrom" name="sq_kfrom" type="text" value="<?php if($_POST['sq_kfrom']) {echo $_POST['sq_kfrom']; } ?>"  />
				<br />
				<div class="header-3">
					Площадь (до)
				</div>
				<label for="sq_allto">Общая</label>
				<input id="sq_allto" name="sq_allto" type="text" value="<?php if($_POST['sq_allto']) {echo $_POST['sq_allto']; } ?>"  /> / 
				<label  for="sq_liveto">Жилая</label>
				<input id="sq_liveto" name="sq_liveto" type="text" value="<?php if($_POST['sq_liveto']) {echo $_POST['sq_liveto']; } ?>"  /> / 
				<label for="sq_kto">Кухня</label>
				<input id="sq_kto" name="sq_kto" type="text" value="<?php if($_POST['sq_kto']) {echo $_POST['sq_kto']; } ?>"  />
			</div>

			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Этаж / Этажность (от)
				</div>
				
				<input id="floorfrom" name="floorfrom" type="text" value="<?php if($_POST['floorfrom']) echo $_POST['floorfrom']; ?>" /> / 
				
				<input id="floor_countfrom" name="floor_countfrom" type="text" value="<?php if($_POST['floor_countfrom']) echo $_POST['floor_countfrom']; ?>" />
				<br />
				<div class="header-3">
					Этаж / Этажность (до)
				</div>
				
				<input id="floorto" name="floorto" type="text" value="<?php if($_POST['floorto']) echo $_POST['floorto']; ?>" /> / 
				
				<input id="floor_countto" name="floor_countto" type="text" value="<?php if($_POST['floor_countto']) echo $_POST['floor_countto']; ?>" />
			</div>

		</td>
		<td style="width: 732px;">
			<div class="control-group">
				<label class="control-label" id="park">Парковка/гараж</label>
					<select class="controls-select" name="park" id="park" >
						<option value="Благоустроенная парковка у дома"  <?php if($_POST['park'] == 'частная') echo "selected"; ?> >Благоустроенная парковка у дома</option>
						<option value="Парковка со шлагбаумом" <?php if($_POST['park'] == 'Парковка со шлагбаумом') echo "selected"; ?> >Парковка со шлагбаумом</option>
						<option value="Подземный гараж" <?php if($_POST['park'] == 'Подземный гараж') echo "selected"; ?> >Подземный гараж</option>
						<option value="Подземная парковка" <?php if($_POST['park'] == 'Подземная парковка') echo "selected"; ?> >Подземная парковка</option>
					</select>
			</div>
	
			<div class="control-group">
				<label class="control-label" id="wall_type">Материал стен</label>
					<select class="controls-select" name="wall_type" id="wall_type" >
						<option value="кирпичный"  <?php if($_POST['wall_type'] == 'кирпичный') echo "selected"; ?> >кирпичный</option>
						<option value="панельный"  <?php if($_POST['wall_type'] == 'панельный') echo "selected"; ?> >панельный</option>
						<option value="деревянный"  <?php if($_POST['wall_type'] == 'деревянный') echo "selected"; ?> >деревянный</option>
						<option value="монолит"  <?php if($_POST['wall_type'] == 'монолит') echo "selected"; ?> >монолит</option>
					</select>
			</div>
			<div class="control-group">
				<label class="control-label" id="val_bal">Количество балконов</label>
				<input id="val_bal" name="val_bal" type="text" value="<?php if($_POST['val_bal']) {echo $_POST['val_bal']; } ?>" /> 
				
				<label class="control-label" id="val_lodg">Количество лоджий</label>
				<input id="val_lodg" name="val_lodg" type="text" value="<?php if($_POST['val_lodg']) {echo $_POST['val_lodg']; } ?>" /> 
		
			</div>
		</td>
	</tr>
</table>
	<li id="control_panel" style="
		text-align: left;
		list-style: none;">
		<span id="control" style="
		cursor:pointer;
		"><a onclick="showSelect('advansed-search')">Расширенный поиск</a></span>
		
		<input id="search-button" type="submit" name="submit" value="Поиск" style="float: right;" />
		</li>
	
	</form>
</div>
<!--Коттеджы-дома --> 
<div>
	<form id="" method="POST" action="?task=main&action=search" >


	
	<div class="control-group checklabel topic_id">
			<div class="header-3">
				Я хочу
			</div>
			<input type="hidden" name="search_type" value="topic_id4" />
			<input class="invisible" id="vkl4sell" value="2"  type="radio" name="topic_id4"  /> 
			<label id="label" for="vkl4sell">Купить</label>
			<input class="invisible" id="vkl4rent" value="1" type="radio" name="topic_id4" checked="checked" /> 
			<label id="label" for="vkl4rent">Снять</label>
		
		</div>
	
	<?php

?>
<table>
<tr>
<td style="width: 300px;">
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text"  value="<?php if($_POST['live_point']) { echo $_POST['live_point']; } ?>" /> <br />
	</div>
	
	
	<div onclick="showSelect('dis-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
text-align: left;
	cursor: pointer;
	" >Район</div>
	<div id="dis-select" style="display: none;" class="div-select">
		<div class="left">
		<label for="dis1" >Дзержинский</label> <input id="dis1" type="checkbox" name="dis1" /><br />
		<label for="dis2" >Железнодорожный</label><input id="dis2" type="checkbox" name="dis2" /><br />
		<label for="dis3" >Заельцовский</label> <input id="dis3" type="checkbox" name="dis3" /><br />
		<label for="dis4" >Калининский</label> <input id="dis4" type="checkbox" name="dis4" /><br />
		<label for="dis5" >Кировский</label> <input id="dis5" type="checkbox" name="dis5" />
		</div>
		<div class="right">
		<label for="dis6" >Ленинский</label> <input id="dis6" type="checkbox" name="dis6" /><br />
		<label for="dis7" >Октябрьский</label> <input id="dis7" type="checkbox" name="dis7" /><br />
		<label for="dis8" >Первомайский</label> <input id="dis8" type="checkbox" name="dis8" /><br />
		<label for="dis9" >Советский</label> <input id="dis9" type="checkbox" name="dis9" /><br />
		<label for="dis10" >Центральный</label> <input id="dis10" type="checkbox" name="dis10" />
		</div>
	</div>
	
	
	<div onclick="showSelect('str-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
	text-align: left;
	cursor: pointer;
	" >Улица<span id="streets_number" style="float: right; margin-right: 5px;"></span></div>
	<div id="str-select" style="display: none"  class="div-select" >
	<input type="text" id="str" name="street" style="background: #F2D7E7;"  value="<?php if($_POST['street']) {echo $_POST['street']; } ?>" 
					
	autocomplete="off"/> введите улицу, или часть
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					
					</div>
					<ul id="street_adds">
					<?php if($_POST['street0']) { ?>
					
					<label id="label-0" class="str_search_res" onclick="removeStreet('0')" for="street-0" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-0" class="invisible" name="street0" type="text" value="<?php echo $_POST['street0']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street1']) { ?>
					
					<label id="label-1" class="str_search_res" onclick="removeStreet('1')" for="street-1" style="color: black;"><?php echo $_POST['street1']; ?></label>
					<input id="street-1" class="invisible" name="street0" type="text" value="<?php echo $_POST['street1']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street2']) { ?>
					
					<label id="label-2" class="str_search_res" onclick="removeStreet('2')" for="street-2" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-2" class="invisible" name="street2" type="text" value="<?php echo $_POST['street2']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street3']) { ?>
					
					<label id="label-3" class="str_search_res" onclick="removeStreet('3')" for="street-3" style="color: black;"><?php echo $_POST['street3']; ?></label>
					<input id="street-3" class="invisible" name="street0" type="text" value="<?php echo $_POST['street3']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street4']) { ?>
					
					<label id="label-4" class="str_search_res" onclick="removeStreet('4')" for="street-4" style="color: black;"><?php echo $_POST['street4']; ?></label>
					<input id="street-4" class="invisible" name="street4" type="text" value="<?php echo $_POST['street4']; ?>" style="color: black;">
					
					<?php }
					?>
					</ul>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="house">№</label>
	<input id="house" name="house" type="text" value="<?php if($_POST['house']) {echo $_POST['house']; } ?>"/>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($_POST['orientir']) {echo $_POST['orientir']; } ?>"/>
	</div>
</td>
<td style="width: 420px;">
	
	<div class="control-group checklabel switch_buy_rent" style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;">
		<div class="header-3">
			Количество комнат
		</div> <br />
		
		
		<input class="invisible"  id="k" value="8"  type="checkbox" name="type_id1"  <?php if($_POST['type_id1'] == 8) echo "checked"; ?> /> 
		<label id="label" for="k">Комната</label>
		
		<input class="invisible"  id="k-1" value="9"  type="checkbox" name="type_id2"  <?php if($_POST['type_id2'] == 9) echo "checked"; ?> /> 
		<label id="label" for="k-1">1-к</label>
		
		<input class="invisible"  id="k-2" value="10" type="checkbox" name="type_id3"  <?php if($_POST['type_id3'] == 10) echo "checked"; ?> /> 
		<label id="label" for="k-2">2-к</label>
		
		<input class="invisible"  id="k-3" value="11" type="checkbox" name="type_id4"  <?php if($_POST['type_id4'] == 11) echo "checked"; ?> /> 
		<label id="label" for="k-3">3-к</label>
		
		<input class="invisible"  id="k-4" value="15" type="checkbox" name="type_id5"  <?php if($_POST['type_id5'] == 15) echo "checked"; ?> /> 
		<label id="label" for="k-4">4-к</label>
		
		<input class="invisible"  id="k-5" value="16" type="checkbox" name="type_id6"  <?php if($_POST['type_id6'] == 16) echo "checked"; ?> /> 
		<label id="label" for="k-5">5-к</label>
		
		<input class="invisible"  id="k-6" value="17" type="checkbox" name="type_id7"  <?php if($_POST['type_id7'] == 17) echo "checked"; ?> /> 
		<label id="label" for="k-6">6-к +</label>
	</div>

	<div class="control-group">
		<label class="control-label" id="planning">Планировка</label>
		
			<select  class="controls-select" name="planning" id="planning" >
				<option value="" >не важно</option>
				<option value="изолированная" <?php if($_POST['planning'] == "изолированная") echo "selected"; ?>  >изолированная</option>
				<option value="смежная" <?php if($_POST['planning'] == "смежная") echo "selected"; ?> >смежная</option>
				<option value="см-изолированная" <?php if($_POST['planning'] == "см-изолированная") echo "selected"; ?> >см-изолированная</option>
				<option value="свободная" <?php if($_POST['planning'] == "свободная") echo "selected"; ?> >свободная</option>
				<option value="студия" <?php if($_POST['planning'] == "студия") echo "selected"; ?> >студия</option>
				<option value="иное" <?php if($_POST['planning'] == "иное") echo "selected"; ?> >иное</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="ap_layout">Тип квартиры</label>
		
			<select  class="controls-select" name="ap_layout" id="ap_layout" >
				<option value="">не важно</option>
				<option value="общежитие" <?php if($_POST['ap_layout'] == "общежитие") echo "selected"; ?>  >общежитие</option>
				<option value="малосемейка" <?php if($_POST['ap_layout'] == "малосемейка") echo "selected"; ?> >малосемейка</option>
				<option value="улучшеная планировка" <?php if($_POST['ap_layout'] == "улучшеная планировка") echo "selected"; ?> >улучшеная планировка</option>
				<option value="типовая" <?php if($_POST['ap_layout'] == "типовая") echo "selected"; ?> >типовая</option>
				<option value="хрещевка" <?php if($_POST['ap_layout'] == "хрещевка") echo "selected"; ?> >хрущевка</option>
				<option value="полногабаритная" <?php if($_POST['ap_layout'] == "полногабаритная") echo "selected"; ?> >полногабаритная</option>
				<option value="малоэтажка" <?php if($_POST['ap_layout'] == "малоэтажка") echo "selected"; ?> >малоэтажка</option>
				<option value="пентхаус" <?php if($_POST['ap_layout'] == "пентхаус") echo "selected"; ?> >пентхаус</option>
				<option value="двухуровневая" <?php if($_POST['ap_layout'] == "двухуровневая") echo "selected"; ?> >двухуровневая</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="wc_type">Санузел</label>
		
			<select  class="controls-select" name="wc_type" id="wc_type" >
				<option value="" >не важно</option>
				<option value="раздельный" <?php if($_POST['wc_type'] == "раздельный") echo "selected"; ?>  >раздельный</option>
				<option value="совмещенный" <?php if($_POST['wc_type'] == "совмещенный") echo "selected"; ?> >совмещенный</option>
				<option value="без удобств" <?php if($_POST['wc_type'] == "без удобств") echo "selected"; ?> >без удобств</option>
				<option value="ванна" <?php if($_POST['wc_type'] == "ванна") echo "selected"; ?> >ванна</option>
				<option value="душ" <?php if($_POST['wc_type'] == "душ") echo "selected"; ?> >душ</option>
				<option value="2 санузла" <?php if($_POST['wc_type'] == "2 санузла") echo "selected"; ?> >2 санузла</option>
				<option value="3 санузла" <?php if($_POST['wc_type'] == "3 санузла") echo "selected"; ?> >3 санузла</option>
				
			</select>
		
	</div>
</td>
<td>
<div  style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;" >
<label for="pricefrom">Цена от</label>
		<input id="pricefrom" name="pricefrom" type="text" value="<?php if ($_POST['pricefrom']) echo $_POST['pricefrom']; ?>" style="width: 100px; text-align: right;"/> 
<label for="priceto">до</label>
		<input id="priceto" name="priceto" type="text" value="<?php if ($_POST['priceto']) echo $_POST['priceto']; ?>" style="width: 100px; text-align: right;"/>
		<br />
		<label class="control-label" id="rent_type">за </label>
		
			<select  class="controls-select" name="rent_type" id="rent_type" >
				<option value="месяц"  <?php if($_POST['rent_type'] == 'месяц') echo "selected"; ?> >месяц</option>
				<option value="сутки"  <?php if($_POST['rent_type'] == 'сутки') echo "selected"; ?> >сутки</option>
				<option value="час"  <?php if($_POST['rent_type'] == 'час') echo "selected"; ?> >час</option>
				
			</select>
		
	
		
		<label for="price">Торг</label>
		<input id="torg" name="torg" type="checkbox" <?php if($_POST['torg'] == 'on') echo "checked"; ?> /> 
		
<div class="control-group">	
	<table>
	  <tr>
		<td>
		<label for="inet"><span><img id="icons" src="images/inet.png" title="Интернет"/></span></label>
		</td>
		<td>
		<label for="furn"><span><img id="icons" src="images/mebel.png" title="Мебель"/></span></label>
		</td>
		<td>
		<label for="tv"><span><img id="icons" src="images/icon-tv.png" title="Телевизор"/></span></label>
		</td>
		<td>
		<label for="washing"><span><img id="icons" src="images/iconlaundry.png" title="Стиральная машина"/></span></label>
		</td>
		<td>
		<label for="refrig"><span><img id="icons" class="refrigerator" src="images/refrigerator.png" title="Холодильник"/></span></label>
		</td>
		<td>
		<label for="conditioner"><span><img id="icons" src="images/freashing.png" title="Кондиционер"/></span></label>
		</td>
	  </tr>	
	  <tr>	
		<td>
		<input id="inet" name="inet" type="checkbox"  <?php if($_POST['tel'] == 1) echo "checked"; ?>  /> 
		</td>
		<td>
		<input id="furn" name="furn" type="checkbox"  <?php if($_POST['furn'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="tv" name="tv" type="checkbox"  <?php if($_POST['tv'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="washing" name="washing" type="checkbox"  <?php if($_POST['washing'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="refrig" name="refrig" type="checkbox"  <?php if($_POST['refrig'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="conditioner" name="conditioner" type="checkbox"  <?php if($_POST['conditioner'] == 1) echo "checked"; ?> /> 
		</td>
	  </tr>
	</table>
	</div>
	
	

	</div>
</td>
</tr>
</table>
<table id="advansed-search" style="display: none;">
	<tr>
		<td style="width: 565px;">
			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Площадь (от)
				</div>
				<label for="sq_allfrom">Общая</label>
				<input id="sq_allfrom" name="sq_allfrom" type="text" value="<?php if($_POST['sq_allfrom']) {echo $_POST['sq_allfrom']; } ?>"  /> / 
				<label  for="sq_livefrom">Жилая</label>
				<input id="sq_livefrom" name="sq_livefrom" type="text" value="<?php if($_POST['sq_livefrom']) {echo $_POST['sq_livefrom']; } ?>"  /> / 
				<label for="sq_kfrom">Кухня</label>
				<input id="sq_kfrom" name="sq_kfrom" type="text" value="<?php if($_POST['sq_kfrom']) {echo $_POST['sq_kfrom']; } ?>"  />
				<br />
				<div class="header-3">
					Площадь (до)
				</div>
				<label for="sq_allto">Общая</label>
				<input id="sq_allto" name="sq_allto" type="text" value="<?php if($_POST['sq_allto']) {echo $_POST['sq_allto']; } ?>"  /> / 
				<label  for="sq_liveto">Жилая</label>
				<input id="sq_liveto" name="sq_liveto" type="text" value="<?php if($_POST['sq_liveto']) {echo $_POST['sq_liveto']; } ?>"  /> / 
				<label for="sq_kto">Кухня</label>
				<input id="sq_kto" name="sq_kto" type="text" value="<?php if($_POST['sq_kto']) {echo $_POST['sq_kto']; } ?>"  />
			</div>

			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Этаж / Этажность (от)
				</div>
				
				<input id="floorfrom" name="floorfrom" type="text" value="<?php if($_POST['floorfrom']) echo $_POST['floorfrom']; ?>" /> / 
				
				<input id="floor_countfrom" name="floor_countfrom" type="text" value="<?php if($_POST['floor_countfrom']) echo $_POST['floor_countfrom']; ?>" />
				<br />
				<div class="header-3">
					Этаж / Этажность (до)
				</div>
				
				<input id="floorto" name="floorto" type="text" value="<?php if($_POST['floorto']) echo $_POST['floorto']; ?>" /> / 
				
				<input id="floor_countto" name="floor_countto" type="text" value="<?php if($_POST['floor_countto']) echo $_POST['floor_countto']; ?>" />
			</div>

		</td>
		<td style="width: 732px;">
			<div class="control-group">
				<label class="control-label" id="park">Парковка/гараж</label>
					<select class="controls-select" name="park" id="park" >
						<option value="Благоустроенная парковка у дома"  <?php if($_POST['park'] == 'частная') echo "selected"; ?> >Благоустроенная парковка у дома</option>
						<option value="Парковка со шлагбаумом" <?php if($_POST['park'] == 'Парковка со шлагбаумом') echo "selected"; ?> >Парковка со шлагбаумом</option>
						<option value="Подземный гараж" <?php if($_POST['park'] == 'Подземный гараж') echo "selected"; ?> >Подземный гараж</option>
						<option value="Подземная парковка" <?php if($_POST['park'] == 'Подземная парковка') echo "selected"; ?> >Подземная парковка</option>
					</select>
			</div>
	
			<div class="control-group">
				<label class="control-label" id="wall_type">Материал стен</label>
					<select class="controls-select" name="wall_type" id="wall_type" >
						<option value="кирпичный"  <?php if($_POST['wall_type'] == 'кирпичный') echo "selected"; ?> >кирпичный</option>
						<option value="панельный"  <?php if($_POST['wall_type'] == 'панельный') echo "selected"; ?> >панельный</option>
						<option value="деревянный"  <?php if($_POST['wall_type'] == 'деревянный') echo "selected"; ?> >деревянный</option>
						<option value="монолит"  <?php if($_POST['wall_type'] == 'монолит') echo "selected"; ?> >монолит</option>
					</select>
			</div>
			<div class="control-group">
				<label class="control-label" id="val_bal">Количество балконов</label>
				<input id="val_bal" name="val_bal" type="text" value="<?php if($_POST['val_bal']) {echo $_POST['val_bal']; } ?>" /> 
				
				<label class="control-label" id="val_lodg">Количество лоджий</label>
				<input id="val_lodg" name="val_lodg" type="text" value="<?php if($_POST['val_lodg']) {echo $_POST['val_lodg']; } ?>" /> 
		
			</div>
		</td>
	</tr>
</table>
	<li id="control_panel" style="
		text-align: left;
		list-style: none;">
		<span id="control" style="
		cursor:pointer;
		"><a onclick="showSelect('advansed-search')">Расширенный поиск</a></span>
		
		<input id="search-button" type="submit" name="submit" value="Поиск" style="float: right;" />
		</li>
	
	</form>
</div>
<!--Дачи --> 
<div>
	<form id="" method="POST" action="?task=main&action=search" >


	
	<div class="control-group checklabel topic_id">
			<div class="header-3">
				Я хочу
			</div>
			<input type="hidden" name="search_type" value="topic_id5" />
			<input class="invisible" id="vkl5sell" value="2"  type="radio" name="topic_id5"  /> 
			<label id="label" for="vkl4sell">Купить</label>
			<input class="invisible" id="vkl5rent" value="1" type="radio" name="topic_id5" checked="checked" /> 
			<label id="label" for="vkl5rent">Снять</label>
		
		</div>
	
	<?php

?>
<table>
<tr>
<td style="width: 300px;">
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text"  value="<?php if($_POST['live_point']) { echo $_POST['live_point']; } ?>" /> <br />
	</div>
	
	
	<div onclick="showSelect('dis-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
text-align: left;
	cursor: pointer;
	" >Район</div>
	<div id="dis-select" style="display: none;" class="div-select">
		<div class="left">
		<label for="dis1" >Дзержинский</label> <input id="dis1" type="checkbox" name="dis1" /><br />
		<label for="dis2" >Железнодорожный</label><input id="dis2" type="checkbox" name="dis2" /><br />
		<label for="dis3" >Заельцовский</label> <input id="dis3" type="checkbox" name="dis3" /><br />
		<label for="dis4" >Калининский</label> <input id="dis4" type="checkbox" name="dis4" /><br />
		<label for="dis5" >Кировский</label> <input id="dis5" type="checkbox" name="dis5" />
		</div>
		<div class="right">
		<label for="dis6" >Ленинский</label> <input id="dis6" type="checkbox" name="dis6" /><br />
		<label for="dis7" >Октябрьский</label> <input id="dis7" type="checkbox" name="dis7" /><br />
		<label for="dis8" >Первомайский</label> <input id="dis8" type="checkbox" name="dis8" /><br />
		<label for="dis9" >Советский</label> <input id="dis9" type="checkbox" name="dis9" /><br />
		<label for="dis10" >Центральный</label> <input id="dis10" type="checkbox" name="dis10" />
		</div>
	</div>
	
	
	<div onclick="showSelect('str-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
	text-align: left;
	cursor: pointer;
	" >Улица<span id="streets_number" style="float: right; margin-right: 5px;"></span></div>
	<div id="str-select" style="display: none"  class="div-select" >
	<input type="text" id="str" name="street" style="background: #F2D7E7;"  value="<?php if($_POST['street']) {echo $_POST['street']; } ?>" 
					
	autocomplete="off"/> введите улицу, или часть
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					
					</div>
					<ul id="street_adds">
					<?php if($_POST['street0']) { ?>
					
					<label id="label-0" class="str_search_res" onclick="removeStreet('0')" for="street-0" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-0" class="invisible" name="street0" type="text" value="<?php echo $_POST['street0']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street1']) { ?>
					
					<label id="label-1" class="str_search_res" onclick="removeStreet('1')" for="street-1" style="color: black;"><?php echo $_POST['street1']; ?></label>
					<input id="street-1" class="invisible" name="street0" type="text" value="<?php echo $_POST['street1']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street2']) { ?>
					
					<label id="label-2" class="str_search_res" onclick="removeStreet('2')" for="street-2" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-2" class="invisible" name="street2" type="text" value="<?php echo $_POST['street2']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street3']) { ?>
					
					<label id="label-3" class="str_search_res" onclick="removeStreet('3')" for="street-3" style="color: black;"><?php echo $_POST['street3']; ?></label>
					<input id="street-3" class="invisible" name="street0" type="text" value="<?php echo $_POST['street3']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street4']) { ?>
					
					<label id="label-4" class="str_search_res" onclick="removeStreet('4')" for="street-4" style="color: black;"><?php echo $_POST['street4']; ?></label>
					<input id="street-4" class="invisible" name="street4" type="text" value="<?php echo $_POST['street4']; ?>" style="color: black;">
					
					<?php }
					?>
					</ul>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="house">№</label>
	<input id="house" name="house" type="text" value="<?php if($_POST['house']) {echo $_POST['house']; } ?>"/>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($_POST['orientir']) {echo $_POST['orientir']; } ?>"/>
	</div>
</td>
<td style="width: 420px;">
	
	<div class="control-group checklabel switch_buy_rent" style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;">
		<div class="header-3">
			Количество комнат
		</div> <br />
		
		
		<input class="invisible"  id="k" value="8"  type="checkbox" name="type_id1"  <?php if($_POST['type_id1'] == 8) echo "checked"; ?> /> 
		<label id="label" for="k">Комната</label>
		
		<input class="invisible"  id="k-1" value="9"  type="checkbox" name="type_id2"  <?php if($_POST['type_id2'] == 9) echo "checked"; ?> /> 
		<label id="label" for="k-1">1-к</label>
		
		<input class="invisible"  id="k-2" value="10" type="checkbox" name="type_id3"  <?php if($_POST['type_id3'] == 10) echo "checked"; ?> /> 
		<label id="label" for="k-2">2-к</label>
		
		<input class="invisible"  id="k-3" value="11" type="checkbox" name="type_id4"  <?php if($_POST['type_id4'] == 11) echo "checked"; ?> /> 
		<label id="label" for="k-3">3-к</label>
		
		<input class="invisible"  id="k-4" value="15" type="checkbox" name="type_id5"  <?php if($_POST['type_id5'] == 15) echo "checked"; ?> /> 
		<label id="label" for="k-4">4-к</label>
		
		<input class="invisible"  id="k-5" value="16" type="checkbox" name="type_id6"  <?php if($_POST['type_id6'] == 16) echo "checked"; ?> /> 
		<label id="label" for="k-5">5-к</label>
		
		<input class="invisible"  id="k-6" value="17" type="checkbox" name="type_id7"  <?php if($_POST['type_id7'] == 17) echo "checked"; ?> /> 
		<label id="label" for="k-6">6-к +</label>
	</div>

	<div class="control-group">
		<label class="control-label" id="planning">Планировка</label>
		
			<select  class="controls-select" name="planning" id="planning" >
				<option value="" >не важно</option>
				<option value="изолированная" <?php if($_POST['planning'] == "изолированная") echo "selected"; ?>  >изолированная</option>
				<option value="смежная" <?php if($_POST['planning'] == "смежная") echo "selected"; ?> >смежная</option>
				<option value="см-изолированная" <?php if($_POST['planning'] == "см-изолированная") echo "selected"; ?> >см-изолированная</option>
				<option value="свободная" <?php if($_POST['planning'] == "свободная") echo "selected"; ?> >свободная</option>
				<option value="студия" <?php if($_POST['planning'] == "студия") echo "selected"; ?> >студия</option>
				<option value="иное" <?php if($_POST['planning'] == "иное") echo "selected"; ?> >иное</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="ap_layout">Тип квартиры</label>
		
			<select  class="controls-select" name="ap_layout" id="ap_layout" >
				<option value="">не важно</option>
				<option value="общежитие" <?php if($_POST['ap_layout'] == "общежитие") echo "selected"; ?>  >общежитие</option>
				<option value="малосемейка" <?php if($_POST['ap_layout'] == "малосемейка") echo "selected"; ?> >малосемейка</option>
				<option value="улучшеная планировка" <?php if($_POST['ap_layout'] == "улучшеная планировка") echo "selected"; ?> >улучшеная планировка</option>
				<option value="типовая" <?php if($_POST['ap_layout'] == "типовая") echo "selected"; ?> >типовая</option>
				<option value="хрещевка" <?php if($_POST['ap_layout'] == "хрещевка") echo "selected"; ?> >хрущевка</option>
				<option value="полногабаритная" <?php if($_POST['ap_layout'] == "полногабаритная") echo "selected"; ?> >полногабаритная</option>
				<option value="малоэтажка" <?php if($_POST['ap_layout'] == "малоэтажка") echo "selected"; ?> >малоэтажка</option>
				<option value="пентхаус" <?php if($_POST['ap_layout'] == "пентхаус") echo "selected"; ?> >пентхаус</option>
				<option value="двухуровневая" <?php if($_POST['ap_layout'] == "двухуровневая") echo "selected"; ?> >двухуровневая</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="wc_type">Санузел</label>
		
			<select  class="controls-select" name="wc_type" id="wc_type" >
				<option value="" >не важно</option>
				<option value="раздельный" <?php if($_POST['wc_type'] == "раздельный") echo "selected"; ?>  >раздельный</option>
				<option value="совмещенный" <?php if($_POST['wc_type'] == "совмещенный") echo "selected"; ?> >совмещенный</option>
				<option value="без удобств" <?php if($_POST['wc_type'] == "без удобств") echo "selected"; ?> >без удобств</option>
				<option value="ванна" <?php if($_POST['wc_type'] == "ванна") echo "selected"; ?> >ванна</option>
				<option value="душ" <?php if($_POST['wc_type'] == "душ") echo "selected"; ?> >душ</option>
				<option value="2 санузла" <?php if($_POST['wc_type'] == "2 санузла") echo "selected"; ?> >2 санузла</option>
				<option value="3 санузла" <?php if($_POST['wc_type'] == "3 санузла") echo "selected"; ?> >3 санузла</option>
				
			</select>
		
	</div>
</td>
<td>
<div  style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;" >
<label for="pricefrom">Цена от</label>
		<input id="pricefrom" name="pricefrom" type="text" value="<?php if ($_POST['pricefrom']) echo $_POST['pricefrom']; ?>" style="width: 100px; text-align: right;"/> 
<label for="priceto">до</label>
		<input id="priceto" name="priceto" type="text" value="<?php if ($_POST['priceto']) echo $_POST['priceto']; ?>" style="width: 100px; text-align: right;"/>
		<br />
		<label class="control-label" id="rent_type">за </label>
		
			<select  class="controls-select" name="rent_type" id="rent_type" >
				<option value="месяц"  <?php if($_POST['rent_type'] == 'месяц') echo "selected"; ?> >месяц</option>
				<option value="сутки"  <?php if($_POST['rent_type'] == 'сутки') echo "selected"; ?> >сутки</option>
				<option value="час"  <?php if($_POST['rent_type'] == 'час') echo "selected"; ?> >час</option>
				
			</select>
		
	
		
		<label for="price">Торг</label>
		<input id="torg" name="torg" type="checkbox" <?php if($_POST['torg'] == 'on') echo "checked"; ?> /> 
		
<div class="control-group">	
	<table>
	  <tr>
		<td>
		<label for="inet"><span><img id="icons" src="images/inet.png" title="Интернет"/></span></label>
		</td>
		<td>
		<label for="furn"><span><img id="icons" src="images/mebel.png" title="Мебель"/></span></label>
		</td>
		<td>
		<label for="tv"><span><img id="icons" src="images/icon-tv.png" title="Телевизор"/></span></label>
		</td>
		<td>
		<label for="washing"><span><img id="icons" src="images/iconlaundry.png" title="Стиральная машина"/></span></label>
		</td>
		<td>
		<label for="refrig"><span><img id="icons" class="refrigerator" src="images/refrigerator.png" title="Холодильник"/></span></label>
		</td>
		<td>
		<label for="conditioner"><span><img id="icons" src="images/freashing.png" title="Кондиционер"/></span></label>
		</td>
	  </tr>	
	  <tr>	
		<td>
		<input id="inet" name="inet" type="checkbox"  <?php if($_POST['tel'] == 1) echo "checked"; ?>  /> 
		</td>
		<td>
		<input id="furn" name="furn" type="checkbox"  <?php if($_POST['furn'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="tv" name="tv" type="checkbox"  <?php if($_POST['tv'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="washing" name="washing" type="checkbox"  <?php if($_POST['washing'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="refrig" name="refrig" type="checkbox"  <?php if($_POST['refrig'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="conditioner" name="conditioner" type="checkbox"  <?php if($_POST['conditioner'] == 1) echo "checked"; ?> /> 
		</td>
	  </tr>
	</table>
	</div>
	
	

	</div>
</td>
</tr>
</table>
<table id="advansed-search" style="display: none;">
	<tr>
		<td style="width: 565px;">
			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Площадь (от)
				</div>
				<label for="sq_allfrom">Общая</label>
				<input id="sq_allfrom" name="sq_allfrom" type="text" value="<?php if($_POST['sq_allfrom']) {echo $_POST['sq_allfrom']; } ?>"  /> / 
				<label  for="sq_livefrom">Жилая</label>
				<input id="sq_livefrom" name="sq_livefrom" type="text" value="<?php if($_POST['sq_livefrom']) {echo $_POST['sq_livefrom']; } ?>"  /> / 
				<label for="sq_kfrom">Кухня</label>
				<input id="sq_kfrom" name="sq_kfrom" type="text" value="<?php if($_POST['sq_kfrom']) {echo $_POST['sq_kfrom']; } ?>"  />
				<br />
				<div class="header-3">
					Площадь (до)
				</div>
				<label for="sq_allto">Общая</label>
				<input id="sq_allto" name="sq_allto" type="text" value="<?php if($_POST['sq_allto']) {echo $_POST['sq_allto']; } ?>"  /> / 
				<label  for="sq_liveto">Жилая</label>
				<input id="sq_liveto" name="sq_liveto" type="text" value="<?php if($_POST['sq_liveto']) {echo $_POST['sq_liveto']; } ?>"  /> / 
				<label for="sq_kto">Кухня</label>
				<input id="sq_kto" name="sq_kto" type="text" value="<?php if($_POST['sq_kto']) {echo $_POST['sq_kto']; } ?>"  />
			</div>

			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Этаж / Этажность (от)
				</div>
				
				<input id="floorfrom" name="floorfrom" type="text" value="<?php if($_POST['floorfrom']) echo $_POST['floorfrom']; ?>" /> / 
				
				<input id="floor_countfrom" name="floor_countfrom" type="text" value="<?php if($_POST['floor_countfrom']) echo $_POST['floor_countfrom']; ?>" />
				<br />
				<div class="header-3">
					Этаж / Этажность (до)
				</div>
				
				<input id="floorto" name="floorto" type="text" value="<?php if($_POST['floorto']) echo $_POST['floorto']; ?>" /> / 
				
				<input id="floor_countto" name="floor_countto" type="text" value="<?php if($_POST['floor_countto']) echo $_POST['floor_countto']; ?>" />
			</div>

		</td>
		<td style="width: 732px;">
			<div class="control-group">
				<label class="control-label" id="park">Парковка/гараж</label>
					<select class="controls-select" name="park" id="park" >
						<option value="Благоустроенная парковка у дома"  <?php if($_POST['park'] == 'частная') echo "selected"; ?> >Благоустроенная парковка у дома</option>
						<option value="Парковка со шлагбаумом" <?php if($_POST['park'] == 'Парковка со шлагбаумом') echo "selected"; ?> >Парковка со шлагбаумом</option>
						<option value="Подземный гараж" <?php if($_POST['park'] == 'Подземный гараж') echo "selected"; ?> >Подземный гараж</option>
						<option value="Подземная парковка" <?php if($_POST['park'] == 'Подземная парковка') echo "selected"; ?> >Подземная парковка</option>
					</select>
			</div>
	
			<div class="control-group">
				<label class="control-label" id="wall_type">Материал стен</label>
					<select class="controls-select" name="wall_type" id="wall_type" >
						<option value="кирпичный"  <?php if($_POST['wall_type'] == 'кирпичный') echo "selected"; ?> >кирпичный</option>
						<option value="панельный"  <?php if($_POST['wall_type'] == 'панельный') echo "selected"; ?> >панельный</option>
						<option value="деревянный"  <?php if($_POST['wall_type'] == 'деревянный') echo "selected"; ?> >деревянный</option>
						<option value="монолит"  <?php if($_POST['wall_type'] == 'монолит') echo "selected"; ?> >монолит</option>
					</select>
			</div>
			<div class="control-group">
				<label class="control-label" id="val_bal">Количество балконов</label>
				<input id="val_bal" name="val_bal" type="text" value="<?php if($_POST['val_bal']) {echo $_POST['val_bal']; } ?>" /> 
				
				<label class="control-label" id="val_lodg">Количество лоджий</label>
				<input id="val_lodg" name="val_lodg" type="text" value="<?php if($_POST['val_lodg']) {echo $_POST['val_lodg']; } ?>" /> 
		
			</div>
		</td>
	</tr>
</table>
	<li id="control_panel" style="
		text-align: left;
		list-style: none;">
		<span id="control" style="
		cursor:pointer;
		"><a onclick="showSelect('advansed-search')">Расширенный поиск</a></span>
		
		<input id="search-button" type="submit" name="submit" value="Поиск" style="float: right;" />
		</li>
	
	</form>
</div>
<!--Земля --> 
<div>
	<form id="" method="POST" action="?task=main&action=search" >


	
	<div class="control-group checklabel topic_id">
			<div class="header-3">
				Я хочу
			</div>
			<input type="hidden" name="search_type" value="topic_id6" />
			<input class="invisible" id="vkl6sell" value="2"  type="radio" name="topic_id6"  /> 
			<label id="label" for="vkl6sell">Купить</label>
			<input class="invisible" id="vkl6rent" value="1" type="radio" name="topic_id6" checked="checked" /> 
			<label id="label" for="vkl6rent">Снять</label>
		
		</div>
	
	<?php

?>
<table>
<tr>
<td style="width: 300px;">
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text"  value="<?php if($_POST['live_point']) { echo $_POST['live_point']; } ?>" /> <br />
	</div>
	
	
	<div onclick="showSelect('dis-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
text-align: left;
	cursor: pointer;
	" >Район</div>
	<div id="dis-select" style="display: none;" class="div-select">
		<div class="left">
		<label for="dis1" >Дзержинский</label> <input id="dis1" type="checkbox" name="dis1" /><br />
		<label for="dis2" >Железнодорожный</label><input id="dis2" type="checkbox" name="dis2" /><br />
		<label for="dis3" >Заельцовский</label> <input id="dis3" type="checkbox" name="dis3" /><br />
		<label for="dis4" >Калининский</label> <input id="dis4" type="checkbox" name="dis4" /><br />
		<label for="dis5" >Кировский</label> <input id="dis5" type="checkbox" name="dis5" />
		</div>
		<div class="right">
		<label for="dis6" >Ленинский</label> <input id="dis6" type="checkbox" name="dis6" /><br />
		<label for="dis7" >Октябрьский</label> <input id="dis7" type="checkbox" name="dis7" /><br />
		<label for="dis8" >Первомайский</label> <input id="dis8" type="checkbox" name="dis8" /><br />
		<label for="dis9" >Советский</label> <input id="dis9" type="checkbox" name="dis9" /><br />
		<label for="dis10" >Центральный</label> <input id="dis10" type="checkbox" name="dis10" />
		</div>
	</div>
	
	
	<div onclick="showSelect('str-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
	text-align: left;
	cursor: pointer;
	" >Улица<span id="streets_number" style="float: right; margin-right: 5px;"></span></div>
	<div id="str-select" style="display: none"  class="div-select" >
	<input type="text" id="str" name="street" style="background: #F2D7E7;"  value="<?php if($_POST['street']) {echo $_POST['street']; } ?>" 
					
	autocomplete="off"/> введите улицу, или часть
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					
					</div>
					<ul id="street_adds">
					<?php if($_POST['street0']) { ?>
					
					<label id="label-0" class="str_search_res" onclick="removeStreet('0')" for="street-0" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-0" class="invisible" name="street0" type="text" value="<?php echo $_POST['street0']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street1']) { ?>
					
					<label id="label-1" class="str_search_res" onclick="removeStreet('1')" for="street-1" style="color: black;"><?php echo $_POST['street1']; ?></label>
					<input id="street-1" class="invisible" name="street0" type="text" value="<?php echo $_POST['street1']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street2']) { ?>
					
					<label id="label-2" class="str_search_res" onclick="removeStreet('2')" for="street-2" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-2" class="invisible" name="street2" type="text" value="<?php echo $_POST['street2']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street3']) { ?>
					
					<label id="label-3" class="str_search_res" onclick="removeStreet('3')" for="street-3" style="color: black;"><?php echo $_POST['street3']; ?></label>
					<input id="street-3" class="invisible" name="street0" type="text" value="<?php echo $_POST['street3']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street4']) { ?>
					
					<label id="label-4" class="str_search_res" onclick="removeStreet('4')" for="street-4" style="color: black;"><?php echo $_POST['street4']; ?></label>
					<input id="street-4" class="invisible" name="street4" type="text" value="<?php echo $_POST['street4']; ?>" style="color: black;">
					
					<?php }
					?>
					</ul>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="house">№</label>
	<input id="house" name="house" type="text" value="<?php if($_POST['house']) {echo $_POST['house']; } ?>"/>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($_POST['orientir']) {echo $_POST['orientir']; } ?>"/>
	</div>
</td>
<td style="width: 420px;">
	
	<div class="control-group checklabel switch_buy_rent" style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;">
		<div class="header-3">
			Количество комнат
		</div> <br />
		
		
		<input class="invisible"  id="k" value="8"  type="checkbox" name="type_id1"  <?php if($_POST['type_id1'] == 8) echo "checked"; ?> /> 
		<label id="label" for="k">Комната</label>
		
		<input class="invisible"  id="k-1" value="9"  type="checkbox" name="type_id2"  <?php if($_POST['type_id2'] == 9) echo "checked"; ?> /> 
		<label id="label" for="k-1">1-к</label>
		
		<input class="invisible"  id="k-2" value="10" type="checkbox" name="type_id3"  <?php if($_POST['type_id3'] == 10) echo "checked"; ?> /> 
		<label id="label" for="k-2">2-к</label>
		
		<input class="invisible"  id="k-3" value="11" type="checkbox" name="type_id4"  <?php if($_POST['type_id4'] == 11) echo "checked"; ?> /> 
		<label id="label" for="k-3">3-к</label>
		
		<input class="invisible"  id="k-4" value="15" type="checkbox" name="type_id5"  <?php if($_POST['type_id5'] == 15) echo "checked"; ?> /> 
		<label id="label" for="k-4">4-к</label>
		
		<input class="invisible"  id="k-5" value="16" type="checkbox" name="type_id6"  <?php if($_POST['type_id6'] == 16) echo "checked"; ?> /> 
		<label id="label" for="k-5">5-к</label>
		
		<input class="invisible"  id="k-6" value="17" type="checkbox" name="type_id7"  <?php if($_POST['type_id7'] == 17) echo "checked"; ?> /> 
		<label id="label" for="k-6">6-к +</label>
	</div>

	<div class="control-group">
		<label class="control-label" id="planning">Планировка</label>
		
			<select  class="controls-select" name="planning" id="planning" >
				<option value="" >не важно</option>
				<option value="изолированная" <?php if($_POST['planning'] == "изолированная") echo "selected"; ?>  >изолированная</option>
				<option value="смежная" <?php if($_POST['planning'] == "смежная") echo "selected"; ?> >смежная</option>
				<option value="см-изолированная" <?php if($_POST['planning'] == "см-изолированная") echo "selected"; ?> >см-изолированная</option>
				<option value="свободная" <?php if($_POST['planning'] == "свободная") echo "selected"; ?> >свободная</option>
				<option value="студия" <?php if($_POST['planning'] == "студия") echo "selected"; ?> >студия</option>
				<option value="иное" <?php if($_POST['planning'] == "иное") echo "selected"; ?> >иное</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="ap_layout">Тип квартиры</label>
		
			<select  class="controls-select" name="ap_layout" id="ap_layout" >
				<option value="">не важно</option>
				<option value="общежитие" <?php if($_POST['ap_layout'] == "общежитие") echo "selected"; ?>  >общежитие</option>
				<option value="малосемейка" <?php if($_POST['ap_layout'] == "малосемейка") echo "selected"; ?> >малосемейка</option>
				<option value="улучшеная планировка" <?php if($_POST['ap_layout'] == "улучшеная планировка") echo "selected"; ?> >улучшеная планировка</option>
				<option value="типовая" <?php if($_POST['ap_layout'] == "типовая") echo "selected"; ?> >типовая</option>
				<option value="хрещевка" <?php if($_POST['ap_layout'] == "хрещевка") echo "selected"; ?> >хрущевка</option>
				<option value="полногабаритная" <?php if($_POST['ap_layout'] == "полногабаритная") echo "selected"; ?> >полногабаритная</option>
				<option value="малоэтажка" <?php if($_POST['ap_layout'] == "малоэтажка") echo "selected"; ?> >малоэтажка</option>
				<option value="пентхаус" <?php if($_POST['ap_layout'] == "пентхаус") echo "selected"; ?> >пентхаус</option>
				<option value="двухуровневая" <?php if($_POST['ap_layout'] == "двухуровневая") echo "selected"; ?> >двухуровневая</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="wc_type">Санузел</label>
		
			<select  class="controls-select" name="wc_type" id="wc_type" >
				<option value="" >не важно</option>
				<option value="раздельный" <?php if($_POST['wc_type'] == "раздельный") echo "selected"; ?>  >раздельный</option>
				<option value="совмещенный" <?php if($_POST['wc_type'] == "совмещенный") echo "selected"; ?> >совмещенный</option>
				<option value="без удобств" <?php if($_POST['wc_type'] == "без удобств") echo "selected"; ?> >без удобств</option>
				<option value="ванна" <?php if($_POST['wc_type'] == "ванна") echo "selected"; ?> >ванна</option>
				<option value="душ" <?php if($_POST['wc_type'] == "душ") echo "selected"; ?> >душ</option>
				<option value="2 санузла" <?php if($_POST['wc_type'] == "2 санузла") echo "selected"; ?> >2 санузла</option>
				<option value="3 санузла" <?php if($_POST['wc_type'] == "3 санузла") echo "selected"; ?> >3 санузла</option>
				
			</select>
		
	</div>
</td>
<td>
<div  style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;" >
<label for="pricefrom">Цена от</label>
		<input id="pricefrom" name="pricefrom" type="text" value="<?php if ($_POST['pricefrom']) echo $_POST['pricefrom']; ?>" style="width: 100px; text-align: right;"/> 
<label for="priceto">до</label>
		<input id="priceto" name="priceto" type="text" value="<?php if ($_POST['priceto']) echo $_POST['priceto']; ?>" style="width: 100px; text-align: right;"/>
		<br />
		<label class="control-label" id="rent_type">за </label>
		
			<select  class="controls-select" name="rent_type" id="rent_type" >
				<option value="месяц"  <?php if($_POST['rent_type'] == 'месяц') echo "selected"; ?> >месяц</option>
				<option value="сутки"  <?php if($_POST['rent_type'] == 'сутки') echo "selected"; ?> >сутки</option>
				<option value="час"  <?php if($_POST['rent_type'] == 'час') echo "selected"; ?> >час</option>
				
			</select>
		
	
		
		<label for="price">Торг</label>
		<input id="torg" name="torg" type="checkbox" <?php if($_POST['torg'] == 'on') echo "checked"; ?> /> 
		
<div class="control-group">	
	<table>
	  <tr>
		<td>
		<label for="inet"><span><img id="icons" src="images/inet.png" title="Интернет"/></span></label>
		</td>
		<td>
		<label for="furn"><span><img id="icons" src="images/mebel.png" title="Мебель"/></span></label>
		</td>
		<td>
		<label for="tv"><span><img id="icons" src="images/icon-tv.png" title="Телевизор"/></span></label>
		</td>
		<td>
		<label for="washing"><span><img id="icons" src="images/iconlaundry.png" title="Стиральная машина"/></span></label>
		</td>
		<td>
		<label for="refrig"><span><img id="icons" class="refrigerator" src="images/refrigerator.png" title="Холодильник"/></span></label>
		</td>
		<td>
		<label for="conditioner"><span><img id="icons" src="images/freashing.png" title="Кондиционер"/></span></label>
		</td>
	  </tr>	
	  <tr>	
		<td>
		<input id="inet" name="inet" type="checkbox"  <?php if($_POST['tel'] == 1) echo "checked"; ?>  /> 
		</td>
		<td>
		<input id="furn" name="furn" type="checkbox"  <?php if($_POST['furn'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="tv" name="tv" type="checkbox"  <?php if($_POST['tv'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="washing" name="washing" type="checkbox"  <?php if($_POST['washing'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="refrig" name="refrig" type="checkbox"  <?php if($_POST['refrig'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="conditioner" name="conditioner" type="checkbox"  <?php if($_POST['conditioner'] == 1) echo "checked"; ?> /> 
		</td>
	  </tr>
	</table>
	</div>
	
	

	</div>
</td>
</tr>
</table>
<table id="advansed-search" style="display: none;">
	<tr>
		<td style="width: 565px;">
			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Площадь (от)
				</div>
				<label for="sq_allfrom">Общая</label>
				<input id="sq_allfrom" name="sq_allfrom" type="text" value="<?php if($_POST['sq_allfrom']) {echo $_POST['sq_allfrom']; } ?>"  /> / 
				<label  for="sq_livefrom">Жилая</label>
				<input id="sq_livefrom" name="sq_livefrom" type="text" value="<?php if($_POST['sq_livefrom']) {echo $_POST['sq_livefrom']; } ?>"  /> / 
				<label for="sq_kfrom">Кухня</label>
				<input id="sq_kfrom" name="sq_kfrom" type="text" value="<?php if($_POST['sq_kfrom']) {echo $_POST['sq_kfrom']; } ?>"  />
				<br />
				<div class="header-3">
					Площадь (до)
				</div>
				<label for="sq_allto">Общая</label>
				<input id="sq_allto" name="sq_allto" type="text" value="<?php if($_POST['sq_allto']) {echo $_POST['sq_allto']; } ?>"  /> / 
				<label  for="sq_liveto">Жилая</label>
				<input id="sq_liveto" name="sq_liveto" type="text" value="<?php if($_POST['sq_liveto']) {echo $_POST['sq_liveto']; } ?>"  /> / 
				<label for="sq_kto">Кухня</label>
				<input id="sq_kto" name="sq_kto" type="text" value="<?php if($_POST['sq_kto']) {echo $_POST['sq_kto']; } ?>"  />
			</div>

			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Этаж / Этажность (от)
				</div>
				
				<input id="floorfrom" name="floorfrom" type="text" value="<?php if($_POST['floorfrom']) echo $_POST['floorfrom']; ?>" /> / 
				
				<input id="floor_countfrom" name="floor_countfrom" type="text" value="<?php if($_POST['floor_countfrom']) echo $_POST['floor_countfrom']; ?>" />
				<br />
				<div class="header-3">
					Этаж / Этажность (до)
				</div>
				
				<input id="floorto" name="floorto" type="text" value="<?php if($_POST['floorto']) echo $_POST['floorto']; ?>" /> / 
				
				<input id="floor_countto" name="floor_countto" type="text" value="<?php if($_POST['floor_countto']) echo $_POST['floor_countto']; ?>" />
			</div>

		</td>
		<td style="width: 732px;">
			<div class="control-group">
				<label class="control-label" id="park">Парковка/гараж</label>
					<select class="controls-select" name="park" id="park" >
						<option value="Благоустроенная парковка у дома"  <?php if($_POST['park'] == 'частная') echo "selected"; ?> >Благоустроенная парковка у дома</option>
						<option value="Парковка со шлагбаумом" <?php if($_POST['park'] == 'Парковка со шлагбаумом') echo "selected"; ?> >Парковка со шлагбаумом</option>
						<option value="Подземный гараж" <?php if($_POST['park'] == 'Подземный гараж') echo "selected"; ?> >Подземный гараж</option>
						<option value="Подземная парковка" <?php if($_POST['park'] == 'Подземная парковка') echo "selected"; ?> >Подземная парковка</option>
					</select>
			</div>
	
			<div class="control-group">
				<label class="control-label" id="wall_type">Материал стен</label>
					<select class="controls-select" name="wall_type" id="wall_type" >
						<option value="кирпичный"  <?php if($_POST['wall_type'] == 'кирпичный') echo "selected"; ?> >кирпичный</option>
						<option value="панельный"  <?php if($_POST['wall_type'] == 'панельный') echo "selected"; ?> >панельный</option>
						<option value="деревянный"  <?php if($_POST['wall_type'] == 'деревянный') echo "selected"; ?> >деревянный</option>
						<option value="монолит"  <?php if($_POST['wall_type'] == 'монолит') echo "selected"; ?> >монолит</option>
					</select>
			</div>
			<div class="control-group">
				<label class="control-label" id="val_bal">Количество балконов</label>
				<input id="val_bal" name="val_bal" type="text" value="<?php if($_POST['val_bal']) {echo $_POST['val_bal']; } ?>" /> 
				
				<label class="control-label" id="val_lodg">Количество лоджий</label>
				<input id="val_lodg" name="val_lodg" type="text" value="<?php if($_POST['val_lodg']) {echo $_POST['val_lodg']; } ?>" /> 
		
			</div>
		</td>
	</tr>
</table>
	<li id="control_panel" style="
		text-align: left;
		list-style: none;">
		<span id="control" style="
		cursor:pointer;
		"><a onclick="showSelect('advansed-search')">Расширенный поиск</a></span>
		
		<input id="search-button" type="submit" name="submit" value="Поиск" style="float: right;" />
		</li>
	
	</form>
</div>
<!--Гаражи/парковки --> 
<div>
	<form id="" method="POST" action="?task=main&action=search" >


	
	<div class="control-group checklabel topic_id">
			<div class="header-3">
				Я хочу
			</div>
			<input type="hidden" name="search_type" value="topic_id7" />
			<input class="invisible" id="vkl7sell" value="2"  type="radio" name="topic_id7"  /> 
			<label id="label" for="vkl4sell">Купить</label>
			<input class="invisible" id="vkl7rent" value="1" type="radio" name="topic_id7" checked="checked" /> 
			<label id="label" for="vkl7rent">Снять</label>
		
		</div>
	
	<?php

?>
<table>
<tr>
<td style="width: 300px;">
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text"  value="<?php if($_POST['live_point']) { echo $_POST['live_point']; } ?>" /> <br />
	</div>
	
	
	<div onclick="showSelect('dis-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
text-align: left;
	cursor: pointer;
	" >Район</div>
	<div id="dis-select" style="display: none;" class="div-select">
		<div class="left">
		<label for="dis1" >Дзержинский</label> <input id="dis1" type="checkbox" name="dis1" /><br />
		<label for="dis2" >Железнодорожный</label><input id="dis2" type="checkbox" name="dis2" /><br />
		<label for="dis3" >Заельцовский</label> <input id="dis3" type="checkbox" name="dis3" /><br />
		<label for="dis4" >Калининский</label> <input id="dis4" type="checkbox" name="dis4" /><br />
		<label for="dis5" >Кировский</label> <input id="dis5" type="checkbox" name="dis5" />
		</div>
		<div class="right">
		<label for="dis6" >Ленинский</label> <input id="dis6" type="checkbox" name="dis6" /><br />
		<label for="dis7" >Октябрьский</label> <input id="dis7" type="checkbox" name="dis7" /><br />
		<label for="dis8" >Первомайский</label> <input id="dis8" type="checkbox" name="dis8" /><br />
		<label for="dis9" >Советский</label> <input id="dis9" type="checkbox" name="dis9" /><br />
		<label for="dis10" >Центральный</label> <input id="dis10" type="checkbox" name="dis10" />
		</div>
	</div>
	
	
	<div onclick="showSelect('str-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
	text-align: left;
	cursor: pointer;
	" >Улица<span id="streets_number" style="float: right; margin-right: 5px;"></span></div>
	<div id="str-select" style="display: none"  class="div-select" >
	<input type="text" id="str" name="street" style="background: #F2D7E7;"  value="<?php if($_POST['street']) {echo $_POST['street']; } ?>" 
					
	autocomplete="off"/> введите улицу, или часть
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					
					</div>
					<ul id="street_adds">
					<?php if($_POST['street0']) { ?>
					
					<label id="label-0" class="str_search_res" onclick="removeStreet('0')" for="street-0" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-0" class="invisible" name="street0" type="text" value="<?php echo $_POST['street0']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street1']) { ?>
					
					<label id="label-1" class="str_search_res" onclick="removeStreet('1')" for="street-1" style="color: black;"><?php echo $_POST['street1']; ?></label>
					<input id="street-1" class="invisible" name="street0" type="text" value="<?php echo $_POST['street1']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street2']) { ?>
					
					<label id="label-2" class="str_search_res" onclick="removeStreet('2')" for="street-2" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-2" class="invisible" name="street2" type="text" value="<?php echo $_POST['street2']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street3']) { ?>
					
					<label id="label-3" class="str_search_res" onclick="removeStreet('3')" for="street-3" style="color: black;"><?php echo $_POST['street3']; ?></label>
					<input id="street-3" class="invisible" name="street0" type="text" value="<?php echo $_POST['street3']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street4']) { ?>
					
					<label id="label-4" class="str_search_res" onclick="removeStreet('4')" for="street-4" style="color: black;"><?php echo $_POST['street4']; ?></label>
					<input id="street-4" class="invisible" name="street4" type="text" value="<?php echo $_POST['street4']; ?>" style="color: black;">
					
					<?php }
					?>
					</ul>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="house">№</label>
	<input id="house" name="house" type="text" value="<?php if($_POST['house']) {echo $_POST['house']; } ?>"/>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($_POST['orientir']) {echo $_POST['orientir']; } ?>"/>
	</div>
</td>
<td style="width: 420px;">
	
	<div class="control-group checklabel switch_buy_rent" style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;">
		<div class="header-3">
			Количество комнат
		</div> <br />
		
		
		<input class="invisible"  id="k" value="8"  type="checkbox" name="type_id1"  <?php if($_POST['type_id1'] == 8) echo "checked"; ?> /> 
		<label id="label" for="k">Комната</label>
		
		<input class="invisible"  id="k-1" value="9"  type="checkbox" name="type_id2"  <?php if($_POST['type_id2'] == 9) echo "checked"; ?> /> 
		<label id="label" for="k-1">1-к</label>
		
		<input class="invisible"  id="k-2" value="10" type="checkbox" name="type_id3"  <?php if($_POST['type_id3'] == 10) echo "checked"; ?> /> 
		<label id="label" for="k-2">2-к</label>
		
		<input class="invisible"  id="k-3" value="11" type="checkbox" name="type_id4"  <?php if($_POST['type_id4'] == 11) echo "checked"; ?> /> 
		<label id="label" for="k-3">3-к</label>
		
		<input class="invisible"  id="k-4" value="15" type="checkbox" name="type_id5"  <?php if($_POST['type_id5'] == 15) echo "checked"; ?> /> 
		<label id="label" for="k-4">4-к</label>
		
		<input class="invisible"  id="k-5" value="16" type="checkbox" name="type_id6"  <?php if($_POST['type_id6'] == 16) echo "checked"; ?> /> 
		<label id="label" for="k-5">5-к</label>
		
		<input class="invisible"  id="k-6" value="17" type="checkbox" name="type_id7"  <?php if($_POST['type_id7'] == 17) echo "checked"; ?> /> 
		<label id="label" for="k-6">6-к +</label>
	</div>

	<div class="control-group">
		<label class="control-label" id="planning">Планировка</label>
		
			<select  class="controls-select" name="planning" id="planning" >
				<option value="" >не важно</option>
				<option value="изолированная" <?php if($_POST['planning'] == "изолированная") echo "selected"; ?>  >изолированная</option>
				<option value="смежная" <?php if($_POST['planning'] == "смежная") echo "selected"; ?> >смежная</option>
				<option value="см-изолированная" <?php if($_POST['planning'] == "см-изолированная") echo "selected"; ?> >см-изолированная</option>
				<option value="свободная" <?php if($_POST['planning'] == "свободная") echo "selected"; ?> >свободная</option>
				<option value="студия" <?php if($_POST['planning'] == "студия") echo "selected"; ?> >студия</option>
				<option value="иное" <?php if($_POST['planning'] == "иное") echo "selected"; ?> >иное</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="ap_layout">Тип квартиры</label>
		
			<select  class="controls-select" name="ap_layout" id="ap_layout" >
				<option value="">не важно</option>
				<option value="общежитие" <?php if($_POST['ap_layout'] == "общежитие") echo "selected"; ?>  >общежитие</option>
				<option value="малосемейка" <?php if($_POST['ap_layout'] == "малосемейка") echo "selected"; ?> >малосемейка</option>
				<option value="улучшеная планировка" <?php if($_POST['ap_layout'] == "улучшеная планировка") echo "selected"; ?> >улучшеная планировка</option>
				<option value="типовая" <?php if($_POST['ap_layout'] == "типовая") echo "selected"; ?> >типовая</option>
				<option value="хрещевка" <?php if($_POST['ap_layout'] == "хрещевка") echo "selected"; ?> >хрущевка</option>
				<option value="полногабаритная" <?php if($_POST['ap_layout'] == "полногабаритная") echo "selected"; ?> >полногабаритная</option>
				<option value="малоэтажка" <?php if($_POST['ap_layout'] == "малоэтажка") echo "selected"; ?> >малоэтажка</option>
				<option value="пентхаус" <?php if($_POST['ap_layout'] == "пентхаус") echo "selected"; ?> >пентхаус</option>
				<option value="двухуровневая" <?php if($_POST['ap_layout'] == "двухуровневая") echo "selected"; ?> >двухуровневая</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="wc_type">Санузел</label>
		
			<select  class="controls-select" name="wc_type" id="wc_type" >
				<option value="" >не важно</option>
				<option value="раздельный" <?php if($_POST['wc_type'] == "раздельный") echo "selected"; ?>  >раздельный</option>
				<option value="совмещенный" <?php if($_POST['wc_type'] == "совмещенный") echo "selected"; ?> >совмещенный</option>
				<option value="без удобств" <?php if($_POST['wc_type'] == "без удобств") echo "selected"; ?> >без удобств</option>
				<option value="ванна" <?php if($_POST['wc_type'] == "ванна") echo "selected"; ?> >ванна</option>
				<option value="душ" <?php if($_POST['wc_type'] == "душ") echo "selected"; ?> >душ</option>
				<option value="2 санузла" <?php if($_POST['wc_type'] == "2 санузла") echo "selected"; ?> >2 санузла</option>
				<option value="3 санузла" <?php if($_POST['wc_type'] == "3 санузла") echo "selected"; ?> >3 санузла</option>
				
			</select>
		
	</div>
</td>
<td>
<div  style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;" >
<label for="pricefrom">Цена от</label>
		<input id="pricefrom" name="pricefrom" type="text" value="<?php if ($_POST['pricefrom']) echo $_POST['pricefrom']; ?>" style="width: 100px; text-align: right;"/> 
<label for="priceto">до</label>
		<input id="priceto" name="priceto" type="text" value="<?php if ($_POST['priceto']) echo $_POST['priceto']; ?>" style="width: 100px; text-align: right;"/>
		<br />
		<label class="control-label" id="rent_type">за </label>
		
			<select  class="controls-select" name="rent_type" id="rent_type" >
				<option value="месяц"  <?php if($_POST['rent_type'] == 'месяц') echo "selected"; ?> >месяц</option>
				<option value="сутки"  <?php if($_POST['rent_type'] == 'сутки') echo "selected"; ?> >сутки</option>
				<option value="час"  <?php if($_POST['rent_type'] == 'час') echo "selected"; ?> >час</option>
				
			</select>
		
	
		
		<label for="price">Торг</label>
		<input id="torg" name="torg" type="checkbox" <?php if($_POST['torg'] == 'on') echo "checked"; ?> /> 
		
<div class="control-group">	
	<table>
	  <tr>
		<td>
		<label for="inet"><span><img id="icons" src="images/inet.png" title="Интернет"/></span></label>
		</td>
		<td>
		<label for="furn"><span><img id="icons" src="images/mebel.png" title="Мебель"/></span></label>
		</td>
		<td>
		<label for="tv"><span><img id="icons" src="images/icon-tv.png" title="Телевизор"/></span></label>
		</td>
		<td>
		<label for="washing"><span><img id="icons" src="images/iconlaundry.png" title="Стиральная машина"/></span></label>
		</td>
		<td>
		<label for="refrig"><span><img id="icons" class="refrigerator" src="images/refrigerator.png" title="Холодильник"/></span></label>
		</td>
		<td>
		<label for="conditioner"><span><img id="icons" src="images/freashing.png" title="Кондиционер"/></span></label>
		</td>
	  </tr>	
	  <tr>	
		<td>
		<input id="inet" name="inet" type="checkbox"  <?php if($_POST['tel'] == 1) echo "checked"; ?>  /> 
		</td>
		<td>
		<input id="furn" name="furn" type="checkbox"  <?php if($_POST['furn'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="tv" name="tv" type="checkbox"  <?php if($_POST['tv'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="washing" name="washing" type="checkbox"  <?php if($_POST['washing'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="refrig" name="refrig" type="checkbox"  <?php if($_POST['refrig'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="conditioner" name="conditioner" type="checkbox"  <?php if($_POST['conditioner'] == 1) echo "checked"; ?> /> 
		</td>
	  </tr>
	</table>
	</div>
	
	

	</div>
</td>
</tr>
</table>
<table id="advansed-search" style="display: none;">
	<tr>
		<td style="width: 565px;">
			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Площадь (от)
				</div>
				<label for="sq_allfrom">Общая</label>
				<input id="sq_allfrom" name="sq_allfrom" type="text" value="<?php if($_POST['sq_allfrom']) {echo $_POST['sq_allfrom']; } ?>"  /> / 
				<label  for="sq_livefrom">Жилая</label>
				<input id="sq_livefrom" name="sq_livefrom" type="text" value="<?php if($_POST['sq_livefrom']) {echo $_POST['sq_livefrom']; } ?>"  /> / 
				<label for="sq_kfrom">Кухня</label>
				<input id="sq_kfrom" name="sq_kfrom" type="text" value="<?php if($_POST['sq_kfrom']) {echo $_POST['sq_kfrom']; } ?>"  />
				<br />
				<div class="header-3">
					Площадь (до)
				</div>
				<label for="sq_allto">Общая</label>
				<input id="sq_allto" name="sq_allto" type="text" value="<?php if($_POST['sq_allto']) {echo $_POST['sq_allto']; } ?>"  /> / 
				<label  for="sq_liveto">Жилая</label>
				<input id="sq_liveto" name="sq_liveto" type="text" value="<?php if($_POST['sq_liveto']) {echo $_POST['sq_liveto']; } ?>"  /> / 
				<label for="sq_kto">Кухня</label>
				<input id="sq_kto" name="sq_kto" type="text" value="<?php if($_POST['sq_kto']) {echo $_POST['sq_kto']; } ?>"  />
			</div>

			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Этаж / Этажность (от)
				</div>
				
				<input id="floorfrom" name="floorfrom" type="text" value="<?php if($_POST['floorfrom']) echo $_POST['floorfrom']; ?>" /> / 
				
				<input id="floor_countfrom" name="floor_countfrom" type="text" value="<?php if($_POST['floor_countfrom']) echo $_POST['floor_countfrom']; ?>" />
				<br />
				<div class="header-3">
					Этаж / Этажность (до)
				</div>
				
				<input id="floorto" name="floorto" type="text" value="<?php if($_POST['floorto']) echo $_POST['floorto']; ?>" /> / 
				
				<input id="floor_countto" name="floor_countto" type="text" value="<?php if($_POST['floor_countto']) echo $_POST['floor_countto']; ?>" />
			</div>

		</td>
		<td style="width: 732px;">
			<div class="control-group">
				<label class="control-label" id="park">Парковка/гараж</label>
					<select class="controls-select" name="park" id="park" >
						<option value="Благоустроенная парковка у дома"  <?php if($_POST['park'] == 'частная') echo "selected"; ?> >Благоустроенная парковка у дома</option>
						<option value="Парковка со шлагбаумом" <?php if($_POST['park'] == 'Парковка со шлагбаумом') echo "selected"; ?> >Парковка со шлагбаумом</option>
						<option value="Подземный гараж" <?php if($_POST['park'] == 'Подземный гараж') echo "selected"; ?> >Подземный гараж</option>
						<option value="Подземная парковка" <?php if($_POST['park'] == 'Подземная парковка') echo "selected"; ?> >Подземная парковка</option>
					</select>
			</div>
	
			<div class="control-group">
				<label class="control-label" id="wall_type">Материал стен</label>
					<select class="controls-select" name="wall_type" id="wall_type" >
						<option value="кирпичный"  <?php if($_POST['wall_type'] == 'кирпичный') echo "selected"; ?> >кирпичный</option>
						<option value="панельный"  <?php if($_POST['wall_type'] == 'панельный') echo "selected"; ?> >панельный</option>
						<option value="деревянный"  <?php if($_POST['wall_type'] == 'деревянный') echo "selected"; ?> >деревянный</option>
						<option value="монолит"  <?php if($_POST['wall_type'] == 'монолит') echo "selected"; ?> >монолит</option>
					</select>
			</div>
			<div class="control-group">
				<label class="control-label" id="val_bal">Количество балконов</label>
				<input id="val_bal" name="val_bal" type="text" value="<?php if($_POST['val_bal']) {echo $_POST['val_bal']; } ?>" /> 
				
				<label class="control-label" id="val_lodg">Количество лоджий</label>
				<input id="val_lodg" name="val_lodg" type="text" value="<?php if($_POST['val_lodg']) {echo $_POST['val_lodg']; } ?>" /> 
		
			</div>
		</td>
	</tr>
</table>
	<li id="control_panel" style="
		text-align: left;
		list-style: none;">
		<span id="control" style="
		cursor:pointer;
		"><a onclick="showSelect('advansed-search')">Расширенный поиск</a></span>
		
		<input id="search-button" type="submit" name="submit" value="Поиск" style="float: right;" />
		</li>
	
	</form>
</div>
<!--коммерческая --> 
<div>
	<form id="" method="POST" action="?task=main&action=search" >


	
	<div class="control-group checklabel topic_id">
			<div class="header-3">
				Я хочу
			</div>
			<input type="hidden" name="search_type" value="topic_id8" />
			<input class="invisible" id="vkl8sell" value="2"  type="radio" name="topic_id8"  /> 
			<label id="label" for="vkl8sell">Купить</label>
			<input class="invisible" id="vkl8rent" value="1" type="radio" name="topic_id8" checked="checked" /> 
			<label id="label" for="vkl8rent">Снять</label>
		
		</div>
	
	<?php

?>
<table>
<tr>
<td style="width: 300px;">
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="live_point">Населенный пункт</label>
	<input id="live_point" name="live_point" type="text"  value="<?php if($_POST['live_point']) { echo $_POST['live_point']; } ?>" /> <br />
	</div>
	
	
	<div onclick="showSelect('dis-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
text-align: left;
	cursor: pointer;
	" >Район</div>
	<div id="dis-select" style="display: none;" class="div-select">
		<div class="left">
		<label for="dis1" >Дзержинский</label> <input id="dis1" type="checkbox" name="dis1" /><br />
		<label for="dis2" >Железнодорожный</label><input id="dis2" type="checkbox" name="dis2" /><br />
		<label for="dis3" >Заельцовский</label> <input id="dis3" type="checkbox" name="dis3" /><br />
		<label for="dis4" >Калининский</label> <input id="dis4" type="checkbox" name="dis4" /><br />
		<label for="dis5" >Кировский</label> <input id="dis5" type="checkbox" name="dis5" />
		</div>
		<div class="right">
		<label for="dis6" >Ленинский</label> <input id="dis6" type="checkbox" name="dis6" /><br />
		<label for="dis7" >Октябрьский</label> <input id="dis7" type="checkbox" name="dis7" /><br />
		<label for="dis8" >Первомайский</label> <input id="dis8" type="checkbox" name="dis8" /><br />
		<label for="dis9" >Советский</label> <input id="dis9" type="checkbox" name="dis9" /><br />
		<label for="dis10" >Центральный</label> <input id="dis10" type="checkbox" name="dis10" />
		</div>
	</div>
	
	
	<div onclick="showSelect('str-select')" style="
	border: 2px solid orange;
	padding-left:5px;
	width: 295px;
	text-align: left;
	cursor: pointer;
	" >Улица<span id="streets_number" style="float: right; margin-right: 5px;"></span></div>
	<div id="str-select" style="display: none"  class="div-select" >
	<input type="text" id="str" name="street" style="background: #F2D7E7;"  value="<?php if($_POST['street']) {echo $_POST['street']; } ?>" 
					
	autocomplete="off"/> введите улицу, или часть
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					
					</div>
					<ul id="street_adds">
					<?php if($_POST['street0']) { ?>
					
					<label id="label-0" class="str_search_res" onclick="removeStreet('0')" for="street-0" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-0" class="invisible" name="street0" type="text" value="<?php echo $_POST['street0']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street1']) { ?>
					
					<label id="label-1" class="str_search_res" onclick="removeStreet('1')" for="street-1" style="color: black;"><?php echo $_POST['street1']; ?></label>
					<input id="street-1" class="invisible" name="street0" type="text" value="<?php echo $_POST['street1']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street2']) { ?>
					
					<label id="label-2" class="str_search_res" onclick="removeStreet('2')" for="street-2" style="color: black;"><?php echo $_POST['street0']; ?></label>
					<input id="street-2" class="invisible" name="street2" type="text" value="<?php echo $_POST['street2']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street3']) { ?>
					
					<label id="label-3" class="str_search_res" onclick="removeStreet('3')" for="street-3" style="color: black;"><?php echo $_POST['street3']; ?></label>
					<input id="street-3" class="invisible" name="street0" type="text" value="<?php echo $_POST['street3']; ?>" style="color: black;">
					
					<?php } else if ($_POST['street4']) { ?>
					
					<label id="label-4" class="str_search_res" onclick="removeStreet('4')" for="street-4" style="color: black;"><?php echo $_POST['street4']; ?></label>
					<input id="street-4" class="invisible" name="street4" type="text" value="<?php echo $_POST['street4']; ?>" style="color: black;">
					
					<?php }
					?>
					</ul>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="house">№</label>
	<input id="house" name="house" type="text" value="<?php if($_POST['house']) {echo $_POST['house']; } ?>"/>
	</div>
	<div  style="
	border: 2px solid orange;
	
	width: 300px;
	text-align: center;
	cursor: pointer;
	" ; >
	<label for="orientir">Ориентир</label>
	<input id="orientir" name="orientir" type="text" value="<?php if($_POST['orientir']) {echo $_POST['orientir']; } ?>"/>
	</div>
</td>
<td style="width: 420px;">
	
	<div class="control-group checklabel switch_buy_rent" style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;">
		<div class="header-3">
			Количество комнат
		</div> <br />
		
		
		<input class="invisible"  id="k" value="8"  type="checkbox" name="type_id1"  <?php if($_POST['type_id1'] == 8) echo "checked"; ?> /> 
		<label id="label" for="k">Комната</label>
		
		<input class="invisible"  id="k-1" value="9"  type="checkbox" name="type_id2"  <?php if($_POST['type_id2'] == 9) echo "checked"; ?> /> 
		<label id="label" for="k-1">1-к</label>
		
		<input class="invisible"  id="k-2" value="10" type="checkbox" name="type_id3"  <?php if($_POST['type_id3'] == 10) echo "checked"; ?> /> 
		<label id="label" for="k-2">2-к</label>
		
		<input class="invisible"  id="k-3" value="11" type="checkbox" name="type_id4"  <?php if($_POST['type_id4'] == 11) echo "checked"; ?> /> 
		<label id="label" for="k-3">3-к</label>
		
		<input class="invisible"  id="k-4" value="15" type="checkbox" name="type_id5"  <?php if($_POST['type_id5'] == 15) echo "checked"; ?> /> 
		<label id="label" for="k-4">4-к</label>
		
		<input class="invisible"  id="k-5" value="16" type="checkbox" name="type_id6"  <?php if($_POST['type_id6'] == 16) echo "checked"; ?> /> 
		<label id="label" for="k-5">5-к</label>
		
		<input class="invisible"  id="k-6" value="17" type="checkbox" name="type_id7"  <?php if($_POST['type_id7'] == 17) echo "checked"; ?> /> 
		<label id="label" for="k-6">6-к +</label>
	</div>

	<div class="control-group">
		<label class="control-label" id="planning">Планировка</label>
		
			<select  class="controls-select" name="planning" id="planning" >
				<option value="" >не важно</option>
				<option value="изолированная" <?php if($_POST['planning'] == "изолированная") echo "selected"; ?>  >изолированная</option>
				<option value="смежная" <?php if($_POST['planning'] == "смежная") echo "selected"; ?> >смежная</option>
				<option value="см-изолированная" <?php if($_POST['planning'] == "см-изолированная") echo "selected"; ?> >см-изолированная</option>
				<option value="свободная" <?php if($_POST['planning'] == "свободная") echo "selected"; ?> >свободная</option>
				<option value="студия" <?php if($_POST['planning'] == "студия") echo "selected"; ?> >студия</option>
				<option value="иное" <?php if($_POST['planning'] == "иное") echo "selected"; ?> >иное</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="ap_layout">Тип квартиры</label>
		
			<select  class="controls-select" name="ap_layout" id="ap_layout" >
				<option value="">не важно</option>
				<option value="общежитие" <?php if($_POST['ap_layout'] == "общежитие") echo "selected"; ?>  >общежитие</option>
				<option value="малосемейка" <?php if($_POST['ap_layout'] == "малосемейка") echo "selected"; ?> >малосемейка</option>
				<option value="улучшеная планировка" <?php if($_POST['ap_layout'] == "улучшеная планировка") echo "selected"; ?> >улучшеная планировка</option>
				<option value="типовая" <?php if($_POST['ap_layout'] == "типовая") echo "selected"; ?> >типовая</option>
				<option value="хрещевка" <?php if($_POST['ap_layout'] == "хрещевка") echo "selected"; ?> >хрущевка</option>
				<option value="полногабаритная" <?php if($_POST['ap_layout'] == "полногабаритная") echo "selected"; ?> >полногабаритная</option>
				<option value="малоэтажка" <?php if($_POST['ap_layout'] == "малоэтажка") echo "selected"; ?> >малоэтажка</option>
				<option value="пентхаус" <?php if($_POST['ap_layout'] == "пентхаус") echo "selected"; ?> >пентхаус</option>
				<option value="двухуровневая" <?php if($_POST['ap_layout'] == "двухуровневая") echo "selected"; ?> >двухуровневая</option>
				
			
			</select>
		
	</div>
	
	<div class="control-group">
		<label class="control-label" id="wc_type">Санузел</label>
		
			<select  class="controls-select" name="wc_type" id="wc_type" >
				<option value="" >не важно</option>
				<option value="раздельный" <?php if($_POST['wc_type'] == "раздельный") echo "selected"; ?>  >раздельный</option>
				<option value="совмещенный" <?php if($_POST['wc_type'] == "совмещенный") echo "selected"; ?> >совмещенный</option>
				<option value="без удобств" <?php if($_POST['wc_type'] == "без удобств") echo "selected"; ?> >без удобств</option>
				<option value="ванна" <?php if($_POST['wc_type'] == "ванна") echo "selected"; ?> >ванна</option>
				<option value="душ" <?php if($_POST['wc_type'] == "душ") echo "selected"; ?> >душ</option>
				<option value="2 санузла" <?php if($_POST['wc_type'] == "2 санузла") echo "selected"; ?> >2 санузла</option>
				<option value="3 санузла" <?php if($_POST['wc_type'] == "3 санузла") echo "selected"; ?> >3 санузла</option>
				
			</select>
		
	</div>
</td>
<td>
<div  style=" border: 2px solid orange;
padding: 0px 0px 3px 5px;" >
<label for="pricefrom">Цена от</label>
		<input id="pricefrom" name="pricefrom" type="text" value="<?php if ($_POST['pricefrom']) echo $_POST['pricefrom']; ?>" style="width: 100px; text-align: right;"/> 
<label for="priceto">до</label>
		<input id="priceto" name="priceto" type="text" value="<?php if ($_POST['priceto']) echo $_POST['priceto']; ?>" style="width: 100px; text-align: right;"/>
		<br />
		<label class="control-label" id="rent_type">за </label>
		
			<select  class="controls-select" name="rent_type" id="rent_type" >
				<option value="месяц"  <?php if($_POST['rent_type'] == 'месяц') echo "selected"; ?> >месяц</option>
				<option value="сутки"  <?php if($_POST['rent_type'] == 'сутки') echo "selected"; ?> >сутки</option>
				<option value="час"  <?php if($_POST['rent_type'] == 'час') echo "selected"; ?> >час</option>
				
			</select>
		
	
		
		<label for="price">Торг</label>
		<input id="torg" name="torg" type="checkbox" <?php if($_POST['torg'] == 'on') echo "checked"; ?> /> 
		
<div class="control-group">	
	<table>
	  <tr>
		<td>
		<label for="inet"><span><img id="icons" src="images/inet.png" title="Интернет"/></span></label>
		</td>
		<td>
		<label for="furn"><span><img id="icons" src="images/mebel.png" title="Мебель"/></span></label>
		</td>
		<td>
		<label for="tv"><span><img id="icons" src="images/icon-tv.png" title="Телевизор"/></span></label>
		</td>
		<td>
		<label for="washing"><span><img id="icons" src="images/iconlaundry.png" title="Стиральная машина"/></span></label>
		</td>
		<td>
		<label for="refrig"><span><img id="icons" class="refrigerator" src="images/refrigerator.png" title="Холодильник"/></span></label>
		</td>
		<td>
		<label for="conditioner"><span><img id="icons" src="images/freashing.png" title="Кондиционер"/></span></label>
		</td>
	  </tr>	
	  <tr>	
		<td>
		<input id="inet" name="inet" type="checkbox"  <?php if($_POST['tel'] == 1) echo "checked"; ?>  /> 
		</td>
		<td>
		<input id="furn" name="furn" type="checkbox"  <?php if($_POST['furn'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="tv" name="tv" type="checkbox"  <?php if($_POST['tv'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="washing" name="washing" type="checkbox"  <?php if($_POST['washing'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="refrig" name="refrig" type="checkbox"  <?php if($_POST['refrig'] == 1) echo "checked"; ?> /> 
		</td>
		<td>
		<input id="conditioner" name="conditioner" type="checkbox"  <?php if($_POST['conditioner'] == 1) echo "checked"; ?> /> 
		</td>
	  </tr>
	</table>
	</div>
	
	

	</div>
</td>
</tr>
</table>
<table id="advansed-search" style="display: none;">
	<tr>
		<td style="width: 565px;">
			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Площадь (от)
				</div>
				<label for="sq_allfrom">Общая</label>
				<input id="sq_allfrom" name="sq_allfrom" type="text" value="<?php if($_POST['sq_allfrom']) {echo $_POST['sq_allfrom']; } ?>"  /> / 
				<label  for="sq_livefrom">Жилая</label>
				<input id="sq_livefrom" name="sq_livefrom" type="text" value="<?php if($_POST['sq_livefrom']) {echo $_POST['sq_livefrom']; } ?>"  /> / 
				<label for="sq_kfrom">Кухня</label>
				<input id="sq_kfrom" name="sq_kfrom" type="text" value="<?php if($_POST['sq_kfrom']) {echo $_POST['sq_kfrom']; } ?>"  />
				<br />
				<div class="header-3">
					Площадь (до)
				</div>
				<label for="sq_allto">Общая</label>
				<input id="sq_allto" name="sq_allto" type="text" value="<?php if($_POST['sq_allto']) {echo $_POST['sq_allto']; } ?>"  /> / 
				<label  for="sq_liveto">Жилая</label>
				<input id="sq_liveto" name="sq_liveto" type="text" value="<?php if($_POST['sq_liveto']) {echo $_POST['sq_liveto']; } ?>"  /> / 
				<label for="sq_kto">Кухня</label>
				<input id="sq_kto" name="sq_kto" type="text" value="<?php if($_POST['sq_kto']) {echo $_POST['sq_kto']; } ?>"  />
			</div>

			<div class="control-group checklabel switch_buy_rent">
				<div class="header-3">
					Этаж / Этажность (от)
				</div>
				
				<input id="floorfrom" name="floorfrom" type="text" value="<?php if($_POST['floorfrom']) echo $_POST['floorfrom']; ?>" /> / 
				
				<input id="floor_countfrom" name="floor_countfrom" type="text" value="<?php if($_POST['floor_countfrom']) echo $_POST['floor_countfrom']; ?>" />
				<br />
				<div class="header-3">
					Этаж / Этажность (до)
				</div>
				
				<input id="floorto" name="floorto" type="text" value="<?php if($_POST['floorto']) echo $_POST['floorto']; ?>" /> / 
				
				<input id="floor_countto" name="floor_countto" type="text" value="<?php if($_POST['floor_countto']) echo $_POST['floor_countto']; ?>" />
			</div>

		</td>
		<td style="width: 732px;">
			<div class="control-group">
				<label class="control-label" id="park">Парковка/гараж</label>
					<select class="controls-select" name="park" id="park" >
						<option value="Благоустроенная парковка у дома"  <?php if($_POST['park'] == 'частная') echo "selected"; ?> >Благоустроенная парковка у дома</option>
						<option value="Парковка со шлагбаумом" <?php if($_POST['park'] == 'Парковка со шлагбаумом') echo "selected"; ?> >Парковка со шлагбаумом</option>
						<option value="Подземный гараж" <?php if($_POST['park'] == 'Подземный гараж') echo "selected"; ?> >Подземный гараж</option>
						<option value="Подземная парковка" <?php if($_POST['park'] == 'Подземная парковка') echo "selected"; ?> >Подземная парковка</option>
					</select>
			</div>
	
			<div class="control-group">
				<label class="control-label" id="wall_type">Материал стен</label>
					<select class="controls-select" name="wall_type" id="wall_type" >
						<option value="кирпичный"  <?php if($_POST['wall_type'] == 'кирпичный') echo "selected"; ?> >кирпичный</option>
						<option value="панельный"  <?php if($_POST['wall_type'] == 'панельный') echo "selected"; ?> >панельный</option>
						<option value="деревянный"  <?php if($_POST['wall_type'] == 'деревянный') echo "selected"; ?> >деревянный</option>
						<option value="монолит"  <?php if($_POST['wall_type'] == 'монолит') echo "selected"; ?> >монолит</option>
					</select>
			</div>
			<div class="control-group">
				<label class="control-label" id="val_bal">Количество балконов</label>
				<input id="val_bal" name="val_bal" type="text" value="<?php if($_POST['val_bal']) {echo $_POST['val_bal']; } ?>" /> 
				
				<label class="control-label" id="val_lodg">Количество лоджий</label>
				<input id="val_lodg" name="val_lodg" type="text" value="<?php if($_POST['val_lodg']) {echo $_POST['val_lodg']; } ?>" /> 
		
			</div>
		</td>
	</tr>
</table>
	<li id="control_panel" style="
		text-align: left;
		list-style: none;">
		<span id="control" style="
		cursor:pointer;
		"><a onclick="showSelect('advansed-search')">Расширенный поиск</a></span>
		
		<input id="search-button" type="submit" name="submit" value="Поиск" style="float: right;" />
		</li>
	
	</form>
</div>
  
</div>



