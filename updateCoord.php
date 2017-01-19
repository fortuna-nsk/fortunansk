<script src="js/jquery-2.1.3.js" type="text/javascript" charset="utf-8"></script>
<script src="http://api-maps.yandex.ru/2.0/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script src="js/yandex.js" type="text/javascript"></script>	
<script type="text/javascript">
	var id = "",
		coords="",
		metro_coords="",
		metro_name="",
		distanceToMetro="";
	$(function(){
		$("button").on("click", function(){
			getAddress();
		});
		setTimeout(function(){
			$("button").click();
		}, 1000);
	});
	
	function getAddress(){
		var span = $("span").first();
		id = $(span).data("id");
		address = $(span).text();
		getCoord(address);
		post($(span));
	};
	
	function post(span){
		setTimeout(function(){
			if(distanceToMetro != "" || address.match(/Новосибирск/) == null){
				jQuery.ajax({
					type: 'POST',
					url: location, 
					data: 'id=' + id +
						'&coords=' + coords +
						'&metro_coords=' + metro_coords +
						'&metro_name=' + metro_name +
						'&distanceToMetro=' + distanceToMetro,
					success: function(){},
					complete: function(html) { 
						$(span).remove();
						coords="";
						metro_coords="";
						metro_name="";
						distanceToMetro="";
						getAddress();
					}
				});
			}else{
				post($(span));
			}
		}, 100);
	};
</script>
<?		
	ini_set('date.timezone', 'Asia/Novosibirsk');
	ini_set('display_errors', 1);
	require_once 'application/includes/config.php';
	require_once 'application/includes/classes/db_class.php';
	mysql_connect($db_host,$db_user,$db_pass) or die("Невозможно подключится к БД");
	mysql_select_db($db_name);
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET NAMES utf8"); 
	mysql_query("SET TIME_ZONE='+7:00'");

	
	if(!$_POST){
		$res = mysql_query("SELECT `id`, `live_point`, `street`, `house` FROM re_var WHERE live_point != 'Кудряши' AND street != '' AND (house RLIKE '[0-9]+\/[0-9]' OR house RLIKE '[0-9]') 
and (coords is null or coords='') LIMIT 0,10000");
		for($j=0; $j<mysql_num_rows($res); ++$j) {
			$data[] = mysql_fetch_assoc($res);
		}
		$count = count($data);
		echo "<button>GO</button>";
		
		for($i=0; $i<$count; $i++){
			echo "<span data-id='".$data[$i]['id']."'>НСО, ".$data[$i]['live_point'].", ".$data[$i]['street']." д.".$data[$i]['house']."</span>";
		}
		
		// $res = mysql_query("select id, street, house from re_parse where live_point='Новосибирск' and street != '' AND street !='Новосибирск' and house!='0' and (dis='' or dis='0') ORDER BY id desc limit 100");
		// while($var = mysql_fetch_assoc($res)){
			// $dis_res = mysql_query("SELECT pp.dis, pp.street from re_pay_parse as pp, re_district as d, re_parse as p where p.street like replace('%0%', '0', pp.street) and pp.dis=d.name and p.id={$var['id']}");
			// $dis_street = mysql_fetch_assoc($dis_res);
			// if($dis_street['street']!="" && $dis_street['dis']!=""){
				// mysql_query("Update re_parse set dis='{$dis_street['dis']}', street='{$dis_street['street']}' where id={$var['id']}");
			// }
		// }
		
		// $res = mysql_query("SELECT id, street, house from re_pay_parse where dis='' and live_point='Новосибирск' AND street!='' AND house!='' AND street!='Краснообск'");
		// while($var = mysql_fetch_assoc($res)){
			// $dis_res = mysql_query("SELECT dis from re_parse where street='{$var['street']}' and house='{$var['house']}' and dis!='' limit 1");
			// $dis = mysql_fetch_assoc($dis_res)['dis'];
			// if($dis!=""){
				// mysql_query("Update re_pay_parse set dis='{$dis}' where id={$var['id']}");
			// }
		// }
		
		if(intval(date("H")==4) && intval(date("i")<=30)){
			if ($objs = glob("/var/session/*")){
				foreach($objs as $obj) {
					unlink($obj);
				}
			}
			mysql_query("TRUNCATE re_session");
		}
	
	}else{
		mysql_query("UPDATE re_var SET coords='".$_POST['coords']."', metro_coords='".$_POST['metro_coords']."', metro_name='".$_POST['metro_name']."', distance_to_metro='".$_POST['distanceToMetro']."' WHERE `id`=".$_POST['id']);
	}
?>