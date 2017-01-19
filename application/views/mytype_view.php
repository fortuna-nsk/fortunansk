<script type="text/javascript">
	$(function(){
		var reviewCount = $(".hasReview").length;
		ReviewCountShow(reviewCount);
		$(".hasReview").on("click", function(){
			if(reviewCount < $(".hasReview").length){
				reviewCount = $(".hasReview").length;
				ReviewCountShow(reviewCount);
			}
		});
		if(QueryString("active")==0){
			var colCount = $(".dateCol").length;
			ColCountShow(colCount);
			$(".dateCol").on("click", function(){
				if(colCount < $(".dateCol").length){
					colCount = $(".dateCol").length;
					ColCountShow(colCount);
				}
			});
		}
	})
	
	function ReviewCountShow(count){
		if(count>0){
			var id = $(".hasReview").attr("id");
			$(".btn-group-justified.count label.active").append("<span class='badge' style='background-color: #E81010;' title='колличество вариантов с отзывами'>"+count+"</span>");
			if(confirm("У Вас есть отзыв на вариант. Показать данный вариант?")){
				$('html,body').stop().animate({	scrollTop: $("#"+id+"").offset().top-100}, 1000);
			}
		}
	}
	
	function ColCountShow(count){
		if(count>0){
			var id = $(".dateCol").attr("id");
			$(".btn-group-justified.count label.active").append("<span class='badge' data-id='date_col' style='background-color: #0F919E;' title='колличество вариантов для прозвона'>"+count+"</span>");
			if(confirm("У Вас есть вариант требуемый прозвона. Показать данный вариант?")){
				$('html,body').stop().animate({	scrollTop: $("#"+id+"").offset().top-100}, 1000);
			}
		}
	}
</script>

<?php
	if($_GET["action"] != "recipients"){
		include_once 'application/includes/search.php';
	}
	include_once "application/includes/filters/my_type_buttons.php";
	if (isset($data[0]["topic_id"])){
		if($_GET["active"] == 1){
			$title = "МОИ ОБЪЕКТЫ, АКТИВНЫЕ ПО АРЕНДЕ: ";
		}else if($_GET["action"] == "favorites"){
			$title = "МОИ ОБЪЕКТЫ, ИЗБРАННЫЕ ПО АРЕНДЕ: ";
		}else{
			$title = "МОИ ОБЪЕКТЫ, АРХИВНЫЕ ПО АРЕНДЕ: ";			
		}
		switch ($_GET["parent_id"]){
			case "all":
				$title .= "ВСЕ-ОБЩИЙ СПИСОК";
				break;
			case "1":
				$title .= "КВАРТИРЫ";
				break;
			case "18":
				$title .= "КОМНАТЫ";
				break;
			case "2":
				$title .= "НОВОСТРОЙКИ";
				break;
			case "3":
				$title .= "КОТТЕДЖИ-ДОМА";
				break;
			case "4":
				$title .= "ДАЧИ";
				break;
			case "5":
				$title .= "ГАРАЖИ/ПАРКОВКИ";
				break;
			case "6":
				$title .= "КОММЕРЧЕСКАЯ";
				break;
			case "7":
				$title .= "ЗЕМЛЯ";
				break;
		}
	
	?>

		<div class="row products-list">		
			<h4 class="center" style="margin-bottom: 30px;">
				<?php
				echo $title;				
				/*if($_GET["action"] == "favorites"){?>
					<div class="col-xs-1 deployed right" style="text-align: left;">
						<button type="button" onclick="SendFavoritesToEmail()" style="" class="btn btn-success btn-xs ">Отправить</button>
					</div>
					<div class="col-xs-2 deployed right" style="text-align: left;">
						<label class="signature">Отправить подборку на</label>
						<input class="form-control" data-name="email_for_favor" placeholder="email">
					</div>
				<?}*/?>
			</h4>
			<?if($_GET['action'] == "mytype" && $_GET['active'] == 1){?>
				<div class="col-xs-12" data-id="control-buttons" style="position: absolute;z-index: 2;margin-top: -60px;">
					<div class="checkbox" style="display: inline-block;">
						<label>
							<input data-id="checkAll" type="checkbox" value="">		
							Выделить все
						</label>
					</div>				
					<button type="button" onclick="VarExtend('checked')" style="display:none" class="btn btn-default btn-xs extend">Продлить</button>
					<br />
					<?/*if($_SESSION['for_open_site']!=0 && isset($_SESSION['for_open_site'])){?>
						<div class="checkbox" style="display: inline-block;    color: #9C1515;">
							<label>
								<input data-id="for_open_site" data-user="<?=$_SESSION['user']?>" type="checkbox" value="1" <?if($_SESSION['for_open_site']==1)echo "checked";?>>
								Хочу, чтобы все мои активные варианты с фото рекламировались на сайте <a href="http://sibkv.ru" target="_blank">SIBKV.RU</a> для привлечения потенциальных клиентов.
							</label>
						</div>
					<?}*/?>
					<!--<button type="button" style="display:none" class="btn btn-default btn-xs archive">В архив</button>
					<button type="button" onClick="DeleteVar('checked')" style="display:none" class="btn btn-default btn-xs delete">Удалить</button>-->
				</div>
			<?} 
			if($_GET['action']!="favorites_pay_parse"){
				include "application/includes/product_compact.php";
			}else if($_SESSION["pay_parse_date_end"] > date("Y-m-d")){
				include "application/includes/product_pay_parse.php";
			}else{
				if($_SESSION['parent']==0){
					echo "<div class='row center products-list'><span>Ваша оплата данного раздела закончилась. Вам необходимо продлить 'частники 2' <a href='?task=profile&action=services'>в личном кабинете</a>.</span></div>";
				}else{
					echo "<div class='row center products-list'><span>Ваша оплата данного раздела закончилась. Вам необходимо продлить 'частники 2' в личном кабинете директора.</span></div>";
				}
			}
			?>
		</div>
<?php }else{
		if($_GET["action"] != "recipients"){
		echo '<div id="row">
				<p>У вас пока, что не иммется вариантов данного типа.</p>
			</div>';
		}else{
			include "application/includes/recipients.php";
		}
	}
	echo "<script src='js/yandex.js' type='text/javascript'></script>";
	echo Helper::Modal_win_find_address();
	echo Helper::Modal_win_clean();
	echo Helper::Modal_win_send_review();
	echo Helper::Modal_win_add_to_black_list();
?>



		