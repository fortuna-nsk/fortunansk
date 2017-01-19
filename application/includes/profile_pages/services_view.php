<?
	$rent_access = ($data["day_count"]>0);
	$show_all = $data["group_topic_id"] != 2;
?>
<script type="text/javascript">
	$(function(){		
		var postUrl = "?task=profile&action=services_payment";
		if(window.location.search.indexOf("show=message") != -1){
			alertify.alert("Ваш счет пополнен и составляет "+$("[data-id=balance]").text()+" рублей. Вам необходимо активировать и продлить услуги.");
		}
		<?if($show_all){?>
			$(document).on("change", "[name=rent_month_count]", function(){
				var month_count = parseInt($("[name=rent_month_count]").val()),
					subscription = parseInt($("[data-id=rielter_sum]").val()),
					sum_rent = month_count * subscription;
				$("#rent-extension [data-id=sum]").val(sum_rent);
			});
		
			$(document).on("change", "[name=rent_premium_count], [name=rent_premium_period]", function(){
				var period = parseInt($("[name=rent_premium_period]").val()),
					premium_count = parseInt($("[name=rent_premium_count]").val());
				$("#premium-extension [data-id=sum]").val(period*premium_count*1.33);
			});
		<?}?>
		$(document).on("change", "[name=sell_month_count]", function(){
			var sum_sell = parseInt($("[name=sell_month_count]").val()) * 200;				
			$("[data-id=sell_sum]").val(sum_sell);			
		});
		$(document).on("keyup change", "[name=rielter_count]", function(){
			$("[data-id=rielter_sum]").val(parseInt($(this).val()) * 100);			
		});
		$(document).on("change", "[name=pay_parse_period]", function(){
			var payParsePeriod = parseInt($("[name=pay_parse_period]").val()); 
			if(payParsePeriod > 0){
				$("[data-id=pay_parse_sum]").val(Math.round(payParsePeriod * 6.66).toFixed(0));
			}else{
				$("[data-id=pay_parse_sum]").val(0);
			}
		})
		<?if($show_all){?>
			$("#rent-extension").submit(function (e) {
				e.preventDefault();
				var sum = parseFloat($("#rent-extension [data-id=sum]").val()),
					balance = parseFloat($("[data-id=balance]").text()),
					duty = parseFloat($("[data-id=duty]").text()),
					date = $("[data-id=rent_date_end]").text(),
					resultSum = balance-sum-duty;
				if(duty==0){
					if((resultSum)>=0){
						alertify.confirm("Продлить раздел 'Аренда' на  "+$("[name=rent_month_count] option:selected").text()+" ?", function (result) {
							if (result) {
								$.ajax({
									type:"POST",
									url:postUrl,
									data:"type=rent&rent_month_count="+$("[name=rent_month_count]").val()+"&date="+date,
									success:function(html){	
										if(QueryString("task")=="profile"){
											window.location = "\?task=profile&action=services&topic_id=1&parent_id=1";
											// $("[data-id=balance]").text(resultSum);
											// $("[data-id=duty]").text(0);
											// $("[data-id=rent_date_end]").text(html);
											// alertify.success("Доступ к аренде продлен");
										}else{
											alertify.confirm("Оплата проведена. Можете входить.", function(result){
												if(result){
													window.location = location;
												}else{
													window.location = location;
												}
											})
										}
									}
								})
							}
						});
					}else{
						alertify.error("На Вашем счете не достаточно средств!");
					}
				}else{
					alertify.alert("Чтобы воспользоваться данной услугой, сначало необходимо погасить долг в размере "+duty+"р.");
				}
			});
		
			$("#premium-extension").submit(function (e) {
				e.preventDefault();
				var sum = parseFloat($("#premium-extension [data-id=sum]").val()),
					duty = parseFloat($("[data-id=duty]").text()),
					balance = parseFloat($("[data-id=balance]").text()),
					new_premium_count = parseInt($("[name=rent_premium_count]").val()) + parseInt($("[data-id=rent_premium]").text());
					resultSum = balance-sum-duty;
				if(sum == 0){
					$("[name=rent_premium_count]").focus();		
					alertify.error("Выберете количество премиумов.");
					return false;
				}
				if(duty==0){
					if((resultSum)>=0){
						alertify.confirm("Активировать "+$("[name=rent_premium_count]").val() + " премиумов на "+$("[name=rent_premium_period] option:selected").text()+"?", function (result) {
							if (result) {
								$.post(postUrl, "type=premium&"+decodeURIComponent($("#premium-extension").serialize()), function(html){
									window.location = "\?task=profile&action=services";
									// $("[data-id=rent_premium]").text(new_premium_count);
									// $("[data-id=balance]").text(resultSum);
									// $("[data-id=duty]").text(0);
									// alertify.success("Премиумов добавленно: "+$("[name=rent_premium_count]").val());
								})
							}
						})
					}else{
						alertify.error("На Вашем счете не достаточно средств!");
					}
				}else{
					alertify.alert("Чтобы воспользоваться данной услугой погасите долг в размере "+duty+"р.");
				}
			});
			
			$("#pay-parse-extension").submit(function (e) {
				e.preventDefault();
				var sum = parseFloat($("[data-id=pay_parse_sum]").val()),
					balance = parseFloat($("[data-id=balance]").text()),
					duty = parseFloat($("[data-id=duty]").text()),
					date = $("[data-id=rent_date_end]").text(),
					resultSum = balance-sum-duty;
				if(duty==0){
					if((resultSum)>=0){
						alertify.confirm("Продлить раздел 'Частники 2' на  "+$("[name=pay_parse_period] option:selected").text()+" ?", function (result) {
							if (result) {
								$.ajax({
									type:"POST",
									url:postUrl,
									data:"type=pay_parse&pay_parse_period="+$("[name=pay_parse_period]").val(),
									success:function(){	
										window.location = location;
									}
								})
							}
						});
					}else{
						alertify.error("На Вашем счете не достаточно средств!");
					}
				}else{
					alertify.alert("Чтобы воспользоваться данной услугой, сначало необходимо погасить долг в размере "+duty+"р.");
				}
			});
		<?}?>
		$("#sell-extension").submit(function (e) {
            e.preventDefault();
			var sum = parseFloat($("#sell-extension [data-id=sell_sum]").val()),
				balance = parseFloat($("[data-id=balance]").text()),
				duty = parseFloat($("[data-id=duty]").text()),
				date = $("[data-id=sell_date_end]").text(),
				resultSum = balance-sum-duty;
			if(duty==0){
				if((resultSum)>=0){
					alertify.confirm("Внести оплату в размере "+sum+" рублей?", function (result) {
						if (result) {
							$.ajax({
								type:"POST",
								url:postUrl,
								data:"type=sell&"+decodeURIComponent($("#sell-extension").serialize())+"&date="+date,
								success:function(html){		
									if(QueryString("task")=="profile"){
										window.location = "\?task=profile&action=services";
										// $("[data-id=balance]").text(resultSum);
										// $("[data-id=duty]").text(0);
										// $("[data-id=sell_date_end]").text(html);
										// alertify.success("Доступ к продаже продлен");
									}else{
										alertify.confirm("Оплата проведена. Можете входить.", function(result){
											if(result){
												window.location = location;
											}else{
												window.location = location;
											}
										})
									}
								}
							})
						}
					});
				}else{
					alertify.error("На Вашем счете не достаточно средств!");
				}
			}else{
				alertify.alert("Чтобы воспользоваться данной услугой погасите долг в размере "+duty+"р.");
			}
		});
		
		$("#new-address, #new-ip, #new-rielter").submit(function (e) {
            e.preventDefault();
			var balance = parseFloat($("[data-id=balance]").text()),
				duty = parseFloat($("[data-id=duty]").text());
			if(duty==0){
				var rielterSum = parseFloat($(this).find("[data-id=rielter_sum]").val()),
					message = $(this).attr("id") == "new-rielter" 
								? "Внести оплату в размере "+$("#new-rielter [data-id=rielter_sum]").val()+" рублей?"
								: "Ваша заявка на добавление или изменение данных будет отправлена администратору. По данной заявки с вашего счета будет списано "+rielterSum+" рублей. Заказать услугу?",				
					resultSum = balance-duty-rielterSum,
					data = decodeURIComponent($(this).serialize());
				if(resultSum >=0){
					alertify.confirm(message, function (result) {
						if (result) {
							$.ajax({
								type:"POST",
								url:"?task=profile&action=services_payment",
								data:"type=application&"+data,
								success:function(html){			
									window.location = "\?task=profile&action=services";
									// $("[data-id=balance]").text(resultSum);
									// $("[data-id=duty]").text(0);
									// alertify.success("Заявка отправлена.");
								}
							})
						}
					});
				}else{
					alertify.error("На Вашем счете не достаточно средств!");
				}
			}else{
				alertify.alert("Чтобы воспользоваться данной услугой погасите долг в размере "+duty+"р.");
			}
		})
	})
