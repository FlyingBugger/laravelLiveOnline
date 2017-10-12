<html><head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>现场管理</title>
    <link rel="stylesheet" href="/css/main/ui.css">
    <script src="/js/vue-min.js"></script>
    <script src="/js/vue-resource.js"></script>
</head>
<body>
<div id="app">
    <component :is="currentView" :dir="items" v-on:refreshbizlines="makeReport"></component>
</div>
<script id="edit" type="text/template">
    <div>
        <div id="j-search" class="pz-form pz-searchform xcy-search fn-clear">
            <span id="j-back" class="fn-left pz-btn btn-white"><i class="pz-icon icon-back1"></i> 返回</span>
        </div>
        <div class="fn-pl40 fn-pr40 fn-pt30 fn-pb30 fn-clear">
            <div class="pz-form">
                <form id="j-reportform">
                    <div class="wrap fn-clear">
                        <div class="group2">
                            <div class="row xcy-row">
                                <div class="row-title">报道内容</div>
                                <div class="row-content" data-field="content"><textarea name="content" class="j-content fn-h180"></textarea></div>
                            </div>
                            <div class="row xcy-row">
                                <div class="row-title">所属现场</div>
                                <div class="row-content" data-field="scene"><input type="text" value="test" name="scene" class="disabled" disabled=""></div>
                            </div>
                        </div>
                        <div class="group2 fn-pl40">
                            <div class="row xcy-row fn-mb0">
                                <div class="row-title">报道类型</div>
                                <div class="row-content" data-field="type">
                                    <div>

                                        <label><input type="radio" name="type" v-model="type" value="1" checked="">图文报道</label>
                                        <label><input type="radio" name="type"  v-model="type" value="4"> 视频报道</label>
                                    </div></div>
                            </div>
                            <div class="row xcy-row">
                                <div id="j-upcontain" class="row-content">
                                    <div id="j-row-img" class="xcy-video fn-left">
                                        <div class="j-uploader-tip upbtn toplayer fn-hide">
                                            <div class="fn-pt25">
                                                <i class="pz-icon icon-img"></i>
                                                <p class="fn-textcenter fn-mt5"></p>
                                            </div>
                                        </div>
                                        <div id="j-cover" class="xcy-cutimg">
                                            <label class="upbtn">
                                                <div class="imgbar fn-hide"></div>
                                                <div class="fn-pt25">
                                                    <i class="pz-icon icon-img"></i>
                                                    <p class="fn-textcenter fn-mt5">点击选择封面图片</p>
                                                </div>
                                                <div class="j-file-input fn-hide">
                                                    <input required type="file"  @change="imgUrl($event)" id="image" name="image" accept="image/gif,image/jpeg,image/jpg,image/png">
                                                </div>
                                            </label>
                                        </div>

                                    </div>
                                    <div id="j-row-video" class="fn-hide" style="position: relative;">
                                        <div class="xcy-video">
                                            <div class="imgbar"></div>
                                            <div class="j-uploader-tip upbtn toplayer fn-hide">
                                                <div class="fn-pt25">
                                                    <i class="pz-icon icon-video"></i>
                                                    <p class="fn-textcenter fn-mt5"></p>
                                                </div>
                                            </div>
                                            <div class="videobar toplayer fn-hide">
                                                <div class="fn-pt30">
                                                    <span class="close"><i class="pz-icon icon-close"></i></span>
                                                    <i class="pz-icon icon-video"></i>
                                                    <p class="fn-textcenter fn-mt10">点击播放</p>
                                                </div>
                                            </div>
                                            <div id="j-uploader-selectvideo" class="j-uploader-select upbtn fn-cursor-pointer" style="position: relative; z-index: 1;">
                                                <div class="fn-pt25">
                                                    <i class="pz-icon icon-video"></i>
                                                    <p class="fn-textcenter fn-mt5">点击选择报道视频</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row-title fn-w240 fn-clear">
                                            <a id="j-material" class="fn-right" href="javascript:void(0)">查看全部</a>
                                            <a id="j-videocover" class="fn-right fn-pointer fn-hide" href="javascript:void(0)">
                                                <label>
                                                    <span>修改封面</span>
                                                    <div class="j-file-input fn-hide">
                                                        <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png">
                                                    </div>
                                                </label>
                                            </a>
                                        </div>

                                        <div id="html5_1bs5alsrfs761u8dhjelkcfle8_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 0px; left: 0px; width: 0px; height: 0px; overflow: hidden; z-index: 0;"><input id="html5_1bs5alsrfs761u8dhjelkcfle8" type="file" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" accept="video/3gpp,video/mp4,.m3u8,video/x-ms-wmv,video/webm,video/quicktime,video/avi,video/mpeg,.mpeg1,.mpeg4,video/x-matroska,video/x-flv"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actions actions-transparent fn-pt20">
                        <input type="submit" class="pz-btn btn-success btn-big" value="发布报道">
                    </div>
                </form>
            </div>
        </div>
    </div>
</script>

<script  id="mainScen" type="text/template">
    <div>

        <div id="j-list" class="fn-pt30 fn-pb30 fn-pl40 fn-pr40">
            <div class="fn-fs14" style="color:#666;">当前正在直播的现场</div>
            <div class="pz-table fn-mt10">

                <table class="table-noborder table-noheader">
                    <tbody>
                    <tr v-for="(item,index) in dates">
                    <td>[[item.title]]</td>
                    <td>[[item.seter]]
                    </td>
                    <td class="fn-textcenter">[[item.createAt]]</td>
                    <td class="fn-textcenter">
                    <a class="j-get" href="javascript:void(0)" @click="report(index,item.id)">发布报道</a>
                    </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</script>

<script>
  new Vue({
        delimiters: ['[[', ']]'],
        el:'#app',
        data:{
            items:'',
            tes:'21',
            currentView:''
        },components:{
            mainS:{
                delimiters: ['[[', ']]'],
                template:'#mainScen',
                methods:{
                    report:function (index,id) {
                        localStorage.setItem("index", index);
                        localStorage.setItem("id", id);
                        var a=[index,id];
                        this.$emit('refreshbizlines',a);
                    }
                },
                data:function(){
                    return{
                        dates:'',
                        flag:'1'
                    }
                },
                props:['dir'],
                mounted:function () {
                    this.dates=this.dir;
                   console.log(this.dates);

                }
            },
            makereport:{
                delimiters: ['[[', ']]'],
                template:'#edit',
                props:['dir'],
                data:function () {
                    return{
                    type:1
                    }
                },methods:{
                    imgUrl:function (e) {
                        $('.fn-pt25').hide();
                        var imgUrl= window.URL.createObjectURL(e.target.files[0]);
                        $('#imgSrc').attr('src',imgUrl);
                        $('.upbtn').css(
                            {"background":"url(\""+(imgUrl)+"\") no-repeat center",
                                "background-size":"100% 100%"
                            }
                        );
                    },
                },
                mounted:function () {
                }
            }
      },
          methods:{

              makeReport:function (a) {
                  this.currentView='makereport';
              }
          },
        mounted:function () {
                this.$http.post('/Api/makerepot',{act:'makereport','_token':'{{csrf_token()}}'}).then(function (res) {
               this.items=eval('('+res.body+')');
               this.currentView='makereport';
            },function (e) {
                console.log(e)
            })
            console.log('loadding')
        }
    })
</script>
<script src="/js/jq.min.js"></script>
</body></html>