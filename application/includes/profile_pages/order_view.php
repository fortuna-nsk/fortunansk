<?/*if($_SESSION["admin"]!=1){?>
	<div class="col-xs-9">
		<legend>Данные для оплаты доступа</legend>
		<div class="col-xs-12 deployed">
			<p>Страница временно не доступна. Ведутся работы.</p>
		</div>
	</div>
<?exit;}*/?>
<script type="text/javascript">
	$(function(){
		if($("form#order_send").attr("action") == ""){
			$("form#order_send .form-control").attr("disabled", "");
		}
		
		//отображение доп. полей взависимости от типа платежа
		$(document).on("change", "[name=order_type]", function(){
			var dataId = $(this).val(),
				anotherId = {"sber":"qiwi", "qiwi":"sber"};
			if(dataId != ""){
				ShowFields(anotherId[dataId], "[name=wallet_num]", 0);
				ShowFields(anotherId[dataId], "select", 0);
				ShowFields(anotherId[dataId], "textarea", 0);
				ShowFields(dataId, "select", 1);							
			}else{				
				ShowFields("sber", ":visible", 0);
				ShowFields("qiwi", ":visible", 0);				
			}
			$("textarea").removeAttr("disabled");
		});
		$(document).on("change", "[name=order_place]", function(){
			var val = $(this).val();
			if(val == "wallet"){
				
				ShowFields("sber", "[data-name=wallet_num]", 0);
				ShowFields("qiwi", "[name=wallet_num]", 1);
				$("div[data-id=qiwi]").has("textarea").show();

			}else if(val == "terminal" || val == "euroset"){
				
				ShowFields("sber", "[data-name=wallet_num]", 0);
				ShowFields("qiwi", "[name=wallet_num]", 0);
				$("div[data-id=qiwi]").has("textarea").show();

			}else if(val == "mobil" || val == "lk" || val == "bankomat"){
				ShowFields("qiwi", "[name=wallet_num]", 0);
				ShowFields("sber", "[data-name=wallet_num]", 1);				
				$("div[data-id=qiwi]").has("textarea").hide();
			}else{
				ShowFields("sber", "[data-name=wallet_num]", 0);
				ShowFields("qiwi", "[name=wallet_num]", 0);
				$("div[data-id=qiwi]").has("textarea").hide();
			}
		})
		$("#order_send").submit(function(e){
			if(parseInt($("[data-id=price]").val().replace(" ", "")) > 3000){
				 e.preventDefault();
				 alertify.error("Максимальная сумма к оплате 3 000р");
				 $("[data-id=price]").focus();
			}else if($("[name=order_place]:required").val()==""){
				 e.preventDefault();
				 alertify.error("Отметьте все обязательные поля!");
				 $("[name=order_place]:required").focus();
			}else if($("[data-id=sber_num]:visible").length > 0){
				if($("[data-id=sber_num]").val().match(/\d{4}/) == null){
					e.preventDefault();
					alertify.error("Укажите последнии цыфры карты");
					$("[data-id=sber_num]").focus();
				}
			}
		})
	})

