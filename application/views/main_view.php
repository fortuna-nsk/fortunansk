<?if ($data[0]['count'] > 0){

	if($_GET["action"]!="pay_parse"){
		include 'application/includes/pagination.php';
	}else{
		include 'application/includes/pagination_pay_parse.php';
	}
		
	/*if($_GET["action"]=="pay_parse"){
		echo "<div style='padding: 10px;'>В данный момент ведутся работы над предоставлением вариантов по 'Коттеджи - дома' в разделе 'частниках 2'</div>";
	}*/
	echo "<div class='row products-list' style='margin-bottom: -45px;' data-topic='".(isset($_GET['topic_id']) ? $_GET['topic_id'] : "")."' data-parent='".(isset($_GET['parent_id']) ? $_GET['parent_id'] : "")."'>";	
	if(Helper::FilterVal('view_type') == "map"){
		echo "<script src='js/yandex.js' type='text/javascript'></script>
			<div id='map' style='width: 100%; height: 500px;'></div>";
		$num = count($data);
		$str="";		
		for ($mc=0; $mc<$num; $mc++){
			$str.=$data[$mc]['coords'].",".$data[$mc]['id'].";";
		}		
		echo "<input type='hidden' data-id='coords' value='".$str."'>";
		unset($mc, $str, $num);
	}else if(Helper::FilterVal('view_type') == "compact"){
		include "application/includes/product.php";	
		echo "<script src='js/yandex.js' type='text/javascript'></script>";
		echo Helper::Modal_win_find_address();
		echo Helper::Modal_win_clean();
		echo Helper::Modal_win_send_review();
		echo Helper::Modal_win_add_to_black_list();
	}else if($_GET['action']!="pay_parse" &&   $_GET['table']!="pay_parse"){
		//!!!!!!!!!!!!!!!!!!!!!!!
		echo "<div class='row col-xs-12' style='color: rgb(205, 24, 24);font-weight: bold;'>";		
		echo DB::Select("text", "re_messages", "spec_recipient='all' ORDER BY date_send DESC limit 1")[0]['text'];
		echo "</div>";
		include "application/includes/product_compact.php";	
		echo "<script src='js/yandex.js' type='text/javascript'></script>";
		echo Helper::Modal_win_find_address();
		echo Helper::Modal_win_clean();
		echo Helper::Modal_win_send_review();
		echo Helper::Modal_win_add_to_black_list();
	}else{
		echo "<div class='row col-xs-12' style='color: rgb(205, 24, 24);font-weight: bold;'>";		
			$reMessagesText = DB::Select("text", "re_messages", "spec_recipient='all' ORDER BY date_send DESC limit 1");
		if(isset($reMessagesText[0]['text'])) echo $reMessagesText[0]['text'];
		echo "</div>";
		include "application/includes/product_pay_parse.php";
		echo "<script src='js/yandex.js' type='text/javascript'></script>";
		echo Helper::Modal_win_find_address();
		echo Helper::Modal_win_clean();
		echo Helper::Modal_win_send_review();
		echo Helper::Modal_win_add_to_black_list();
	}
	echo "</div><div id='spacer' class='spacer-bottom'></div>";
	
	if($_GET["action"]!="pay_parse"){
		include 'application/includes/pagination.php';
	}else{
		include 'application/includes/pagination_pay_parse.php';
	}
	
}else if(($_SESSION["tariff_id"] != '1' OR ($_SESSION['topic_id'] != '1' && $_SESSION['topic_id'] != '3')) AND (date("Y-m-d", strtotime($_SESSION['sell_date_end'])) > date("Y-m-d") OR ($_SESSION['topic_id'] != '2' && $_SESSION['topic_id'] != '4')) OR $_SESSION['search_user_id'] == "site"){
	echo "<div class='row center products-list'><span>По данным параметрам вариантов не найдено. Попробуйте увеличить радиус поиска.</span></div>";
}else if($_SESSION["tariff_id"] != '1' OR ($_SESSION['topic_id'] != '1' && $_SESSION['topic_id'] != '3')){
	echo "<div class='row center products-list'><span>По вашему тарифу доступ к частникам по продаже закрыт. Доступ можно получить, оплатив его в личном кобинете АН у директора.</span></div>";
}else{
	echo "<div class='row center products-list'><span>По вашему тарифу доступ к частникам по аренде закрыт.</span></div>";
}

//echo print_r(new DateTime()->format('YY-mm-dd H:m'));
?>


