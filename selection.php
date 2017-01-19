<?
ini_set('date.timezone', 'Asia/Novosibirsk');
ini_set('display_errors', 0);
require_once 'application/includes/config.php';
require_once 'application/includes/classes/db_class.php';
mysql_connect($db_host,$db_user,$db_pass) or die("Невозможно подключится к БД");
mysql_select_db($db_name);
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET NAMES utf8"); 
mysql_query("SET TIME_ZONE='+7:00'");

if(isset($_POST["login"]) && isset($_POST["password"])){
	$login = $_POST["login"];
	$pass = $_POST["password"];
	unset ($_POST);
}
if(isset($login) && isset($pass)){
	$text = DB::Select("text", "re_recipients_list", "DATE_ADD(date, INTERVAL 24 HOUR) >= NOW() AND address='".$login."' AND pass='".$pass."' AND type=1")[0]["text"];
	if($text != ""){
		$ids = explode(",", $text);
		$count = count($ids);
		$condition = "";
		for($i=0; $i<$count; $i++){
			if($count == 1){
				$condition = "v.id=".$ids[$i];
			}else if($i == 0){
				$condition.= "(v.id = ".$ids[$i];
			}else if($i == ($count-1)){
				$condition.= " OR v.id = ".$ids[$i].")";
			}else{
				$condition.= " OR v.id = ".$ids[$i];
			}
		}
		if($count > 0){
			$data = DB::Select("v.id, v.live_point, v.dis, v.street, v.type_id, v.parent_id, v.room_count, v.planning, v.ap_layout, v.price, p.people_id, GROUP_CONCAT(p.photo) as photos" , "re_var as v, re_photos as p", "v.id = p.var_id AND ".$condition." AND v.active=1 GROUP BY v.id");
		}
	}else{
		unset($login, $pass);
		$data["error"] = "Время жизни ссылки истекло или Вы ввели неправильные регистрационные данные. Обратитесь к вашему риелтору.";
	}
	unset($count, $condition, $ids, $text, $i);
}

