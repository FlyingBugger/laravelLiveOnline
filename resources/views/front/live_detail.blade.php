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
    <script src="/js/video.min.js"></script>
    <script src="/js/idangerous.swiper.min.js"></script>
    <link href="/css/fron_live.css" rel="stylesheet">
    <script src="/js/vue-min.js"></script>
    <script src="/js/vue-resource.js"></script>
</head>
<style>

</style>
<body>

<div class="container" id="app">
    {{--col-md-4 col-md-offset-4--}}
    <div id="main" class="col-md-6 col-md-offset-4 .col-sm-1 	col-xs-12">
        <!--直播addr-->
        <div class="live">
            <video style="width: 100%;height:270px;" id="example_video_1"  class="video-js vjs-big-play-centered  vjs-default-skin" controls="controls" preload="auto" width="1280" height="720" poster="http://vjs.zencdn.net/v/oceans.png" data-setup="{}">
                <source src="rtmp://220.166.83.187:1935/live/a" type="rtmp/flv">
                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that
            </video>
        </div>
        <div class="containA">
            <div class="tagactive" data-pid="live">直播</div>
            <div data-pid="chat">聊天室</div>
        </div>
        <div class="section" style="left: 0;">
            <div class="live-tag leftTag" >
                <div class="live_section" >
                    <div  id="move" style="border-left:1px solid #dddddd; margin-left: 17px;margin-right: 5px;">
                        <div class="swiper-container ">
                            <div class="preloader"> Loading... </div>
                            <div class="swiper-wrapper">
                                <div v-for="x in " class="swiper-slide green-slide swiper-slide-visible swiper-slide-active">
                                    <div class="blueI"></div>
                                    <div class="out"></div>
                                    <div class="main_content">
                                        <div>
                                            <span>
                                            <img src="/img/live_user_header_bg.png" alt=""><span style="color: #13b7f6;margin-left: 4px;">主持人 小1</span>
                                            </span>
                                            <span class="time" style="float: right">01-19 23:25</span>
                                        </div>
                                        <div>
                                            舞蹈  《梦幻羌寨》  曾获四川省第二届广场舞大赛一等奖。舞蹈编导张亚龄是一个90后帅小伙，舞蹈专业科班出身，这是他的第一支编舞作品。《梦幻羌寨》这个节目里添加了不少难度较高的动作和队形，且18名舞蹈演员全是业余爱好者，来自不同行业，如卖奶茶的、搞婚庆的，都是各行各业的舞蹈爱好者。
                                        </div>
                                        <div class="img c">
                                                <ul>
                                                    <li><img src="https://img.newaircloud.com/njrb/pic/201701/19/62a3e02c-2e96-4750-9081-cc9642cf8bd8.jpg@!md11" alt=""></li>
                                                    <li><img src="https://img.newaircloud.com/njrb/pic/201701/19/62a3e02c-2e96-4750-9081-cc9642cf8bd8.jpg@!md11" alt=""></li>
                                                    <li><img src="https://img.newaircloud.com/njrb/pic/201701/19/62a3e02c-2e96-4750-9081-cc9642cf8bd8.jpg@!md11" alt=""></li>
                                                    <li><img src="https://img.newaircloud.com/njrb/pic/201701/19/62a3e02c-2e96-4750-9081-cc9642cf8bd8.jpg@!md11" alt=""></li>

                                                </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="live-tag rightTag" >
                <div class="live_section" >
                    <div  id="move" style="border-left:1px solid #dddddd; margin-left: 17px;margin-right: 5px;">
                        <div class="swiper-container2">
                            <div class="preloader2"> Loading... </div>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide green-slide swiper-slide-visible swiper-slide-active">
                                    <div class="title2">silder 2</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
//init
//
//    var holdPosition = 0;
//    var mySwiper2= new Swiper('.swiper-container2',{
//        slidesPerView:'auto',
//        mode:'vertical',
//        watchActiveIndex: true,
//        onTouchStart: function() {
//            holdPosition = 0;
//        },
//        onResistanceBefore: function(s, pos){
//            holdPosition = pos;
//        },
//        onTouchEnd: function(){
//            if (holdPosition>100) {
//                mySwiper2.setWrapperTranslate(0,100,0)
//                mySwiper2.params.onlyExternal=true
//                $('.preloader2').addClass('animate2');
//                loadNewSlides2();
//            }
//        }
//    })
//    var slideNumber2 = 0;
//    function loadNewSlides2(){
//        setTimeout(function(){
//            //Prepend new slide
//            var colors = ['red','blue','green','orange','pink'];
//            var color = colors[Math.floor(Math.random()*colors.length)];
//            mySwiper2.prependSlide('<div class="title2">silder '+slideNumber2+'</div>', 'swiper-slide '+color+'-slide');
//            //Release interactions and set wrapper
//            mySwiper2.setWrapperTranslate(0,0,0)
//            mySwiper2.params.onlyExternal=false;
//            //Update active slide
//            mySwiper2.updateActiveSlide(0)
//            //Hide loader
//            $('.preloader2').removeClass('animate2');
//        },1000)
//        slideNumber2++;
//    }
</script>
<script>
//    var holdPosition = 0;
//    var mySwiper = new Swiper('.swiper-container',{
//        slidesPerView:'auto',
//        mode:'vertical',
//        observer:true,//修改swiper自己或子元素时，自动初始化swiper    重要
//        observeParents:true,//修改swiper的父元素时，自动初始化swiper  重要
//        watchActiveIndex: false,
//        onTouchStart: function() {
//            holdPosition = 0;
//        },
//        onResistanceBefore: function(s, pos){
//            holdPosition = pos;
//        },
//        onTouchEnd: function(){
//            if (holdPosition>100) {
//                mySwiper.setWrapperTranslate(0,100,0)
//                mySwiper.params.onlyExternal=true
//                $('.preloader').addClass('visible');
//                loadNewSlides();
//            }
//        }
//    })
//    var slideNumber = 0;
//    function loadNewSlides(){
//        setTimeout(function(){
//            //Prepend new slide
//            mySwiper.prependSlide('<div class="title">silder '+slideNumber+'</div>', 'swiper-slide');
//            //Release interactions and set wrapper
//            mySwiper.setWrapperTranslate(0,0,0)
//            mySwiper.params.onlyExternal=false;
//            //Update active slide
//            mySwiper.updateActiveSlide(0)
//            //Hide loader
//            $('.preloader').removeClass('visible');
//        },1000)
//        slideNumber++;
//    }
    //part two

</script>

<script src="/js/jq.min.js"></script>

<script src="/js/bootstrap.min.js"></script>

<script>

    $(function () {
        $('.live').on('click',function () {
            console.log('clicked');
        })
      var _width=$("#main").width()*2;
       $('.section').css('width',_width);
        $('.containA').click(function (e) {
          for (var i=0;i<2;i++){
             $(this).find('div')[i].className='';
          }
          e.target.className='tagactive';
            console.log('clicked3');
            $('.section').animate({'left':'-'+_width/2});
            if (e.target.dataset.pid=='chat'){
                console.log(_width/2)
                $('.section').animate({'left':'-'+_width/2});
                console.log('clicked4');
            }else{
                $('.section').animate({'left':'0'});
            }
        })
    })

</script>
<script>

    vue=new Vue({
        delimiters: ['[[', ']]'],
        el: '#app',
        data:{

        }
    })

</script>
</body>
</html>