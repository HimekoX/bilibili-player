# 仿哔哩哔哩播放器（私有仓库）

此仓库已设置为私有，仅限授权用户访问。

## 功能

- 支持解析
- 支持播放
- 支持播放后自动加载
- 支持播放后自动加载

## 使用方式

1. 关于本地运行使用

```html
<div id="bili-player"></div>
<script src="./bili-player.js"></script>
<script>
    var player = new BiliPlayer({
        container: document.getElementById('bili-player'),
        video: {
            url: 'https://example.com/video.mp4',
            type: 'auto'
        }
    });
</script>
```

2. 支持解析产品接口

```javascript
var player = new BiliPlayer({
    container: document.getElementById('bili-player'),
    video: {
        url: 'https://api.example.com/parse?url=https://www.bilibili.com/video/av12345678',
        type: 'parse'
    }
});
```

## 请注意

当前仿哔哩哔哩播放器已为**私有**项目，可能存在一些限制，请做我的主项目使用。

> 此为一个私有项目，不允许从外部访问。