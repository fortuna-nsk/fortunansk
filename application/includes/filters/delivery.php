<?
	$kvartal = Helper::FilterVal('kvartal');
?>
<div class="col-xs-4 deployed">
	<div class="input-group interval xm">
		<span class="input-group-addon">Сдача</span>
		<input type="text" id="y_done" name="y_done" class="form-control"  size="4" maxlength="4" placeholder="год" value="<?php if($data_res['y_done']){echo $data_res['y_done'];}else if(Helper::FilterVal('y_done')){echo Helper::FilterVal('y_done');} ?>">
		<select  class="form-control" name="kvartal" id="kvartal">
			<option value="">квартал</option>
			<option value="1"  <?php if($data_res['kvartal'] == '1' || $kvartal == '1') echo "selected"; ?> >
				1 (январь-март)
			</option>
			<option value="2" <?php if($data_res['kvartal'] == '2' || $kvartal == '2') echo "selected"; ?> >
				2 (апрель-июнь)
			</option>
			<option value="3" <?php if($data_res['kvartal'] == '3' || $kvartal == '3') echo "selected"; ?> >
				3 (июль-сентябрь)
			</option>
			<option value="4" <?php if($data_res['kvartal'] == '4' || $kvartal == '4') echo "selected"; ?> >
				4 (октябрь-декабрь)
			</option>
		</select>
	</div>
</div>
<?unset($kvartal);?>