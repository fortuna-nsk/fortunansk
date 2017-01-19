<?$suspicion = Helper::FilterVal('suspicion');?>
<div class="col-xs-2 deployed">
	<select class="form-control" name="suspicion">			
		<option value="0">не важно</option>
		<option value="1" <?php if($suspicion == "1") echo "selected"; ?>>
				подозрительно
		</option>				
	</select>
</div>