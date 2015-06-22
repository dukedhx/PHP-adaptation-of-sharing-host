<?php

require ('../includes/rst.php');
require ('../includes/io.php');

class fljsonifier extends jsonifier{
protected function jsonify($item)
{
global $jofn,$josize,$jotime;
$size=filesize($item);
$parts=explode('/',$item);
$filename=$parts[sizeof($parts)-1];
$time= date ("Y-m-d H:i:s", filemtime($item));
echo <<<EOT
{ "$jofn": "$filename", "$josize":"$size","$jotime":"$time"}
EOT;
}
}

 function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        
            return $mime_types[array_key_exists($ext, $mime_types)?$ext:'txt'];
        }

if(isset($_POST[$uphasfile]))
{
  set_time_limit(0);
$results= new resultset;
foreach ($_FILES[$upfile]["error"] as $key => $error) 
    if ($error == UPLOAD_ERR_OK) 
    {
    $filename=$oldname=$filepath.$_FILES[$upfile]["name"][$key];$rid=0;
    while(file_exists($filename)){$parts=explode('.',$oldname);$lpid=sizeof($parts)-2;$lpid=$lpid<0?0:$lpid;$parts[$lpid]=$parts[$lpid].'['.$rid++.']';$filename=implode('.',$parts);}
     if(   move_uploaded_file($_FILES[$upfile]["tmp_name"][$key], $filename))
        $results->add(success());
    else                     
    $results->add(fail($error,false));    
    }
       else
    $results->add(fail($error,false));
(new jsonifier)->outputJSON($results->array);
}
else{
  if(empty($_GET[$uphasfile]))
  {
if(empty($_GET[$getfile]))
{
  $rst=new fljsonifier;
  if(isset($_GET[$updel]))
  
  $rst->outputJSON((new flremover($_GET[$updel],$filepath))->getrsts(),$joresentry,true);    
  
$rst->outputJSON(glob($filepath.'*'));
}
else
{
$sfn=$_GET[$getfile];
$filename = $filepath.$sfn;
if(file_exists($filename)){
  $writer=new writer($filename);
$size=$writer->getsize();

  
if(!isset($_GET[$fmode])&&$_GET[$fmode]!=$fmraw){
  header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=\"$sfn\"");
}
else header('Content-type: '.mime_content_type($sfn));
header('Content-Transfer-Encoding: binary');
  header("Content-Length: $size");
$writer->writefile();
unset($writer);
}
else notfound(); 
}


}
else
{
   session_start();
var_dump($_SESSION[ini_get("session.upload_progress.prefix") .$_GET[$uphasfile]]);
}
}
?>