<div class="col-xs-9">
	<legend>Форма отправки сообщения администратору</legend>	
	<?if ($_POST) echo $data;?>
	<form method="POST" id="send_message">				
		<div class="col-xs-12 deployed">	
			<textarea name="text" class="form-control" placeholder="содержание сообщения" rows="5" cols="80"  required="required"></textarea>
		</div>
		<div class="col-xs-2 deployed">	
			<input type="submit" class="form-control btn btn-success" value="Отправить">
		</div>	
	</form`>
</div>