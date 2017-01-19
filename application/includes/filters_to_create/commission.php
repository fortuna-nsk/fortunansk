<div class="col-xs-2 deployed">
	<label class="signature">Комиссия не менее</label>					
	<select class="form-control" name="commission" id="commission" required>
		<?
		$i = $parent == "Комната" ? 60 : 50;
		for ($i; $i<=100; $i=$i+5){
			$commission = $data_res['commission'] == $i ? "selected" : "";
			echo "<option value='".$i."' ".$commission.">".$i."%</option>";
		}?>	
	</select>
</div>