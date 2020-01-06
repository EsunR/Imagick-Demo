<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials:true");

$fileName = $_GET["file"];
if (!$fileName) {
  http_response_code(400);
  echo "Params Error";
  return;
}
$file = "./tmp/" . $fileName;
if (!file_exists($file)) {
  http_response_code(404);
  echo "File Not Exists";
  return;
}
$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($fileinfo, $file);
finfo_close($fileinfo);
header('Content-type:' . $mimeType);
header('Content-Disposition: attachement; filename=' . basename($file));
header('Content-Length:' . filesize($file));
readfile($file);
