<?php
require ('../includes/dbc.php');
require ('../includes/rst.php');
require ('../includes/io.php');
class txremover extends bprocrst{
	private $dbc;
	public function __construct( $arrstr,$dbc){

parent::__construct($arrstr);
$this->dbc=$dbc;
}
  protected function process($item)
  {    
    return getrst($this->dbc->del($item),'','failed','does not exist');    
  }
}

class txjsonifier extends jsonifier{
protected function iterate(&$array,$callp){
	if($callp)parent::iterate($array);else{
	$first=true;
while($item = mysql_fetch_assoc($array))
parent::process($item,$first);}
}
}

class fltxjsonifier extends jsonifier{
protected function jsonify($item)
{global $upid,$uptext, $peek;
	$filename=basename($item);$writer=new writer($item);
	$text=$writer->peek($peek);unset($writer);
	
echo <<<EOT
{ "$upid": "$filename", "$uptext":"$text"}
EOT;
}
}

class textprv
{

	public $id,$text;
		public function __construct($id,$txt){
$this->id=$id;$this->text=$txt;
	}

}

if(empty($_POST[$uptext]))
{
$page=empty($_GET[$uppage])?0:intval($_GET[$uppage]);
$pp=empty($_GET[$uppp])?5:intval($_GET[$uppp]);
	if(empty($_GET[$txsvfile])){
$rst=new txjsonifier;
$dbc=new dbhelper;
if(isset($_GET[$updel]))

$rst->outputJSON((new txremover($_GET[$updel],$dbc))->getrsts(),$joresentry,true);

$result=$dbc->getText($page,$pp);
if($result)
$rst->outputJSON($result);unset($rst);
mysql_free_result($result);
unset($dbc);
}
else
{$rst=new fltxjsonifier;
	if(isset($_GET[$updel]))
	

		$rst->outputJSON((new flremover($_GET[$updel],$textpath))->getrsts(),$joresentry,true);


$farr=glob($textpath.'*');
$length=sizeof($farr);
$start=$pp*$page;
if($length>$start+1)
$rst->outputJSON(array_slice($farr,$start,$pp));
}
}
else
{
$id=-1;
if(empty($_POST[$txsvfile])){
$dbc=new dbhelper;
$id=$dbc->insert($_POST[$uptext],empty($_POST[$upcond])?null:$_POST[$upcond]);
unset($dbc);

}else{

	$id=0;
	$farr=glob($textpath.'*');
	$length=sizeof($farr)-1;if($length>-1){$parts=explode('/',$farr[$length]);$id=intval($parts[sizeof($parts)-1])+1;}
$writer=new writer($textpath.$id);
$writer->writecontent($_POST[$uptext]);
unset($writer);
}
echoresult(success($id));
}


?>