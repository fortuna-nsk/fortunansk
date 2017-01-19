<?$prem_count = Get_functions::Get_premium_balance();
$without_vip = DB::Select("without_vip", "re_company", "id={$_SESSION['company_id']}")[0]['without_vip'];?>
<div style="display:block; border:1px solid red; padding:5px; margin:10px">
	<br>
	<table>
		<tbody>
			<?if($prem_count>0 || $data_res['premium'] == 1){?>
				<tr>
					<td style="height: 21px" align="center">
						<div id="premium">
							<input type="checkbox" id="premium" value="1" name="premium" <?php if($data_res['premium'] == 1) echo "checked"; ?>>
							<span style="color:green">ПРЕМИУМ(<?=$prem_count;?>)</span>
						</div>
					</td>
				</tr>
			<?}if($without_vip == 0){?>
				<tr>
					<td>
						<input onchange="if(this.checked){ document.getElementById('premium').style.display = 'block';}else{ document.getElementById('premium').style.display = 'none';}" id="exkl" type="radio" value="3" name="status" <?php if($data_res['status'] == 3) echo "checked"; ?>>«VIP»<br>Данный статус не влияет на месторасположение данного варианта в списке базы всех вариантов,
						а носит исключительно информативный характер!
						Гарантия 100% что данного варианта на момент рекламирования на сайте fortunasib нет в разделе «от собственников», 
						и на просторах интернета напрямую от собственника!
						VIP не обозначает, что это эксклюзив. Данный вариант может рекламироваться несколькими агентствами одновременно! 
						В случае установки данного статуса на объект который не соответствует условию статуса "vip"(умышленно или по невнимательности),
						возможность в дальнейшем пользоваться данным статусом при отправке новых сообшений будет исключена! 
						Если не уверены, в том что хозяева не ведут свою игру, лучше отметьте статус «50на50»!
						<br><br>
					</td>
				</tr>
			<?}?>
			<tr>
				<td>
					<input onchange="if(this.checked){ document.getElementById('premium').style.display = 'block';}else{ document.getElementById('premium').style.display = 'none';}" id="exkl" type="radio" value="2" name="status" <?php if($data_res['status'] == 2) echo "checked"; ?>>  «50 на 50» <br>Данный статус не влияет на месторасположение данного варианта в списке базы всех вариантов,
					а носит исключительно информативный характер!
					Гарантирую что на момент публикации и на момент каждого продления на fortunasib данного объекта нет в разделе «от хозяев», 
					и на просторах интернета напрямую от собственника!
					Но не уверен, что по истечении какого то времяни хозяева или их близкие, не поставив вас в известность, 
					начнут дополнительно рекламировать его самостоятельно на просторах интернета! 
					Обращаем ваше внимание! Если выяснится что данный вариант есть на просторах интернета на прямую от собственника
					или в разделе от собственников на fortunasib, и ко всему прочему, 
					опубликован раньше чем отправили или последний раз продлили его на fortunasib, 
					то возможность в дальнейшем пользоваться данным статусом при отправке новых сообшений будет исключена!
					Если сомневаетесь, лучше отметьте статус «без гарантий»!<br><br>
				</td>
			</tr>
			<tr>
				<td>
					<input onchange="if(this.checked){ document.getElementById('premium').style.display = 'block';}" id="exkl" type="radio" value="1" name="status" <?php if($data_res['status'] == 1 || !isset($data_res['status'])) echo "checked"; ?>> «без гарантий»<br>Данный статус не обозначает что данный объект не имеет ценности, а говорит только о том 
					что вы дополнительно не желаете делать разные проверки для установки статуса с какой либо гарантией!
					Ничего гарантировать не могу и не собираюсь! 
					Вам надо вот вы и проверяйте, есть такое сообщение на просторах интернета или в разделе «от собственников» на fortunasib, 
					мне это не надо! С данным статусом сообщение вообще не обязательно как то проверять и чего то гарантировать, отправил и забыл<br>
				</td>				
			</tr>
		</tbody>
	</table>
</div>