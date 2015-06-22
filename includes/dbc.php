<?php 
require_once ('constants.php');

class dbhelper{
private $link;
public function __construct( /*...*/ ){
global $host, $usr, $pw,$dbname;
$this->link= mysql_connect($host, $usr, $pw);
if (!$this->link)     die('Could not connect: ' . mysql_error());


$db_selected = mysql_select_db($dbname, $this->link);
if (!$db_selected)     die ('Can\'t use sb233 : ' . mysql_error());
}
   

function __destruct() {

if ($this->link)  mysql_close($this->link);
}

private function query($str)
{

	return mysql_query($str,$this->link);
}

private function sanitize($arg)
{
	return mysql_real_escape_string($arg);
}
function del($id)
{
	global $texttable, $success,$nonexist;
  return $this->query("DELETE FROM $texttable WHERE id=".$this->sanitize($id))?$success:$nonexist;

}

function getText($page=0,$perpage=5)
{
global $texttable ;
return $this->query("SELECT * FROM $texttable LIMIT ".$page*($perpage>0?$perpage:5).", ".$this->sanitize($perpage));
}

function insert(&$text,$cond=null)
{
global $texttable,$upcond ;
$this->query(is_null($cond)?"INSERT INTO $texttable ($texttable) values ('$text')":"INSERT INTO $texttable ($texttable,$upcond) values ('".$this->sanitize($text)."',$cond)",$this->link);
return mysql_insert_id($this->link);
}

}





?>