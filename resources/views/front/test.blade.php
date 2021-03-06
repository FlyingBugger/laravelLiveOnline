<!DOCTYPE html>
<html>

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>flv.js demo</title>
    <style>
        .mainContainer {
            display: block;
            width: 1024px;
            margin-left: auto;
            margin-right: auto;
        }

        .urlInput {
            display: block;
            width: 100%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 8px;
            margin-bottom: 8px;
        }

        .centeredVideo {
            display: block;
            width: 100%;
            height: 576px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: auto;
        }

        .controls {
            display: block;
            width: 100%;
            text-align: left;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
<div class="mainContainer">
    <video id="videoElement" class="centeredVideo" controls autoplay width="1024" height="576">Your browser is too old which doesn't support HTML5 video.</video>
</div>
<br>
<div class="controls">
    <!--<button onclick="flv_load()">加载</button>-->
    <button onclick="flv_start()">开始</button>
    <button onclick="flv_pause()">暂停</button>
    <button onclick="flv_destroy()">停止</button>
    <input style="width:100px" type="text" name="seekpoint" />
    <button onclick="flv_seekto()">跳转</button>
</div>
<script src="/js/flv.js"></script>
<script>
    var player = document.getElementById('videoElement');
    if (flvjs.isSupported()) {
        var flvPlayer = flvjs.createPlayer({
            type: 'flv',
            url: 'http://220.166.83.187:8000/live/59f691cc1d084.flv'
        });
        flvPlayer.attachMediaElement(videoElement);
        flvPlayer.load(); //加载
    }

    function flv_start() {
        player.play();
    }

    function flv_pause() {
        player.pause();
    }

    function flv_destroy() {
        player.pause();
        player.unload();
        player.detachMediaElement();
        player.destroy();
        player = null;
    }

    function flv_seekto() {
        player.currentTime = parseFloat(document.getElementsByName('seekpoint')[0].value);
    }
</script>
</body>

</html>

作者：关爱单身狗成长协会
链接：http://www.jianshu.com/p/1b825ae84005
來源：简书
著作权归作者所有。商业转载请联系作者获得授权，非商业转载请注明出处。