</script>
<div class="col-xs-9">
	<legend>Текущее состояние доступа</legend>
	<div style="width: 400px;display: inline-block;float: left;">
		<div class="col-xs-2 deployed">
			Баланс: <span data-id="balance"><?echo $data["balance"];?></span>
		</div>
		<div class="col-xs-2 deployed">
			Долг: <span data-id="duty"><?echo $data["duty"];?></span>
		</div>
		<?if($show_all){?>
			<div class="col-xs-3 deployed">
				Аренда до: <span data-id="rent_date_end" style="<?=Helper::Warn($data["rent_date_end"])?>"><?echo date("d.m.Y", strtotime($data["rent_date_end"]));?></span>
			</div>
			<div class="col-xs-2 deployed">
				Премиумы: <span data-id="rent_premium"><?echo $data["rent_premium"];?></span>
			</div>				
			<div class="col-xs-4 deployed">
				Частники 2 до: <span data-id="pay_parse_date_end" style="<?=Helper::Warn($_SESSION["pay_parse_date_end"])?>"><?echo date("d.m.Y", strtotime($_SESSION["pay_parse_date_end"]));?></span>
			</div>	
		<?}?>
		<?if($_SESSION['group_topic_id'] != 1){?>
			<div class="col-xs-4 deployed">
				Продажа от частников до: <span data-id="sell_date_end" style="<?=Helper::Warn($data["sell_date_end"])?>"><?echo date("d.m.Y", strtotime($data["sell_date_end"]));?></span>
			</div>
		<?}?>
	</div>
	<?if($data["duty"]>0){?>
		<form method="POST" action="?task=profile&action=services_payment" id="duty_pay">
			<div class="col-xs-4 deployed info">
				<label class="signature">Описание долга</label>
				<span><?echo $data["duty_comment"];?></span>
			</div>
			<?if(($data["balance"] - $data["duty"])>=0){?>
				<div class="col-xs-2 deployed">
					<input type="submit" form="duty_pay" class="form-control btn btn-danger" value="Погасить долг">
				</div>
				<input type="hidden" name="type" value="duty">
				<input type="hidden" name="duty" value="<?echo $data["duty"];?>">
			<?}?>
		</form>
	<?}?>
	<?$count = count($data["prem_end_date"]);
	$diff = null;
	if($count>0){?>
		<div class="col-xs-5 deployed info">
			<label class="signature">Даты списания премиумов</label>
			<?for($i=0; $i<$count; $i++){
				$diff = $diff==null 
					? ($data["rent_premium"] - $data["prem_end_date"][$i]["prem_sum"]) 
					: ($diff - $data["prem_end_date"][$i]["prem_sum"]);?>
				<span><?echo date("d.m.Y", strtotime($data["prem_end_date"][$i]["date_finish"]));?> cпишется <?echo $data["prem_end_date"][$i]["prem_sum"];?> премиумов, остаток составит <?echo $diff;?></span><br />
				
			<?}?>
		</div>
	<?}	unset($count, $diff);?>
