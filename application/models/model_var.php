<?php

class Model_Var extends Model
{

	public function getBaseFhoto($var_id){

			$photosBase = DB::Select("photo", "re_photos as p", "p.var_id={$var_id} ");
			$freshPhoto = [];
			foreach ($photosBase as $photo) 
				$freshPhoto[]	=	$photo['photo'];
			

			return $freshPhoto;
	}

	public function checkPhotoLimit(){
				$photoLimitArray = DB::Select("photo_limit, photo_limit_used", "re_people", "people_id='{$_SESSION['people_id']}'" )[0];
				if(empty($photoLimitArray['photo_limit']) || $photoLimitArray['photo_limit']>=$photoLimitArray['photo_limit_used'])
					return true;
				return false;
	}

	private function smtpmail($to, $subject, $content, $host, $username, $password, $attaches=false)
	{
	  $__smtp = array(
	    "debug" => 0, 
	    "auth" => true,                
	    "port" => 465,                   
	    "secure"   => "ssl",
	    );

	    require_once('lib/phpmailer/class.smtp.php'); //путь до класса phpmailer
	    require_once('lib/phpmailer/class.phpmailer.php'); //путь до класса phpmailer
	    $mail = new PHPMailer(true);

	    $mail->IsSMTP();
	    try {
	      $mail->SMTPDebug  = $__smtp['debug'];
	      $mail->SMTPAuth   = $__smtp['auth'];
	      $mail->Port       = $__smtp['port'];
	      $mail->SMTPSecure = $__smtp['secure'];
	      $mail->Host       = $host;
	      $mail->Username   = $username;
	      $mail->Password   = $password;

	      $mail->AddReplyTo($username, $username);
	      $mail->AddAddress($to);                //кому письмо
	      $mail->SetFrom($username, $username); //от кого (желательно указывать свой реальный e-mail на используемом SMTP сервере
	      $mail->AddReplyTo($username, $username);
	      $mail->Subject = htmlspecialchars($subject);
	      $mail->MsgHTML($content);
	      $mail->CharSet = 'UTF-8';
	      foreach ($attaches as $attach) {
	        if($attach)  $mail->AddAttachment($attach); 
	      }
	      if($mail->Send()){
	       // echo "Message sent {$to} Ok!</p>\n";
	        return true;
	      }
	    } catch (phpmailerException $e) {
	      // echo $e->errorMessage();
	    } catch (Exception $e) {
	      //echo $e->getMessage();
	    }
	}


	private function createCatalog($var_id){
	  $queryObj = mysql_query("SELECT * FROM `re_var` WHERE `id` = {$var_id} ");
	  $obj = mysql_fetch_assoc($queryObj);
	  if($obj['user_id'] ==NULL){
	    return NULL;
	  }
	  $queryUser = mysql_query("SELECT * FROM `re_user` WHERE `user_id` = {$obj['user_id']} ");
	  $user = mysql_fetch_assoc($queryUser);
	  return $user['people_id']."/".$var_id;
	}

	private function createSubject($var_id){
	  $queryObj = mysql_query("SELECT * FROM `re_var` WHERE `id` = {$var_id} ");
	  $obj = mysql_fetch_assoc($queryObj);
	  return $obj['room_count']."-комнатная, " . $obj['planning']." на " . $obj['street'] . " за ". $obj['price'];
	}

	private function getServerHost($email){
	  $servers = [
	    'mail'    => 'smtp.mail.ru',
	    'bk'      => 'smtp.mail.ru',
	    'inbox'      => 'smtp.mail.ru',
	    'yandex'  => 'smtp.yandex.ru',
	    'ngs'     => 'smtp.ngs.ru',
	    'gmail'   => 'smtp.gmail.com',
	  ];

	    $host = explode(".", explode("@", $email)[1])[0]; 
	     return $servers[$host];
	  }



