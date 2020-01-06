# 说明

`convertWebp.php` 是一个可以让图片自动转换为 Webp 格式的 API，已支持多图片格式转换，支持 Gif 动图转为 Webp 动图。

调用示例：

```
# Form Data
file: File
```

返回数据格式示例：

```
{
    "success": 1,
    "data": {
        "key": "5e12c93b297fb",
        "name": "github_avatar.webp",
        "size": 107.32,
        "oldSize": 224.49
    },
    "error": ""
}
```

`convertWbepAnimate.php` 是一个将多张图片合并为 webp 动图的 API，支持自定义调节时间间隔。

调用示例：

```
# Form Data
file1: File
file2: File
file3: File
delay: Number
```

返回数据格式示例：

```
{
    "success": 1,
    "data": {
        "name": "5e12c9608b1a9.webp"
    },
    "error": ""
}
```

`getImage.php` 是一个间接获取图片 URL 的 API，可以让 PHP 脚本读取 `./tmp` 文件夹下的图片，避免直接向用户暴露服务器的静态文件目录。

调用示例：

```
getImage.php?file=test.webp
```

# 依赖

- ImageMagick 7
- imagick
- libwebp-dev
- libpng-dev
- libjpeg-dev