</div>
<div class="col-xs-9">
	<legend>Продление доступа</legend>	
	<?if($show_all){?>
		<form id="rent-extension" method="POST">
			<div class="col-xs-2 deployed" style="max-width: 110px !important;min-width: 110px !important;">
				<b style="font-size: 17px;color: rgb(92, 184, 92);">Аренда</b>
			</div>		
			<div class="col-xs-2 deployed">
				<label class="signature">Продлить на</label>
				<select class="form-control" name="rent_month_count" required>
					<option value="1">1 месяц</option>
					<option value="2">2 месяца</option>
					<option value="3">3 месяца</option>
					<option value="4">4 месяца</option>
					<option value="5">5 месяцев</option>
					<option value="6">6 месяцев</option>
					<option value="7">7 месяцев</option>
					<option value="8">8 месяцев</option>
					<option value="9">9 месяцев</option>
					<option value="10">10 месяцев</option>
					<option value="11">11 месяцев</option>
					<option value="12">12 месяцев</option>				
				</select>
			</div>		
			<div class="col-xs-1 deployed">
				<label class="signature">Сумма</label>
				<input type="text" data-id="sum" class="form-control" value="<?echo $data["subscription"];?>" disabled>
			</div>
			<div class="col-xs-2 deployed">
				<input type="submit" class="form-control btn btn-success" value="Продлить аренду">	
			</div>
			<input type="hidden" data-id="rielter_sum" value="<?echo $data["subscription"];?>">
		</form>
		<div class="col-xs-12 deployed">	
			<hr style="margin: 0;">
			<?if($_GET['task']=='login'){
				echo "<span style='color:rgb(216, 42, 42)'>Те кому требуется дополнительные премиумы, могут их активировать из ЛК раздел 'Продление доступа, изменение услуг'.</span>";
			}?>
		</div>
		<?if($rent_access){?>
			<form id="premium-extension" method="POST">
				<div class="col-xs-2 deployed" style="max-width: 110px !important;min-width: 110px !important;">
					<b style="font-size: 17px;color: rgb(92, 184, 92);">Премиумы</b>
				</div>		
				<div class="col-xs-2 deployed">
					<label class="signature">Активировать на срок</label>
					<select class="form-control" name="rent_premium_period" required>
						<?if($data["day_count"] <= 10 && $rent_access){?>
							<option value="<?echo $data["day_count"];?>"><?echo $data["day_count"];?> дней</option>
						<?}else{
							for($d=10; $data["day_count"]>$d; $d+=10){?>
								<option value="<?echo $d;?>"><?echo $d;?> дней</option>
							<?}?>
							<option value="<?echo $d-($d - $data["day_count"]);?>"><?echo $d-($d - $data["day_count"]);?> дней</option>
						<?}?>
					</select>
				</div>		
				<div class="col-xs-1 deployed">
					<label class="signature">Кол.</label>
					<select class="form-control" name="rent_premium_count" required>
						<?for($i=0; $i<=100; $i+=5){?>
							<option value="<?echo $i;?>"><?echo $i;?></option>
						<?}?>
					</select>
				</div>
				<div class="col-xs-1 deployed">
					<label class="signature">Сумма</label>
					<input type="text" data-id="sum" class="form-control" value="0" disabled>
				</div>
				<div class="col-xs-3 deployed">
					<input type="submit" class="form-control btn btn-success" value="Активировать премиумы">	
				</div>
				<input type="hidden" data-id="rielter_sum" value="<?echo $data["subscription"];?>">
			</form>
		<?}else{
			echo "<p>Чтобы получить доступ к активации премиумов, продлите доступ по аренде.</p>";
		}?>
	
		<?if($rent_access){?>
			<div class="col-xs-12 deployed">	
				<hr style="margin: 0;">
			</div>
			<form id="pay-parse-extension" method="POST">
				<div class="col-xs-2 deployed" style="max-width: 110px !important;min-width: 110px !important;padding-right: 0;">
					<b style="font-size: 17px;color: rgb(92, 184, 92);">Частники 2</b>
				</div>		
				<div class="col-xs-2 deployed">
					<label class="signature">Активировать на срок</label>
					<select class="form-control" name="pay_parse_period" required>
							<option value="">не продлевать</option>
						<?if($data["day_count"] <= 10 && $rent_access){?>
							<option value="<?echo $data["day_count"];?>"><?echo $data["day_count"];?> дней</option>
						<?}else{
							for($d=10; $data["day_count"]>$d; $d+=10){?>
								<option value="<?echo $d;?>" ><?echo $d;?> дней</option>
							<?}?>
							<option value="<?echo $d-($d - $data["day_count"]);?>"><?echo $d-($d - $data["day_count"]);?> дней</option>
						<?}?>
					</select>
				</div>
				<div class="col-xs-1 deployed">
					<label class="signature">Сумма</label>
					<input type="text" data-id="pay_parse_sum" class="form-control" value="0" disabled>
				</div>
				<div class="col-xs-3 deployed">
					<input type="submit" class="form-control btn btn-success" value="Продлить 'частников 2'" <?=($_SESSION["pay_parse_date_end"] < $data["rent_date_end"] ? "" : "disabled")?>>	
				</div>
			</form>
		<?}else{
			echo "<p>Чтобы получить доступ к продлению 'частников 2', продлите доступ по аренде.</p>";
		}?>
	<?}?>
	<?if($_SESSION['group_topic_id'] != 1){?>
		<div class="col-xs-12 deployed">	
			<hr style="margin: 0;">
		</div>
		<form id="sell-extension" method="POST" action="?task=profile&action=extension">		
			<div class="col-xs-2 deployed" style="max-width: 110px !important;min-width: 110px !important;">
				<b style="font-size: 17px;color: rgb(92, 184, 92);">Продажа</b>
			</div>		
			<div class="col-xs-2 deployed">
				<label class="signature">Продлить на</label>
				<select class="form-control" name="sell_month_count" required>
					<option value="1">1 месяц</option>
					<option value="2">2 месяца</option>
					<option value="3">3 месяца</option>
					<option value="4">4 месяца</option>
					<option value="5">5 месяцев</option>
					<option value="6">6 месяцев</option>
					<option value="7">7 месяцев</option>
					<option value="8">8 месяцев</option>
					<option value="9">9 месяцев</option>
					<option value="10">10 месяцев</option>
					<option value="11">11 месяцев</option>
					<option value="12">12 месяцев</option>				
				</select>
			</div>		
			<div class="col-xs-1 deployed">			
				<label class="signature">Сумма</label>
				<input type="text" data-id="sell_sum" class="form-control" value="200" disabled>	
			</div>
			<div class="col-xs-2 deployed">
				<input type="submit" class="form-control btn btn-success" value="Продлить продажу">	
			</div>
		</form>
	<?}?>