	public function get_data()
	{
		mysql_set_charset( 'utf8' );
		$data = array();
		if($_GET['id']){
			$table = $_GET['ngs'] ? "re_parse" : "re_var";
			$query = "SELECT * FROM ".$table." where `id` = '". $_GET['id'] ."'";
			$q_res = mysql_query($query);
			$data = mysql_fetch_assoc($q_res);
			$user_res = mysql_query("SELECT * FROM re_user where `user_id` = '".$data['user_id']."'");
			
			if ($table == "re_var"){
				if (count($user_res)==0){
					$user_res = mysql_query("SELECT * FROM re_user where `user_id` = '1'");
					}
				$user = mysql_fetch_assoc($user_res);
				
				$data['fio'] = $user['fio'];
				$data['phone'] = $user['phone'];
				$data['company_name'] = $user['company_name'];				
				$data['email'] = $user['email'];
			}else if($table == "re_parse"){					
				$data['fio'] = $data['contact_name'];
				$data['phone'] = $data['contact_tel'];
				$data['company_name'] = "ngs";				
				$data['email'] = $data['contact_email'];
			}
			
			
			$query_photo = "SELECT * FROM `re_photos` where `var_id` = '". $_GET['id'] ."'";		
			$q_res_photo = mysql_query($query_photo);		
			$num_photo = mysql_num_rows($q_res_photo);	
			
			for($i=0; $num_photo > $i; ++$i){
				$photo = mysql_fetch_assoc($q_res_photo);							
				$data['photo'][$i]['photo'] = $photo['photo'];
			}
		}else{
			$data = "Произошла ошибка! Вариант не найден.";			
		}
		
		return $data;
	}
	
	public function photo_list()
	{
		if($_POST['url']!="" && $_SESSION['user']){

			$dirArr = explode('/', $_POST['url']);
			$dir = $dirArr[0]."/".$dirArr[1]."/".$dirArr[2]."/";
			$openFile = $dirArr[3];
			$dh = opendir($dir);
			$resual = "";

			$photoLimitArray = DB::Select("photo_limit, photo_limit_used", "re_people", "id='{$_SESSION['people_id']}'" )[0];				
				//print_r($photoLimitArray);
			if(!empty($photoLimitArray['photo_limit']) && $photoLimitArray['photo_limit']<=$photoLimitArray['photo_limit_used']){
				echo  'over';
				return false;
			}		
			/*Helper::Session_date_update();/**/

			
			while ($file = readdir($dh)){
				/**
				 * Проверка на наличие файлов в каталоге и существование ссылок в базе, в случае вариантов от агентств
				 */
				if($file != "." && $file!=".." && $file!="main.jpg" && (in_array($file, Model_Var::getBaseFhoto($dirArr[2]) )|| $dirArr[1] == 'parse' )){
					$resual.= "/".$dir.$file.",";
				}
			}
			echo substr($resual, 0, -1);
			$date = date("Y-m-d H:i:s");
			if(isset($_SESSION['login'])){
				DB::Insert("re_photo_statistic", "login, ip, var_id, date", "'{$_SESSION['login']}', '{$_SERVER['REMOTE_ADDR']}', '{$dirArr[2]}', '{$date}'");
				$sessionDate = DB::Select("date_start", "re_session as s", "s.people_id={$_SESSION['people_id']}")[0];
				$cntPhotoAlredyGet = DB::Select("COUNT(statistic.var_id) as cnt","re_photo_statistic as statistic",  "statistic.login='{$_SESSION['login']}' AND statistic.var_id={$dirArr[2]} AND statistic.date >= '{$sessionDate['date_start']}' ")[0];
				if($cntPhotoAlredyGet['cnt'] == 1){
					$limitUsed = DB::Select("photo_limit_used", "re_people as p", "p.id={$_SESSION['people_id']}")[0];
					$limitUsedNew = $limitUsed['photo_limit_used']+1;
					DB::Update('re_people', "`photo_limit_used`='{$limitUsedNew}'", "id={$_SESSION['people_id']}");
				}
			}
			unset($dirArr, $dir, $openFile, $dh, $resual, $file);
		}
	}
	
	public function black_list_comments(){
		if(isset($_POST['people_id']) && isset($_SESSION['people_id'])){
			$black_list_comments = mysql_query("SELECT b.id, b.text, b.people_id, p.name, p.second_name FROM re_black_list AS b, re_people AS p WHERE p. id = '".$_POST['people_id']."' AND b.people_id = p.id AND b.owner_people_id='".$_SESSION['people_id']."'");
			$i=0;
			while($black = mysql_fetch_assoc($black_list_comments)){				
				if($i==0){
					$result .= "<legend data-id='".$black['people_id']."'>".$black["name"]." ".$black["second_name"]."<span class='btn btn-default' style='float: right;' onClick='DeleteBlackListComment(".$black['people_id'].", \"people\")'>амнистировать</span></legend>";
				}
				$result.="<div class='comment' data-id='".$black['id']."'><p style='word-wrap:break-word;padding: 5px;'><button type='button' class='close' onClick='DeleteBlackListComment(".$black['id'].", \"comment\")'><span aria-hidden='true'>×</span></button>".$black['text']."</p></div>";
				$i++;
			}
			echo $result;
			unset($black_list_comments, $result, $black, $i);
		}
	}
	
