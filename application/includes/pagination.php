<div class="row">
	<div class="col-xs-12 pagination_row">
		<div class="col-xs-4">
		<?php
		if(!isset($_SESSION['limit'])){
			$sessionLimit = 50;
		}else{
			$sessionLimit = $_SESSION['limit'];
		}
		/*print_r($_SESSION);	
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		parse_str($_SERVER['QUERY_STRING'], $get_array);
		$url = $_SERVER['PHP_SELF'].'?';
		foreach($get_array as $key => $value)
		{	
			if($key!='page')
			{
			$url = $url.$key.'='.$value.'&';	
			}
		};
		print_r(array_keys ($get_array));
		echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		$_SERVER['QUERY_STRING']	*/
		?>
			<div class="input-group interval xl">
				<span class="input-group-addon"><?echo $data[0]['count'];?> вариантов</span>	
				<select type="text"  class="form-control" name="limit" id="limit">
					<?if( !isset($_SESSION['post']['view_type'])  ||  $_SESSION['post']['view_type']!= "map"){?>
					<option value="50" <?php if($sessionLimit == 50 OR !$sessionLimit) echo "selected"; ?> >по 50</option>
					<option value="100" <?php if($sessionLimit == 100) echo "selected"; ?>  >по 100</option>
					<option value="200" <?php if($sessionLimit == 200) echo "selected"; ?> >по 200</option>	
					<?}else{						
						echo "<option value='50' selected>по 50</option>";
					}?>
				</select>
			</div>	
		</div>
		<ul class="pagination pagination-sm">

		<?
		if ($sessionLimit){
			$limit = $sessionLimit;
		} else {
			$limit = 50;
		}
		$pages = $data[0]['count']/$limit;

		if (isset($_GET['page'])){
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		if ($pages > 1)
			{
				if($page == 1)
				{
					echo '<li class="disabled">
							<a data-name="previous" href="javascript:void(0)">«</a>
						</li>';
				}else{
					echo '<li>
							<a data-name="previous" href="javascript:void(0)" onclick="changePage('.($page - 1).')">«</a>
						</li>';
				}

				for ($p = 1; $p < $pages + 1; $p++)
				{
					$active = ($p == $page) ? 'active' : '';
					
					if (abs($p-$page) <= 2)
					{						
						echo '<li data-id='.$p.' class='.$active.'>
								<a href="javascript:void(0)" onclick="changePage('.$p.')">'.$p.'</a>
							</li>';
					}
					elseif($p == 1 || $p == ceil($pages))
					{					
						echo '<li data-id='.$p.'>
								<a href="javascript:void(0)" onclick="changePage('.$p.')">'.$p.'</a>
							</li>';
					}
				}

				if($page == ceil($pages))
				{			
					echo '<li class="disabled">
							<a data-name="next" href="javascript:void(0)">»</a>
						</li>';
				}else{
					echo '<li>
							<a data-name="next" href="javascript:void(0)" onclick="changePage('.($page + 1).')">»</a>
						</li>';
				}		
			}			
		?>
		</ul>
		<?if ($_SESSION['search_user_id'] != 'ngs'){
			$view_type = Helper::FilterVal('view_type');?>
			<div class="btn-group medium" data-toggle="buttons" style="float: right;margin: 10px;">
				<label data-id="view_type" class="btn btn-default <?if($view_type  == 'list' || !$view_type) echo 'active';?>">
					<input type="radio" name="view_type" form="main_search" value="list" <?if($view_type || !$view_type) echo 'checked';?>>списком
				</label>
				<label data-id="view_type" class="btn btn-default <?if($view_type  == 'map') echo 'active';?>">
					<input type="radio" name="view_type" form="main_search" value="map" <?if($view_type == 'map') echo 'checked';?>>на карте
				</label>
			</div>
		<?unset($view_type);
		}?>
		<a href="javascript:void(0)" class="btn btn-warning right" style="margin: 10px;padding: 3px;" onClick="SaveSearch()">Создать заявку</a>
	</div>
</div>