function ShowFields(type, objStr, show){
	if(show == 0){
		$("div[data-id="+type+"]").has(objStr).hide();
		$("div[data-id="+type+"] "+objStr).removeAttr("required").attr("disabled", "");
	}else{
		$("div[data-id="+type+"]").has(objStr).show();
		$("div[data-id="+type+"] "+objStr).attr("required", "").removeAttr("disabled");
	}
}
</script>
<?$form_visible =  intval($data[0]['order_access']) == 1 || intval($_SESSION['order_access']) == 1;?>
<div class="col-xs-9">
	<legend>Два способа оплаты</legend>
	<div class="col-xs-12 deployed">
		<table style = "width: 95%; padding: 5px;">
			<tbody>
				<tr>
					<th style = "color:red; font-size: 18px; text-align: center" /> Карта Tinkoff
					<th style = "color:red; font-size: 18px; text-align: center"  /> Qiwi-кошелёк
				<tr>
					<td style = "width: 50%; padding: 15px; border: solid 2px #eee;vertical-align: top;">
						ОДИН ИЗ ВАРИАНТОВ ПОПОЛНИТЬ БАЛАНС НА ФОРТУНЕ МОЖНО ПУТЕМ ПЕРЕВОДА ДЕНЕГ С ВАШЕЙ ЛЮБОЙ КАРТЫ НА НАШУ 
						КАРТУ ТИНЬКОФФ ВОТ ЕЕ НОМЕР: 
						<br/><span style="color: #33B100;font-weight: bolder;">4377 7237 4136 4784</span>  <br/>
						ДЛЯ ЭТОГО НУЖНО ПЕРЕЙТИ НА ЗАЩИЩЕННУЮ СТРАНИЦУ ВОТ ЭТУ: 
						<br/><a target = "_blank" href = "https://www.tinkoff.ru/payments/card-to-card" style = "font-size: 15px; color: blue">
						 https://www.tinkoff.ru/payments/card-to-card </a><br/>

						ВПИСАТЬ СВОЮ КАРТУ ПОТОМ НАШУ ОТМЕТИТЬ СУММУ КОТОРУЮ ЖЕЛАЕТЕ ПЕРЕВЕСТИ 
						 И НАЖАТЬ КНОПКУ «ПЕРЕВЕСТИ» ПОСЛЕ ЗАХОДИТЕ НА ССЫЛКУ «ОТПРАВКА ДАННЫХ ОБ ОПЛАТЕ» И ВПИСЫВАЕТЕ ВСЕ ДАННЫЕ О ПЕРЕВОДЕ
						 И ОТПРАВЛЯЕТЕ! ВСЕ БАЛАНС ПОПОЛНЕН И МОЖИТЕ ПЕРЕХОДИТЬ ПО ССЫЛКЕ «ПРОДЛЕНИЕ ДОСТУПА» 
						 ГДЕ ВЫБИРАЕТЕ ЧТО ЖЕЛАЕТЕ ПРОДЛИТЬ И ПОДЛИВАЕТЕ!

						<br/>
						<!--<a target = "_blank" href = "https://www.tinkoff.ru/payments/card-to-card" style = "font-size: 15px; color: blue">Оплата с карты на карту</a> -->
					</td>
					<td style = "width: 50%; padding: 15px; border: solid 2px #eee;vertical-align: top;">
						ЕЩЕ ОДИН СПОСОБ УЖЕ ЗНАКОМЫЙ МНОГИМ. ЭТО ПУТЕМ ПОПОЛНЕНИЯ НАШЕГО КИВИ КОШЕЛЬКА ВОТ ЕГО НОМЕР:
						 <br/><span style="color: #33B100;font-weight: bolder;">89139179516</span><br/> ЭТО МОЖНО СДЕЛАТЬ РАЗНЫМИ СПОСОБАМИ! ПЕРЕВЕСТИ СО СВОЕГО КИВИ,
						  ПЕРЕВЕСТИ ЧЕРЕЗ САЛОНЫ СВЯЗИ СВЯЗНОЙ И ЕВРОСЕТЬ, А ТАКЖЕ ПЕРЕВЕСТИ ЧЕРЕЗ ТЕРМИНАЛЫ КИВИ.
						   ВОТ ССЫЛКА ДЛЯ ПЕРЕВОДА СО СВОЕГО КИВИ:
						   <br/><a target = "_blank" href = "https://w.qiwi.com/payment/main.action" style = "font-size: 15px; color: blue"> w.qiwi.com/payment/main.action</a><br/>
						    ВОТ ССЫЛКА ДЛЯ АЛЬТЕРНАТИВНЫХ СПОСОБОВ ПЕРЕВОДА: 
						    <br/><a target = "_blank" href = "https://w.qiwi.com/replenish.action " style = "font-size: 15px; color: blue">w.qiwi.com/replenish.action </a><br/>
						    ПОСЛЕ ПЕРЕВОДА ЗАХОДИМ В РАЗДЕЛ НА ФОРТУНЕ «ОТПРАВКА ДАННЫХ ОБ ОПЛАТЕ» И ОТПРАВЛЯЕМ ВСЕ НЕОБХОДИМЫЕ ДАННЫЕ О СОВЕРШЕННОМ ПЛАТЕЖЕ. 
						    КАК ТОЛЬКО ОТПРАВИТЕ БАЛАНС АВТОМАТОМ ПОПОЛНИТЬСЯ И МОЖНО ПЕРЕЙТИ К ПОСЛЕДНЕМУ ЭТАПУ ЭТО «ПРОДЛЕНИЕ ДОСТУПА» ГДЕ ВЫБИРАЕТЕ ЧТО ЖЕЛАЕТЕ ПРОДЛИТЬ И ПОДЛИВАЕТЕ! 
						    МИНУС ДАННОГО ПЕРЕВОДА В ТОМ ЧТО НУЖНО ПЛАТИТЬ БОЛЬШЕ ЧЕМ ВАМ ТРЕБУЕТСЯ ДЛЯ ПРОДЛЕНИЯ Т.К. ЕСТЬ КОМИССИИ ПРИ ВНЕСЕНИИ
						    И НА САМОЙ ФОРТУНЕ УДЕРЖИВАЕТСЯ МИНИМУМ 20 РУБ. ПРИ ЗАЧИСЛЕНИИ ЗА ОБНАЛИЧИВАНИЕ. 
						ЕСЛИ СУММА БОЛЬШЕ ЧЕМ 400Р ТО ЛУЧШЕ ПЕРЕВОД ДЕЛАТЬ С КАРТЫ НА КАРТУ.

					</td>
				</tr>	
			</tbody>
		</table>
		<br/>
		<!--<p>Оплата производится на карту сбербанка номер: <span style="color: #33B100;font-weight: bolder;">4276 8440 1970 6084</span> которая привязана к номеру телефона 89139179516 или на киви кошелек: <span style="color: #33B100;font-weight: bolder;">9139179516</span></p> 
		<p/>С 17 декабря временно оплата принемается только на киви кошелек его номер<span style="color: #33B100;font-weight: bolder;"> 89139179516</span>.<br/>
		При оплате учитывайте что необходимо учитывать комиссию за отправку и обналичивание.<br/>
		За отправку бывает что комиссию и не берут а за обналичивание с любой суммы 20р списывается при внесении данных об оплате.<br/>
		Скоро появятся альтернативные способы оплаты.</p>
		<p/>Для тех кому всё сложно, звоните, помогу решить вопрос альтернативным, подходящиям для вас способом -->

		<?if($_GET["task"]=="login"){
			echo "<p style='color: rgb(216, 42, 42);'>Ваш доступ деактивирован, т.к. закончилась абонентская плата. Рекомендуемый минимальный платеж по аренде: ".($data['duty'] + $data['subscription'] - $data['balance'] + 50)."р.. Все оплаченные излишки остаются на вашем балансе и могут быть использованы в любое время.<br /><br />После отправки данных об оплате, Вам потребуется заново ввести логин и пароль, чтобы выбрать и активировать нужные Вам услуги, которые будут доступны в пределах вашего баланса. После активации услуг опять заходите под логином и паролем, пользуетесь ресурсом. Те кому требуется дополнительные премиумы, могут их активировать из ЛК раздел 'Продление доступа, изменение услуг'.</p>";
		}?>
	</div>
	<legend>Отправка данных об оплате <?if($_GET["task"]=="login") echo "АН «".$data[1]."»";?></legend>
		<?if(!$form_visible){?>
			<div class="col-xs-12 deployed">
				<p style="color:red">Форма оплаты будет доступна после проверки администратором предыдущего платежа.</p>
			</div>
		<?}?>
		<form id="order_send" method="POST" action="<?if($form_visible) echo "?task=profile&action=order_send";?>">
			<div class="col-xs-2 deployed">
				<label class="signature">Дата платежа</label>
				<input type="text" class="form-control" data-id="date" name="pay_date" required>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Время платежа</label>
				<input type="text" class="form-control" data-id="time" name="pay_time" required>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Сумма</label>
				<input type="type" class="form-control" data-id="price" name="sum" required>
			</div>
			<div class="col-xs-12 deployed">
				<hr style="margin-bottom: 5px;margin-top: 0;">
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Способ оплаты</label>
				<select class="form-control" name="order_type" required>
					<option value="">выберите</option>
					<option value="sber">На карту Tinkoff</option>
					<option value="qiwi">На Qiwi-кошелёк</option>
				</select>
			</div>
			<div class="col-xs-2 deployed" data-id="qiwi">
				<label class="signature">Через что</label>
				<select class="form-control" name="order_place">
					<option value="">выберите</option>
					<option value="wallet">со своего кошелька</option>
					<option value="terminal">через терминал QIWI</option>
					<option value="euroset">в евросети</option>
				</select>
			</div>	
			<div class="col-xs-2 deployed" data-id="sber">
				<label class="signature">Через что</label>
				<select class="form-control" name="order_place">
					<option value="">выберите</option>
					<option value="mobil">с карты на карту через мобильник</option>
					<option value="lk">с карты на карту через компьютер</option>
					<option value="bankomat">с карты на карту через банкомат</option>
				</select>
			</div>
			<div class="col-xs-2 deployed" data-id="sber">
				<label class="signature">Посл 4цифры карты</label>
				<input type="text" class="form-control" name="card_number"  data-name="wallet_num" data-id="sber_num">
			</div>	
			<div class="col-xs-2 deployed" data-id="qiwi">
				<label class="signature">Номер кошелька</label>
				<input type="text" data-id="phone" class="form-control" name="wallet_num">
			</div>
			<?/*<div class="col-xs-2 deployed" data-id="sber">
				<label class="signature">Пос. 4 цифры карты</label>
				<input type="text" class="form-control" name="wallet_num" data-id="sber_num">
			</div>*/?>
			<div class="col-xs-2 deployed" data-id="sber">
				<label class="signature">Имя владельца карты</label>
				<input type="text" class="form-control" name="name" data-name="wallet_num">
			</div>
			<div class="col-xs-2 deployed" data-id="sber">
				<label class="signature">Отчество владельца</label>
				<input type="text" class="form-control" name="surname" data-name="wallet_num">
			</div>
			<div class="col-xs-2 deployed" data-id="sber">
				<label class="signature">Фамилия владельца</label>
				<input type="text" class="form-control" name="second_name" data-name="wallet_num">
			</div>
			<div class="col-xs-4 deployed" data-id="qiwi">
				<label class="signature">Коментарий в платеже</label>
				<textarea rows="3" name="comment_pay" class="form-control" placeholder="коментарий в платеже"></textarea>
			</div>
			<div class="col-xs-4 deployed">
				<label class="signature">Коментарий для админа</label>
				<textarea rows="3" name="comment_order" class="form-control" placeholder="коментарий для админа"></textarea>
			</div>
			<div class="col-xs-12 deployed">
				<div class="checkbox" style="margin-bottom: auto; display: inline-block;">
					<label>
						<input name="access" type="checkbox" required>
						подтверждаю, что данные не вымышлены, и введены правильно. В случае отправки не существующего платежа, логин будет заблокирован до момента оплаты штрафа 500р
					</label>
				</div>
			</div>
	<?if ($form_visible){?>
			<div class="col-xs-2 deployed right">
				<input type="submit" class="form-control btn btn-success" value="Отправить">
			</div>	
			<input type="hidden" name="company_id" value="<?echo $_SESSION['company_id'];?>">
			<input type="hidden" name="active" value="1">
	<?}unset($form_visible);?>
		</form>	
	<?if($_GET["task"]=="profile"){?>
		<div class="col-xs-12 deployed">
			<legend>Список платежей</legend>	
		</div>
		<table id="application" class="table table-striped">
			<thead>
				<tr><th>#</th><th>Дата <br />записи</th><th>Дата <br />платежа</th><th>Тип <br />платежа</th><th>Номер карты/<br />кошелька</th><th>Место <br />платежа</th><th>Сумма</th><th>Коментарий <br />в платеже</th><th>Пояснение</th></tr>
			</thead>
			<tbody>
				<?	$count = count($data);
					if($data[0]['id']!=""){
						for($i=0; $i<$count; $i++){?>
							<tr>
								<td><?echo $i+1;?></td>
								<td style="width: 100px;"><?echo date("d.m.Y H:i:s", strtotime($data[$i]['date_order']));?></td>
								<td style="width: 100px;"><?echo date("d.m.Y H:i:s", strtotime($data[$i]['pay_date']));?></td>
								<td><?echo Translate::Order_type_place($data[$i]['order_type']);?></td>
								<td><?echo $data[$i]['wallet_num'];?></td>	
								<td><?echo Translate::Order_type_place($data[$i]['order_place']);?></td>
								<td><?echo $data[$i]["sum"];?></td>	
								<td><?echo $data[$i]['comment_pay'];?></td>	
								<td><?echo $data[$i]['comment_order'];?></td>							
							</tr>
						<?}
					}
				?>			
			</tbody>
		</table>
	<?}?>
</div>			
			</div>