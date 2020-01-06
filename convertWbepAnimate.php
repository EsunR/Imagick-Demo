<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials:true");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  echo json_encode(["success" => 0, "error" => "请求方式错误"]);
  return;
}

try {
  if (sizeof($_FILES) === 0) {
    echo json_encode(["success" => 0, "error" => "上传文件数为空"]);
    return;
  }

  $format = "webp"; // support webp and gif
  $animate = new Imagick();
  $animate->setFormat($format);
  // 1 = 10ms
  $delay = is_null($_POST["delay"]) ? 20 : intval($_POST["delay"]);
  if ($delay > 5000) {
    $delay = 5000;
  }

  foreach ($_FILES as $fileInfo) {
    $tmpName = $fileInfo["tmp_name"];
    $framImage = new Imagick($tmpName);
    $framImage->setFormat($format);
    $animate->addImage($framImage);
    $animate->setImageDelay($delay);
  }

  // 写入文件前检查目录是否存在
  if (!is_dir("./tmp/")) {
    mkdir("tmp");
  }

  $outputFileName = uniqid() . "." . $format;
  $result = $animate->writeImages("./tmp/" . $outputFileName, true);

  if ($result) {
    echo json_encode(["success" => 1, "data" => ["name" => $outputFileName], "error" => ""]);
  } else {
    echo json_encode(["success" => 0, "error" => "文件写入失败"]);
  }
} catch (Exception $e) {
  echo json_encode(["success" => 0, "error" => "转换出错，请检查图片格式"]);
  // var_dump($e);
}
