<div class="row">
	<div class="col-xs-12 pagination_row">
		<div class="col-xs-4">
			<div class="input-group interval xl">
				<span class="input-group-addon"><?echo $data[0]['count'];?> вариантов</span>	
				<select type="text"  class="form-control" name="limit" id="limit">
					<?if($_GET['post']['view_type']!= "map"){?>
						<option value="50" <?php if($_SESSION['limit'] == 50 OR !$_SESSION['limit']) echo "selected"; ?> >по 50</option>
						<option value="100" <?php if($_SESSION['limit'] == 100) echo "selected"; ?>  >по 100</option>
						<option value="200" <?php if($_SESSION['limit'] == 200) echo "selected"; ?> >по 200</option>	
					<?}else{						
						echo "<option value='50' selected>по 50</option>";
					}?>
				</select>
			</div>	
		</div>
		<ul class="pagination pagination-sm">
			<?
			if ($_GET['limit']){
				$limit = $_GET['limit'];
				$_SESSION['limit'] = $limit;
			} else {
				$limit = isset($_SESSION['limit']) ? $_SESSION['limit'] : 50;
			}
			$pages = $data[0]['count']/$limit;

			if ($_GET['page']){
				$page = $_GET['page'];
			} else {
				$page = 1;
			}

			if ($pages > 1)
			{
				if($page == 1)
				{?>
					<li class="disabled">
						<a data-name="previous" href="javascript:void(0)">«</a>
					</li>
				<?}else{
					//$link = preg_replace("/(.+page=)(\d+)(.+)/", '{$1}'.($page-1).'{$3}', $_SERVER['REQUEST_URI']);?>
					<li>
						<a href="javascript:void(0)" onclick="NewPage(<?=($page-1)?>)" aria-label="Previous">
							<span aria-hidden="true">«</span>
						</a>
					</li>
				<?}
				for ($p = 1; $p < $pages + 1; $p++)
				{
					//$link = preg_replace("/(.+page=)(\d+)(.+)/", '{$1}'.$p.'{$3}', $_SERVER['REQUEST_URI']);
					$active = ($p == $page) ? 'active' : '';
					
					if (abs($p-$page) <= 2)
					{?>					
						<li class='<?=$active?>'>
							<a href="javascript:void(0)" onclick="NewPage(<?=$p?>)"><?=$p?></a>
						</li>
					<?}
					elseif($p == 1 || $p == ceil($pages))
					{?>				
						<li>
							<a href="javascript:void(0)" onclick="NewPage(<?=$p?>)"><?=$p?></a>
						</li>
					<?}
				}

				if($page == ceil($pages))
				{?>		
					<li class="disabled">
						<a data-name="next" href="javascript:void(0)">»</a>
					</li>
				<?}else{
					//$link = preg_replace("/(.+page=)(\d+)(.+)/", '{$1}'.($page+1).'{$3}', $_SERVER['REQUEST_URI']);?>
					<li>
						<a data-name="next" href="javascript:void(0)" onclick="NewPage(<?=($page+1)?>)">»</a>
					</li>
				<?}		
			}?>
		</ul>
		<?/*if ($_SESSION['search_user_id'] != 'ngs'){?>
		<div class="btn-group medium" data-toggle="buttons" style="float: right;margin: 10px;">
			<!--<label data-id="view_type" class="btn btn-default <?if($_SESSION['post']['view_type'] == 'compact') echo 'active';?>">
				<input type="radio" name="view_type" form="main_search" value="compact" <?if($_SESSION['post']['view_type'] == 'compact' || !isset($_SESSION['post']['view_type'])) echo 'checked';?>>новый
			</label>-->
			<label data-id="view_type" class="btn btn-default <?if($_SESSION['post']['view_type'] == 'list' || !isset($_SESSION['post']['view_type'])) echo 'active';?>">
				<input type="radio" name="view_type" form="main_search" value="list" <?if($_SESSION['post']['view_type'] == 'list' || !isset($_SESSION['post']['view_type'])) echo 'checked';?>>списком
			</label>
			<label data-id="view_type" class="btn btn-default <?if($_SESSION['post']['view_type'] == 'map') echo 'active';?>">
				<input type="radio" name="view_type" form="main_search" value="map" <?if($_SESSION['post']['view_type'] == 'map') echo 'checked';?>>на карте
			</label>
		</div>
		<?}*/?>
		<a href="javascript:void(0)" class="btn btn-warning right" style="margin: 10px;padding: 3px;" onClick="SaveSearch()">Создать заявку</a>
	</div>
</div>