function Helper($type_id, $parent_id, $room_count, $planning, $ap_layout){
	if($type_id >= 19 && $type_id <= 24){
			$type_name = ($type_id-18) ."-комнатная";
		}else if($type_id == 0){
			$type_name = $room_count."-комнатная";
		}else if($type_id > 24){
			$type_name = DB::Select("`name`", "re_type_object", "`id`='".$type_id."'")[0]['name'];
			if($type_id > 24 && $type_id < 30 && $room_count >0){
				$type_name.="/".$room_count." ком.";
			}
		}	
		if($type_id != 18){
			switch($parent_id) {
				case '1':
					$parent_name = "квартира";
					break;
				case '2':
					$parent_name = "новостройка";
					break;		
				case '3':
					$parent_name = "раздел (коттеджи/дома)";
					break;
				case '4':
					$parent_name = "дача";
					break;
				case '5':
					$parent_name = "земля";
					break;
				case '6':
					$parent_name = "гараж";
					break;		
				case '7':
					$parent_name = "раздел (коммерческая)";
					break;			
				case '18':
					$parent_name = "комната";
					break;
			}
		}else{
			$parent_name = "комната";			
		}
		
		if($parent_id == 6){
			if($type_name == "Капитальный" || $type_name == "Металлический"){
				$ap_layout.=" гараж";
			}
		}
		if($parent_name != "квартира" && $parent_name != "новостройка"){
			$title = strtolower($type_name).($parent_name == "комната" ? ", " : " ").strtolower($ap_layout);
		}else{
			$title = strtolower($type_name).", ".strtolower($planning);
		}
		return str_replace("комнату", "комната", $title);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1">		
		<title>Fortunasib</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />		
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />		
		<link rel="stylesheet" href="/css/alertify.core.css">
		<link rel="stylesheet" href="/css/alertify.default.css">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="js/jquery-2.1.3.js" type="text/javascript" charset="utf-8"></script>
		<script src="/js/alertify.js" type="text/javascript"></script>
		<!-- Add fancyBox main JS and CSS files -->
		<script type="text/javascript" src="fancyBox/source/jquery.fancybox.js?v=2.1.5"> </script>
		<link rel="stylesheet" type="text/css" href="fancyBox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
		<!-- Add Thumbnail helper (this is optional) -->
		<link rel="stylesheet" type="text/css" href="fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
		<script type="text/javascript" src="fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	</head>
	<style>
		.info{
			width: 30%;
			position: absolute;
			top: 20%;
			display: inline-block;
			left: 35%;
		}
			.info input{
				margin: 5%;
				width: 90%;
				height: 40px;
			}
		.product-image{
			margin: 20px;
			border: 1px solid #ccc;
			padding: 10px;
			border-radius: 10px;
			width: 220px;
			height: 300px;
			cursor:pointer;
		}
			.product-image span{
				display: inline-block;
				margin: 10px 0px 0;
			}
		.product-image:hover{
			-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #9dce51;
			box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #9dce51;
		}
	</style>
	<script type="text/javascript">
		$(function(){
			$("body").contextmenu(function(){return false;});
			$('body').bind("mousedown", function(e){
				if(e.button == 2 || e.button == 1){
					e.preventDefault();
					return false;
				}
			});
			$('.fancybox-thumbs').fancybox({			
				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});
			
			alertify.set({ 
				labels: {
					ok     : "Ok",
					cancel : "Отмена"
				} 
			});
			if($("[data-name=error]").length > 0){
				var val = $("[data-name=error]").val();
				if(val != ""){
					alertify.alert(val);
				}
			};
			$(document).on("click", function(e){
				var obj = e.target;
				if(!$(obj).is(".fancybox-thumbs") && $(".product-image").find(obj).length > 0){
					$($(".product-image").has(obj).find(".fancybox-thumbs")[0]).click();
				}else if($(obj).is(".product-image")){
					$($(obj).find(".fancybox-thumbs")[0]).click();
				}
			});
			$(".fancybox-thumbs").on("click", function(){
				var obj = $(this),
					parent = $(obj).parent(),
					photosArr = $(obj).data("photos").split(',')
					dirsArr = $(obj).attr("href").split('/'),
					group = $(obj).data("fancybox-group"),
					result="";
				if($(parent).find("a").length == 1){
					$.each(photosArr, function(){
						result += "<a style='display:none' class='fancybox-thumbs'  data-fancybox-group='"+group+"'><img src='images/"+dirsArr[1]+"/"+dirsArr[2]+"/"+this+"' /></a>";
					});
					$(parent).append(result);
				}
			});
		})
	</script>
	<body style="display: flex;flex-direction: column; min-height: 100vh; margin: 0;">
		<div style="flex: 1;">
			<?if(!isset($login)){?>
				<div class="info">
					<form method="POST" action="selection.php">
						<legend class="center">Авторизация</legend>
						<input type="text" name="login" class="form-control" value="<?if(isset($_GET["login"])) echo $_GET["login"];?>" placeholder="Логин" required="" autocomplete="off">
						<input type="password" name="password" class="form-control" value="<?if(isset($_GET["pass"])) echo $_GET["pass"];?>" placeholder="Пароль" required="" autocomplete="off">
						<input type="submit" value="Войти" class="btn btn-success right">
					</form>
					<input type="hidden" data-name='error' value="<?if(isset($data["error"])) echo $data["error"];?>">
				</div>
			<?}else if(!isset($data["error"])){
				$count = count($data);
				for($i=0; $i<$count; $i++){
					$first_photo = explode("," ,$data[$i]["photos"])[0];
					$url = "images/".$data[$i]["people_id"]."/".$data[$i]["id"]."/".$first_photo;
					$photos = str_replace($first_photo.",", "", $data[$i]["photos"]);
					?>
					<div class="col-xs-2 product-image">			
						<a class="fancybox-thumbs pull-left" href="<?=$url;?>" data-fancybox-group="var<?=$i;?>" data-photos="<?=$photos;?>">
							<img class="media-object" alt="200x150" style="max-width: 200px; width: 200px; height:150px;" src="<?=$url;?>" />
						</a>
						<span>
							<?
							echo Helper($data[$i]["type_id"], $data[$i]["parent_id"], $data[$i]["room_count"], $data[$i]["planning"], $data[$i]["ap_layout"])."<br />";
							if($data[$i]["live_point"] == "Новосибирск" && $data[$i]["dis"] != ""){
								echo "район: ".$data[$i]["dis"]."<br / >улица: ".$data[$i]["street"]."<br / >цена: ".$data[$i]["price"];
							}else{
								echo "населенный пункт: ".$data[$i]["live_point"]."<br / >улица: ".$data[$i]["street"]."<br / >цена: ".$data[$i]["price"];
							}?>
						</span>
					</div>
			<?		unset($url, $photos, $first_photo);
				}
				unset($count, $i);
			}?>
		</div>	
		<div class="row footer" id="footer">
			<a href="/">fortunasib</a> &copy; 2008 - <?=date("Y");?></a>
		</div>
	</body>
</html>