	public function add_to_black_list()
	{
		if(isset($_SESSION['people_id']) && isset($_POST['text']) && isset($_POST['black_agent']) && isset($_POST['people_id']))
		{
			if($_POST['black_agent'] == 0){
				DB::Update('re_people', 'in_black_list=1', '`id`='.$_POST['people_id']);
			}
			DB::Insert('re_black_list', 'people_id, text, owner_people_id', $_POST['people_id'].', "'.$_POST['text'].'", "'.$_SESSION["people_id"].'"');
			//DB::Delete("re_white_list", "people_id = {$_POST['people_id']} AND owner_people_id={$_SESSION["people_id"]}");
		}
	}
	
	public function delete_black_list_comment()
	{
		if($_SESSION && $_POST)
		{
			if($_POST["target"] == "comment"){
				mysql_query("DELETE FROM re_black_list WHERE id='".$_POST['id']."' AND owner_people_id = '".$_SESSION['people_id']."'");
			}else if($_POST["target"] == "people"){
				mysql_query("DELETE FROM re_black_list WHERE people_id='".$_POST['id']."' AND owner_people_id = '".$_SESSION['people_id']."'");
				mysql_query("UPDATE re_people SET in_black_list=0 WHERE id='".$_POST['id']."'");
			}
		}
	}
	
	public function review_list_for_rielter()
	{
		if($_POST['id'] && $_SESSION['user']){
			if($_SESSION['search_user_id']=="site" && $_POST['search_user_id']!="parse"){
				$table = "re_review INNER JOIN re_people ON re_review.people_id = re_people.id INNER JOIN re_company ON re_company.id = re_people.company_id";
				$condition = "var_id = ".$_POST['id']." AND anonymous = 0";
				$columns = "re_review.id, people_id, review, anonymous, review_date, company_name, name, second_name";
			}else if($_POST['search_user_id']=="pay_parse"){
				$table = "re_review_pay_parse INNER JOIN re_people ON re_review_pay_parse.people_id = re_people.id INNER JOIN re_company ON re_company.id = re_people.company_id";
				$condition = "parse_id = ".$_POST['id'];
				$columns = "re_review_pay_parse.id, people_id, text as review, date as review_date, company_name, name, second_name";
			}else{
				$table = "re_review_parse INNER JOIN re_people ON re_review_parse.people_id = re_people.id INNER JOIN re_company ON re_company.id = re_people.company_id";
				$condition = "parse_id = ".$_POST['id'];
				$columns = "re_review_parse.id, people_id, text as review, date as review_date, company_name, name, second_name";
			}
			$data = DB::Select($columns, $table, $condition);
			$num = count($data);
			for($r=0; $r<$num; $r++){
				$myVar = false;
				if($_POST['delBtn']==1){
					$varCount = DB::Select("count(DISTINCT r.id) as c", "re_review as r, re_people as p", "p.company_id={$_SESSION['company_id']} AND r.id = {$data[$r]['id']}")[0]['c'];
					$myVar = $varCount>0;
				}
				$deleteBtn = (($data[$r]['people_id']==$_SESSION['people_id]'] || $_SESSION['admin']==1) 
							&& $_SESSION['search_user_id']!="site") || $myVar
							? "<span class='delete' data-name='review_parse' style='float: right;width: 65px;height: 25px;'>удалить</span>" 
							: "";
				echo "<div class='comment' data-id=".$data[$r]['id'].">
						<div class='center' style='margin-bottom: 10px;'>
							Отзыв от {$data[$r]['name']} {$data[$r]['second_name']} АН: «{$data[$r]['company_name']}» ".date("d.m.Y H:i", strtotime($data[$r]['review_date']))."
						</div>
						<hr>
						<p style='margin-left: 10px;' data-people-id='{$_SESSION['people_id']}' id='{$data[$r]['id']}'>{$data[$r]['review']} {$deleteBtn}</p>
					</div>";
			}
			unset($columns, $table, $condition, $num, $r);
		}else{
			header("Location: http://". $_SERVER['SERVER_NAME']);
		}
	}
	