</div>
<?if($_GET["task"]=="profile"){?>
	<div class="col-xs-9">
		<legend>
			Дополнительные услуги
			<a href="javascript:void(0)" class="retro-gray" style="font-size: 14px;/*float: right;*/" onclick="$($(this).parent().next()).toggleClass('hidden')">
				показать/скрыть<span class="caret"></span>
			</a>
		</legend>
		<div class="hidden">
			<form id="new-address" method="POST">
				<div class="col-xs-7 deployed">
					<p>Подключение или перенос точки доступа (1 000 руб.)</p>
					<textarea class="form-control" name="comment" placeholder="ардес и телефон точки" required="required"></textarea>
					<input type="hidden" name="rielter_sum" data-id="rielter_sum" value="1000">
				</div>
				<div class="col-xs-2 deployed" style="margin: 30px;">
					<input type="submit" class="form-control btn btn-success" value="Заказать">	
				</div>
			</form>
			<div class="col-xs-12 deployed">	
				<hr style="margin: 0;">
			</div>
			<form id="new-ip" method="POST">
				<div class="col-xs-7 deployed">
					<p>Смена ip-адреса на подключенной точке доступа (500 руб.)</p>
					<textarea class="form-control" name="comment" placeholder="ардес, телефон и новый IP точки" required="required"></textarea>
					<input type="hidden" name="rielter_sum" data-id="rielter_sum" value="500">
				</div>
				<div class="col-xs-2 deployed" style="margin: 30px;">
					<input type="submit" class="form-control btn btn-success" value="Заказать">	
				</div>
			</form>
		</div>
		<?/*
		<div class="col-xs-12 deployed">	
			<hr style="margin: 0;">
		</div>	
		<form id="new-rielter" method="POST" action="?task=profile&action=new_application">
			<div class="col-xs-5 deployed">
				<p>Регистрация нового сотрудника или смена номера</p>
				<textarea class="form-control" name="comment" placeholder="пояснение" required="required"></textarea>
			</div>
			<div class="col-xs-1 deployed" style="margin: 30px 0;">
				<label class="signature">Колл.</label>
				<input type="number" name="rielter_count" class="form-control" min="0" value="1">
			</div>
			<div class="col-xs-1 deployed" style="margin: 30px 0;">
				<label class="signature">К оплате</label>
				<input type="number" data-id="rielter_sum" class="form-control" value="100" disabled>
			</div>
			<div class="col-xs-2 deployed" style="margin: 30px;">
				<input type="submit" class="form-control btn btn-success" value="Оплатить">	
			</div>
		</form>
		*/?>
	</div>
	<div class="col-xs-9" style="margin-top: 20px;">
	<?include "application/views/services_list_view.php";?>
	</div>
<?}?>
