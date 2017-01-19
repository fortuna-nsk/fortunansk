<legend>
	Список заказаных ранее услуг
	<a href="javascript:void(0)" class="retro-gray" style="font-size: 14px;/*float: right;*/" onclick="$($(this).parent().next()).toggleClass('hidden')">
		показать/скрыть<span class="caret"></span>
	</a>
</legend>

<table id="application" class="table table-striped hidden">
	<thead>
		<tr><th>#</th><th>Дата платежа</th><th>Дата окончания</th><th>Проплаченный период</th><th>Кол. оплаченых премиумов</th><th>Сумма</th><th>Доп.инф.</th><?if($_SESSION["admin"]==1)echo "<th></th>";?></tr>
	</thead>
	<tbody>
		<?$count = count($data["payment_list"]);
		for($i=0; $count>$i; $i++){?>
			<tr>
				<td><?echo $i+1;?></td>
				<td><?echo date("d.m.Y", strtotime($data["payment_list"][$i]["date_payment"]));?></td>
				<td><?echo date("d.m.Y", strtotime($data["payment_list"][$i]["date_finish"]));?></td>
				<td><?echo $data["payment_list"][$i]["month_count"] == 0 
					? $data["payment_list"][$i]["day_count"]." д." 
					: $data["payment_list"][$i]["month_count"]." м.";?></td>
				<td><?echo $data["payment_list"][$i]["premium_count"];?></td>
				<td><?echo $data["payment_list"][$i]["sum"];?></td>
				<td><?echo $data["payment_list"][$i]["comment"];?></td>
				<?if($_SESSION["admin"]==1)echo "<td><span class='delete right' onClick='Delete(\"payment\", {$data["payment_list"][$i]["id"]})'>удалить</span></td>";?>
			</tr>
		<?}unset($i, $count);?>
	</tbody>
</table>
