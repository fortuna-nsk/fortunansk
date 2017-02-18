<?php
class Controller_Login extends Controller
{
	
	function action_enter()
	{

		if(isset($_POST['login']) && isset($_POST['password']))
		{
			unset($data, $login, $password, $_SESSION);
			session_destroy();
			$login = $_POST['login'];
			$password = $_POST['password'];
			$date = date("Y-m-d H:i:s");
			$ip = $_SERVER['REMOTE_ADDR'];
			$browser = $_SERVER['HTTP_USER_AGENT'];			
			$date_block_to = date("Y-m-d H:i:s", strtotime($date." +30 minutes"));
			// $count_try_enter = "count_try_enter = count_try_enter + 1";
			/*поиск неудачных попыток входа с данного IP*/
			$statistic = mysql_fetch_assoc(mysql_query("SELECT * FROM re_enter_statistics WHERE ip = '".$ip."' AND enter_success = 0 ORDER BY id DESC LIMIT 0, 1"));
			$date_block = date("Y-m-d H:i:s", strtotime($statistic["date_block_to"]));
			
			$tf = true;
			/*добавление в статистику попытки входа если таковой нет*/
			if($statistic["id"] == ""){
				mysql_query("INSERT INTO re_enter_statistics (login, ip, browser, date_enter) VALUES ('".$login."', '".$ip."', '".$browser."', '".$date."')");
				$statistic = mysql_fetch_assoc(mysql_query("SELECT * FROM re_enter_statistics WHERE ip = '".$ip."' AND enter_success = 0 ORDER BY id DESC LIMIT 0, 1"));
			}else if($date > $date_block){
				/*проверка на количесво попыток входа за последнии 10 минут и дальнейшая блокировка, вслучае привышения разрешенного количества*/
					if(intval($statistic["count_try_enter"])<15){
						if($date > date("Y-m-d H:i:s", strtotime($statistic["date_enter"]." +10 minutes"))){
							mysql_query("UPDATE re_enter_statistics SET count_try_enter = 1, date_enter='".$date."' WHERE id=".$statistic["id"]);
						}else{
							mysql_query("UPDATE re_enter_statistics SET count_try_enter = count_try_enter + 1 WHERE id=".$statistic["id"]);
						}
					}else{
						mysql_query("UPDATE re_enter_statistics SET count_try_enter = 0, date_block_to='".$date_block_to."' WHERE id=".$statistic["id"]);
						$data = "Вы заблокированы на 30 минут.";
						$tf = false;
					}
			}else{
				$data = "Вы заблокированы до ".date("d.m.Y H:i", strtotime($date_block." -1 hour"));
				$tf = false;
			}
			unset($date_block_to, $date_block);
			if($tf){
				
				$query = "SELECT * FROM re_user INNER JOIN re_people ON re_user.people_id = re_people.id INNER JOIN re_company ON re_people.company_id = re_company.id INNER JOIN re_access_date_end ON re_access_date_end.company_id = re_company.id where ((`login` = '". $login ."') AND (`password` = '". $password ."')) AND active = '1' AND archive = '0'";
				$res_q = mysql_query($query);
				unset($login, $password, $query);				
				/*
				Производим аутентификацию
				*/
				if(mysql_num_rows($res_q) == 1)
				{
					/*проверка на наличие сессии*/
					$row_q = mysql_fetch_assoc($res_q);					
					//$session = mysql_fetch_assoc(mysql_query("SELECT * FROM re_session WHERE people_id = '".$row_q["people_id"]."' ORDER BY date_start DESC LIMIT 1"));
					
					/*если сессии нет осуществляется вход на сайт*/
					//if($date > date("Y-m-d H:i:s", strtotime($session["date_start"]." +30 minutes")) || $session["id"] == null || session_id() == $session["name"] || $row_q['admin'] == 1){
					if(true){
						$queryDouble = "SELECT name  FROM re_session WHERE people_id = '{$row_q['people_id']}' ";
						mysql_query("DELETE FROM re_session WHERE people_id={$row_q['people_id']}");
						if($row_q['admin'] == 0){
							if((intval($row_q['group_topic_id']) == 1 && date("Y-m-d", strtotime($row_q["rent_date_end"])) < date("Y-m-d"))){
								$row_q["group_topic_id"] = 0;
							}else if(intval($row_q['group_topic_id'])== 3){
								//if(date("Y-m-d", strtotime($row_q["rent_date_end"])) < $date){							
								//	$row_q["group_topic_id"]= 2;
								//}
								// if(date("Y-m-d", strtotime($row_q["sell_date_end"])) < $date){
									// $row_q["group_topic_id"]= intval($row_q['group_topic_id'])-2;
								// }
							}
							if(intval($row_q['group_topic_id'])==0){
								if($row_q['parent'] > 0){
									$data = "У Вас кончился доступ, обратитесь к директору вашего АН.";
								}else if($row_q['company_id'] && $row_q['user_id'] && $row_q['people_id']){
									session_start();
									
									$_SESSION['company_id'] = $row_q['company_id'];
									$_SESSION['group_topic_id'] = 0;
									$_SESSION["order_access"] = $row_q['order_access'];
									$_SESSION["parent"] = 0;
									$data[0] = "ex_of_acc";
									$data[1] = $row_q['company_name'];
									$data['balance'] = $row_q['balance'];
									$data['duty'] = $row_q['duty'];
									$data['subscription'] = $row_q['subscription'];
									mysql_query("UPDATE re_enter_statistics SET enter_success='1', date_enter='".$date."', browser='".$browser."', ip='".$ip."', people_id='".$row_q["people_id"]."' WHERE id=".$statistic["id"]);
								}
								$tf=false;
							}else if (intval($row_q['group_topic_id']) > 0){
								$rs = array(
									1 => "rent",
									2 => "sell",
									3 => "rent"
								);
								$access_ip = mysql_query("SELECT ip FROM re_addresses WHERE people_id = '".$row_q["people_id"]."' AND active = 1 AND archive = 0");
								$num = mysql_num_rows($access_ip);
								$x=0;
								for($i=0; $i<$num; $i++){
									$ip_temp = mysql_fetch_assoc($access_ip)["ip"];
									if($ip_temp!=""){
										if(preg_match('/^'.$ip_temp.'/', $ip) || $ip_temp=='1'){
											$tf=true;
											$x=1;
										}
									}
								}
								if ($x==0){
									mysql_query("UPDATE re_enter_statistics SET enter_success='1', date_enter='".$date."', browser='".$browser."', ip='".$ip."', people_id='".$row_q["people_id"]."' WHERE id=".$statistic["id"]);
									$tf=false;
									$data = "Ваш ip-адресс не совпадает с заявленым.";
								}
								unset($num, $x, $access_ip, $i, $ip_temp, $x, $rs);
							}
						}
						$res_q = mysql_query($queryDouble);
							if(mysql_num_rows($res_q) > 0){
								$tf=false;
								$sessionDir = '/var/www/fortuna/sessions/';
								while ($rowSessionName = mysql_fetch_array($res_q)){ 
									mysql_query("DELETE FROM re_session WHERE people_id={$row_q['people_id']}");
									@unlink($sessionDir.'sess_'.$rowSessionName['name']);
									//$data = "DELETE re_session WHERE people_id={$row_q['people_id']}";
								}
							}
						$premium_count = mysql_fetch_assoc(mysql_query("select sum(premium_count) as premuim_count from re_payment where company_id = '".$row_q['company_id']."' and premium_count>0 and active=1 and date_finish <= NOW()"))["premuim_count"];
						if(intval($premium_count)>0){
							mysql_query("UPDATE re_company SET rent_premium = `rent_premium`-".$premium_count." WHERE id= '".$row_q['company_id']."'");
							unset($premium_count);
							mysql_query("UPDATE re_payment SET active=0 WHERE company_id = '".$row_q['company_id']."' and premium_count>0 and active=1 and date_finish <= NOW()");
							
							$active_rent_premium = mysql_fetch_assoc(mysql_query("SELECT rent_premium from re_company where id = '".$row_q['company_id']."'"))["rent_premium"];
							
							$ids_for_update = mysql_query("select v.id from re_var as v INNER JOIN re_user as u ON u.user_id=v.user_id INNER JOIN re_people as p ON p.id=u.people_id where p.company_id=".$row_q['company_id']." and v.premium=1 ORDER BY v.date_last_edit DESC limit ".intval($active_rent_premium).", 999");
							unset($active_rent_premium);
							$id_str = "";
							while($id = mysql_fetch_assoc($ids_for_update))
							{
								$id_str .= " id=".$id["id"]." OR";
							}
							if($id_str!=""){
								$id_str = substr($id_str, 0, -2);
								mysql_query("UPDATE re_var SET premium=0 WHERE".$id_str);
							}
							unset($id_str, $ids_for_update);
						}
						if($tf){
							$data = "Успешный вход.";
							session_start();
							$_SESSION['user'] = $row_q['user_id'];
							$_SESSION['login'] = $row_q['login'];
							$_SESSION['people_id'] = $row_q['people_id'];
							$_SESSION['group_id'] = $row_q['group_id'];
							$_SESSION['fio'] = $row_q['surname']." ".$row_q['name']." ".$row_q['second_name'];
							$_SESSION['io'] = $row_q['name']." ".$row_q['second_name'];
							$_SESSION['email'] = $row_q['email'];
							$_SESSION['phone'] = $row_q['phone'];
							$_SESSION['phone_addon'] = $row_q['phone_addon'];
							$_SESSION['company_id'] = $row_q['company_id'];
							$_SESSION['company_name'] = $row_q['company_name'];
							$_SESSION['date_company_reg'] = $row_q['date_company_reg'];
							$_SESSION['pass'] = $row_q['password'];
							$_SESSION['parent'] = $row_q['parent'];
							$_SESSION['order_access'] = $row_q['order_access'];
							$_SESSION['site'] = $row_q['site'];
							$_SESSION['group_topic_id'] = $row_q['group_topic_id'];
							$_SESSION['admin'] = $row_q['admin'];			
							$_SESSION['start_time'] = $date;
							$_SESSION['tariff_id'] = $row_q['tariff_id'];
							$_SESSION['sell_date_end'] = $row_q["sell_date_end"];
							$_SESSION['rent_date_end'] = $row_q["rent_date_end"];
							$_SESSION['pay_parse_date_end'] = $row_q["pay_parse_date_end"];
							$_SESSION['show_message'] = 1;
							$_SESSION['access_var'] = $row_q["access_var"];
							$_SESSION['block_com_an'] = $row_q["block_com_an"];
							$_SESSION['block_com_parse'] = $row_q["block_com_parse"];
							$_SESSION['block_forum'] = $row_q["block_forum"];
							$_SESSION['block_chat'] = $row_q["block_chat"];
							$_SESSION['nickname'] = $row_q["nickname"];
							$_SESSION['email_work'] = $row_q["email_work"];
							$_SESSION['email_pass'] = $row_q["email_pass"];
							$_SESSION['save_search_limit'] = $row_q["save_search_limit"];
							//$_SESSION['address_rent'] = $row_q['ip_rent']."||".$row_q['street_rent']."||".$row_q['house_rent']."||".$row_q['office_rent']."||".$row_q['comment_rent'];
							//$_SESSION['address_sell'] = $row_q['ip_sell']."||".$row_q['street_sell']."||".$row_q['house_sell']."||".$row_q['office_sell']."||".$row_q['comment_sell'];
							
							mysql_query("UPDATE re_enter_statistics SET enter_success='1', date_enter='".$date."', browser='".$browser."', ip='".$ip."', people_id='".$_SESSION["people_id"]."' WHERE id=".$statistic["id"]);
							mysql_query("DELETE FROM re_session WHERE people_id = ".$row_q['people_id']);
							mysql_query("INSERT INTO re_session (people_id, name, date_start) VALUE(".$row_q['people_id'].", '".session_id()."', '".$date."')");


							if($_SESSION["admin"]==1){
								header('Location: /?task=admin&action=order');
							}else{
								header('Location: /?task=main&action=index&parent_id=1&topic_id=1');
							}
							unset($row_q, $date, $browser, $ip, $statistic, $tf, $session);		
						}
					}else{
						$data = "Риелтер в данный момент на сайте. Вы не можете зайти под введенными данными пока он не закончит работу!";
					}
				} else {
					$data = "Неправильное имя пользователя или пароль.";
				}				
			}
		}
		// else{
			// $data = "Введите данные для входа или восстановите пароль.";
		// }
		$this->view->generate('login_view.php', 'template_view.php', $data);
	}
	