	/*public function send_favorites_to_email()
	{
		if($_POST["email"] && $_SESSION["people_id"]){
			$ids_str = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(text) AS ids FROM re_recipients_list WHERE DATE_ADD(date, INTERVAL 1 MONTH) >= NOW() AND address = '".$_POST["email"]."'"))["ids"];
			$ids_arr = explode(',', $ids_str);
			$count_ids = count($ids_arr);
			if($count_ids < 20){
				$favorit_ids = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id) as ids FROM re_var WHERE active = 1 AND favorit like '%|".$_SESSION['people_id']."|%'"))["ids"];
				$favorit_ids_arr = explode(',', $favorit_ids);
				$count_fav = count($favorit_ids_arr);
				if((20 - $count_ids) >= $count_fav){
					$date = date("Y-m-d H:i:s");
					$pass = substr_replace(sha1(microtime(true)), '', 5);
					DB::Insert("re_recipients_list", "people_id, address, pass, type, text, date", "'".$_SESSION["people_id"]."', '".$_POST["email"]."', '".$pass."', '1', '".$favorit_ids."', '".$date."'");
					DB::Update("re_var", "favorit=REPLACE(favorit, '|".$_SESSION['people_id']."|', '')", "favorit like '%|".$_SESSION['people_id']."|%'");
					unset($favorit_ids, $date, $pass, $text, $_POST, $count_fav, $favorit_ids_arr);
					echo 1;
				}
			}
			unset($ids_str, $ids_arr, $count_ids);
		}
	}*/
	
	public function send_var_to_email(){
		if($_POST["email"] && $_SESSION["people_id"] && $_POST['id']){
			$ids_str = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(text) AS ids FROM re_recipients_list WHERE DATE_ADD(date, INTERVAL 1 MONTH) >= NOW() AND address = '{$_POST["email"]}' AND people_id={$_SESSION['people_id']}"))["ids"];
			$ids_arr = explode(',', $ids_str);
			$count_ids = count($ids_arr);
			$responce = 0;
			if($count_ids < 50){
				$date = date("Y-m-d H:i:s");
				DB::Insert("re_recipients_list", "people_id, address, type, text, date, comment", "'{$_SESSION["people_id"]}', '{$_POST["email"]}', '1', '{$_POST['id']}', '{$date}', '{$_POST['comment']}'");			
				$record =	mysql_fetch_assoc(mysql_query("SELECT * FROM `re_recipients_list` WHERE `people_id` = {$_SESSION["people_id"]} ORDER BY `date`  DESC"));
				$filelist = glob($_SERVER['DOCUMENT_ROOT']."/images/".Model_Var::createCatalog($_POST['id'])."/*.jpg"); 

				if(sizeof($filelist) != 0){
					$queryPeople = mysql_query("SELECT * FROM `re_people` WHERE `id` = {$_SESSION["people_id"]} ");
					$rieltor = mysql_fetch_assoc($queryPeople);
					$phone = $rieltor['phone'];
					$firstName = $rieltor['name'];
					$middleName = $rieltor['second_name'];
					$subject = Model_Var::createSubject($_POST['id']);
					$mailText =" Ваш риелтор: {$firstName} {$middleName} т. {$phone} <br/> Выслал Вам вариант: {$_POST['comment']}";

					if(!empty($rieltor['email_work']) AND !empty($rieltor['email_pass'])){ 
						if(Model_Var::smtpmail($_POST["email"], $subject, $mailText, Model_Var::getServerHost($rieltor['email_work']), $rieltor['email_work'], $rieltor['email_pass'], $filelist)){
							$responce = 1;    
							mysql_query("UPDATE re_recipients_list SET active = '0', `date_send` = NOW() WHERE id={$record['id']}");
						}else{
						$responce = 2;
							// mysql_query("UPDATE re_recipients_list SET active = '2', `date_send` = NOW() WHERE id={$record['id']}");
						}
					}else{

					$responce = 3;
						mysql_query("UPDATE re_recipients_list SET active = '3', `date_send` = NOW(), `err_mess` = ' {$record['id']} WORK EMAIL IS EMPTY | Отсутствует дополнительный ящик.' WHERE `id`={$record['id']}");
					}
				}
				unset($date, $pass, $_POST);
			}else{
				$responce = 4;
			}
			unset($ids_str, $ids_arr, $count_ids);

				echo $responce;				
		}
	}
	
