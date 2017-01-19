	<script>
$(function (){
	$(".btn.active [name=topic_id]").click();
	<?if(!$_POST){ ?>
		// var parent = $(".products-list").data("parent");
		// var topic = $(".products-list").data("topic");
		// $("input[name=parent_id]").val(parent ? parent : "1");
		// $("input[name=topic_id]").val(topic ? topic : "1");				
	<?}else{?>
	$(".street_list span").each(function(){
		if($(this).text().toString().match(/\S/) != null)
		{			
			$(this).css("display", "block");
		}
	});
	<?}?>
	$(document).on("click", "label[data-id=topic_id], label[data-id=view_type]",  function(){	
		if(!$(this).hasClass("active")){
			if($(this).text().match(/списком/) == "списком"){
				$.post('?task=main&action=save_limit', 'limit=50');
			}
			setTimeout(function(){
				$("input[type=submit]").click();
			}, 400)
		}
	});
	if($('[name=type_id6]').is(':checked')){
		$('select[name=ap_layout]').parent().toggleClass('hidden').attr('disabled', 'disabled');
	}
});

function ApLayoutChange(){
	$('select[name=ap_layout]').parent().toggleClass('hidden');
	if($('select[name=ap_layout]').parent().hasClass('hidden')){
		$('select[name=ap_layout]').attr('disabled', 'disabled');
	}else{
		$('select[name=ap_layout]').removeAttr('disabled');
	}
}
</script>
<form id="main_search" method="GET" style="margin-top: -15px;">
	<?
	echo "<input type='hidden' name='task' value='main'>
		<input type='hidden' name='action' value='{$_GET['action']}'>";
	if($_GET['task']=='profile'){
		echo "<input type='hidden' name='task' value='profile'>
		<input type='hidden' name='action' value='{$_GET['action']}'>
		<input type='hidden' name='page' value='1'>";
		if(isset($_GET['active'])){
			echo "<input type='hidden' name='active' value='{$_GET['active']}'>";
		}
	}
	$rent_true = $topic=="Аренда" && $_SESSION['search_user_id'] != "ngs";
	?>
	<div class="row">
		<?include "application/includes/filters/topic.php";
		if($_SESSION['search_user_id'] != "ngs" && $parent=="Комната"){
			include "application/includes/filters/ap_layout_room.php";
		}else if($parent=="Квартиры" || $parent=="Новостройки"){
			/*колличество комнат*/
			include "application/includes/filters/count_types.php";
		}
		if($rent_true && ($parent=="Квартиры" || $parent=="Комната"))include "application/includes/filters/planning.php";

		if($parent != "Все" && $parent!="Комната") include "application/includes/filters/ap_layout.php";
		include "application/includes/filters/price.php";
		if($rent_true)include "application/includes/filters/delivery_period.php";
		if($parent=="Дома")include "application/includes/filters/garage_exists.php";
		if($parent=="Земля" || $parent=="Коммерческая")include "application/includes/filters/area.php";?>
		<div class="geo" style="width: 99%;">
			<?include "application/includes/filters/city.php";
			include "application/includes/filters/districts_list.php";
			include "application/includes/filters/street_house.php";
			if($parent != "Квартиры" && $parent != "Комната"){
				include "application/includes/filters/orientir.php";
			}
			if($rent_true && ($parent=="Квартиры" || $parent=="Комната") || $parent == "Новостройки")include "application/includes/filters/floor.php";
			if($parent!="Земля" && $parent!="Гаражи")include "application/includes/filters/race_now.php";
			
	?>
		</div>

	<?if($parent!="Земля" && $parent!="Гаражи" && $parent!="Коммерческая" && $parent !="Все"){?>
		<div>
			<?if($rent_true){
				/*форма собственности/мебель*/
				include "application/includes/filters/own_type.php";
				include "application/includes/filters/residents.php";
			}else{
				/*доп условия продажи*/
				if($parent=="Новостройки" || $parent=="Квартиры")include "application/includes/filters/additional_terms.php";
				if($parent=="Новостройки")include "application/includes/filters/own_type.php";
				if($parent!="Дачи" || $parent!="Дачи"){	
					/*балконов/лоджий*/
					include "application/includes/filters/bal_lodg.php";
					/*наличие парковки*/
					include "application/includes/filters/park.php";
				}
				/*материал стен*/
				include "application/includes/filters/wall_type.php";
			}
			if($rent_true && ($parent=="Квартиры" || $parent=="Комната")){
				include "application/includes/filters/metro.php";
				include "application/includes/filters/new_house.php";
			}
			if($parent!="Комната" && $parent!="Дома" && $parent!="Дачи")include "application/includes/filters/wc_type.php";
			//include "application/includes/filters/area.php";
			?>
		</div>
		<div style="display: inline-block;">
			<?/*площадь недвижемости*/
			if($rent_true && ($parent=="Квартиры" || $parent=="Комната"))include "application/includes/filters/area.php";
			if($parent=="Комната")include "application/includes/filters/rooms_count.php";
			if($_SESSION['people_id'] == 1)
				include "application/includes/filters/suspicion.php";
			if($parent=="Дома"){
				/*Отопление*/
				include "application/includes/filters/heating.php";
				/*Мыться*/
				include "application/includes/filters/wash.php";
				include "application/includes/filters/wc_type.php";
				/*Вода*/
				include "application/includes/filters/water.php";
			}?>
		</div>	
	<?}?>
	</div>	
	<hr>	
	<div class="row col-xs-12 <?if($_SESSION['search_user_id'] == "ngs")echo "center";?>" id="control_panel">		
		<?if($_SESSION['user'] != 'guest' && $_GET['task'] != "profile"){
			include "application/includes/filters/searchFooter.php";
		}else{
			Helper::Retro_pag($data[0]['count'], 100);?>	
			<div class="btn-group medium" data-toggle="buttons" style="margin-left: 2%;">
				<label onClick="HideContacts($(this))" class="btn btn-default <?php if($_SESSION["post"]['without_cont'] == 1) echo "active"; ?>">
					<input type="checkbox" name="without_cont" value="1" <?php if($_SESSION["post"]['without_cont'] == 1) echo "checked"; ?>>Скрыть контакты
				</label>
			</div>
			<div class="col-xs-2 deployed" style="width: 150px;">			
				<select class="form-control" name="order">
					<option value="date_last_edit" <?php if($order == "date_last_edit") echo "selected"; ?>>
						по продлению
					</option>
					<option value="date_added" <?php if($order == "date_added") echo "selected"; ?>>
						по созданию
					</option>
				</select>
			</div>
			<?
			/*if($_GET['active']==1){?>
				<a href="<?="http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}&limit=all"?>" style="vertical-align: sub;margin-left: 20px;">Показать все активные варианты</a>
			<?}*/
		}?>
		<input type="submit" class="btn btn-primary right" value="Поиск">		
		<input type="button" onClick="$('.nav-tabs li.active a').click()" class="btn btn-danger right" style="margin-right: 15px;" value="Сброс">
	</div>
	<input type="hidden" name="parent_id" value="<?=$parent_id;?>">	
</form>	