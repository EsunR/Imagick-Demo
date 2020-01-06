<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials:true");
header("Content-type: application/json");

function path_info($filepath)
{
  $path_parts = array();
  $path_parts['dirname'] = rtrim(substr($filepath, 0, strrpos($filepath, '/')), "/") . "/";
  $path_parts['basename'] = ltrim(substr($filepath, strrpos($filepath, '/')), "/");
  $path_parts['extension'] = substr(strrchr($filepath, '.'), 1);
  $path_parts['filename'] = ltrim(substr($path_parts['basename'], 0, strrpos($path_parts['basename'], '.')), "/");
  return $path_parts;
}

function get_file_size($filePath)
{
  return round(filesize($filePath) / 1024, 2);
}

try {
  // 取出上传文件的信息
  $fileInfo = $_FILES["file"];
  $tmpName = $fileInfo["tmp_name"];
  $fileName = $fileInfo["name"];
  if (is_uploaded_file($tmpName)) {
    // 转换图片格式
    $img = new Imagick($tmpName);
    $format = "webp";
    $img->setFormat($format);
    $outputFileName = path_info($fileName)["filename"] . "." . $format;

    // 写入文件前检查目录是否存在
    if (!is_dir("./tmp/")) {
      mkdir("tmp");
    }

    // 输出文件
    $result = $img->writeImages("./tmp/" . $outputFileName, true);

    // 设置返回信息
    if ($result) {
      $respData = [
        "key" => uniqid(),
        "name" => $outputFileName,
        "size" => get_file_size("./tmp/" . $outputFileName),
        "oldSize" => get_file_size($tmpName)
      ];
      echo json_encode(["success" => 1, "data" => $respData, "error" => ""]);
    } else {
      echo json_encode(["success" => 0, "error" => "图片写入失败"]);
    }
  } else {
    echo json_encode(["success" => 0, "error" => "参数或方法错误"]);
  }
} catch (Exception $e) {
  // var_dump($e);
  echo json_encode(["success" => 0, "error" => "转换出错，请检查图片格式"]);
}
