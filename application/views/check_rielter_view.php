<script type="text/javascript">
	$(function(){		
		$(document).on("change", "[name=search_type]", function(){
			var search = $("[name=search_type]:checked").val();
			$("[data-name=search-str]").hide();
			$("div").has("#"+search).show();
		});
		
		$(document).on("click", function(e){
			if(!$(".street_list").has($(e.target)).length>0 && !$(".street_list").is($(e.target))){
				$(".street_list").slideUp();
			}
		});
		
		// $("#check_rielter").submit(function(e){
			// if($("#phone").val().length == 0 && $("#mail").val().length == 0)
			// {
				// e.preventDefault();
				// $("#phone:visible, #mail:visible").focus();
			// }
		// })
	})
</script>
<div class="col-xs-9" id='check_rielter'>
	<legend>Поиск риелтера в базе</legend>	
	<i>Перед проверкой номера выбирите в списке вариант по которому звонил риэлтор, а также в случае отсутствия номера в базе напишите дополнительно каким именем и из какого ан представлялся звонящий! <br/>Эти данные помогут администратору навести порядок и исключить посторонних из базы</i>
	<?php
		if($data['error']	==	'***'){
	?>
	<br/><br/>
		<div style = 'border: 2px solid red; text-align:center;'><i><b style = 'color:red'>Перед проверкой номера выбирите в списке вариант по которому звонил риэлтор</b></i></div>
		<br/>
	<?php
		}
	?>
    <script type="text/javascript">
        <!--
        /**
         *
         * @returns {boolean|*}
         */
        function check_rielter_form(){
            valid = true;
            if(document.check_rielter.phone.value == ""  && document.check_rielter.company_id.value == ""){
                alert( "Введите номер телефона или название агентства " );
                valid = false;
            }
            return valid;
        }
        //-->
    </script>

    <form method='POST' id='check_rielter'  name='check_rielter' onsubmit="return check_rielter_form();">
		<?if($_SESSION['admin'] == 1){?>
				<label class="signature">Выберите тип поиска</label>
				<div class="radio" style="display:none">
					<label>
						<input type="radio" name="search_type" value="phone" <?if($_POST['search_type']=="phone" || !$_POST) echo "checked";?>>
						телефон
					</label>
				</div>	
			<!--	<div class="radio" style="display:inline-block">
					<label>
						<input type="radio" name="search_type" value="mail" <?if($_POST['search_type']=="mail") echo "checked";?>>
						почта
					</label>
				</div> -->
			</div>
		<?}?>
		<div class="col-xs-2 deployed" data-name='search-str' style="<?if($_POST['search_type']=="mail") echo 'display:none'?>">
			<label class="signature">Телефон</label>
			<input type='text' class="form-control" name="phone" id='phone' value="<?if(isset($_POST['phone'])) echo $_POST["phone"];?>">
		</div>
		<?if($_SESSION['admin'] == 1){ ?>
			<div class="col-xs-2 deployed" data-name='search-str' style="<?if($_POST['search_type']=="phone" || !$_POST) echo 'display:none'?>">
				<label class="signature">E-Mail</label>
				<input type='text' class="form-control" name="mail" id='mail' value="<?if(isset($_POST['mail'])) echo $_POST["mail"];?>">
			</div>
		<?}?>
		<div class="col-xs-2 deployed">			
			<label class="signature">В каком агентстве</label>
			<input type="text" class="form-control" data-name="an-list" placeholder="все АН">
			<div class="an_list" style="display: none;"></div>
			<input type="hidden" name="company_id">		
		</div>
		<div class="col-xs-2 deployed" style = "width:500px;">			
			<label class="signature">Вариант</label>
			<select class="form-control" name="var_id" style = "width:500px;">
				<option value="***">--Выбрать вариант---</option>
				<option value="00_00">- проверить без выбора варианта - </option>
			<?php 
			if(!empty($data['var_list'])){ 
				foreach ($data['var_list'] as $value) {
			?>
				<option value="<?=$value['id']?>_<?=$value['parent_id']?>"><?=$value['dis']."  ул.".$value['street']. " " .$value['house']. " " .$value['orientir']. " " .$value['planning']. " " .$value['price']."p " ?></option>
			<?
				}
			}else{
			?>	
				<option value="simple">проверить без выбора варианта</option>
			<?php
			}
			?>	
			</select>
		</div>
		<br/>
		<br/>
		<div class="col-xs-2 deployed">	
			<input type="submit" class="form-control btn btn-success" value='Поиск'>
		</div>
		<br/>
				
	</form>

		<br/>
	<?if ($_SESSION["admin"] == 1){?>
	<div class="col-xs-3 deployed right">	
		<a href="?task=admin&action=check_rielter&request=all" class="form-control btn btn-primary">Показать Все запросы</a>
	</div>		
	<?}
	//print_r($data);

	if ($_POST || $_GET['request'] == "all"){
		$num = count($data)-1; // -2 ???
		$count_check = count($data['check_list']);
		if ($_POST){
			for($i=0; $i<$num; $i++){?>
				<div class='col-xs-12 info' style = 'width:80%'>
					<div class='col-xs-12 center'>
						АН  «<?echo $data[$i]['company_name'];?>»
					</div>
					
					<div class='col-xs-6'>
						<span style="color: rgb(50, 150, 50);font-size: 17px;"><?echo $data[$i]['name'];?> <?echo $data[$i]['second_name'];?></span><br />
						<?if($data[$i]['parent'] == "0"){
							echo "Директор агенства<br />";
						}?>
						дата регистрации: <?echo $data[$i]['date_reg'];?><br />
						статус: <?echo $data[$i]['status'];?><br />
						телефон для входящих: <?echo $data[$i]['phone'];?>
						<?if($data[$i]['phone_addon'] != "") 
							echo "<br />телефоны для исходящих: ".$data[$i]['phone_addon'];
						if($data[$i]['phone_archive'] != "") 
							echo "<br />архивные телефоны: ".$data[$i]['phone_archive'];
						?>
					</div>		
					<?if($data[$i]['warning'] == "1"){?>
						<div class='col-xs-6'>
							<a href="/?task=profile&action=caution&type=1&people=<?=$data[$i]['people_id']?>" class="warning" target="_blank" title="данный риелтор был занесен в раздел 'осторожно'">!</a>
						</div>
					<?}
					/*if($data[$i]['parent'] == "0"){?>
						<div class='col-xs-6'>
							<span style="color: rgb(50, 150, 50);font-size: 17px;"><?echo $data[$i]["director"]['name'];?> <?echo $data[$i]["director"]['second_name'];?></span><br />
							<?if($data[$i]["director"]['parent'] == "0"){
								echo "Директор агенства<br />";
							}?>
							дата регистрации: <?echo $data[$i]["director"]['date_reg'];?><br />							
							телефон для входящих: <?echo $data[$i]["director"]['phone'];?>
							<?if($data[$i]["director"]['phone_addon'] != "") 
								echo "<br />телефоны для исходящих: ".$data[$i]["director"]['phone_addon'];
							if($data[$i]["director"]['phone_archive'] != "") 
								echo "<br />архивные телефоны: ".$data[$i]["director"]['phone_archive'];
							?>
						</div>
					<?}*/?>
				</div>
			<?}
			if($num==0 && !isset($data['error'])){
				unset($i, $num);		
				$search_str = "телефоном ".$_POST['phone'];
				$num_or_mail = $_POST['phone'];
				$check_date = date("d.m.Y H:i:s");?>
				<div class='col-xs-12 info center' style = 'width:80%'>
					<h3 style='color:red'>ВНИМАНИЕ! Риелтора с <?echo $search_str;?> нет в базе!</h3>
					<div>Если вам известно, каким именем и агенством представляется человек с этого номера сообщите нам, мы примем меры
						<div class='col-xs-12 deployed'>
							<textarea class='form-control' name='check_rielter_comment' placeholder='пояснение' rows='5' cols='80' ></textarea>
						</div>
						<div class='col-xs-2 deployed'>
							<button type='button' onClick="Check_comment_set('<?echo $_SESSION['io'];?>', '<?echo $check_date;?>', '<?echo $num_or_mail;?>', '<?echo $_SESSION['people_id'];?>')" class='form-control btn btn-success'>Отправить</button>
						</div>
					</div>
				</div>
		<?	}
		}if($count_check > 0){?>
			<div class='col-xs-12' id='check_list' style = 'width: 80%'>
				<hr>
				<h4 class="">Кто ещё искал данный номер:<span style="color:#F00; float:right; margin-right:5px; font-size: 14px;">нет в базе</span>
				<!--<span style="color:#D0B400; float:right; margin-right:5px; font-size: 14px;">уволен</span>-->
				<span style="color:#4CAE4C; float:right; margin-right:5px; font-size: 14px;">работает</span></h4>
				<table class="table table-striped list">
					<thead><tr><th>#</th><th>Кто искал</th><th>АН</th><th>Что искали</th><th>Дата поиска</th>
					<?if($_SESSION['admin']==1){?>
						<th>Просмотренный вариант</th><th>Оставленный коментарий</th>
					<?}?>
					</tr></thead>
					<tbody>
						<?
						$result_color=[
							0 => "color:#F00",
							1 => "color:#D0B400",
							2 => "color:#4CAE4C"
						];
						for($c=0; $c<$count_check; $c++){							
							$check_date = date("d.m.Y H:i:s", strtotime($data['check_list'][$c]['date_search']));?>
							<tr>
								<td><?echo $c + 1?></td>
								<td><?echo $data['check_list'][$c]['name']." ".$data['check_list'][$c]['second_name'];?></td>
								<td>«<?=$data['check_list'][$c]['company_name'];?>»</td>
								<td style="<?echo $result_color[$data['check_list'][$c]['search_result']]?>"><?echo $data['check_list'][$c]['search_str'];?></td>
								<td><?echo $check_date;?></td>
								<?php 
									if($_SESSION['admin']==1){
									$var_id = explode('_', $data['check_list'][$c]['variant']); if(!isset($var_id[1]))$var_id[1]= 1;
								?>
										<td>
								<?php
									if($var_id[0] != 'simple'){
								?>
											<a target="_blank" href="?task=main&id=<?=$var_id[0]?>&parent_id=<?=$var_id[1]?>"><?=$var_id[0]?></a>
								<?php
									}
								?>
										</td>
										<td><?=$data['check_list'][$c]['check_comment']?></td>
								<?php
									}
								?>
							</tr>
						<?}unset($c, $count_check);?>
					</tbody>
				</table>
			</div>
		<?}
	}?>
</div>