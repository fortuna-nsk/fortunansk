<?php
Class DB
{	
	static function Select($column, $table, $condition) {
		$data = [];
		$condition = $condition != null ? (" WHERE ".$condition) : "";
		$query = "SELECT ".$column." FROM ".$table.$condition;	
		// if($_SESSION['admin']==1 || $_SESSION['login']==9200){
			// echo $query;
		// }
		$res = mysql_query($query);
		$num = mysql_num_rows($res);
		for($j=0; $j<$num; ++$j) {
			$data[] = mysql_fetch_assoc($res);			
		}		
		unset($condition, $query, $res, $num, $j);
		return $data;
	}
	static function Insert($table, $column, $values) {
		$query = "INSERT INTO ".$table." (".$column.") VALUE (".$values.")";		
		//return $query;
		try{
			$res = mysql_query($query);		
			if($res){
				return 1;
			}else{
				return $res;
			}			
		}catch(Exception $e){
			return $e;
		}		
	}
	static function Update($table, $values, $condition) {
		$condition = $condition != null ? (" WHERE ".$condition) : "";
		$query = "UPDATE ".$table." SET ".$values.$condition;		
		// if($_SESSION['admin']==1 || $_SESSION['login']==9200){
			// echo $query;
		// }
		try{
			mysql_query($query);		
			return $query;
		}catch(Exception $e){
			return $e;
		}
	}
	static function Delete($table, $condition) {
		$query = "DELETE FROM ".$table." WHERE ".$condition."";
		$data = '1';
		try{
			mysql_query($query);					
		}catch(Exception $e){
			$data = $e;
		}
		return $data;
	}
}
?>