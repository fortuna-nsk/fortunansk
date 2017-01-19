<?$url = "&parent_id=".($_GET['parent_id'] ? $_GET['parent_id'] : 1)."&topic_id=".(isset($_GET['topic_id']) ? $_GET['topic_id'] : ($_SESSION["group_topic_id"] == 3 ? 1 : $_SESSION["group_topic_id"]));?>
<script type="text/javaScript">
	$(function(){
		//показ подменю создания вариантов
		$("[role=menu] li").on("click", function(){
			$(".dropdown-menu[data-name=dropdown-second]").hide();
			$(".dropdown-menu."+$(this).data("name")).show();
			if(!$(this).hasClass("active")){
				$("[role=menu] li").removeClass("active");
				$(this).addClass("active");			
			}		
		});
		
		//скрытие меню добавления варианта
		$(document).on("click", function(e){
			if ($(".dropdown-menu:visible").length !=0){			
				var obj = $(".dropdown-menu").parent();
				if(!obj.is(e.target) && obj.has(e.target).length == 0){
					$(".dropdown-menu").parent().removeClass("open");
					$(".dropdown-menu li").removeClass("active");
					$(".dropdown-menu[data-name=dropdown-second]").hide();					
				}  
			}
		});	
		$(".dropdown-menu[data-name=dropdown-second] a").on('click', function(){
			window.location = $(this).attr("href");
		});
		$(".btn-group.count label").on("click", function(){
			window.location = $(this).data("href");
		})		
	})
</script>
<div class="btn-group btn-group-justified count" role="group" aria-label="...">
  <div class="btn-group" role="group" data-toggle="buttons">
    <label class="btn btn-default <?php if(!isset($_GET['active']) && $_GET['action'] == "mytype" || $_GET['active'] == 1) echo "active"; ?>" style="width: 14%;" data-href="<?echo "?task=profile&action=mytype".$url."&limit=all&active=1";?>">
		<input type="radio" name="active" value="1" <?php if(!isset($_GET['active']) || $_GET['active'] == 1) echo "checked"; ?>>Активные <?if($_GET['active']==1)echo "<span class='badge'>{$data[0]['count']}</span>";/*<span class="badge"><?echo Get_functions::Get_var_count(null,$_GET['topic_id'],$_GET['parent_id'],1);?></span>*/?>
	</label>
    <label class="btn btn-default <?php if(isset($_GET['active']) && $_GET['active'] == 0) echo "active"; ?>" style="width: 14%;" data-href="<?echo "?task=profile&action=mytype".$url."&active=0";?>">
		<input type="radio" name="active" value="0" <?php if(isset($_GET['active']) && $_GET['active'] == 0) echo "checked"; ?>>Архив <?if($_GET['active']==0 && $_GET['action']=='mytype')echo "<span class='badge'>{$data[0]['count']}</span>";/*<span class="badge"><?echo Get_functions::Get_var_count(null,$_GET['topic_id'],$_GET['parent_id'],0);?></span>*/?>
	</label>
    <label class="btn btn-default <?php if($_GET['action'] == "favorites") echo "active"; ?>" style="width: 14%;" data-href="<?echo "?task=profile&action=favorites".$url;?>">
		<input type="radio" name="favorites" value="1" <?php if($_GET['action'] == "favorites") echo "checked"; ?>>Избранное от АН
	</label>
	<label class="btn btn-default <?php if($_GET['action'] == "favorites_parse") echo "active"; ?>" style="width: 14%;" data-href="<?echo "?task=profile&action=favorites_parse".$url;?>">
		<input type="radio" name="favorites_parse" value="1" <?php if($_GET['action'] == "favorites_parse") echo "checked"; ?>>Избранное от хоз
	</label>
	<label class="btn btn-default <?php if($_GET['action'] == "favorites_pay_parse") echo "active"; ?>" style="width: 16%;" data-href="?task=profile&action=favorites_pay_parse">
		<input type="radio" name="favorites_pay_parse" value="1" <?php if($_GET['action'] == "favorites_pay_parse") echo "checked"; ?>>Избранное от хоз 2</span>
	</label>
	<label class="btn btn-default <?php if($_GET['action'] == "recipients") echo "active"; ?>" style="width: 14%;" data-href="?task=profile&action=recipients">
		<input type="radio" name="recipients" value="1" <?php if($_GET['action'] == "recipients") echo "checked"; ?>>Подборки</span>
	</label>
	<div class="btn-group" id="add-var" style="width: 14%;">
		<button type="button" onClick="$(this).parent().toggleClass('open')" class="btn btn-info dropdown-toggle" aria-expanded="true">Добавить объект <span class="caret"></span></button>
		<?
		if($condition){?>
			<ul class="dropdown-menu" role="menu" style="top:30px;">
				<li data-name="rent"><a href="javaScript:void(0)">Аренда</a></li>		
				<li class="divider"></li>
				<li data-name="sell"><a href="javaScript:void(0)">Продажа</a></li>			
			</ul>
		<?}
		if($_SESSION['group_topic_id'] != 2){?>
			<ul class="dropdown-menu rent" data-name="dropdown-second" style="top:30px; <?if ($condition) echo "display:none; left:-140px;";?>">
				<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=1">Квартира</a></li>
				<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=18">Комната</a></li>	
				<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=3">Коттеджи-дома</a></li>
				<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=4">Дачи</a></li>
				<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=6">Гаражи/Парковки</a></li>
				<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=7">Коммерческая</a></li>	
				<li><a href="?task=profile&action=newvar&topic_id=1&parent_id=5">Земля</a></li>
			</ul>
		<?}
		if($_SESSION['group_topic_id'] != 1){?>
			<ul class="dropdown-menu sell" data-name="dropdown-second" style="top:30px; <?if ($condition) echo "display:none; left:-140px;";?>">
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
	</div>
  </div>
</div>