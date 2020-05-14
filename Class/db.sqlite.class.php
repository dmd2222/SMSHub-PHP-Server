<?php


class SQLiteDatabase
{
	
		/*
* SQLite3 Class
* based on the code of miquelcamps
* @see http://7devs.com/code/view.php?id=67
*/

	private $sqlite;
	private $mode;
  
	function __construct( $filename, $mode = SQLITE3_ASSOC ){

				$this->mode = $mode;
	  			$this->sqlite = new SQLite3($filename);
		

	}
  
	function __destruct(){
	  @$this->sqlite->close();
	}
  
	function clean( $str ){
	  return $this->sqlite->escapeString( $str );
	}
  
	function query( $query ){
	  $res = $this->sqlite->query( $query );
	  if ( !$res ){
		throw new Exception( $this->sqlite->lastErrorMsg() );
	  }
  
	  return $res;
	}
  
	function queryRow( $query ){
	  $res = $this->query( $query );
	  $row = $res->fetchArray( $this->mode );
	  return $row;
	}
  
	function queryOne( $query ){
	  $res = $this->sqlite->querySingle( $query );
	  return $res;
	}
  
	function queryAll( $query ){
	  $rows = array();
	  if( $res = $this->query( $query ) ){
		while($row = $res->fetchArray($this->mode)){
		  $rows[] = $row;
		}
	  }
	  return $rows;
	}
  
	function getLastID(){
	  return $this->sqlite->lastInsertRowID();
	}


}	
?>