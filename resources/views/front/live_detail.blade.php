<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="http://vjs.zencdn.net/5.20.1/video-js.css" rel="stylesheet">
    <script src="/js/video.js"></script>
    <link href="/css/fron_live.css" rel="stylesheet">
    <script src="/js/vue-min.js"></script>
    <script src="/js/vue-resource.js"></script>
</head>
<body>
<div class="container-fluid" id="app">
    {{--col-md-4 col-md-offset-4--}}
        <div class="col-md-6 col-md-offset-4 .col-sm-1 	col-xs-12">
           <!--直播addr-->
            <div>
            <video style="width: 100%;height:270px;" id="example_video_1"  class="video-js vjs-big-play-centered  vjs-default-skin" controls="controls" preload="auto" width="1280" height="720" poster="http://vjs.zencdn.net/v/oceans.png" data-setup="{}">
                <source src="rtmp://220.166.83.187:1935/singal1/a" type="rtmp/flv">
                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that
            </video>
            </div>
            <div class="contain">
                <div class="tagactive">直播</div>
                <div >聊天室</div>
            </div>
            <div class="live-tag" >
                <div  id="move" style="transform: translate3d(0px, -25px, 0px);border-left:1px solid #dddddd; margin-left: 17px;margin-right: 5px;">
                <div class="loading" >下拉刷新</div>
                <ul>
                    <li ng-repeat="item in live.list" class="am-g am-list-item-desced time_content ng-scope" style="border-top:0;border-bottom:0;">
                        <span style="color:#13b7f6;"></span>
                        <div class="live_content">
                            <div class="live_list_right_content">
                                <div class="live_title_info">
                                    <img ng-src="app/v1/mobile/img/live_user_header_bg.png" style="width:8%;margin:0 auto;border-radius:50%;" src="app/v1/mobile/img/live_user_header_bg.png">
                                    <span class="live_list_title ng-binding" ng-bind="item.userTitle" style="font-size:90%;">主持人</span>
                                    <span class="live_list_name ng-binding" ng-bind="item.userName" style="font-size:90%;">小i</span>
                                    <div style="float:right;padding-top:5px;margin-top:3px;">
                                        <span class="live_list_time ng-binding" ng-bind="item.publishTime">12-07 14:52</span>
                                    </div>
                                </div>
                                <div class="live_list_content ng-binding" ng-bind="item.content" style="text-align:left;padding-left: 7px;margin:5px;0">12月7日，在成都市锦江区大成宾馆见到了被拐28年的康波，他说，4岁的时候被拐，已有意识，知道自己是被拐到养父母家，一直以来他从没有放弃寻找自己的亲生父母，包括宝贝回家官网登记个人信息，到县公安局录入DNA，得知DNA配对成功以后，激动哭泣起来，立马从工作地湖北赶往成都，昨天在宾馆一夜没睡。对于下午和亲生母亲和父亲的见面，他表示，我很想他们，做梦都在想，我想尽快看到他们。
                                </div>
                                <!-- ngIf: item.attachments.pics.length > 0 --><div ng-if="item.attachments.pics.length > 0" class="ng-scope">
                                    <ul data-am-widget="gallery" class="am-gallery am-avg-sm-3                                                         am-avg-md-3 am-avg-lg-3 am-gallery-default am-no-layout" data-am-gallery="{pureview:{target: 'a'}}" style="text-align:center;">
                                        <!-- ngRepeat: pic in item.attachments.pics --><li ng-repeat="pic in item.attachments.pics" class="live_list_image1 ng-scope" style="width: 100%">
                                            <div class="am-gallery-item">
                                                   </div>
                                        </li><!-- end ngRepeat: pic in item.attachments.pics -->
                                    </ul>

                                </div><!-- end ngIf: item.attachments.pics.length > 0 -->
                                <!-- ngIf: item.attachments.videos.length > 0 -->
                            </div>
                            <div class="out">
                                <!--  <div class="in"></div>-->
                            </div>
                        </div>
                    </li>
                </ul>
                </div>
            </div>
        </div>
</div>
<script>
    function mousePosition(ev){
        ev = ev || window.event;
        if(ev.pageX || ev.pageY){
            return {x:ev.pageX, y:ev.pageY};
        }
        return {
            x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
            y:ev.clientY + document.body.scrollTop - document.body.clientTop
        };
    }
    window.addEventListener('load',function (e) {
        var flag=false;
        document.getElementById('move').onmousedown=function (e) {
            console.log(this.style.transform="translate3d(0px, -0px, 0px)");
            //record firt Y
            var _sY=e.clientY;
            var flag=true;
                console.log('start'+_sY);
            this.onmousemove=function (e) {
                if(flag==true){
                    console.log(mousePosition(e).y);
                };
            }
            this.onmouseup=function (e) {
                console.log('end'+e.clientY)
                flag=false;
            }
        }



    })
</script>

<script>
    var vue =new Vue({
        delimiters: ['[[', ']]'],
        el:'#app',
        methods:{
            drag:function (e) {
               e.currentTarget.onmousemove=function (e) {
                   console.log(1);
                   console.log(e);
               }
                console.log(e);
               e.currentTarget.style.transform="translate3d(0px,0px,0px)";
            },mousedown:function (e) {
                console.log(e);
            },mouseup:function (e) {
                console.log(e);
            }
        }
    })
</script>
<script src="/js/jq.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>