<?
	if($topic == "Аренда"){
		$rentOrSell = array( 
					1 => "1",
					2 => "сдам",
					3 => "3",
					4 => "сниму");
	}else{
		$rentOrSell = array( 
					1 => "2",
					2 => "продам",
					3 => "4",
					4 => "куплю");	
	}
?>
<div class="col-xs-2 deployed" style="max-width: 130px;  min-width: 150px  !important;">
	<div class="btn-group medium" data-toggle="buttons">
	  <label class="btn btn-default <?php if($data_res['topic_id'] == $rentOrSell[1] || !$data_res['topic_id']) echo "active"; ?>">
		<input type="radio" name="topic_id" value="<?echo $rentOrSell[1];?>" <?php if($data_res['topic_id'] == $rentOrSell[1] || !$data_res['topic_id'] ) echo "checked"; ?>><?echo $rentOrSell[2];?>
	  </label>
	  <label class="btn btn-default <?php if($data_res['topic_id'] == $rentOrSell[3]) echo "active"; ?>">
		<input type="radio" name="topic_id" value="<?echo $rentOrSell[3];?>" <?php if($data_res['topic_id'] == $rentOrSell[3]) echo "checked"; ?>><?echo $rentOrSell[4];?>
	  </label>
	</div>
</div> 