	function action_logout()
	{
		if($_SESSION['user']) {
			mysql_query("DELETE FROM re_session WHERE people_id = ".$_SESSION['people_id']);
			session_destroy();
			header('Location: /');
		} else {
			header('Location: /');
		}
		
		$this->view->generate('login_view.php', 'template_view.php');
	}
	
	function action_login_back()
	{
		if($_POST['login']) {
			mysql_set_charset( 'utf8' );
			$query = "SELECT `email` FROM `re_user` where (`login` = '". $_POST['login'] ."')";
				$res = mysql_query($query);
				if ((mysql_num_rows($res) == 1) AND ($res)) {
					$row_q = mysql_fetch_array($res);
					$email = $row_q['email'];
					
$to  = $email .", " ; 
//$to .= ""; 

$subject = "Восстановление пароля для сайта Arendanovosib.ru"; 

$message = ' 
<html> 
    <head> 
        <title>Восстановление пароля для сайта Arendanovosib.ru</title> 
    </head> 
    <body> 
        <p>
		Здравствуйте логин, <br />
		'. $_POST['login'] . ' <br />
		ваш новый пароль: ' . md5($_POST['login']) .'<br />
		Желаем удачи в далнейшей работе с сайтом.
		</p> 
    </body> 
</html>'; 

$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
$headers .= "From: Arendanovosib.ru <arendanovosib@mail.ru>\r\n"; 

$mailto = mail($to, $subject, $message, $headers); 
					if ($mailto) {
						echo "<p>Новый пароль отправлен вам на почту</p>";
					} else {
						echo "<p>Произошла ошибка.</p>";
					}
	$query2 = "UPDATE `re_user` set `password` = '". md5($_POST['login']) ."' where (`login` = '". $_POST['login'] ."')";
	mysql_query($query2);
				}
		} else {
			echo "<p>повторите попытку</p>";
		}
	}
	
}
