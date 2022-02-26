<?php	
	
	// SELECT
	function get_some_data($tn, $extra_sql, $index = "*", $jk = null) {
		global $conn;
		if(strpos($tn, '_-_') !== false) {
			$tablesA = explode("_-_", $tn);
			$jKeysA = explode("_-_", $jk);
			$tn = $tablesA[0];
		} else $tablesA = array();
		
		$get = "SELECT ". $index ." FROM {$tn} \n";
		
		for($i=1; $i<count($tablesA); $i++) {
			$get .= "LEFT JOIN {$tablesA[$i]} ";
			$get .= "ON {$tn}.{$jKeysA[0]} = {$tablesA[$i]}.{$jKeysA[$i]} ";
		}
		
		$get .= "WHERE ". $extra_sql;
		$result = $conn->query($get);
		return $result;
		
		/* $get = "SELECT * FROM ".$tablename." ";
		$get.= "WHERE ".$condition;
		$result = $conn->query($get);
		return $result; */
	}
	function get_single_data($tablename, $condition) {
		global $conn;
		$get = "SELECT * FROM ".$tablename." ";
		$get.= "WHERE ".$condition;
		$result = $conn->query($get);
		$row = $result->fetch_array();
		return $row;
	}
	function get_single_index_data($tablename, $condition, $index) {
		global $conn;
		$get = "SELECT * FROM ".$tablename." ";
		$get.= "WHERE ".$condition;
		$result = $conn->query($get);
		$row = $result->fetch_array();
		return $row[$index];
	}
	
	// INSERT UPDATE DELETE
	function InsertInTable($table,$fields){
		global $conn;
		$sql  = "INSERT INTO {$table} (".implode(" , ",array_keys($fields)).") ";
		$sql .= "VALUES('";      
		foreach($fields as $key => $value) { 
			$fields[$key] = $value;
		}
		$sql .= implode("' , '",array_values($fields))."');";       
		return $sql;
	}
	function UpdateTable($table,$fields,$condition) {
		global $conn;
		$sql = "UPDATE {$table} SET ";
		foreach($fields as $key => $value) { 
			$fields[$key] = " {$key} = '{$value}' ";
		}
		$sql .= implode(" , ",array_values($fields))." WHERE ".$condition.";";  
		return $sql;
	}
	function DeleteTable($tablename, $condition) {
		$sql = "DELETE FROM {$tablename} ";
		$sql.= "WHERE {$condition}" ;
		return $sql;
	}
	