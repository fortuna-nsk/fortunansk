<script type="text/javaScript">
    //для сохранения
    var confirmStr = "Обновить информацию?";
    var postUrl = '?task=profile&action=change_user';
</script>
<div class='col-xs-9'>
    <legend>Список оплат</legend>
    <table class="table table-striped list">
        <thead>
        <tr><th>#</th>
            <th>АН</th>
            <th>Тип оплаты</th>
            <th>Место <br />платежа</th>
            <th>Сумма</th>
            <th>Коментарий</th>
            <th>Дата</th>
            <th>Дата <br />платежа</th>
            <th></th></tr>
        </thead>
        <tbody>
        <?
        $count= count($data);
        for($i=0; $i<$count; $i++){
            $active = $data[$i]['active'] == 0 ? "" : "color:#4CAE4C";?>
            <tr class="an" data-name='order' id="<?echo $data[$i]["company_id"];?>" data-order-id="<?echo $data[$i]["id"];?>">
                <td><?echo $i+1;?></td>
                <td data-name='an' onclick="ShowEmployees('<?echo $data[$i]["company_id"];?>')">
                    (<?=$data[0]["people_info"][$data[$i]["company_id"]]?>) <?=$data[$i]["company_name"];?></td>
                <td><?echo Translate::Order_type_place($data[$i]["order_type"]);?></td>
                <td><?echo Translate::Order_type_place($data[$i]['order_place']);if(!empty($data[$i]['wallet_num'])) echo "<br/>".$data[$i]['wallet_num'];?></td>
                <td><?echo $data[$i]["sum"];?></td>
                <td><?echo $data[$i]["comment_order"];?></td>
                <td style="width: 100px;"><?echo date("d.m.Y H:i:s", strtotime($data[$i]["date_order"]));?></td>
                <td style="width: 100px;"><?echo date("d.m.Y H:i:s", strtotime($data[$i]['pay_date']));?></td>
                <td style="<?echo $active;?>"><?if($active!="") {echo "Новый!";}else{?>
                        <span class="dropdown">
							<a href="javascript:void(0)" id="orderMenu" data-toggle="dropdown">Меню<span class="caret"></span></a>
							<ul class="dropdown-menu" aria-labelledby="orderMenu" style='margin-left: -115px;'>
                                <li><a href="javascript:void(0)" onClick="ToArchive('order', <?=$data[$i]['id'];?>)">В архив</a></li>
                                <li><a href="javascript:void(0)" onClick="Delete('order', <?=$data[$i]['id'];?>)">Удалить</a></li>
                            </ul>
						</span>
                    <?}?></td>
            </tr>
        <?}unset($i, $count);?>
        </tbody>
    </table>
</div>