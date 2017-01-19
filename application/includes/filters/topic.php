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
<div class="col-xs-2 deployed" style="min-width: 150px  !important;">
	<div class="btn-group medium" data-toggle="buttons">
	  <label data-id="topic_id" class="btn btn-default <?php if(!isset($_GET['topic_id']) || $_GET['topic_id'] == $rentOrSell[1]) echo "active"; ?>">
		<input type="radio" name="topic_id" value="<?echo $rentOrSell[1];?>" <?php if(!isset($_GET['topic_id']) || $_GET['topic_id'] == $rentOrSell[1]) echo "checked"; ?>><?echo $rentOrSell[2];?>
	  </label>
	  <label data-id="topic_id" class="btn btn-default <?php if($_GET['topic_id'] == $rentOrSell[3]) echo "active"; ?>">
		<input type="radio" name="topic_id" value="<?echo $rentOrSell[3];?>" <?php if($_GET['topic_id'] == $rentOrSell[3]) echo "checked"; ?>><?echo $rentOrSell[4];?>
	  </label>
	</div>
</div> 