	public function employee_list()
	{
		if($_SESSION["parent"]==0 && $_SESSION["company_name"] == $_POST["company_name"]){
			$res = mysql_query("SELECT CONCAT_WS(' ',p.surname,p.name,p.second_name) as fio, p.phone, u.user_id FROM re_user as u, re_people as p, re_company as c WHERE c.company_name = '".$_POST["company_name"]."' AND u.people_id = p.id AND c.id = p.company_id AND u.active = 1 AND u.user_id != '".$_POST["user_id"]."'");
			echo "<div class='change-owner-list'><button type='button' class='close'><span aria-hidden='true' onClick='CloseOwnerList($(this))'>×</span></button>";
			while($people = mysql_fetch_assoc($res)){
				echo "<div data-id='".$people['user_id']."'>".$people["fio"]." <br />".$people["phone"]."</div>";
			}
			echo "</div>";
		}
	}
	
	public function change_owner()
	{
		if($_SESSION["parent"]==0){
			$res = mysql_query("select count(*) as c, people_id from re_user as u, re_var as v, re_company as c, re_people as p where u.user_id = v.user_id and u.people_id = p.id and c.id = p.company_id and v.id = ".$_POST["var_id"]." and c.id =".$_SESSION["company_id"]);
			$result = mysql_fetch_assoc($res);
			if($result["c"] == 1){
				DB::Update("re_var", "user_id = '".$_POST["user_id"]."'", "id='".$_POST["var_id"]."'");
			}
			unset($res);
			$res = mysql_query("SELECT people_id FROM re_user WHERE user_id = ".$_POST["user_id"]);
			$new_people_id = mysql_fetch_assoc($res)["people_id"];
			
			DB::Update("re_photos", "people_id = '{$new_people_id}'", "var_id='{$_POST["var_id"]}'");
			
			$old_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'.$result["people_id"]."/".$_POST["var_id"];
			if(file_exists($old_dir)){
				$new_dir = $_SERVER['DOCUMENT_ROOT'] .'/images/'.$new_people_id."/".$_POST["var_id"];
				rename($old_dir, $new_dir);
			}
		}
	}
	
	public function contacts_hide(){
		if(isset($_SESSION['user'])){
			$_SESSION["post"]["without_cont"]=1;
		}
	}
	
	public function contacts_show(){
		if(isset($_SESSION['user'])){
			$_SESSION["post"]["without_cont"]=0;
		}
	}
	
	public function photo_statistic(){
		if($_SESSION['admin']==1){
			DB::Delete("re_photo_statistic", "DATE_ADD(NOW(),INTERVAL - 72 hour) >= date");
			$data = DB::Select("*, COUNT(*) as count", "re_photo_statistic GROUP BY(login) ORDER BY count DESC");
			return $data;
		}
	}
	
	public function street_check(){
		if(isset($_SESSION['people_id']) && isset($_POST['street'])){
			$count = DB::Select("count(*) as c", "re_street", "name='{$_POST['street']}'")[0]['c'];
			echo $count;
		}
	}
	
	public function delete_recipients(){
		if(isset($_SESSION['people_id'])){
			DB::Delete("re_recipients_list", "DATE_ADD(date, INTERVAL +1 MONTH) < NOW() AND people_id=".$_SESSION['people_id']);
		}
	}
	
	public function save_search(){
		if(isset($_POST["search_str"])){
			foreach($_POST as $k=>$v){
				$columns .= "{$k},";
				$values .= "'{$v}',";
			}
			$columns .=  "date,people_id";
			$values .= "NOW(),'{$_SESSION['people_id']}'";
			$count = DB::Select("count(*) as c", "re_save_search", "people_id={$_SESSION['people_id']}")[0]['c'];
			$countLimit = DB::Select("save_search_limit", "re_people", "id={$_SESSION['people_id']}")[0]['save_search_limit'];
			if($count<$countLimit){
				DB::Insert("re_save_search", $columns, str_replace("|*|", "&", $values));
			}
		}
	}
	
	public function update_save_search(){
		if(isset($_POST['id']) && isset($_POST['col']) && isset($_SESSION['people_id'])){
			$condition = "people_id={$_SESSION['people_id']} AND id={$_POST['id']}";
			if($_POST['col']=='delete'){
				DB::Delete("re_save_search", $condition);
			}else{
				$update_str = "";
				if($_POST['col'] == "date"){
					$update_str = "date=NOW()";
				}
				if($update_str!="")DB::Update("re_save_search", $update_str, $condition);
			}
		}
	}
}

?>