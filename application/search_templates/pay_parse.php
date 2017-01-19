<script type='text/javascript'>
	$(function(){
		$(document).on("click", "[data-id=contacts]", function(){
			setTimeout(function(){
				$("[type=submit]").click();
			}, 500)
		})
	})
</script>
<form id="main_search" method="GET" style="margin-top: -15px;">
	<?
		echo "<input type='hidden' name='task' value='{$_GET['task']}'>
		<input type='hidden' name='action' value='{$_GET['action']}'>";
	?>
	<div class="row">
		<div class="col-xs-2 deployed" style="min-width: 150px  !important;">
			<div class="btn-group medium" data-toggle="buttons">
			  <label data-id="topic_id" class="btn btn-default active">
				<input type="radio" name="topic_id" value="1" checked="">сдам</label>
			</div>
		</div>
		<?
		if($parent == "Квартиры"){
			include "application/includes/filters/count_types.php";
		}
		$rent_true = $topic=="Аренда";
		include "application/includes/filters/price.php";?>	
		<div class="geo" style="width: 99%;">
			<?include "application/includes/filters/city.php";
			include "application/includes/filters/districts_list.php";
			include "application/includes/filters/street_house.php";?>
			<div class="col-xs-2 deployed">
				<input class="form-control" type="text" name="phone" placeholder="телефон" value="<?=Helper::FilterVal('phone')?>">
			</div>
		</div>
	</div>
	<hr>	
	<div class="row col-xs-12 center" id="control_panel">
		<?if($_SESSION['user'] != 'guest' && $_GET['task'] != "profile"){
			include "application/includes/filters/searchFooter.php";
		}else{
			Helper::Retro_pag($data[0]['count'], 100);
		}
		if($_GET['action'] != "favorites_parse"){?>	
			<div class="btn-group medium" data-toggle="buttons" style="margin-left: 2%;">
				<label onClick="HideContacts($(this))" data-id="contacts" class="btn btn-default <?php if($_SESSION["post"]['without_cont'] == 1) echo "active"; ?>">
					<input type="checkbox" name="without_cont" value="1" <?php if($_SESSION["post"]['without_cont'] == 1) echo "checked"; ?>>Скрыть контакты
				</label>
			</div>
		<?}else{?>
			<div class="btn-group medium" data-toggle="buttons" style="margin-left: 2%;">
				<label onClick="HideContacts($(this))"  data-id="contacts" class="btn btn-default <?php if($_SESSION["post"]['without_cont'] == 1) echo "active"; ?>">
					<input type="checkbox" value="1" <?php if($_SESSION["post"]['without_cont'] == 1) echo "checked"; ?>>Скрыть контакты
				</label>
			</div>
		<?}?>
		<input type="submit" class="btn btn-primary right" value="Поиск">		
	</div>
	<input type="hidden" name="parent_id" value="<?=$parent_id;?>">	
</form>	