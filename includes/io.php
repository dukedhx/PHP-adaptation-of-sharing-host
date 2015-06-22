<?php 

require_once ('constants.php');

class writer{
private $filename, $size,$handle;
	public function __construct($fn){
$this->filename=$fn;
	}
  
	public function del()
	{
delfile($this->filename);
	}

public function getsize(){
$this->size=filesize($this->filename);
	return $this->size;
}
private function close($h)
{
if($h)fclose($h);	
}
private function getfh($fn,$w=false)
{
return	fopen($fn, $w?'w':'r');
}

public function writefile(){
global $buffer;

$this->handle = $this->getfh($this->filename);

$out=fopen('php://output', 'w');
$written=0;
do{
$contents = fread($this->handle, $buffer);
$written=fwrite($out, $contents);
}while(($this->size=$this->size-$written)>0);
$this->close($out);
}

public function peek($peek)
{
	
$this->handle = $this->getfh($this->filename);
return fread($this->handle, $peek);
}

public function writecontent(&$contents){
	$this->handle = $this->getfh($this->filename, true);
fwrite($this->handle, $contents);
}
function __destruct() {
	$this->close($this->handle);
}
}

class flremover extends bprocrst{
	private $path;
	public function __construct( $arrstr,$path){
parent::__construct($arrstr);
$this->path=$path;
	}
  protected function process($item)
  {    
        return getrst(delfile($this->path.$item),'','failed','does not exist');         
  }
}

function delfile($filename)
{global $nonexist,$failure,$success;$answer=$success;
		if(file_exists($filename)){if(!unlink($filename))$answer=$failure;}else $answer=$nonexist;
		return $answer;}



?>